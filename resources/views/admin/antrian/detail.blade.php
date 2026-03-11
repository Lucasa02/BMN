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

    /* Styling khusus Card Detail Premium */
    .glass-card-admin {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(27, 54, 93, 0.08); /* Subtle navy border */
        box-shadow: 0 10px 40px -10px rgba(27, 54, 93, 0.12); /* Navy shadow */
    }
    .dark .glass-card-admin {
        background: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(27, 54, 93, 0.5);
        box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.4);
    }
    .img-overlay-gradient {
        background: linear-gradient(to top, rgba(27, 54, 93, 0.9) 0%, transparent 60%);
    }
</style>

<div class="px-6 py-8 min-h-screen bg-slate-50/50 dark:bg-gray-900/50">
    {{-- Header Page --}}
    <div class="mb-8 flex flex-col justify-between gap-4 animate-fade-in-up" style="animation-delay: 0ms;">
        <div>
            <a href="{{ route('admin.antrean-perbaikan.index') }}" class="inline-flex items-center text-[#1b365d] hover:text-blue-700 dark:text-blue-400 font-bold text-sm gap-2 mb-5 transition-colors group w-max">
                <span class="group-hover:-translate-x-1 transition-transform duration-300"><i class="fa-solid fa-arrow-left"></i></span> Kembali ke Antrean
            </a>
            <div class="flex items-center gap-3">
                <span class="bg-amber-500/10 dark:bg-amber-500/20 p-2.5 rounded-xl text-amber-600 dark:text-amber-400 shadow-sm border border-amber-500/20">
                    <i class="fa-solid fa-file-circle-check text-xl"></i>
                </span>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    Detail Antrean <span class="text-[#1b365d] dark:text-blue-400">BMN</span>
                </h1>
            </div>
        </div>
    </div>

    {{-- KARTU UTAMA --}}
    <div class="glass-card-admin rounded-[2rem] overflow-hidden transition-all duration-500 relative animate-fade-in-up" style="animation-delay: 100ms;">
        {{-- Top Accent Gradient Line --}}
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#1b365d] via-blue-700 to-amber-500"></div>

        <div class="p-8 sm:p-10 mt-2">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                {{-- INFORMASI KIRI --}}
                <div class="lg:col-span-7 space-y-8">
                    {{-- Nama Barang --}}
                    <div class="relative pl-6 before:content-[''] before:absolute before:left-0 before:top-1 before:bottom-1 before:w-1.5 before:bg-gradient-to-b before:from-[#1b365d] before:to-amber-500 before:rounded-full animate-fade-in-up" style="animation-delay: 200ms;">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-[#1b365d]/60 dark:text-blue-300 mb-1.5">Identitas Aset / Barang</label>
                        <p class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white leading-tight">{{ $laporan->barang->nama_barang }}</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 animate-fade-in-up" style="animation-delay: 300ms;">
                        {{-- Tanggal --}}
                        <div class="bg-white dark:bg-gray-800/80 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-[0_2px_10px_-3px_rgba(27,54,93,0.05)] transition-all hover:shadow-lg hover:border-[#1b365d]/20 group">
                            <label class="block text-[10px] font-extrabold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-3">Waktu Laporan</label>
                            <div class="flex items-center gap-3">
                                <div class="p-2.5 bg-slate-50 dark:bg-gray-700 rounded-xl shadow-sm border border-slate-100 dark:border-gray-600 text-[#1b365d] dark:text-blue-400 group-hover:scale-110 transition-transform duration-300">
                                    <i class="fa-solid fa-calendar-check text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-extrabold text-gray-800 dark:text-gray-200">{{ $laporan->updated_at->translatedFormat('d F Y') }}</p>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $laporan->updated_at->format('H:i') }} WIB</p>
                                </div>
                            </div>
                        </div>

                        {{-- Pelapor --}}
                        <div class="bg-white dark:bg-gray-800/80 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-[0_2px_10px_-3px_rgba(27,54,93,0.05)] transition-all hover:shadow-lg hover:border-[#1b365d]/20 group">
                            <label class="block text-[10px] font-extrabold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-3">Dilaporkan Oleh</label>
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-[#1b365d] to-[#122643] shadow-md flex items-center justify-center text-amber-400 font-extrabold text-sm border border-[#0d1e36] group-hover:rotate-3 transition-transform duration-300">
                                    {{ strtoupper(substr($laporan->user->nama_lengkap ?? 'A', 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-extrabold text-gray-800 dark:text-gray-200 truncate">{{ $laporan->user->nama_lengkap ?? 'Tidak diketahui' }}</p>
                                    <p class="text-[10px] text-gray-500 dark:text-gray-400 font-semibold tracking-wide">PENGGUNA BMN</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Keluhan & Deskripsi --}}
                    <div class="animate-fade-in-up" style="animation-delay: 400ms;">
                        <div class="flex items-center justify-between mb-3">
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-[#1b365d]/60 dark:text-blue-300">Deskripsi Keluhan</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-widest bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-100 dark:border-red-800 shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5 animate-pulse"></span>
                                {{ str_replace('_', ' ', $laporan->jenis_kerusakan) }}
                            </span>
                        </div>
                        <div class="bg-slate-50 dark:bg-gray-800/50 p-6 rounded-2xl border border-slate-100 dark:border-gray-700 relative group transition-all duration-300 hover:bg-[#1b365d]/5 dark:hover:bg-gray-800 hover:shadow-md">
                            <i class="fa-solid fa-quote-left absolute top-4 left-4 text-2xl text-gray-200 dark:text-gray-700 group-hover:text-amber-400/30 transition-colors duration-300"></i>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-sm italic relative z-10 pl-8 font-medium">
                                "{{ $laporan->deskripsi }}"
                            </p>
                        </div>
                    </div>
                </div>

                {{-- FOTO KANAN --}}
                <div class="lg:col-span-5 flex flex-col items-center justify-center animate-fade-in-up" style="animation-delay: 500ms;">
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-[#1b365d]/60 dark:text-blue-300 mb-3 w-full text-left lg:text-center">Lampiran Visual</label>
                    @if ($laporan->foto)
                        <div class="group relative overflow-hidden rounded-3xl shadow-[0_10px_30px_-10px_rgba(27,54,93,0.2)] w-full aspect-[4/3] border border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800 p-1.5 transition-all duration-500 hover:shadow-[0_15px_40px_-10px_rgba(27,54,93,0.3)]">
                            <div class="w-full h-full rounded-2xl overflow-hidden relative bg-gray-50 dark:bg-gray-900">
                                <img src="{{ asset('storage/'.$laporan->foto) }}" class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-110" alt="Foto Kerusakan">
                                <div class="absolute inset-0 img-overlay-gradient opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
                                    <span class="text-white text-xs font-semibold backdrop-blur-md bg-white/20 border border-white/20 px-3.5 py-1.5 rounded-lg shadow-lg">
                                        <i class="fa-solid fa-magnifying-glass mr-1"></i> Bukti Laporan
                                    </span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="w-full aspect-[4/3] bg-slate-50 dark:bg-gray-800/50 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-600 flex flex-col items-center justify-center text-gray-400 dark:text-gray-500 transition-colors hover:border-[#1b365d]/30 hover:bg-[#1b365d]/5">
                            <div class="bg-white dark:bg-gray-700 p-4 rounded-2xl shadow-sm mb-3 border border-gray-100 dark:border-gray-600">
                                <i class="fa-regular fa-images text-3xl text-gray-300 dark:text-gray-500"></i>
                            </div>
                            <p class="text-sm font-bold text-gray-600 dark:text-gray-400">Nirvisual</p>
                            <p class="text-[10px] font-medium uppercase tracking-widest mt-1 text-gray-400">Tidak ada foto terlampir</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
