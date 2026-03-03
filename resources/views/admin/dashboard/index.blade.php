@extends('layouts.admin.main')

@section('content')
<main class="flex-1 px-4 sm:px-8 py-8 bg-[#F8FAFC] dark:bg-[#0F172A] min-h-screen transition-colors duration-500">
    <div class="max-w-[1600px] mx-auto space-y-10">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 animate-reveal">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Dashboard <span class="text-[#1b365d] bg-clip-text text-transparent bg-gradient-to-r from-[#1b365d] to-[#2d5a9e]">ESIMBA</span>
                </h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1 font-medium">Selamat datang kembali, berikut ringkasan aset Anda hari ini.</p>
            </div>
            <div class="flex items-center gap-3 bg-white dark:bg-slate-800 p-2 rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700/50">
                <div class="p-2 bg-[#1b365d]/10 dark:bg-[#1b365d]/30 rounded-lg text-[#1b365d] dark:text-blue-400">
                    <span class="material-symbols-outlined text-[20px]">calendar_today</span>
                </div>
                <div class="pr-4">
                    <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400">Tanggal Hari Ini</p>
                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">{{ now()->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Hero Slider Section (Bento Style) --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-8 relative group rounded-[2rem] overflow-hidden shadow-2xl shadow-[#1b365d]/10 border border-white dark:border-slate-800 animate-reveal delay-100">
                <div id="hero-slider" class="absolute inset-0 z-0">
                    @if ($slider_images->isEmpty())
                        <div class="absolute inset-0 bg-cover bg-center active-slide slider-item"
                             style="background-image: url('{{ asset('images/default-image.jpg') }}')">
                        </div>
                    @else
                        @foreach ($slider_images as $index => $img)
                            <div class="absolute inset-0 bg-cover bg-center transition-all duration-[1200ms] ease-in-out
                                {{ $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }} slider-item"
                                style="background-image: url('{{ asset('storage/' . $img->image_path) }}');">
                            </div>
                        @endforeach
                    @endif
                </div>

                {{-- Overlay & Content --}}
                <div class="absolute inset-0 bg-gradient-to-t from-[#1b365d]/90 via-[#1b365d]/20 to-transparent z-10"></div>
                <div class="absolute bottom-0 left-0 p-8 z-20 w-full flex justify-between items-end">
                    <div class="space-y-2">
                        <span class="px-3 py-1 bg-[#1b365d]/30 backdrop-blur-md border border-white/20 text-blue-100 text-xs font-bold rounded-full uppercase tracking-widest">Featured Assets</span>
                        <h2 class="text-2xl md:text-3xl font-bold text-white">Kelola Inventaris Lebih Efisien</h2>
                    </div>
                    <a href="{{ route('slider.index') }}"
                       class="group/btn flex items-center gap-2 bg-white/10 hover:bg-white backdrop-blur-xl border border-white/30 hover:border-white text-white hover:text-[#1b365d] px-6 py-3 rounded-2xl transition-all duration-300 font-bold shadow-xl">
                        <span class="material-symbols-outlined group-hover/btn:rotate-180 transition-transform duration-500">settings</span>
                    </a>
                </div>
            </div>

            {{-- Quick Stats Sidebar Bento --}}
            <div class="lg:col-span-4 grid grid-cols-1 gap-6">
                <div class="bg-gradient-to-br from-[#1b365d] to-[#2d5a9e] rounded-[2rem] p-8 text-white relative overflow-hidden group animate-reveal delay-200">
                    <div class="relative z-10">
                        <p class="text-blue-100 font-medium opacity-80 text-sm">Total Pengguna Terdaftar</p>
                        <h3 class="text-5xl font-black mt-2 tracking-tighter">{{ $user }}</h3>
                        <div class="mt-8 flex -space-x-3">
                            @for($i=0; $i<5; $i++)
                            <div class="w-10 h-10 rounded-full border-2 border-[#1b365d] bg-slate-200 flex items-center justify-center text-[10px] text-slate-600 font-bold">U</div>
                            @endfor
                            <div class="w-10 h-10 rounded-full border-2 border-[#1b365d] bg-white/20 backdrop-blur-md flex items-center justify-center text-[10px] font-bold">+{{ $user }}</div>
                        </div>
                    </div>
                    <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[150px] opacity-10 group-hover:scale-110 transition-transform duration-700">group</span>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-[2rem] p-8 border border-slate-200/60 dark:border-slate-700/50 shadow-sm animate-reveal delay-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 font-medium text-sm">Kategori & Ruangan</p>
                            <h3 class="text-3xl font-bold text-slate-800 dark:text-white mt-1">{{ $bmn_kategori + $bmn_ruangan }}</h3>
                        </div>
                        <div class="p-4 bg-amber-50 dark:bg-amber-900/20 text-amber-600 rounded-2xl">
                            <span class="material-symbols-outlined">meeting_room</span>
                        </div>
                    </div>
                    <div class="mt-6 flex gap-4">
                        <div class="flex-1 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-xl border border-slate-100 dark:border-slate-700">
                            <p class="text-[10px] uppercase font-bold text-slate-400">Ruangan</p>
                            <p class="text-lg font-bold text-slate-700 dark:text-slate-200">{{ $bmn_ruangan }}</p>
                        </div>
                        <div class="flex-1 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-xl border border-slate-100 dark:border-slate-700">
                            <p class="text-[10px] uppercase font-bold text-slate-400">Kategori</p>
                            <p class="text-lg font-bold text-slate-700 dark:text-slate-200">{{ $bmn_kategori }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Statistics Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Card: Barang --}}
            <div class="stat-card-premium animate-reveal delay-400 group">
                <div class="flex justify-between items-center mb-6">
                    <div class="p-3 bg-[#1b365d]/10 dark:bg-[#1b365d]/30 text-[#1b365d] dark:text-blue-400 rounded-2xl group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 bg-[#1b365d]/10 text-[#1b365d] dark:bg-[#1b365d]/40 dark:text-blue-200 rounded-full">Total BMN</span>
                </div>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white">{{ $barang }}</h3>
                <p class="text-slate-500 text-sm mt-1">Aset BMN terdaftar</p>

                <div class="mt-8 space-y-4">
                    @php
                        $available_pct = $barang > 0 ? ($barang_tersedia / $barang) * 100 : 0;
                    @endphp
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-bold italic tracking-wide">
                            <span class="text-slate-600 dark:text-slate-400">KONDISI LAYAK</span>
                            <span class="text-[#1b365d] dark:text-blue-400">{{ round($available_pct) }}%</span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full bg-[#1b365d] rounded-full transition-all duration-1000" style="width: {{ $available_pct }}%"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase font-extrabold tracking-tighter">Rusak</p>
                            <p class="text-lg font-bold text-red-500">{{ $barang_rusak }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase font-extrabold tracking-tighter">Kurang Baik</p>
                            <p class="text-lg font-bold text-amber-500">{{ $barang_kurang_baik }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Perawatan Inventaris --}}
            <div class="stat-card-premium animate-reveal delay-500 group border-b-4 border-b-orange-500">
                <div class="flex justify-between items-center mb-6">
                    <div class="p-3 bg-orange-50 dark:bg-orange-900/30 text-orange-600 rounded-2xl group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">build_circle</span>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-300 rounded-full">Maintenance</span>
                </div>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white">{{ $perawatan }}</h3>
                <p class="text-slate-500 text-sm mt-1">Total aset dalam perbaikan</p>

                <div class="mt-8 grid grid-cols-1 gap-3">
                    <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-100 dark:border-slate-700">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-slate-400"></div>
                            <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">Menunggu (Pending)</span>
                        </div>
                        <span class="text-lg font-bold text-slate-800 dark:text-white">{{ $perawatan_pending }}</span>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-100 dark:border-slate-700">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-[#1b365d] animate-pulse"></div>
                            <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">Sedang Dikerjakan</span>
                        </div>
                        <span class="text-lg font-bold text-slate-800 dark:text-white">{{ $perawatan_proses }}</span>
                    </div>
                </div>
            </div>

            {{-- Card: Laporan Kerusakan --}}
            <div class="stat-card-premium animate-reveal delay-600 group border-b-4 border-b-red-500">
                <div class="flex justify-between items-center mb-6">
                    <div class="p-3 bg-red-50 dark:bg-red-900/30 text-red-600 rounded-2xl group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">report_gmailerrorred</span>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300 rounded-full">Incoming Reports</span>
                </div>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white">{{ $laporan_total }}</h3>
                <p class="text-slate-500 text-sm mt-1">Total aduan kerusakan</p>

                <div class="mt-8 space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500 italic">Rasio Persetujuan</span>
                    </div>
                    <div class="flex h-3 w-full bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                        @php
                            $approve_pct = $laporan_total > 0 ? ($laporan_disetujui / $laporan_total) * 100 : 0;
                            $reject_pct = $laporan_total > 0 ? ($laporan_ditolak / $laporan_total) * 100 : 0;
                            $pending_pct = $laporan_total > 0 ? ($laporan_pending / $laporan_total) * 100 : 0;
                        @endphp
                        <div class="bg-emerald-500 h-full" style="width: {{ $approve_pct }}%" title="Disetujui"></div>
                        <div class="bg-red-500 h-full" style="width: {{ $reject_pct }}%" title="Ditolak"></div>
                        <div class="bg-yellow-400 h-full" style="width: {{ $pending_pct }}%" title="Pending"></div>
                    </div>
                    <div class="flex flex-col gap-2 text-[10px] font-bold">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-1.5 text-yellow-600">
                                <span class="w-2 h-2 rounded-full bg-yellow-400"></span> MENUNGGU ({{ $laporan_pending }})
                            </div>
                            <div class="flex items-center gap-1.5 text-emerald-600">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> DISETUJUI ({{ $laporan_disetujui }})
                            </div>
                        </div>
                        <a href="{{ route('admin.laporan-kerusakan.index') }}" class="mt-2 text-center py-2 bg-slate-100 dark:bg-slate-700 rounded-lg hover:bg-red-50 hover:text-red-600 transition-colors">
                            Lihat Semua Laporan →
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<style>
    /* Premium Entry Animation */
    @keyframes reveal {
        from { opacity: 0; transform: translateY(30px) scale(0.98); filter: blur(10px); }
        to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
    }

    .animate-reveal {
        opacity: 0;
        animation: reveal 1s cubic-bezier(0.19, 1, 0.22, 1) forwards;
    }

    .delay-100 { animation-delay: 100ms; }
    .delay-200 { animation-delay: 200ms; }
    .delay-300 { animation-delay: 300ms; }
    .delay-400 { animation-delay: 400ms; }
    .delay-500 { animation-delay: 500ms; }
    .delay-600 { animation-delay: 600ms; }

    /* Card Premium Styling */
    .stat-card-premium {
        background: white;
        padding: 2rem;
        border-radius: 2.5rem;
        border: 1px solid rgba(226, 232, 240, 0.7);
        box-shadow: 0 10px 30px -15px rgba(0,0,0,0.05);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .dark .stat-card-premium {
        background: #1E293B;
        border-color: rgba(51, 65, 85, 0.5);
    }

    .stat-card-premium:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px -15px rgba(0,0,0,0.1);
        border-color: #1b365d; /* Menggunakan Navy Blue saat hover */
    }

    /* Slider Ken Burns */
    .slider-item {
        transform: scale(1);
    }
    .active-ken-burns {
        transform: scale(1.15);
        transition: transform 10s ease-out;
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const slides = document.querySelectorAll("#hero-slider .slider-item");
    if (slides.length <= 1) {
        if(slides[0]) slides[0].classList.add("active-ken-burns");
        return;
    }

    let current = 0;
    slides[0].classList.add("active-ken-burns");

    setInterval(() => {
        const activeSlide = slides[current];
        activeSlide.classList.remove("opacity-100", "z-10", "active-ken-burns");
        activeSlide.classList.add("opacity-0", "z-0");

        current = (current + 1) % slides.length;
        const nextSlide = slides[current];

        nextSlide.classList.remove("opacity-0", "z-0");
        nextSlide.classList.add("opacity-100", "z-10");

        void nextSlide.offsetWidth;
        nextSlide.classList.add("active-ken-burns");
    }, 6000);
});
</script>
@endsection
