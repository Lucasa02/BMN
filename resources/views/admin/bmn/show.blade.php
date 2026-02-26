@extends('layouts.admin.main')

@section('content')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <div class="font-display bg-[#f8fafc] dark:bg-[#0f172a] min-h-screen pb-12 overflow-x-hidden no-scrollbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">

            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10" data-aos="fade-up">
    <div class="space-y-2">
        <h1 class="text-4xl lg:text-5xl font-black text-slate-900 dark:text-white tracking-tight italic">
            {{ $barang->nama_barang }}
        </h1>
        <div class="flex items-center gap-3">
            <span class="h-1 w-12 bg-primary rounded-full"></span>
            <p class="text-slate-500 dark:text-slate-400 font-medium tracking-wide uppercase text-xs">Aset
                Inventaris Negara • {{ $barang->kode_barang }}</p>
        </div>
    </div>

    <div class="flex flex-wrap gap-3">
        {{-- TOMBOL KEMBALI --}}
        <a href="{{ route('barang.bmn_index', $ruangan) }}"
            class="group flex items-center gap-2 bg-white dark:bg-slate-800 text-slate-700 dark:text-white px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all shadow-sm">
            <span class="material-symbols-outlined text-slate-500 group-hover:-translate-x-1 transition-transform text-xl">arrow_back</span>
            <span class="text-sm font-bold">Kembali</span>
        </a>

        <a href="{{ route('bmn.edit', [$ruangan, $barang->id]) }}"
            class="group flex items-center gap-2 bg-white dark:bg-slate-800 text-slate-700 dark:text-white px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-primary dark:hover:border-primary transition-all shadow-sm hover:shadow-md">
            <span class="material-symbols-outlined text-primary group-hover:rotate-12 transition-transform text-xl">edit</span>
            <span class="text-sm font-bold">Edit Detail</span>
        </a>

        {{-- Tombol lainnya tetap sama --}}
        <a href="{{ asset('storage/' . $barang->qr_code) }}" target="_blank"
            class="flex items-center gap-2 bg-slate-900 dark:bg-primary text-white px-5 py-2.5 rounded-xl hover:bg-slate-800 dark:hover:bg-blue-600 transition-all shadow-lg shadow-slate-200 dark:shadow-none">
            <span class="material-symbols-outlined text-xl">qr_code_2</span>
            <span class="text-sm font-bold">Cetak Label</span>
        </a>

        <form action="{{ route('perawatan_inventaris.storeFromBarang', $barang->id) }}" method="POST">
            @csrf
            <button type="submit"
                class="flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-xl transition-all shadow-lg shadow-amber-100 dark:shadow-none">
                <span class="material-symbols-outlined text-xl">build</span>
                <span class="text-sm font-bold">Maintenance</span>
            </button>
        </form>
    </div>
