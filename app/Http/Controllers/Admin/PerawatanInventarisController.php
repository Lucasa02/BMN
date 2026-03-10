<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerawatanInventaris;
use App\Models\BmnBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerawatanInventarisController extends Controller
{
    public function index(Request $request) // Tambahkan Request $request untuk menangani filter jika diperlukan
    {
        $query = PerawatanInventaris::with('barang')
            ->where('jenis_perawatan', 'perbaikan')
            ->where('status', '!=', 'selesai'); // <-- TAMBAHKAN BARIS INI agar yang selesai tidak muncul

        // (Opsional) Jika Anda ingin filter di view tetap berfungsi untuk 'search'
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('barang', function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%');
            });
        }

        $data = $query->latest()->get();

        $title = "Perawatan Inventaris";
        return view('admin.perawatan_inventaris.index', compact('data', 'title'));
    }

    public function detail($id)
    {
        $data = PerawatanInventaris::with(['barang', 'user'])->findOrFail($id);
        $title = "Detail Perbaikan Barang";

        return view('admin.perawatan_inventaris.detail', compact('data', 'title'));
    }

    private function cekBarangSudahDiproses($barang_id)
    {
        return PerawatanInventaris::where('barang_id', $barang_id)
            ->whereIn('status', ['pending','proses']) // belum selesai
            ->exists();
    }

    public function storeFromBarang($barang_id)
    {
        if ($this->cekBarangSudahDiproses($barang_id) || \App\Models\LaporanKerusakan::where('barang_id', $barang_id)->whereIn('status', ['pending', 'disetujui'])->exists()) {
            return back()->with('error', 'Barang ini sudah masuk proses perawatan atau sedang di antrean teknisi!');
        }

        PerawatanInventaris::create([
            'uuid' => Str::uuid(),
            'barang_id' => $barang_id,
            'tanggal_perawatan' => now(),
            'jenis_perawatan' => 'perbaikan',
            'status' => 'pending', // Pending agar menunggu admin menulis keluhan
        ]);

        return redirect()->route('perawatan_inventaris.index')->with('success', 'Barang dialihkan ke daftar antrean. Silahkan Tulis Keluhan.');
    }

    public function perbaikiForm($id)
    {
        $data = PerawatanInventaris::with('barang')->findOrFail($id);
        $title = "Mulai / Edit Perbaikan";
        return view('admin.perawatan_inventaris.perbaiki', compact('data', 'title'));
    }

    public function perbaikiSubmit(Request $request, $id)
    {
        $request->validate([
            'keluhan' => 'required|string',
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png|max:4096' // Validasi file foto
        ]);

        $p = PerawatanInventaris::findOrFail($id);

        // Proses simpan file foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan_kerusakan', 'public');
        }

        // Buat Laporan Kerusakan berstatus disetujui agar langsung tampil di teknisi/index.blade.php
        \App\Models\LaporanKerusakan::create([
            'uuid'            => \Illuminate\Support\Str::uuid(),
            'barang_id'       => $p->barang_id,
            'user_id'         => Auth::id(), // Admin yang melapor
            'jenis_kerusakan' => 'Maintenance',
            'deskripsi'       => $request->keluhan,
            'foto'            => $fotoPath, // Simpan path foto ke database
            'status'          => 'disetujui'
        ]);

        // Hapus status dari PerawatanInventaris (akan dibuat ulang oleh Teknisi saat memproses)
        $p->delete();

        return redirect()->route('perawatan_inventaris.index')
                        ->with('success', 'Keluhan berhasil disimpan dan telah dikirim ke halaman Teknisi.');
    }

    public function perbaiki($id)
    {
        $p = PerawatanInventaris::findOrFail($id);
        $p->update(['status' => 'proses']);

        return back()->with('success', 'Barang mulai diperbaiki.');
    }

    public function hapuskan($id)
    {
        $item = PerawatanInventaris::with('barang')->findOrFail($id);
        $barang_id = $item->barang_id;

        // hapus record perbaikan / rencana lama
        $item->delete();

        // cek duplicate rencana_penghapusan
        $cek = PerawatanInventaris::where('barang_id', $barang_id)
            ->where('jenis_perawatan', 'rencana_penghapusan')
            ->whereIn('status', ['pending', 'proses'])
            ->first();

        if ($cek) {
            return back()->with('error', 'Barang ini sudah ada dalam rencana penghapusan!');
        }

        PerawatanInventaris::create([
            'uuid' => Str::uuid(),
            'barang_id' => $barang_id,
            'tanggal_perawatan' => now(),
            'jenis_perawatan' => 'rencana_penghapusan',
            'status' => 'pending',
        ]);

        // <-- FIX BAGIAN INI
    return redirect()->route('data_penghapusan.index')
                    ->with('success', 'Barang berhasil masuk ke Data Penghapusan.');
    }

    public function verifikasiSelesai($id)
    {
        $p = PerawatanInventaris::findOrFail($id);

        $p->update(['status' => 'selesai']);

        return redirect()->route('perawatan_inventaris.index')->with('success', 'Perbaikan telah diverifikasi dan diselesaikan.');
    }
}
