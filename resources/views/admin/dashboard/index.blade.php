@extends('layouts.admin.main')

@section('content')
<main class="flex-1 px-4 sm:px-8 py-8 bg-[#F8FAFC] dark:bg-[#0F172A] min-h-screen transition-colors duration-500">
    <div class="max-w-[1600px] mx-auto space-y-10">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 animate-reveal">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Dashboard <span class="text-primary bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-500">Inventara</span>
                </h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1 font-medium">Selamat datang kembali, berikut ringkasan aset Anda hari ini.</p>
            </div>
            <div class="flex items-center gap-3 bg-white dark:bg-slate-800 p-2 rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700/50">
                <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-blue-600">
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
            <div class="lg:col-span-8 relative group rounded-[2rem] overflow-hidden shadow-2xl shadow-blue-500/10 border border-white dark:border-slate-800 animate-reveal delay-100">
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
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent z-10"></div>
                <div class="absolute bottom-0 left-0 p-8 z-20 w-full flex justify-between items-end">
                    <div class="space-y-2">
                        <span class="px-3 py-1 bg-blue-500/20 backdrop-blur-md border border-white/20 text-blue-200 text-xs font-bold rounded-full uppercase tracking-widest">Featured Assets</span>
                        <h2 class="text-2xl md:text-3xl font-bold text-white">Kelola Inventaris Lebih Efisien</h2>
                    </div>
                    <a href="{{ route('slider.index') }}"
                       class="group/btn flex items-center gap-2 bg-white/10 hover:bg-white backdrop-blur-xl border border-white/30 hover:border-white text-white hover:text-blue-600 px-6 py-3 rounded-2xl transition-all duration-300 font-bold shadow-xl">
                        <span class="material-symbols-outlined group-hover/btn:rotate-180 transition-transform duration-500">settings</span>
                        <span>Update Slider</span>
                    </a>
                </div>
            </div>

            {{-- Quick Stats Sidebar Bento --}}
            <div class="lg:col-span-4 grid grid-cols-1 gap-6">
                <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-[2rem] p-8 text-white relative overflow-hidden group animate-reveal delay-200">
                    <div class="relative z-10">
                        <p class="text-indigo-100 font-medium opacity-80 text-sm">Total Pengguna Terdaftar</p>
                        <h3 class="text-5xl font-black mt-2 tracking-tighter">{{ $user }}</h3>
                        <div class="mt-8 flex -space-x-3">
                            {{-- Placeholder for avatar users --}}
                            @for($i=0; $i<5; $i++)
                            <div class="w-10 h-10 rounded-full border-2 border-indigo-500 bg-slate-200 flex items-center justify-center text-[10px] text-slate-600 font-bold">U</div>
                            @endfor
                            <div class="w-10 h-10 rounded-full border-2 border-indigo-500 bg-white/20 backdrop-blur-md flex items-center justify-center text-[10px] font-bold">+{{ $user }}</div>
                        </div>
                    </div>
                    <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[150px] opacity-10 group-hover:scale-110 transition-transform duration-700">group</span>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-[2rem] p-8 border border-slate-200/60 dark:border-slate-700/50 shadow-sm animate-reveal delay-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-500 dark:text-slate-400 font-medium text-sm">Kategori & Unit</p>
                            <h3 class="text-3xl font-bold text-slate-800 dark:text-white mt-1">{{ $jenis_barang + $peruntukan }}</h3>
                        </div>
                        <div class="p-4 bg-amber-50 dark:bg-amber-900/20 text-amber-600 rounded-2xl">
                            <span class="material-symbols-outlined">category</span>
                        </div>
                    </div>
                    <div class="mt-6 flex gap-4">
                        <div class="flex-1 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-xl border border-slate-100 dark:border-slate-700">
                            <p class="text-[10px] uppercase font-bold text-slate-400">Jenis</p>
                            <p class="text-lg font-bold text-slate-700 dark:text-slate-200">{{ $jenis_barang }}</p>
                        </div>
                        <div class="flex-1 p-3 bg-slate-50 dark:bg-slate-700/30 rounded-xl border border-slate-100 dark:border-slate-700">
                            <p class="text-[10px] uppercase font-bold text-slate-400">Peruntukan</p>
                            <p class="text-lg font-bold text-slate-700 dark:text-slate-200">{{ $peruntukan }}</p>
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
                    <div class="p-3 bg-blue-50 dark:bg-blue-900/30 text-blue-600 rounded-2xl group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300 rounded-full">Total Aset</span>
                </div>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white">{{ $barang }}</h3>
                <p class="text-slate-500 text-sm mt-1">Unit barang terdata</p>
                
                <div class="mt-8 space-y-4">
                    @php
                        $available_pct = $barang > 0 ? ($barang_tersedia / $barang) * 100 : 0;
                    @endphp
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs font-bold italic tracking-wide">
                            <span class="text-slate-600 dark:text-slate-400">AVAILABILITY</span>
                            <span class="text-blue-600">{{ round($available_pct) }}%</span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full transition-all duration-1000" style="width: {{ $available_pct }}%"></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase font-extrabold tracking-tighter">Hilang</p>
                            <p class="text-lg font-bold text-red-500">{{ $barang_hilang }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase font-extrabold tracking-tighter">Habis</p>
                            <p class="text-lg font-bold text-amber-500">{{ $barang_tidak_tersedia }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Peminjaman --}}
            <div class="stat-card-premium animate-reveal delay-500 group border-b-4 border-b-amber-500">
                <div class="flex justify-between items-center mb-6">
                    <div class="p-3 bg-amber-50 dark:bg-amber-900/30 text-amber-600 rounded-2xl group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">local_shipping</span>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300 rounded-full">Aktivitas</span>
                </div>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white">{{ $peminjaman }}</h3>
                <p class="text-slate-500 text-sm mt-1">Total penggunaan barang</p>
                
                <div class="mt-8 grid grid-cols-1 gap-3">
                    <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-100 dark:border-slate-700">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></div>
                            <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">Sedang Diproses</span>
                        </div>
                        <span class="text-lg font-bold text-slate-800 dark:text-white">{{ $peminjaman_proses }}</span>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/50 rounded-2xl border border-slate-100 dark:border-slate-700">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-green-500"></div>
                            <span class="text-sm font-semibold text-slate-600 dark:text-slate-300">Selesai/Kembali</span>
                        </div>
                        <span class="text-lg font-bold text-slate-800 dark:text-white">{{ $peminjaman_selesai }}</span>
                    </div>
                </div>
            </div>

            {{-- Card: Pengembalian --}}
            <div class="stat-card-premium animate-reveal delay-600 group border-b-4 border-b-emerald-500">
                <div class="flex justify-between items-center mb-6">
                    <div class="p-3 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 rounded-2xl group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">assignment_return</span>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300 rounded-full">Logistik</span>
                </div>
                <h3 class="text-4xl font-black text-slate-800 dark:text-white">{{ $pengembalian }}</h3>
                <p class="text-slate-500 text-sm mt-1">Pengembalian tercatat</p>
                
                <div class="mt-8 space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500 italic">Kualitas Pengembalian</span>
                    </div>
                    <div class="flex h-3 w-full bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                        @php
                            $comp_pct = $pengembalian > 0 ? ($pengembalian_complete / $pengembalian) * 100 : 0;
                            $incomp_pct = $pengembalian > 0 ? ($pengembalian_incomplete / $pengembalian) * 100 : 0;
                        @endphp
                        <div class="bg-emerald-500 h-full" style="width: {{ $comp_pct }}%"></div>
                        <div class="bg-red-400 h-full" style="width: {{ $incomp_pct }}%"></div>
                    </div>
                    <div class="flex justify-between text-[10px] font-bold">
                        <div class="flex items-center gap-1.5 text-emerald-600">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span> LENGKAP ({{ $pengembalian_complete }})
                        </div>
                        <div class="flex items-center gap-1.5 text-red-500">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span> TIDAK LENGKAP ({{ $pengembalian_incomplete }})
                        </div>
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
        border-color: #3182CE;
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