</div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- Column Left: Detail --}}
                <div class="lg:col-span-8 space-y-8">

                    {{-- Stats Cards --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4" data-aos="fade-up" data-aos-delay="100">
                        <div
                            class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm">
                            <p class="text-xs font-semibold text-slate-400 uppercase mb-2">Kondisi</p>
                            <span
                                class="px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $barang->persentase_kondisi >= 70 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                {{ $barang->kondisi }}
                            </span>
                        </div>
                        <div
                            class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm">
                            <p class="text-xs font-semibold text-slate-400 uppercase mb-1">Total Unit</p>
                            <p class="text-2xl font-black text-slate-800 dark:text-white">{{ $barang->jumlah }} <span
                                    class="text-sm font-normal text-slate-400">Pcs</span></p>
                        </div>
                        <div
                            class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm">
                            <p class="text-xs font-semibold text-slate-400 uppercase mb-1">Tahun</p>
                            <p class="text-2xl font-black text-slate-800 dark:text-white">
                                {{ $barang->tanggal_perolehan ? \Carbon\Carbon::parse($barang->tanggal_perolehan)->format('Y') : '-' }}
                            </p>
                        </div>
                        <div
                            class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm border-b-4 border-b-primary">
                            <p class="text-xs font-semibold text-slate-400 uppercase mb-1">Nilai Aset</p>
                            <p class="text-lg font-black text-primary">
                                Rp{{ number_format($barang->nilai_perolehan, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    {{-- Information Main Card --}}
                    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm overflow-hidden"
                        data-aos="fade-up" data-aos-delay="200">
                        <div class="p-8">
                            <div class="flex items-center gap-3 mb-8 border-b border-slate-50 dark:border-slate-700 pb-5">
                                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                                    <span class="material-symbols-outlined text-primary text-xl font-bold">analytics</span>
                                </div>
                                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Spesifikasi Teknis</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                                <div class="space-y-6">
                                    <div>
                                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Merk &
                                            Tipe</label>
                                        <p class="text-slate-700 dark:text-slate-200 font-semibold text-lg">
                                            {{ $barang->merk ?? 'Generic' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Nomor
                                            Seri / S/N</label>
                                        <p class="text-slate-700 dark:text-slate-200 font-mono text-md italic">
                                            {{ $barang->nomor_seri ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <label
                                            class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Kategori
                                            Aset</label>
                                        <p class="text-slate-700 dark:text-slate-200 font-semibold">{{ $barang->kategori }}
                                        </p>
                                    </div>
                                </div>
                                <div class="space-y-6">
                                    <div>
                                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Asal
                                            Pengadaan</label>
                                        <p class="text-slate-700 dark:text-slate-200 font-semibold">
                                            {{ $barang->asal_pengadaan ?? 'Hibah/Internal' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">NUP
                                            BMN</label>
                                        <p class="text-slate-700 dark:text-slate-200 font-semibold italic">
                                            {{ $barang->nup ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label
                                            class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Tanggal
                                            Input</label>
                                        <p class="text-slate-700 dark:text-slate-200 font-semibold">
                                            {{ $barang->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="mt-10 p-6 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                                <h4
                                    class="text-sm font-black text-slate-800 dark:text-white mb-3 flex items-center gap-2 italic uppercase tracking-wider">
                                    <span class="material-symbols-outlined text-primary text-sm">history_edu</span>
                                    Deskripsi Tambahan
                                </h4>
                                <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed italic opacity-80">
                                    "{{ $barang->catatan ?? 'Tidak ada catatan khusus untuk aset ini.' }}"
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Lokasi Preview --}}
                    <div class="bg-white dark:bg-slate-800 p-8 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm"
                        data-aos="fade-up">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-rose-50 dark:bg-rose-900/30 rounded-lg">
                                    <span
                                        class="material-symbols-outlined text-rose-500 text-xl font-bold">location_on</span>
                                </div>
                                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Lokasi</h3>
                            </div>
                            <span
                                class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">{{ $barang->ruangan }}</span>
                        </div>

                        <div
                            class="relative group rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-900 aspect-video md:aspect-[21/9] border border-slate-100 dark:border-slate-700">
                            @if ($barang->posisi)
                                <img src="{{ asset('storage/' . $barang->posisi) }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <div class="flex flex-col items-center justify-center h-full text-slate-400">
                                    <span
                                        class="material-symbols-outlined text-6xl mb-2 opacity-20">not_listed_location</span>
                                    <p class="text-xs font-bold uppercase tracking-tighter opacity-50">Visual lokasi tidak
                                        tersedia</p>
                                </div>
                            @endif
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                                <p class="text-white text-xs font-black uppercase tracking-widest">Informasi Lokasi
                                    Strategis</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Column Right: Media --}}
                <div class="lg:col-span-4 space-y-6">

                    {{-- Physical Photo --}}
                    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 shadow-sm p-4"
                        data-aos="fade-left">
                        <div
                            class="relative group rounded-2xl overflow-hidden bg-slate-50 dark:bg-slate-900 aspect-square mb-4 border border-slate-50 dark:border-slate-700">
                            @if ($barang->foto)
                                <img src="{{ asset('storage/' . $barang->foto) }}"
                                    class="w-full h-full object-contain p-4 group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="flex flex-col items-center justify-center h-full text-slate-300">
                                    <span class="material-symbols-outlined text-7xl opacity-20">image</span>
                                </div>
                            @endif
                        </div>
                        <div class="text-center pb-2">
                            <h4 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-tighter">Foto
                                Fisik Barang</h4>
                            <p class="text-[10px] text-slate-400 font-medium">Terakhir diperbarui:
                                {{ $barang->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    {{-- Digital ID Card --}}
                    <div class="bg-gradient-to-br from-primary to-blue-700 rounded-3xl shadow-xl p-8 text-white relative overflow-hidden"
                        data-aos="fade-left" data-aos-delay="100">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                        <div class="relative z-10 flex flex-col items-center">
                            <h4 class="text-xs font-black uppercase tracking-[0.2em] mb-6 opacity-80">Identitas Digital
                            </h4>
                            <div
                                class="bg-white p-3 rounded-2xl shadow-inner mb-6 transition-transform hover:scale-105 duration-500">
                                <img src="{{ asset('storage/' . $barang->qr_code) }}" class="w-32 h-32">
                            </div>
                            <p class="text-[10px] font-bold tracking-widest uppercase mb-1">Asset Security Code</p>
                            <p class="text-xs font-mono opacity-80 select-all">{{ $barang->uuid }}</p>
                        </div>
                    </div>

                    {{-- Maintenance Status --}}
                    @if ($perawatan)
                        <div class="bg-amber-50 dark:bg-amber-900/20 rounded-3xl border border-amber-100 dark:border-amber-800/50 p-6"
                            data-aos="zoom-in">
                            <div class="flex items-center gap-4">
                                <div class="relative flex items-center justify-center">
                                    <span
                                        class="absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75 animate-ping"></span>
                                    <div
                                        class="relative p-2 bg-amber-500 rounded-full text-white shadow-lg shadow-amber-200 dark:shadow-none">
                                        <span class="material-symbols-outlined text-sm font-bold">engineering</span>
                                    </div>
                                </div>
                                <div>
                                    <h4
                                        class="text-xs font-black text-amber-900 dark:text-amber-200 uppercase tracking-widest">
                                        Perawatan Aktif</h4>
                                    <p class="text-xs text-amber-700 dark:text-amber-400 font-bold italic">
                                        {{ ucfirst($perawatan->status) }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Delete Action --}}
                    <form action="{{ route('bmn.delete', [$ruangan, $barang->id]) }}" method="POST"
                        onsubmit="return confirm('Anda yakin ingin menghapus aset berharga ini?')" class="pt-4"
                        data-aos="fade-up">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 py-3 rounded-2xl border border-transparent hover:border-rose-100 transition-all text-xs font-black uppercase tracking-widest italic">
                            <span class="material-symbols-outlined text-sm">delete_sweep</span>
                            Hapus Permanen
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            easing: 'ease-out-quad'
        });
    </script>

    <style>
        /* HIDE SCROLLBAR BUT KEEP SCROLLABLE */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        /* PREVENT HORIZONTAL SCROLL */
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }

        .font-display {
            font-family: 'Inter', sans-serif;
        }
    </style>
@endsection
