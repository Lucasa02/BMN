@extends('layouts.admin.main')

@section('content')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <div class="min-h-screen bg-[#f8fafc] dark:bg-[#0b1120] font-['Plus_Jakarta_Sans'] pb-20 overflow-x-hidden">

        {{-- High-End Decorative Top Bar --}}
        <div class="h-1.5 w-full bg-gradient-to-r from-[#1b365d] via-[#3b82f6] to-[#1b365d] opacity-80"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">

            {{-- Navigation & Top Actions --}}
            <div class="flex flex-wrap items-center justify-between gap-6 mb-10" data-aos="fade-down">
                <div class="space-y-1">
                    <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                        <a href="{{ route('barang.bmn_index', $ruangan) }}" class="hover:text-[#1b365d] transition-colors">Inventaris</a>
                        <span class="material-symbols-outlined text-[12px]">chevron_right</span>
                        <span class="text-[#1b365d] dark:text-blue-400">Arsip Digital</span>
                    </nav>
                    <h2 class="text-slate-900 dark:text-white font-bold tracking-tight italic">Detail Aset Negara</h2>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('barang.bmn_index', $ruangan) }}"
                       class="flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl text-slate-600 dark:text-slate-300 hover:bg-slate-50 transition-all shadow-sm">
                        <span class="material-symbols-outlined text-lg">arrow_back</span>
                        <span class="text-xs font-bold uppercase tracking-wider">Kembali</span>
                    </a>
                    <a href="{{ route('bmn.edit', [$ruangan, $barang->id]) }}"
                       class="flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-800 border border-[#1b365d]/20 dark:border-slate-700 rounded-2xl text-[#1b365d] dark:text-blue-300 hover:border-[#1b365d] transition-all shadow-sm">
                        <span class="material-symbols-outlined text-lg">edit</span>
                        <span class="text-xs font-bold uppercase tracking-wider">Sunting</span>
                    </a>
                </div>
            </div>

            {{-- Hero Section: Main Profile --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 mb-12">

                {{-- Left: The Master Image --}}
                <div class="lg:col-span-4" data-aos="zoom-in-right">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-tr from-[#1b365d] to-blue-400 rounded-[3rem] blur opacity-10 group-hover:opacity-20 transition duration-1000"></div>
                        <div class="relative bg-white dark:bg-slate-800 p-3 rounded-[2.8rem] shadow-2xl shadow-slate-200/50 dark:shadow-none border border-white dark:border-slate-700">
                            <div class="aspect-square rounded-[2.2rem] overflow-hidden bg-slate-50 dark:bg-[#0f172a] relative">
                                @if ($barang->foto)
                                    <img src="{{ asset('storage/' . $barang->foto) }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-slate-200">
                                        <span class="material-symbols-outlined text-8xl">inventory_2</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-[#1b365d]/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            </div>
                        </div>

                        {{-- Status Overlay --}}
                        <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-3/4">
                            <div class="bg-white dark:bg-slate-800 px-6 py-3 rounded-2xl shadow-xl border border-slate-50 dark:border-slate-700 flex justify-between items-center">
                                <span class="text-[10px] font-black uppercase text-slate-400">Kondisi</span>
                                <span class="px-3 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-xs font-black">{{ $barang->kondisi }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Identity & High-Level Stats --}}
                <div class="lg:col-span-8 flex flex-col justify-center" data-aos="fade-left">
                    <div class="space-y-6">
                        <div class="inline-flex items-center gap-3 px-4 py-2 bg-[#1b365d]/5 dark:bg-blue-900/20 text-[#1b365d] dark:text-blue-300 rounded-xl border border-[#1b365d]/10">
                            <div class="flex gap-1">
                                <div class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></div>
                                <div class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-pulse delay-75"></div>
                            </div>
                            <span class="text-[10px] font-bold uppercase tracking-[0.2em]">Asset ID: {{ $barang->kode_barang }}</span>
                        </div>

                        <h1 class="text-5xl lg:text-7xl font-black text-slate-900 dark:text-white tracking-tighter leading-none">
                            {{ $barang->nama_barang }}
                        </h1>

                        <p class="text-2xl text-slate-400 dark:text-slate-500 font-medium italic">
                            {{ $barang->merk ?? 'Standard Issue' }} • <span class="text-[#1b365d] dark:text-blue-400">{{ $barang->kategori }}</span>
                        </p>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-6">
                            @php
                                $stats = [
                                    ['label' => 'Nilai Perolehan', 'val' => 'Rp'.number_format($barang->nilai_perolehan, 0, ',', '.'), 'color' => 'text-[#1b365d]'],
                                    ['label' => 'Tahun', 'val' => $barang->tanggal_perolehan ? \Carbon\Carbon::parse($barang->tanggal_perolehan)->format('Y') : '-', 'color' => 'text-slate-800'],
                                    ['label' => 'Jumlah Unit', 'val' => $barang->jumlah . ' Unit', 'color' => 'text-slate-800'],
                                    ['label' => 'NUP', 'val' => '#'.($barang->nup ?? '000'), 'color' => 'text-blue-600'],
                                ];
                            @endphp
                            @foreach($stats as $s)
                                <div class="bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm p-5 rounded-3xl border border-white dark:border-slate-700 shadow-sm transition-transform hover:-translate-y-1">
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ $s['label'] }}</p>
                                    <p class="text-lg font-black {{ $s['color'] }} dark:text-white">{{ $s['val'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- Column Left: Details & Visual Penempatan --}}
                <div class="lg:col-span-2 space-y-10">

                    {{-- Detailed Specifications --}}
                    <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] p-10 border border-slate-100 dark:border-slate-700 shadow-sm relative overflow-hidden" data-aos="fade-up">
                        <div class="flex items-center gap-4 mb-10">
                            <div class="w-12 h-12 bg-[#1b365d] rounded-2xl flex items-center justify-center text-white">
                                <span class="material-symbols-outlined">analytics</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Spesifikasi Teknis</h3>
                                <p class="text-xs text-slate-400 font-medium uppercase tracking-widest">Parameter Aset Terdaftar</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                            @php
                                $details = [
                                    ['label' => 'Asal Pengadaan', 'value' => $barang->asal_pengadaan ?? 'Hibah/Internal', 'icon' => 'account_balance'],
                                    ['label' => 'Nomor Seri / SN', 'value' => $barang->nomor_seri ?? 'N/A', 'icon' => 'barcode'],
                                    ['label' => 'Unit Kerja', 'value' => $barang->unit_kerja ?? '-', 'icon' => 'corporate_fare'],
                                    ['label' => 'Tanggal Input', 'value' => $barang->created_at->format('d M Y'), 'icon' => 'history'],
                                ];
                            @endphp
                            @foreach($details as $d)
                                <div class="flex items-center gap-5 group">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-900 flex items-center justify-center text-slate-400 group-hover:bg-[#1b365d] group-hover:text-white transition-all duration-300">
                                        <span class="material-symbols-outlined text-lg">{{ $d['icon'] }}</span>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-slate-300 dark:text-slate-500 uppercase tracking-widest">{{ $d['label'] }}</p>
                                        <p class="text-slate-700 dark:text-slate-200 font-bold tracking-tight">{{ $d['value'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-10 p-6 bg-slate-50 dark:bg-slate-900/50 rounded-[1.8rem] border border-dashed border-slate-200 dark:border-slate-700">
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed italic">
                                <span class="font-black text-[#1b365d] dark:text-blue-400 not-italic uppercase tracking-widest mr-2">Catatan:</span>
                                "{{ $barang->catatan ?? 'Tidak ada informasi tambahan yang dilampirkan.' }}"
                            </p>
                        </div>
                    </div>

                    {{-- Visual Penempatan (FOTO POSISI) --}}
                    <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] p-10 border border-slate-100 dark:border-slate-700 shadow-sm" data-aos="fade-up" data-aos-delay="100">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 rounded-2xl flex items-center justify-center text-[#1b365d] dark:text-blue-400">
                                    <span class="material-symbols-outlined">distance</span>
                                </div>
                                <div>
                                    <h3 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">Titik Penempatan</h3>
                                    <p class="text-xs text-slate-400 font-medium uppercase tracking-widest">Lokasi: {{ $barang->ruangan }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="relative group rounded-[2.2rem] overflow-hidden bg-slate-100 dark:bg-slate-900 aspect-video md:aspect-[21/8] border border-slate-100 dark:border-slate-700">
                            @if ($barang->posisi)
                                <img src="{{ asset('storage/' . $barang->posisi) }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#1b365d]/90 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex items-end p-8">
                                    <p class="text-white text-xs font-bold flex items-center gap-2 tracking-widest uppercase">
                                        <span class="material-symbols-outlined text-sm">verified</span>
                                        Dokumentasi Titik Lokasi Statis
                                    </p>
                                </div>
                            @else
                                <div class="flex flex-col items-center justify-center h-full text-slate-300 gap-3">
                                    <span class="material-symbols-outlined text-6xl opacity-20">not_listed_location</span>
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-40">Belum ada foto posisi</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Column Right: Actions & Digital ID --}}
                <div class="space-y-8" data-aos="fade-left" data-aos-delay="200">

                    {{-- Digital ID Card --}}
                    <div class="bg-[#1b365d] rounded-[2.5rem] p-8 text-white shadow-2xl shadow-blue-900/40 relative overflow-hidden group">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-400/20 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000"></div>

                        <div class="relative z-10 flex flex-col items-center text-center">
                            <h4 class="text-[10px] font-black uppercase tracking-[0.4em] opacity-60 mb-8">E-Label System</h4>

                            <div class="bg-white p-4 rounded-[2rem] shadow-2xl mb-8 transform group-hover:rotate-2 transition-transform duration-500">
                                <img src="{{ asset('storage/' . $barang->qr_code) }}" class="w-32 h-32">
                            </div>

                            <div class="space-y-1 mb-6">
                                <p class="text-[10px] font-bold text-blue-300 uppercase tracking-widest">Unique UUID</p>
                                <p class="text-[11px] font-mono opacity-80 break-all bg-black/20 p-2 rounded-lg">{{ $barang->uuid }}</p>
                            </div>

                            <a href="{{ asset('storage/' . $barang->qr_code) }}" target="_blank"
                               class="w-full py-4 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 rounded-2xl text-xs font-black uppercase tracking-[0.2em] transition-all">
                                Cetak Label QR
                            </a>
                        </div>
                    </div>

                    {{-- Maintenance Action --}}
                    <div class="space-y-3">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-4">Manajemen Operasional</p>
                        <form action="{{ route('perawatan_inventaris.storeFromBarang', $barang->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full group flex items-center justify-between p-6 bg-white dark:bg-slate-800 rounded-[2rem] border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-xl hover:border-amber-200 transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-amber-50 dark:bg-amber-900/30 rounded-2xl flex items-center justify-center text-amber-500">
                                        <span class="material-symbols-outlined group-hover:rotate-180 transition-transform duration-700">build</span>
                                    </div>
                                    <div class="text-left">
                                        <h5 class="text-sm font-black text-slate-800 dark:text-white uppercase">Maintenance</h5>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase">Update Kondisi</p>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined text-slate-300 group-hover:text-amber-500 transition-colors">chevron_right</span>
                            </button>
                        </form>

                        {{-- Delete Action --}}
                        <form action="{{ route('bmn.delete', [$ruangan, $barang->id]) }}" method="POST"
                            onsubmit="return confirm('Sistem: Anda akan menghapus aset ini secara permanen dari basis data negara. Lanjutkan?')"
                            class="pt-4 px-4 text-center">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-rose-400 hover:text-rose-600 text-[10px] font-black uppercase tracking-[0.2em] transition-colors flex items-center justify-center gap-2 mx-auto">
                                <span class="material-symbols-outlined text-sm">delete_forever</span>
                                Hapus Arsip Aset
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true,
            easing: 'ease-out-quint'
        });
    </script>

    <style>
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #1b365d; border-radius: 10px; }

        /* Modern Glass Effect */
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
@endsection
