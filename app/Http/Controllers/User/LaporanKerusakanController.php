<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\BmnBarang;
use App\Models\LaporanKerusakan;
use App\Models\BmnJenisKerusakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanKerusakanController extends Controller
{
    public function form($id)
    {
        $barang = BmnBarang::findOrFail($id);

        $jenis_kerusakan = BmnJenisKerusakan::all();

        return view('user.inventaris.lapor_kerusakan', compact('barang', 'jenis_kerusakan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'jenis_kerusakan' => 'required',
            'deskripsi' => 'required',
            'foto' => 'nullable|image|max:4096'
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('laporan/kerusakan', 'public');
        }

        LaporanKerusakan::create([
            'barang_id' => $request->barang_id,
            'user_id' => Auth::id(),
            'jenis_kerusakan' => $request->jenis_kerusakan,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto,
            'status' => 'pending',
        ]);

        return redirect()->route('user.inventaris.detail', $request->barang_id)
            ->with('success', 'Laporan telah dikirim, menunggu verifikasi admin.');
    }
}