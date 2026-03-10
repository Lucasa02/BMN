<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanKerusakan;
use App\Models\PerawatanInventaris;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class TeknisiController extends Controller
{
    public function index()
    {
        $laporan_disetujui = LaporanKerusakan::with(['barang', 'user'])
            ->where('status', 'disetujui')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('user.teknisi.index', compact('laporan_disetujui'));
    }

    public function detail($uuid)
    {
        $laporan = LaporanKerusakan::with(['barang', 'user'])->where('uuid', $uuid)->firstOrFail();
        return view('user.teknisi.detail', compact('laporan'));
    }

    public function perbaikan($uuid)
    {
        $laporan = LaporanKerusakan::with(['barang'])->where('uuid', $uuid)->firstOrFail();
        return view('user.teknisi.perbaikan', compact('laporan'));
    }

    public function perbaikanSubmit(Request $request, $uuid)
    {
        $request->validate([
            'deskripsi'  => 'required',
            'biaya'      => 'required|numeric',
            'foto_bukti' => 'nullable|image|max:4096'
        ]);

        $laporan = LaporanKerusakan::where('uuid', $uuid)->firstOrFail();

        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoPath = $request->file('foto_bukti')->store('perawatan/bukti', 'public');
        }

        PerawatanInventaris::create([
            'uuid'              => Str::uuid(),
            'barang_id'         => $laporan->barang_id,
            'user_id'           => Auth::id(),
            'tanggal_perawatan' => now(),
            'jenis_perawatan'   => 'perbaikan',
            'deskripsi'         => "Keluhan: " . $laporan->deskripsi . "\nTindakan Teknisi: " . $request->deskripsi,
            'biaya'             => $request->biaya,
            'foto_bukti'        => $fotoPath,
            'foto_kerusakan'    => $laporan->foto,
            'status'            => 'proses'
        ]);

        $laporan->delete();

        return redirect()->route('user.teknisi.logbook')->with('success', 'Perbaikan berhasil! Data telah diserahkan ke Admin Perawatan Inventaris untuk verifikasi.');
    }

    public function logbook(Request $request)
    {
        $query = PerawatanInventaris::with(['barang'])
            ->where('user_id', Auth::id())
            ->where('jenis_perawatan', 'perbaikan')
            ->whereIn('status', ['proses', 'selesai']);

        $periodeText = 'Semua Waktu';

        // Filter Per Bulan
        if ($request->filled('filter_month')) {
            $date = Carbon::parse($request->filter_month);
            $query->whereYear('updated_at', $date->year)
                  ->whereMonth('updated_at', $date->month);
            $periodeText = 'Bulan ' . $date->translatedFormat('F Y');
        }
        // Filter Per Minggu (Format HTML5 Week: YYYY-Www, contoh: 2026-W10)
        elseif ($request->filled('filter_week')) {
            $year = substr($request->filter_week, 0, 4);
            $week = substr($request->filter_week, 6);

            $start = Carbon::now()->setISODate($year, $week)->startOfWeek();
            $end = Carbon::now()->setISODate($year, $week)->endOfWeek();

            $query->whereBetween('updated_at', [$start, $end]);
            $periodeText = 'Minggu ke-' . $week . ' Tahun ' . $year . ' (' . $start->format('d/m/Y') . ' - ' . $end->format('d/m/Y') . ')';
        }

        $logbook = $query->orderBy('updated_at', 'desc')->paginate(9)->withQueryString();

        return view('user.teknisi.logbook', compact('logbook', 'periodeText'));
    }

    public function downloadPdf(Request $request)
    {
        $query = PerawatanInventaris::with(['barang'])
            ->where('user_id', Auth::id())
            ->where('jenis_perawatan', 'perbaikan')
            ->whereIn('status', ['proses', 'selesai']);

        $periodeText = 'Semua Waktu';

        // Terapkan filter yang sama persis seperti di tampilan logbook
        if ($request->filled('filter_month')) {
            $date = Carbon::parse($request->filter_month);
            $query->whereYear('updated_at', $date->year)
                  ->whereMonth('updated_at', $date->month);
            $periodeText = 'Bulan ' . $date->translatedFormat('F Y');
        } elseif ($request->filled('filter_week')) {
            $year = substr($request->filter_week, 0, 4);
            $week = substr($request->filter_week, 6);

            $start = Carbon::now()->setISODate($year, $week)->startOfWeek();
            $end = Carbon::now()->setISODate($year, $week)->endOfWeek();

            $query->whereBetween('updated_at', [$start, $end]);
            $periodeText = 'Minggu ke-' . $week . ' Tahun ' . $year . ' (' . $start->format('d/m/Y') . ' - ' . $end->format('d/m/Y') . ')';
        }

        $logbook = $query->orderBy('updated_at', 'desc')->get();

        $pdf = Pdf::loadView('user.teknisi.pdf_logbook', compact('logbook', 'periodeText'))
                  ->setPaper('a4', 'landscape');

        $namaFile = 'Laporan_Kinerja_Teknisi_' . str_replace(' ', '_', Auth::user()->nama_lengkap) . '_' . date('d-m-Y') . '.pdf';

        return $pdf->download($namaFile);
    }
}
