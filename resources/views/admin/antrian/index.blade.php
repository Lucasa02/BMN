@extends('layouts.admin.main')

@section('content')
{{-- Custom Styles untuk Animasi Smooth --}}
<style>
    .animate-fade-in-up {
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(30px);
    }
    @keyframes fadeInUp {
        to { opacity: 1; transform: translateY(0); }
    }
    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }
</style>

<div class="px-6 py-8 min-h-screen bg-slate-50/50 dark:bg-gray-900/50">
    {{-- Header Page --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6 border-b border-gray-200/80 dark:border-gray-700 pb-6 relative">
        <div class="absolute bottom-0 left-0 w-24 h-1 bg-gradient-to-r from-[#1b365d] to-amber-500 rounded-t-md"></div>

        <div class="animate-fade-in-up" style="animation-delay: 0ms;">
            <div class="flex items-center gap-3 mb-2">
                <span class="bg-[#1b365d]/10 dark:bg-[#1b365d]/30 p-2.5 rounded-xl text-[#1b365d] dark:text-blue-400 shadow-sm border border-[#1b365d]/10">
                    <i class="fa-solid fa-list-check text-xl"></i>
                </span>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    Antrean Perbaikan <span class="text-[#1b365d] dark:text-blue-400">BMN</span>
                </h1>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm max-w-2xl leading-relaxed font-medium">
                Sistem Manajemen Inventaris: Daftar barang milik negara yang telah disetujui dan dalam antrean perbaikan teknisi.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 animate-fade-in-up" style="animation-delay: 100ms;">
            {{-- TOMBOL MENUJU LOGBOOK TEKNISI --}}
            <a href="{{ route('admin.antrean-perbaikan.logbook') }}" class="group relative px-5 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl flex items-center justify-center gap-2 shadow-sm hover:shadow-md hover:border-[#1b365d]/30 transition-all duration-300 text-gray-700 dark:text-gray-300 font-semibold text-sm overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-[#1b365d]/0 via-[#1b365d]/5 to-[#1b365d]/0 group-hover:translate-x-full transition-transform duration-700 ease-in-out -translate-x-full"></div>
                <i class="fa-solid fa-book-open text-[#1b365d] dark:text-blue-400 group-hover:scale-110 transition-transform duration-300"></i> Lihat Logbook
            </a>

            <div class="bg-gradient-to-br from-[#1b365d] to-[#122643] border border-[#0d1e36] px-5 py-2.5 rounded-xl flex items-center gap-3 shadow-lg shadow-[#1b365d]/20 justify-center group cursor-default">
                <span class="relative flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                </span>
                <span class="text-white font-bold text-sm tracking-wide">{{ $laporan_disetujui->count() }} Antrean Aktif</span>
            </div>
        </div>
    </div>

    {{-- Empty State --}}
    @if ($laporan_disetujui->isEmpty())
    <div class="animate-fade-in-up flex flex-col items-center justify-center py-28 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-3xl border border-gray-200 dark:border-gray-700 shadow-sm relative overflow-hidden" style="animation-delay: 200ms;">
        <div class="absolute top-0 w-full h-1 bg-gradient-to-r from-transparent via-[#1b365d]/20 to-transparent"></div>
        <div class="p-6 bg-gradient-to-br from-[#1b365d]/5 to-amber-500/5 dark:from-[#1b365d]/20 dark:to-amber-500/10 rounded-full mb-6 border border-[#1b365d]/10 shadow-inner">
            <i class="fa-solid fa-shield-check text-6xl text-[#1b365d] dark:text-blue-400 drop-shadow-md"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Semua Tugas Terselesaikan</h3>
        <p class="text-gray-500 dark:text-gray-400 text-center max-w-md font-medium">Kondisi Barang Milik Negara (BMN) saat ini dalam keadaan optimal. Tidak ada antrean perbaikan untuk teknisi.</p>
    </div>
    @else

    {{-- Grid Card Mewah --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($laporan_disetujui as $l)
        <div class="animate-fade-in-up bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-2xl hover:shadow-[#1b365d]/10 hover:-translate-y-1.5 transition-all duration-500 ease-out flex flex-col group overflow-hidden relative" style="animation-delay: {{ $loop->iteration * 75 }}ms;">

            {{-- Top Accent Gradient --}}
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#1b365d] via-blue-700 to-amber-400 opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>

            <div class="p-5 flex gap-4 mt-1">
                {{-- Gambar Barang --}}
                <div class="w-20 h-20 rounded-xl overflow-hidden shrink-0 border border-gray-100 dark:border-gray-700 shadow-sm relative bg-gray-50 dark:bg-gray-900">
                    <img src="{{ $l->barang->foto ? asset('storage/' . $l->barang->foto) : asset('img/no-image.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out" alt="Barang">
                    <div class="absolute inset-0 ring-1 ring-inset ring-black/5 rounded-xl"></div>
                </div>

                <div class="flex-1 min-w-0 py-0.5">
                    <span class="inline-block bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400 text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-widest mb-2 border border-red-100 dark:border-red-800/50 shadow-sm">
                        {{ str_replace('_', ' ', $l->jenis_kerusakan) }}
                    </span>
                    <h3 class="font-bold text-gray-800 dark:text-white text-base truncate group-hover:text-[#1b365d] dark:group-hover:text-blue-300 transition-colors duration-300">{{ $l->barang->nama_barang }}</h3>
                    <p class="text-[11px] text-gray-400 mt-1.5 font-semibold flex items-center gap-1.5">
                        <i class="fa-regular fa-calendar-check text-[#1b365d]/70 dark:text-blue-400"></i>
                        {{ $l->updated_at->format('d M Y') }}
                    </p>
                </div>
            </div>

            <div class="px-5 pb-5 flex-1">
                <div class="bg-slate-50 dark:bg-gray-900/50 p-3.5 rounded-xl border border-slate-100 dark:border-gray-700 h-20 relative group-hover:bg-[#1b365d]/5 transition-colors duration-300">
                    <i class="fa-solid fa-quote-left text-gray-200 dark:text-gray-700 absolute top-2 left-2 text-sm group-hover:text-amber-400/30 transition-colors duration-300"></i>
                    <p class="text-xs text-gray-600 dark:text-gray-400 font-medium italic line-clamp-3 pl-6 leading-relaxed">
                        {{ $l->deskripsi }}
                    </p>
                </div>
            </div>

            <div class="p-5 pt-0">
                <a href="{{ route('admin.antrean-perbaikan.detail', $l->uuid) }}" class="flex justify-center items-center gap-2 w-full text-center bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 text-[#1b365d] dark:text-blue-300 hover:bg-[#1b365d] hover:border-[#1b365d] hover:text-white dark:hover:bg-blue-600 dark:hover:text-white dark:hover:border-blue-600 text-sm font-bold py-2.5 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md group/btn">
                    <span class="group-hover/btn:-translate-x-1 transition-transform duration-300"><i class="fa-regular fa-eye"></i></span>
                    Tinjau Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Navigasi Pagination --}}
    @if ($laporan_disetujui->hasPages())
        <div class="mt-10 border-t border-gray-200/80 dark:border-gray-700 pt-8 animate-fade-in-up" style="animation-delay: 500ms;">
            {{ $laporan_disetujui->links() }}
        </div>
    @endif

    @endif
</div>
@endsection
