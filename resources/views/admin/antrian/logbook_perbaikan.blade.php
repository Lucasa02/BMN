@extends('layouts.admin.main')

@section('content')
<style>
    /* Animasi Smooth dari Index */
    .animate-fade-in-up {
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(30px);
    }
    @keyframes fadeInUp {
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="px-6 py-8 min-h-screen bg-slate-50/50 dark:bg-gray-900/50">
    {{-- Header Page --}}
    <div class="mb-8 flex flex-col md:flex-row justify-between md:items-end gap-6 border-b border-gray-200/80 dark:border-gray-700 pb-6 relative animate-fade-in-up" style="animation-delay: 0ms;">
        <div class="absolute bottom-0 left-0 w-24 h-1 bg-gradient-to-r from-[#1b365d] to-amber-500 rounded-t-md"></div>

        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="bg-[#1b365d]/10 dark:bg-[#1b365d]/30 p-2.5 rounded-xl text-[#1b365d] dark:text-blue-400 shadow-sm border border-[#1b365d]/10">
                    <i class="fa-solid fa-book-open text-xl"></i>
                </span>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    Logbook Tim <span class="text-[#1b365d] dark:text-blue-400">Perbaikan</span>
                </h1>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 max-w-2xl leading-relaxed font-medium">
                Pantau riwayat pekerjaan, progres, dan hasil perbaikan BMN dari masing-masing teknisi.
            </p>
            <div class="inline-flex mt-3 items-center gap-2 px-3 py-1 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-md">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                <p class="text-[10px] text-amber-700 dark:text-amber-400 font-extrabold tracking-widest uppercase">
                    Periode: {{ $periodeText }}
                </p>
            </div>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.antrean-perbaikan.index') }}"
                class="group flex items-center px-4 py-2.5 text-sm font-bold text-[#1b365d] dark:text-blue-400 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm hover:shadow-md hover:border-[#1b365d]/30 transition-all duration-300">
                <span class="group-hover:-translate-x-1 transition-transform duration-300"><i class="fas fa-arrow-left mr-2"></i></span> Kembali ke Antrean
            </a>
        </div>
    </div>

    {{-- Filter Card Premium --}}
    <div class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-[0_4px_20px_-5px_rgba(27,54,93,0.08)] border border-gray-100 dark:border-gray-700 p-6 mb-8 animate-fade-in-up" style="animation-delay: 100ms;">
        <form method="GET" action="{{ route('admin.antrean-perbaikan.logbook') }}" class="flex flex-col lg:flex-row items-end gap-5 w-full">

            {{-- Filter Teknisi --}}
            <div class="w-full lg:w-1/3">
                <label for="teknisi_id" class="block text-[10px] font-extrabold text-[#1b365d]/70 dark:text-blue-300 mb-2 uppercase tracking-widest">Pilih Teknisi</label>
                <select name="teknisi_id" id="teknisi_id" class="block w-full py-2.5 px-4 border border-gray-200 dark:border-gray-600 rounded-xl bg-slate-50 dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 font-medium focus:ring-2 focus:ring-[#1b365d]/20 focus:border-[#1b365d] transition-colors shadow-sm outline-none">
                    <option value="">Semua Teknisi</option>
                    @foreach($teknisiList as $t)
                        <option value="{{ $t->id }}" {{ request('teknisi_id') == $t->id ? 'selected' : '' }}>
                            {{ $t->nama_lengkap }} ({{ $t->nip }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Bulan --}}
            <div class="w-full lg:w-1/4">
                <label for="filter_bulan" class="block text-[10px] font-extrabold text-[#1b365d]/70 dark:text-blue-300 mb-2 uppercase tracking-widest">Bulan</label>
                <select name="filter_bulan" id="filter_bulan" class="block w-full py-2.5 px-4 border border-gray-200 dark:border-gray-600 rounded-xl bg-slate-50 dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 font-medium focus:ring-2 focus:ring-[#1b365d]/20 focus:border-[#1b365d] transition-colors shadow-sm outline-none">
                    <option value="">Semua Bulan</option>
                    @foreach(['01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'] as $key => $val)
                        <option value="{{ $key }}" {{ request('filter_bulan') == $key ? 'selected' : '' }}>{{ $val }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Tahun --}}
            <div class="w-full lg:w-1/4">
                <label for="filter_tahun" class="block text-[10px] font-extrabold text-[#1b365d]/70 dark:text-blue-300 mb-2 uppercase tracking-widest">Tahun</label>
                <select name="filter_tahun" id="filter_tahun" class="block w-full py-2.5 px-4 border border-gray-200 dark:border-gray-600 rounded-xl bg-slate-50 dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 font-medium focus:ring-2 focus:ring-[#1b365d]/20 focus:border-[#1b365d] transition-colors shadow-sm outline-none">
                    <option value="">Semua Tahun</option>
                    @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}" {{ request('filter_tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>

            {{-- Tombol --}}
            <div class="flex gap-3 w-full lg:w-auto">
                <button type="submit" class="bg-[#1b365d] hover:bg-[#122643] text-white px-6 py-2.5 text-sm font-bold rounded-xl shadow-[0_4px_10px_-2px_rgba(27,54,93,0.3)] hover:shadow-[0_6px_15px_-2px_rgba(27,54,93,0.4)] hover:-translate-y-0.5 transition-all duration-300">
                    <i class="fa-solid fa-filter mr-1.5"></i> Terapkan
                </button>
                @if(request()->has('teknisi_id') || request()->has('filter_bulan') || request()->has('filter_tahun'))
                    <a href="{{ route('admin.antrean-perbaikan.logbook') }}" class="bg-white border border-gray-200 dark:bg-gray-700 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-[#1b365d] dark:text-blue-300 px-5 py-2.5 text-sm font-bold rounded-xl shadow-sm transition-all duration-300">
                        <i class="fa-solid fa-rotate-right"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Content Area --}}
    @if($logbook->isEmpty())
        <div class="animate-fade-in-up flex flex-col items-center justify-center py-24 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden" style="animation-delay: 200ms;">
            <div class="absolute top-0 w-full h-1 bg-gradient-to-r from-transparent via-[#1b365d]/20 to-transparent"></div>
            <div class="p-6 bg-gradient-to-br from-[#1b365d]/5 to-amber-500/5 dark:from-[#1b365d]/20 dark:to-amber-500/10 rounded-full mb-5 border border-[#1b365d]/10 shadow-inner">
                <i class="fa-solid fa-folder-open text-5xl text-[#1b365d]/60 dark:text-blue-400/80 drop-shadow-sm"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Tidak Ada Data Logbook</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center font-medium max-w-sm">Belum ada riwayat perbaikan untuk filter teknisi atau periode waktu yang Anda pilih.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($logbook as $l)
                @php
                    $badgeColors = [
                        'selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/50',
                        'diperbaiki' => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800/50',
                        'tidak_dapat_diperbaiki' => 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800/50',
                        'proses' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800/50'
                    ];
                    $colorClass = $badgeColors[$l->status] ?? 'bg-gray-50 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700';
                @endphp

                <div class="animate-fade-in-up bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07)] hover:shadow-[0_15px_30px_-5px_rgba(27,54,93,0.12)] hover:-translate-y-1.5 transition-all duration-500 ease-out flex flex-col group overflow-hidden relative" style="animation-delay: {{ ($loop->iteration % 12) * 75 + 100 }}ms;">

                    {{-- Top Accent Gradient --}}
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#1b365d] via-blue-700 to-amber-400 opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="p-5 flex gap-4 border-b border-gray-50 dark:border-gray-700 mt-1">
                        {{-- Gambar Barang --}}
                        <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0 border border-gray-100 dark:border-gray-700 bg-gray-50 relative">
                            <img src="{{ $l->barang->foto ? asset('storage/' . $l->barang->foto) : asset('img/no-image.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out" alt="Barang">
                            <div class="absolute inset-0 ring-1 ring-inset ring-black/5 rounded-xl"></div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <span class="inline-block {{ $colorClass }} text-[9px] font-extrabold px-2 py-0.5 rounded border uppercase tracking-widest mb-1.5 shadow-sm">
                                {{ str_replace('_', ' ', $l->status) }}
                            </span>
                            <h3 class="font-bold text-gray-800 dark:text-white text-sm line-clamp-2 leading-tight group-hover:text-[#1b365d] dark:group-hover:text-blue-300 transition-colors duration-300">{{ $l->barang->nama_barang }}</h3>
                            <p class="text-[10px] text-gray-500 font-medium mt-1.5 flex items-center gap-1">
                                <i class="fa-regular fa-calendar-check text-[#1b365d]/70 dark:text-blue-400"></i> {{ $l->updated_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="p-5 flex-1 bg-gray-50/50 dark:bg-gray-800/30">
                        <div class="mb-3">
                            <p class="text-[10px] uppercase font-bold tracking-widest text-[#1b365d]/50 dark:text-gray-500 mb-1.5">Teknisi Penanggung Jawab</p>
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-[#1b365d] to-[#122643] shadow-sm flex items-center justify-center text-amber-400 font-extrabold text-xs border border-[#0d1e36] group-hover:rotate-6 transition-transform duration-300">
                                    {{ strtoupper(substr($l->user->nama_lengkap ?? '?', 0, 1)) }}
                                </div>
                                <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $l->user->nama_lengkap ?? 'Teknisi Dihapus' }}</p>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-900/50 p-3.5 rounded-xl border border-gray-100 dark:border-gray-700 group-hover:border-[#1b365d]/10 transition-colors duration-300 shadow-sm relative mt-2">
                            <i class="fa-solid fa-quote-left absolute top-2 left-2 text-xs text-gray-200 dark:text-gray-700 group-hover:text-amber-400/30 transition-colors"></i>
                            <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed font-medium italic pl-4">
                                {{ $l->deskripsi }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-10 border-t border-gray-200/80 dark:border-gray-700 pt-8 animate-fade-in-up" style="animation-delay: 500ms;">
            {{ $logbook->links() }}
        </div>
    @endif
</div>
@endsection
