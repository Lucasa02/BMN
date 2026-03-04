<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BmnBarang;
use App\Models\BmnRuangan;
use App\Models\BmnKategori;
use App\Models\Pengguna;
use App\Models\UnitKerja;
use App\Models\BmnJenisKerusakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Validation\Rule;
use App\Models\PerawatanInventaris;
class BmnController extends Controller
{
    private function tentukanKondisi($persentase)
    {
        if ($persentase >= 90) return 'Sangat Baik';
        if ($persentase >= 70) return 'Baik';
        if ($persentase >= 50) return 'Kurang Baik';
        return 'Rusak / Cacat';
    }

    private function generateUniqueKode()
    {
        $prefix = 'BRG';
        $year = Carbon::now()->format('Y');

        $last = BmnBarang::where('kode_barang', 'like', "{$prefix}-{$year}-%")
            ->orderBy('kode_barang', 'desc')
            ->first();

        $next = $last ? intval(substr($last->kode_barang, -4)) + 1 : 1;

        return sprintf("%s-%s-%04d", $prefix, $year, $next);
    }

    public function ruanganIndex()
    {
        $ruangan = BmnRuangan::orderBy('nama_ruangan', 'asc')->paginate(10);
        $title = 'Ruangan BMN';
        return view('admin.bmn.ruangan.index', compact('ruangan', 'title'));
    }

    public function ruanganStore(Request $request)
    {
        $validated = $request->validate([
            'nama_ruangan' => 'required|unique:bmn_ruangans,nama_ruangan',
        ]);

        $validated['uuid'] = Str::uuid();
        BmnRuangan::create($validated);

        return redirect()->back()->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function ruanganEdit($uuid)
    {
        $ruangan = BmnRuangan::where('uuid', $uuid)->firstOrFail();
        return response()->json($ruangan);
    }

    public function ruanganUpdate(Request $request, $uuid)
    {
        $ruangan = BmnRuangan::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'nama_ruangan' => 'required|unique:bmn_ruangans,nama_ruangan,' . $ruangan->id,
        ]);

        $ruangan->update(['nama_ruangan' => $request->nama_ruangan]);

