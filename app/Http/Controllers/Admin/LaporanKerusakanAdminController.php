<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporanKerusakan;
use App\Models\PerawatanInventaris;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanKerusakanAdminController extends Controller
{
    public function index()
    {
        // Tambahkan with(['barang', 'user'])
        $laporan = LaporanKerusakan::with(['barang', 'user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $title = "Laporan Kerusakan";
        return view('admin.laporan_kerusakan.index', compact('laporan', 'title'));
    }


    public function detail($uuid)
    {
        $laporan = LaporanKerusakan::with(['barang', 'user'])->where('uuid', $uuid)->firstOrFail();
        $title = "Laporan Kerusakan";
        return view('admin.laporan_kerusakan.detail', compact('laporan', 'title'));
    }

    public function setujui($uuid)
    {
        $laporan = LaporanKerusakan::where('uuid', $uuid)->firstOrFail();

        PerawatanInventaris::create([
            'barang_id'         => $laporan->barang_id,
            'tanggal_perawatan' => now(),
            'jenis_perawatan'   => 'perbaikan',
            'deskripsi'         => $laporan->deskripsi,
            'foto_kerusakan'    => $laporan->foto,
            'status'            => 'pending'
        ]);

        $laporan->update(['status' => 'disetujui']);

        return redirect()->route('perawatan_inventaris.index')
            ->with('success', 'Laporan disetujui dan berhasil dipindahkan ke daftar Perawatan.');
    }

    public function tolak($uuid)
    {
        LaporanKerusakan::where('uuid', $uuid)->update([
            'status' => 'ditolak'
        ]);

        return redirect()->route('admin.laporan-kerusakan.index')
            ->with('success', 'Laporan telah ditolak dan dihapus dari daftar antrean.');
    }

    public function exportPDF()
    {
        // Tambahkan 'user' di dalam with()
        $laporan = LaporanKerusakan::with(['barang', 'user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.laporan_kerusakan.pdf_rekap', compact('laporan'));

        return $pdf->stream('rekap-laporan-kerusakan-' . date('Y-m-d') . '.pdf');
    }
}