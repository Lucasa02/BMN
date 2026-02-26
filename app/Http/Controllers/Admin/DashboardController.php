<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Jabatan;
use App\Models\SliderImage;
use App\Models\BmnKategori;
use App\Models\BmnRuangan;
use App\Models\PerawatanInventaris;
use App\Models\LaporanKerusakan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
	public function index()
	{
		$data['title'] = 'Dashboard';
		$data['user'] = User::count();
		$data['slider_images'] = SliderImage::all();
		$data['jabatan'] = Jabatan::count();
		$data['bmn_kategori'] = BmnKategori::count();
		$data['bmn_ruangan'] = BmnRuangan::count();

		// --- DATA BARANG BMN ---
		$data['barang'] = \App\Models\BmnBarang::count();
		$data['barang_tersedia'] = \App\Models\BmnBarang::whereIn('kondisi', ['Sangat Baik', 'Baik'])->count();
		$data['barang_rusak'] = \App\Models\BmnBarang::where('kondisi', 'Rusak / Cacat')->count();
		$data['barang_kurang_baik'] = \App\Models\BmnBarang::where('kondisi', 'Kurang Baik')->count();

		// --- DATA PERAWATAN INVENTARIS ---
		$data['perawatan'] = PerawatanInventaris::where('status', '!=', 'selesai')->count();
		$data['perawatan_pending'] = PerawatanInventaris::where('status', 'pending')->count();
		$data['perawatan_proses'] = PerawatanInventaris::where('status', 'proses')->count();

		// --- PERUBAHAN DATA PENGEMBALIAN KE LAPORAN KERUSAKAN ---
		$data['laporan_total'] = LaporanKerusakan::count();
		$data['laporan_pending'] = LaporanKerusakan::where('status', 'pending')->count();
		$data['laporan_disetujui'] = LaporanKerusakan::where('status', 'disetujui')->count();
		$data['laporan_ditolak'] = LaporanKerusakan::where('status', 'ditolak')->count();
		// -------------------------------------------------------

		return view('admin.dashboard.index', $data);
	}
}