        return response()->json(['success' => true]);
    }

    public function ruanganDestroy($uuid)
    {
        BmnRuangan::where('uuid', $uuid)->delete();
        return redirect()->back()->with('success', 'Ruangan berhasil dihapus.');
    }

    public function ruanganSearch(Request $request)
    {
        $keyword = $request->search;
        $ruangan = BmnRuangan::where('nama_ruangan', 'like', "%{$keyword}%")
            ->paginate(10);
        $title = 'Hasil Pencarian Ruangan';
        return view('admin.bmn.ruangan.index', compact('ruangan', 'title'));
    }

    public function kategoriIndex()
    {
        $kategori = BmnKategori::orderBy('nama_kategori', 'asc')->paginate(10);
        $title = 'Kategori BMN';
        return view('admin.bmn.kategori.index', compact('kategori', 'title'));
    }

    public function kategoriStore(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|unique:bmn_kategoris,nama_kategori',
        ]);

        $validated['uuid'] = Str::uuid();
        BmnKategori::create($validated);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function kategoriEdit($uuid)
    {
        $kategori = BmnKategori::where('uuid', $uuid)->firstOrFail();
        return response()->json($kategori);
    }

    public function kategoriUpdate(Request $request, $uuid)
    {
        $kategori = BmnKategori::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'nama_kategori' => 'required|unique:bmn_kategoris,nama_kategori,' . $kategori->id,
        ]);

        $kategori->update(['nama_kategori' => $request->nama_kategori]);

        return response()->json(['success' => true]);
    }

    public function kategoriDestroy($uuid)
    {
        BmnKategori::where('uuid', $uuid)->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }

    public function kategoriSearch(Request $request)
    {
        $keyword = $request->search;
        $kategori = BmnKategori::where('nama_kategori', 'like', "%{$keyword}%")
            ->paginate(10);
        $title = 'Hasil Pencarian Kategori';
        return view('admin.bmn.kategori.index', compact('kategori', 'title'));
    }

    public function jenisKerusakanIndex()
    {
        $jenis_kerusakan = BmnJenisKerusakan::orderBy('nama_jenis_kerusakan', 'asc')->paginate(10);
        $title = 'Jenis Kerusakan BMN';
        return view('admin.bmn.jenis_kerusakan.index', compact('jenis_kerusakan', 'title'));
    }

    public function jenisKerusakanStore(Request $request)
    {
        $request->validate([
            'nama_jenis_kerusakan' => 'required|unique:bmn_jenis_kerusakans,nama_jenis_kerusakan',
        ]);

        BmnJenisKerusakan::create([
            'nama_jenis_kerusakan' => $request->nama_jenis_kerusakan
        ]);

        return redirect()->back()->with('success', 'Jenis kerusakan berhasil ditambahkan.');
    }

    public function jenisKerusakanEdit($uuid)
    {
        $data = BmnJenisKerusakan::where('uuid', $uuid)->firstOrFail();
        return response()->json($data);
    }

    public function jenisKerusakanUpdate(Request $request, $uuid)
    {
        $data = BmnJenisKerusakan::where('uuid', $uuid)->firstOrFail();
        $request->validate([
            'nama_jenis_kerusakan' => 'required|unique:bmn_jenis_kerusakans,nama_jenis_kerusakan,' . $data->id,
        ]);

        $data->update(['nama_jenis_kerusakan' => $request->nama_jenis_kerusakan]);
        return response()->json(['success' => true]);
    }

    public function jenisKerusakanDestroy($uuid)
    {
        BmnJenisKerusakan::where('uuid', $uuid)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }

    public function jenisKerusakanSearch(Request $request)
    {
        $keyword = $request->search;
        $jenis_kerusakan = BmnJenisKerusakan::where('nama_jenis_kerusakan', 'like', "%{$keyword}%")
            ->paginate(10);
        $title = 'Hasil Pencarian Jenis Kerusakan';
        return view('admin.bmn.jenis_kerusakan.index', compact('jenis_kerusakan', 'title'));
    }

    public function penggunaIndex()
    {
        $pengguna = Pengguna::orderBy('nama', 'asc')->paginate(10);
        $title = 'Daftar Pengguna BMN';
        return view('admin.bmn.pengguna.index', compact('pengguna', 'title'));
    }

    public function penggunaStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip'  => 'required|string|unique:penggunas,nip|max:50',
        ]);

        $validated['uuid'] = Str::uuid();
        Pengguna::create($validated);

        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function penggunaEdit($uuid)
    {
        $pengguna = Pengguna::where('uuid', $uuid)->firstOrFail();
        return response()->json($pengguna);
    }

    public function penggunaUpdate(Request $request, $uuid)
    {
        $pengguna = Pengguna::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip'  => 'required|string|max:50|unique:penggunas,nip,' . $pengguna->id,
        ]);

        $pengguna->update($validated);

        return response()->json(['success' => true]);
    }

    public function penggunaDestroy($uuid)
    {
        Pengguna::where('uuid', $uuid)->delete();
        return redirect()->back()->with('success', 'Data pengguna berhasil dihapus.');
    }

    public function penggunaSearch(Request $request)
    {
        $keyword = $request->search;
        $pengguna = Pengguna::where('nama', 'like', "%{$keyword}%")
            ->orWhere('nip', 'like', "%{$keyword}%")
            ->paginate(10);

        $title = 'Hasil Pencarian Pengguna';
        return view('admin.bmn.pengguna.index', compact('pengguna', 'title'));
    }

    public function unitKerjaIndex()
    {
        $unit_kerja = UnitKerja::orderBy('nama_unit_kerja', 'asc')->paginate(10);
        $title = 'Daftar Unit Kerja BMN';
        return view('admin.bmn.unit_kerja.index', compact('unit_kerja', 'title'));
    }

    public function unitKerjaStore(Request $request)
    {
        $validated = $request->validate([
            'nama_unit_kerja' => 'required|unique:unit_kerjas,nama_unit_kerja|max:255',
        ]);

        $validated['uuid'] = Str::uuid();
        UnitKerja::create($validated);

        return redirect()->back()->with('success', 'Unit Kerja berhasil ditambahkan.');
    }

    public function unitKerjaEdit($uuid)
    {
        $unit_kerja = UnitKerja::where('uuid', $uuid)->firstOrFail();
        return response()->json($unit_kerja);
    }

    public function unitKerjaUpdate(Request $request, $uuid)
    {
        $unit_kerja = UnitKerja::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'nama_unit_kerja' => 'required|max:255|unique:unit_kerjas,nama_unit_kerja,' . $unit_kerja->id,
        ]);

        $unit_kerja->update($validated);

        return response()->json(['success' => true]);
    }

    public function unitKerjaDestroy($uuid)
    {
        UnitKerja::where('uuid', $uuid)->delete();
        return redirect()->back()->with('success', 'Unit kerja berhasil dihapus.');
    }

    public function unitKerjaSearch(Request $request)
    {
        $keyword = $request->search;
        $unit_kerja = UnitKerja::where('nama_unit_kerja', 'like', "%{$keyword}%")
            ->paginate(10);

        $title = 'Hasil Pencarian Unit Kerja';
        return view('admin.bmn.unit_kerja.index', compact('unit_kerja', 'title'));
    }

    public function index(Request $request, $ruangan)
    {
        $keyword = $request->input('q') ?? $request->input('search');

        // Ambil data ruangan untuk dropdown di modal cetak
        $list_ruangan = BmnRuangan::orderBy('nama_ruangan', 'asc')->get();

        $data = BmnBarang::with([
            'perawatan' => function ($q) {
                $q->whereIn('status', ['pending', 'proses'])
                    ->orderBy('tanggal_perawatan', 'desc');
            },
            'perawatanAktif'
        ])
            ->where('ruangan', 'LIKE', ucfirst($ruangan) . '%')
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('nama_barang', 'like', "%{$keyword}%")
                        ->orWhere('kode_barang', 'like', "%{$keyword}%")
                        ->orWhere('nup', 'like', "%{$keyword}%")
                        ->orWhere('kategori', 'like', "%{$keyword}%")
                        ->orWhere('merk', 'like', "%{$keyword}%")
                        ->orWhere('asal_pengadaan', 'like', "%{$keyword}%")
                        ->orWhere('peruntukan', 'like', "%{$keyword}%")
                        ->orWhere('kondisi', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('nama_barang')
            ->paginate(20);

        $title = 'Data BMN - ' . ucfirst($ruangan);

        // Tambahkan 'list_ruangan' ke compact
        return view('admin.bmn.index', compact('data', 'ruangan', 'title', 'keyword', 'list_ruangan'));
    }

    public function create($ruangan)
    {
        $ruangans = BmnRuangan::orderBy('nama_ruangan', 'asc')->get();
        $kategoris = BmnKategori::orderBy('nama_kategori', 'asc')->get();
        $penggunas = Pengguna::orderBy('nama', 'asc')->get();

        // TAMBAHKAN INI: Ambil data Unit Kerja
        $unit_kerjas = UnitKerja::orderBy('nama_unit_kerja', 'asc')->get();

        $title = ($ruangan == 'general') ? 'Tambah Barang BMN' : 'Tambah Barang - ' . ucfirst($ruangan);

        return view('admin.bmn.create', compact('ruangan', 'title', 'ruangans', 'kategoris', 'penggunas', 'unit_kerjas'));
    }

    public function store(Request $request, $ruangan)
    {
        $rules = [
            'nama_barang'        => 'required',
            'nup'                => ['required','string','max:255',
                Rule::unique('bmn_barangs')->where(function ($query) use ($request) {
                    return $query->where('nama_barang', $request->nama_barang);
                }),],
            'kode_barang'        => 'nullable|string|max:255|unique:bmn_barangs',
            'kategori'           => 'required',
            'tipe_penempatan'    => 'required|in:lokasi,pengguna', // Disesuaikan dengan value di Blade
            'unit_kerja_pilihan' => 'required|exists:unit_kerjas,nama_unit_kerja', // Unit kerja wajib diisi
            'merk'               => 'nullable',
            'nomor_seri'         => 'nullable',
            'jumlah'             => 'required|integer|min:1',
            'persentase_kondisi' => 'required|numeric|min:0|max:100',
            'tanggal_perolehan'  => 'nullable|date',
            'nilai_perolehan'    => 'nullable|numeric|min:0',
            'asal_pengadaan'     => 'nullable',
            'catatan'            => 'nullable',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'posisi'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        $validated = $request->validate($rules);

        // LOGIKA PENENTUAN LOKASI & UNIT KERJA
        if ($ruangan == 'general') {
            $finalRuangan = ($request->tipe_penempatan == 'lokasi')
                ? $request->ruangan_pilihan
                : $request->user_id;

            // Simpan Unit Kerja secara terpisah
            $validated['unit_kerja'] = $request->unit_kerja_pilihan;
        } else {
            $finalRuangan = ucfirst($ruangan);
            $validated['unit_kerja'] = $request->unit_kerja_pilihan ?? null;
        }

        $validated['ruangan'] = $finalRuangan;
        $validated['kode_barang'] = $validated['kode_barang'] ?? $this->generateUniqueKode();
        $validated['uuid']        = Str::uuid();
        $validated['kondisi']     = $this->tentukanKondisi($validated['persentase_kondisi']);

        // Hapus key yang tidak ada di kolom database sebelum create
        unset($validated['tipe_penempatan'], $validated['ruangan_pilihan'], $validated['user_id'], $validated['unit_kerja_pilihan']);

        $manager = new ImageManager(new Driver());

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $name = time() . "_barang." . $file->getClientOriginalExtension();
            $img = $manager->read($file)->scaleDown(800, 800);
            $canvas = $manager->create(800, 800)->fill('#ffffff')->place($img, 'center');
            $path = 'bmn/foto/' . $name;
            Storage::disk('public')->put($path, $canvas->encodeByExtension($file->getClientOriginalExtension(), quality: 80));
            $validated['foto'] = $path;
        }

        if ($request->hasFile('posisi')) {
            $file   = $request->file('posisi');
            $name   = time() . "_posisi." . $file->getClientOriginalExtension();
            $img    = $manager->read($file)->scaleDown(800, 800);
            $canvas = $manager->create(800, 800)->fill('#ffffff')->place($img, 'center');
            $path = 'bmn/posisi/' . $name;
            Storage::disk('public')->put($path, $canvas->encodeByExtension($file->getClientOriginalExtension(), quality: 80));
            $validated['posisi'] = $path;
        }

        $qrName = 'qr_' . $validated['kode_barang'] . '.png';
        $qrPath = 'bmn/qrcode/' . $qrName;
        $scanUrl = route('user.inventaris.scan', $validated['kode_barang']);
        QrCode::format('png')->size(300)->margin(2)
            ->generate($scanUrl, Storage::disk('public')->path($qrPath));
        $validated['qr_code'] = $qrPath;

        BmnBarang::create($validated);

        return redirect()->route('barang.bmn_index')
            ->with('success', 'Barang berhasil ditambahkan ke ' . $finalRuangan);
    }

    public function show($ruangan, $id)
    {
    // Eager load perawatan yang statusnya pending atau proses
    $barang = BmnBarang::with(['perawatan' => function($q){
    $q->whereIn('status', ['proses', 'pending'])->orderBy('tanggal_perawatan', 'desc');
    }])->findOrFail($id);


    $title = 'Detail Barang - ' . ucfirst($ruangan);


    // Ambil perawatan aktif (jika ada) — gunakan koleksi dari relasi yang sudah eager-loaded
    $perawatan = $barang->perawatan->first(); // null jika tidak ada

    return view('admin.bmn.show', compact('barang', 'ruangan', 'title','perawatan'));
    }

    public function edit($ruangan, $id)
    {
        $barang = BmnBarang::findOrFail($id);
        $ruangans = BmnRuangan::orderBy('nama_ruangan', 'asc')->get();
        $kategoris = BmnKategori::orderBy('nama_kategori', 'asc')->get();
        $penggunas = Pengguna::orderBy('nama', 'asc')->get();

        // TAMBAHKAN INI
        $unit_kerjas = UnitKerja::orderBy('nama_unit_kerja', 'asc')->get();

        $title = 'Edit Barang - ' . ucfirst($ruangan);

        return view('admin.bmn.edit', compact('barang', 'ruangan', 'title', 'ruangans', 'kategoris', 'penggunas', 'unit_kerjas'));
    }

    public function update(Request $request, $ruangan, $id)
    {
        $barang = BmnBarang::findOrFail($id);

        $rules = [
            'nama_barang'        => 'required',
            'nup'                => [
                'required', 'string', 'max:255',
                Rule::unique('bmn_barangs')->where(function ($query) use ($request) {
                    return $query->where('nama_barang', $request->nama_barang);
                })->ignore($barang->id),
            ],
            'kode_barang'        => 'required|string|max:255|unique:bmn_barangs,kode_barang,' . $barang->id,
            'kategori'           => 'required',
            'jumlah'             => 'required|integer|min:1',
            'persentase_kondisi' => 'required|numeric|min:0|max:100',
            'tanggal_perolehan'  => 'nullable|date',
            'nilai_perolehan'    => 'nullable|numeric|min:0',
            'tipe_penempatan'    => 'required|in:lokasi,pengguna',
            'unit_kerja_pilihan' => 'required|exists:unit_kerjas,nama_unit_kerja',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'posisi'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'merk'               => 'nullable|string',
            'nomor_seri'         => 'nullable|string',
            'asal_pengadaan'     => 'nullable|string',
            'catatan'            => 'nullable|string',
        ];

        if ($request->tipe_penempatan == 'lokasi') {
            $rules['ruangan_pilihan'] = 'required|exists:bmn_ruangans,nama_ruangan';
        } else {
            $rules['user_id'] = 'required';
        }

        $validated = $request->validate($rules);

        // Update Lokasi & Unit Kerja
        $validated['ruangan'] = ($request->tipe_penempatan == 'lokasi')
            ? $request->ruangan_pilihan
            : $request->user_id;
        $validated['unit_kerja'] = $request->unit_kerja_pilihan;

        $validated['kondisi'] = $this->tentukanKondisi($validated['persentase_kondisi']);

        $manager = new ImageManager(new Driver());

        if ($request->hasFile('foto')) {
            if ($barang->foto) Storage::disk('public')->delete($barang->foto);
            $file = $request->file('foto');
            $name = time() . "_barang." . $file->getClientOriginalExtension();
            $img = $manager->read($file)->scaleDown(800, 800);
            $canvas = $manager->create(800, 800)->fill('#ffffff')->place($img, 'center');
            $path = 'bmn/foto/' . $name;
            Storage::disk('public')->put($path, $canvas->encodeByExtension($file->getClientOriginalExtension(), quality: 80));
            $validated['foto'] = $path;
        }

        if ($request->hasFile('posisi')) {
            if ($barang->posisi) Storage::disk('public')->delete($barang->posisi);
            $file = $request->file('posisi');
            $name = time() . "_posisi." . $file->getClientOriginalExtension();
            $img = $manager->read($file)->scaleDown(800, 800);
            $canvas = $manager->create(800, 800)->fill('#ffffff')->place($img, 'center');
            $path = 'bmn/posisi/' . $name;
            Storage::disk('public')->put($path, $canvas->encodeByExtension($file->getClientOriginalExtension(), quality: 80));
            $validated['posisi'] = $path;
        }

        if ($request->hasFile('foto') || $request->hasFile('posisi') || $request->kode_barang !== $barang->kode_barang) {
            if ($barang->qr_code) Storage::disk('public')->delete($barang->qr_code);
            $qrName = 'qr_' . $validated['kode_barang'] . '.png';
            $qrPath = 'bmn/qrcode/' . $qrName;
            $scanUrl = route('user.inventaris.scan', $validated['kode_barang']);
            QrCode::format('png')->size(300)->margin(2)->generate($scanUrl, Storage::disk('public')->path($qrPath));
            $validated['qr_code'] = $qrPath;
        }

        unset($validated['ruangan_pilihan'], $validated['user_id'], $validated['tipe_penempatan'], $validated['unit_kerja_pilihan']);

        $barang->update($validated);

        return redirect()->route('barang.bmn_index')
            ->with('success', 'Data barang BMN berhasil diperbarui.');
    }

    public function destroy($ruangan, $id)
    {
    $barang = BmnBarang::findOrFail($id);


    if ($barang->foto && Storage::disk('public')->exists($barang->foto)) {
    Storage::disk('public')->delete($barang->foto);
    }
    if ($barang->posisi && Storage::disk('public')->exists($barang->posisi)) {
    Storage::disk('public')->delete($barang->posisi);
    }
    if ($barang->qr_code && Storage::disk('public')->exists($barang->qr_code)) {
    Storage::disk('public')->delete($barang->qr_code);
    }

    $barang->delete();

    return redirect()->route('barang.bmn_index', $ruangan)
    ->with('success', 'Barang berhasil dihapus.');
    }

    public function print($ruangan)
    {
        $data = BmnBarang::where('ruangan', 'like', ucfirst($ruangan) . '%')
            ->orderBy('nama_barang')
            ->get();

        $title = 'Cetak Data BMN - ' . ucfirst($ruangan);
        return view('admin.bmn.print', compact('data', 'ruangan', 'title'));
    }

    public function search(Request $request, $ruangan)
    {
        $keyword = $request->input('search');

        $data = BmnBarang::where('ruangan', ucfirst($ruangan))
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('nama_barang', 'like', "%{$keyword}%")
                        ->orWhere('kode_barang', 'like', "%{$keyword}%")
                        ->orWhere('kategori', 'like', "%{$keyword}%")
                        ->orWhere('merk', 'like', "%{$keyword}%")
                        ->orWhere('nomor_seri', 'like', "%{$keyword}%")
                        ->orWhere('asal_pengadaan', 'like', "%{$keyword}%")
                        ->orWhere('peruntukan', 'like', "%{$keyword}%")
                        ->orWhere('kondisi', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('nama_barang', 'asc')
            ->paginate(10)
            ->appends($request->all());

        $title = 'Hasil Pencarian BMN - ' . ucfirst($ruangan);

        return view('admin.bmn.index', compact('data', 'ruangan', 'title', 'keyword'));
    }

    public function showFilterForm($ruangan)
    {
        $kategoriList = BmnBarang::select('kategori')->distinct()->pluck('kategori');
        $asalList = BmnBarang::select('asal_pengadaan')->distinct()->pluck('asal_pengadaan');
        $posisiList = BmnBarang::select('posisi')->distinct()->pluck('posisi');
        $tahunList = BmnBarang::select('tahun_pengadaan')->distinct()->orderBy('tahun_pengadaan', 'desc')->pluck('tahun_pengadaan');

        return view('admin.bmn.filter_form', compact('ruangan', 'kategoriList', 'asalList', 'posisiList', 'tahunList'));
    }

    public function printFiltered(Request $request, $ruangan)
    {
        $query = BmnBarang::where('ruangan', ucfirst($ruangan));

        if ($request->filled('tahun_pengadaan')) $query->where('tahun_pengadaan', $request->tahun_pengadaan);
        if ($request->filled('kondisi')) $query->where('kondisi', $request->kondisi);
        if ($request->filled('kategori')) $query->where('kategori', $request->kategori);
        if ($request->filled('asal_pengadaan')) $query->where('asal_pengadaan', $request->asal_pengadaan);
        if ($request->filled('posisi')) $query->where('posisi', $request->posisi);
        if ($request->filled('peruntukan')) $query->where('peruntukan', $request->peruntukan);
        if ($request->filled('merk')) $query->where('merk', $request->merk);
        if ($request->filled('nomor_seri')) $query->where('nomor_seri', $request->nomor_seri);

        $data = $query->orderBy('nama_barang', 'asc')->get();
        $title = 'Laporan BMN (Filtered) - ' . ucfirst($ruangan);

        $pdf = Pdf::loadView('admin.bmn.print_filtered', compact('data', 'ruangan', 'title'))
            ->setPaper('a4', 'landscape')
            ->setOption(['isPhpEnabled' => true]);

        return $pdf->stream('Laporan_BMN_Filtered_' . ucfirst($ruangan) . '.pdf');
    }

    /** 🔥 Download QR ALL Barang */
public function downloadQRAll()
{
    $url = route('user.inventaris.index');

    // Buat QR PNG
    $qr = QrCode::format('png')
        ->size(400)
        ->errorCorrection('H')
        ->generate($url);

    $filename = 'QR-ALL-INVENTARIS.png';

    return response($qr)
        ->header('Content-Type', 'image/png')
        ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
}
}
