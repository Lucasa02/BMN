<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanKerusakan;
use App\Models\PerawatanInventaris;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AntreanPerbaikanController extends Controller
{
    public function index()
    {
        $title = 'Antrean Perbaikan';

        $laporan_disetujui = LaporanKerusakan::with(['barang', 'user'])
            ->where('status', 'disetujui')
            ->orderBy('updated_at', 'desc')
            ->paginate(12);

        return view('admin.antrian.index', compact('laporan_disetujui', 'title'));
    }

    public function detail($uuid)
    {
        $title = 'Detail Antrean Perbaikan';
        $laporan = LaporanKerusakan::with(['barang', 'user'])->where('uuid', $uuid)->firstOrFail();

        return view('admin.antrian.detail', compact('laporan', 'title'));
    }

    // METHOD BARU UNTUK LOGBOOK ADMIN YANG DISEderhanakan
    public function logbook(Request $request)
    {
        $title = 'Logbook Tim Perbaikan';

        $teknisiList = User::where('role', 'tim_perbaikan')->orderBy('nama_lengkap', 'asc')->get();

        $query = PerawatanInventaris::with(['barang', 'user'])
            ->where('jenis_perawatan', 'perbaikan')
            ->whereIn('status', ['proses', 'diperbaiki', 'tidak_dapat_diperbaiki', 'selesai']);

        // Filter berdasarkan Teknisi
        if ($request->filled('teknisi_id')) {
            $query->where('user_id', $request->teknisi_id);
        }

        $periodeText = 'Semua Waktu';
        $bulanFilter = $request->filter_bulan;
        $tahunFilter = $request->filter_tahun;

        // Logika Filter Bulan & Tahun Sederhana
        if ($bulanFilter && $tahunFilter) {
            $query->whereMonth('updated_at', $bulanFilter)
                  ->whereYear('updated_at', $tahunFilter);

            // Format teks periode menjadi "Maret 2024" dsb
            $bulanNama = Carbon::createFromFormat('m', $bulanFilter)->translatedFormat('F');
            $periodeText = $bulanNama . ' ' . $tahunFilter;

        } elseif ($tahunFilter) {
            // Jika hanya tahun yang dipilih
            $query->whereYear('updated_at', $tahunFilter);
            $periodeText = 'Tahun ' . $tahunFilter;

        } elseif ($bulanFilter) {
            // Jika hanya bulan yang dipilih (otomatis menggunakan tahun saat ini)
            $query->whereMonth('updated_at', $bulanFilter)
                  ->whereYear('updated_at', Carbon::now()->year);

            $bulanNama = Carbon::createFromFormat('m', $bulanFilter)->translatedFormat('F');
            $periodeText = $bulanNama . ' ' . Carbon::now()->year;
        }

        $logbook = $query->orderBy('updated_at', 'desc')->paginate(12)->withQueryString();

        return view('admin.antrian.logbook_perbaikan', compact('logbook', 'teknisiList', 'title', 'periodeText'));
    }
}
