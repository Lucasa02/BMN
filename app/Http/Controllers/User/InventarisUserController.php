<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BmnBarang;
use Illuminate\Support\Facades\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Imagick;
use ImagickException;
use App\Models\PerawatanInventaris;

class InventarisUserController extends Controller
{
    public function index()
    {
        $title = "Inventaris Barang";
        // Filter agar barang yang sudah di 'penghapusan' tidak tampil
        $barang = BmnBarang::with('perawatan')
            ->whereDoesntHave('perawatan', function ($q) {
                $q->where('jenis_perawatan', 'penghapusan');
            })->latest()->paginate(10);

        return view('user.inventaris', compact('title', 'barang'));
    }

    public function showAll()
    {
        $title = "Semua Inventaris (Scan ALL)";
        $barang = BmnBarang::with('perawatan')
            ->whereDoesntHave('perawatan', function ($q) {
                $q->where('jenis_perawatan', 'penghapusan');
            })->latest()->paginate(12);
        $ruangan = request('ruangan') ?? 'default';
        return view('user.inventaris.show_all', compact('title', 'barang','ruangan'));
    }

    public function scan(Request $request, $kode) // <-- Tambahkan Request $request
    {
        $kode = trim($kode);
        $from = $request->query('from'); // <-- Tangkap parameter asal

        if (strtoupper($kode) === 'ALL') {
            return redirect()->route('user.inventaris.show_all')
                ->with('success', 'Menampilkan semua barang.');
        }

        // Pastikan QR yang di scan bukan barang yang sudah di 'penghapusan'
        $barang = BmnBarang::whereDoesntHave('perawatan', function ($q) {
                $q->where('jenis_perawatan', 'penghapusan');
            })->where('kode_barang', $kode)->first();

        if ($barang) {
            // <-- Teruskan parameter 'from' ke halaman detail
            return redirect()->route('user.inventaris.detail', [
                'id' => $barang->id,
                'from' => $from
            ]);
        }

        return redirect()->route('user.inventaris.show_all')
            ->with('warning', 'QR tidak dikenali atau barang sudah dihapus. Menampilkan semua barang.');
    }

    public function detail($id)
    {
        // Pastikan load perawatan dan pastikan bukan barang terhapus
        $barang = BmnBarang::with('perawatan')
            ->whereDoesntHave('perawatan', function ($q) {
                $q->where('jenis_perawatan', 'penghapusan');
            })->findOrFail($id);

        $title = "Detail Barang";

        return view('user.inventaris.detail', compact('title', 'barang'));
    }

    /**
     * Download Universal QR Inventaris (tetap menggunakan route name user.inventaris.scan)
     */
    public function downloadAllQR()
    {
        $url = route('user.inventaris.scan', 'ALL');

        // Generate QR dalam memori
        $qrData = QrCode::format('png')
            ->size(600)
            ->margin(1)
            ->generate($url);

        try {
            $qr = new Imagick();
            $qr->readImageBlob($qrData);

            $logoPath = public_path('img/assets/esimprod_logo_bg.png');

            if (file_exists($logoPath)) {
                $logo = new Imagick($logoPath);

                // Resize tetap proporsional
                $logoSize = intval($qr->getImageWidth() * 0.20);
                $logo->resizeImage($logoSize, $logoSize, Imagick::FILTER_LANCZOS, 1);

                // Posisi tengah
                $x = intval(($qr->getImageWidth() - $logoSize) / 2);
                $y = intval(($qr->getImageHeight() - $logoSize) / 2);

                $qr->compositeImage($logo, Imagick::COMPOSITE_OVER, $x, $y);
            }

            $qrOutput = $qr->getImageBlob();

            return Response::streamDownload(function () use ($qrOutput) {
                echo $qrOutput;
            }, 'QR-Inventaris.png', [
                'Content-Type' => 'image/png'
            ]);

        } catch (ImagickException $e) {
            return back()->with('error', 'Gagal membuat QR. Error: ' . $e->getMessage());
        }
    }

    public function laporKerusakanForm($id)
    {
        $barang = BmnBarang::findOrFail($id);
        // Pastikan path view sesuai dengan letak file .blade.php Anda
        // Jika file ada di resources/views/user/inventaris/lapor_kerusakan.blade.php
        return view('user.inventaris.lapor_kerusakan', compact('barang'));
    }

    public function laporKerusakanSubmit(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:bmn_barangs,id',
            'jenis_kerusakan' => 'required|string', // Tambahkan ini
            'deskripsi' => 'required|string',
            'foto'      => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('foto')->store('laporan/foto', 'public');

        PerawatanInventaris::create([
            'barang_id' => $request->barang_id,
            'tanggal_perawatan' => now(),
            'deskripsi' => $request->jenis_kerusakan . ' - ' . $request->deskripsi, // Gabungkan agar tersimpan
            'foto' => $path,
            'status' => 'pending',
            'jenis' => 'laporan_kerusakan'
        ]);

        return redirect()->route('user.inventaris.detail', $request->barang_id)
            ->with('success', 'Laporan kerusakan berhasil dikirim.');
    }

    public function scanRak($nama_rak)
    {
        $nama_rak = urldecode($nama_rak);

        // Cari barang, load perawatan, dan kecualikan yang sudah di 'penghapusan'
        $barang = \App\Models\BmnBarang::with('perawatan')
            ->whereDoesntHave('perawatan', function ($q) {
                $q->where('jenis_perawatan', 'penghapusan');
            })->where('ruangan', $nama_rak)->get();

        return view('user.inventaris.hasil_scan_rak', [
            'barang' => $barang,
            'nama_rak' => $nama_rak
        ]);
    }

}
