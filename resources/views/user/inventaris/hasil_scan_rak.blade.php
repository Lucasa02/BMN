<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris BMN - {{ $nama_rak }}</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="shortcut icon" href="{{ asset('img/assets/bg_esimba.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" crossorigin href="https://fonts.gstatic.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1b365d", // Navy Blue
                        "gold": "#c5a059",    // Luxury Gold
                        "luxury-slate": "#0f172a",
                    },
                    fontFamily: {
                        "sans": ["Plus Jakarta Sans", "sans-serif"]
                    }
                },
            },
        }
    </script>

    <style>
        body {
            background: radial-gradient(circle at top right, #f8fafc, #eff6ff);
            min-height: 100vh;
        }

        .card-luxury {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .card-luxury:hover {
            transform: translateY(-12px) scale(1.01);
            box-shadow: 0 40px 80px -15px rgba(27, 54, 93, 0.15);
            border: 1px solid rgba(197, 160, 89, 0.3);
        }

        .gold-gradient {
            background: linear-gradient(135deg, #c5a059 0%, #ecd08d 50%, #c5a059 100%);
        }

        .navy-gradient {
            background: linear-gradient(135deg, #1b365d 0%, #10213a 100%);
        }

        /* Border Animasi Mewah */
        .premium-border {
            position: relative;
        }
        .premium-border::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: #c5a059;
            transition: all 0.4s ease;
            transform: translateX(-50%);
        }
        .card-luxury:hover .premium-border::after {
            width: 60%;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #1b365d; border-radius: 10px; }

        @keyframes subtleZoom {
            0% { transform: scale(1); }
            100% { transform: scale(1.05); }
        }
        .hover-zoom:hover img {
            animation: subtleZoom 5s forwards;
        }
    </style>
</head>

<body class="font-sans text-slate-900 antialiased custom-scrollbar">

<div class="max-w-7xl mx-auto px-6 py-12">

    <header class="mb-16 animate__animated animate__fadeIn">
        @php
            $from = request()->query('from');
            $backUrl = ($from === 'teknisi') ? route('user.teknisi.index') : route('user.inventaris');
        @endphp

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
            <div class="space-y-6">
                <a href="{{ $backUrl }}" class="group inline-flex items-center gap-3 text-primary font-bold text-sm tracking-wide">
                    <div class="w-10 h-10 rounded-full bg-white shadow-sm border border-slate-100 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all duration-300">
                        <span class="material-symbols-outlined text-lg">arrow_back</span>
                    </div>
                    <span>{{ $from === 'teknisi' ? 'Kembali Ke Dasbor Teknisi' : 'Kembali Ke Pemindaian' }}</span>
                </a>

                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="h-[1px] w-8 bg-gold"></span>
                        <span class="text-gold font-bold text-xs uppercase tracking-[0.3em]">Arsip Barang Milik Negara</span>
                    </div>
                    <h1 class="text-5xl font-extrabold text-primary tracking-tight">
                        {{ $nama_rak }}
                    </h1>
                    <p class="text-slate-500 text-lg font-light">
                        Manajemen aset terintegrasi: <span class="font-semibold text-primary">{{ $barang->count() }} Terdaftar</span>
                    </p>
                </div>
            </div>

            <div class="hidden lg:block">
                <img src="{{ asset('img/assets/logo_esimba_bluebg.png') }}" alt="Logo" class="h-16 w-auto opacity-90 drop-shadow-2xl">
            </div>
        </div>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
        <div class="bg-primary p-6 rounded-3xl shadow-xl flex items-center gap-5">
            <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-gold">
                <span class="material-symbols-outlined text-3xl">inventory_2</span>
            </div>
            <div>
                <p class="text-white/60 text-xs font-bold uppercase tracking-widest">Total Unit</p>
                <p class="text-2xl font-bold text-white">{{ $barang->count() }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                <span class="material-symbols-outlined text-3xl">verified</span>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Kondisi Baik</p>
                <p class="text-2xl font-bold text-slate-800">{{ $barang->where('kondisi', 'Baik')->count() }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-5">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600">
                <span class="material-symbols-outlined text-3xl">history</span>
            </div>
            <div>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">Terakhir Update</p>
                <p class="text-lg font-bold text-slate-800">{{ now()->format('d M Y') }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
        @foreach($barang as $index => $b)
        @php
            // Logika cek status (Sama seperti admin)
            $isRencanaPenghapusan = $b->perawatan->where('jenis_perawatan', 'rencana_penghapusan')->isNotEmpty();
            $cek_perawatan = $b->perawatan->where('jenis_perawatan', '!=', 'rencana_penghapusan')->whereIn('status', ['pending', 'proses'])->count() > 0;
            $cek_laporan = \App\Models\LaporanKerusakan::where('barang_id', $b->id)->whereIn('status', ['disetujui', 'proses'])->exists();
            $sedang_maintenance = $cek_perawatan || $cek_laporan;
        @endphp

        <div class="animate__animated animate__fadeInUp card-luxury rounded-[2.5rem] overflow-hidden flex flex-col group/card hover-zoom"
             style="animation-delay: {{ $index * 0.1 }}s">

            <div class="relative aspect-square overflow-hidden bg-slate-100">
                @if ($b->foto)
                    {{-- Tambahkan filter grayscale jika maintenance/penghapusan --}}
                    <img src="{{ asset('storage/' . $b->foto) }}" class="object-cover w-full h-full transition-all duration-1000 {{ ($sedang_maintenance || $isRencanaPenghapusan) ? 'grayscale opacity-75' : '' }}" alt="{{ $b->nama_barang }}">
                @else
                    <div class="flex flex-col items-center justify-center h-full text-slate-300">
                        <span class="material-symbols-outlined text-7xl font-light">image_not_supported</span>
                    </div>
                @endif

                <div class="absolute top-6 left-6 flex flex-col gap-2">
                    <div class="px-4 py-2 rounded-full bg-primary/90 backdrop-blur-md border border-white/20 shadow-2xl w-fit">
                        <p class="text-[9px] font-black text-gold uppercase tracking-[0.2em] leading-none">{{ $b->kode_barang }}</p>
                    </div>
                </div>

                <div class="absolute bottom-6 right-6">
                    {{-- Ubah badge kondisi jika maintenance / penghapusan --}}
                    @if($isRencanaPenghapusan)
                        <span class="flex items-center gap-2 px-5 py-2.5 rounded-2xl text-[11px] font-bold uppercase tracking-wider bg-red-100 text-red-700 shadow-xl border border-red-200">
                            <span class="material-symbols-outlined text-sm animate-pulse">delete_sweep</span> Penghapusan
                        </span>
                    @elseif($sedang_maintenance)
                        <span class="flex items-center gap-2 px-5 py-2.5 rounded-2xl text-[11px] font-bold uppercase tracking-wider bg-amber-100 text-amber-700 shadow-xl border border-amber-200">
                            <span class="material-symbols-outlined text-sm animate-spin-slow">engineering</span> Diperbaiki
                        </span>
                    @else
                        <span class="flex items-center gap-2 px-5 py-2.5 rounded-2xl text-[11px] font-bold uppercase tracking-wider bg-white/95 text-slate-800 shadow-xl border border-white">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ in_array($b->kondisi, ['Baik', 'Sangat Baik']) ? 'bg-emerald-400' : 'bg-rose-400' }} opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 {{ in_array($b->kondisi, ['Baik', 'Sangat Baik']) ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                            </span>
                            {{ $b->kondisi }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-10 flex-1 flex flex-col bg-white">
                <div class="mb-8 premium-border pb-4">
                    <p class="text-[10px] font-bold text-gold uppercase tracking-[0.3em] mb-3 leading-none">{{ $b->kategori }}</p>
                    <h3 class="text-2xl font-bold text-primary leading-tight min-h-[3rem]">
                        {{ $b->nama_barang }}
                    </h3>
                </div>

                <div class="mt-auto space-y-6">
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex flex-col">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Status Lokasi</span>
                            <div class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-emerald-500 text-sm">verified_user</span>
                                <span class="font-bold text-slate-700">{{ $nama_rak }}</span>
                            </div>
                        </div>
                        <div class="h-8 w-[1px] bg-slate-100"></div>
                        <div class="flex flex-col text-right">
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">ID Aset</span>
                            <span class="font-mono text-xs font-bold text-primary bg-primary/5 px-2 py-1 rounded-md">#{{ substr($b->kode_barang, -5) }}</span>
                        </div>
                    </div>

                    <a href="{{ route('user.inventaris.scan', [$b->kode_barang, 'from' => $from]) }}"
                       class="group/btn relative flex items-center justify-center w-full py-5 navy-gradient text-white rounded-2xl text-sm font-bold transition-all duration-300 overflow-hidden shadow-lg shadow-primary/20">
                        <span class="relative z-10 flex items-center gap-2">
                            Lihat Detail Aset
                            <span class="material-symbols-outlined text-lg group-hover/btn:translate-x-1 transition-transform">trending_flat</span>
                        </span>
                        <div class="absolute top-0 -left-full w-full h-full bg-gradient-to-r from-transparent via-white/10 to-transparent transition-all duration-1000 group-hover/btn:left-full"></div>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($barang->isEmpty())
    <div class="animate__animated animate__zoomIn flex flex-col items-center justify-center py-32 px-6 bg-white rounded-[4rem] border border-slate-100 shadow-sm relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none">
            <img src="{{ asset('img/assets/logo_esimba_bluebg.png') }}" class="w-full h-full object-cover">
        </div>

        <div class="relative">
            <div class="w-32 h-32 bg-slate-50 rounded-[3rem] flex items-center justify-center mb-10 rotate-12 group-hover:rotate-0 transition-transform duration-500 shadow-inner">
                <span class="material-symbols-outlined text-7xl text-slate-200">grid_view</span>
            </div>
        </div>

        <h3 class="text-3xl font-bold text-primary tracking-tight">Data Tidak Tersedia</h3>
        <p class="text-slate-400 max-w-sm text-center mt-4 text-lg font-light leading-relaxed">
            Tidak ditemukan aset negara yang terdaftar pada koordinat <span class="font-bold text-gold">{{ $nama_rak }}</span> saat ini.
        </p>

        <a href="{{ $backUrl }}" class="mt-10 px-8 py-4 bg-primary text-white rounded-2xl font-bold shadow-xl hover:shadow-primary/30 transition-all active:scale-95">
            {{ $from === 'teknisi' ? 'Kembali ke Dasbor' : 'Coba Scan Ulang' }}
        </a>
    </div>
    @endif

</div>

</body>
</html>
