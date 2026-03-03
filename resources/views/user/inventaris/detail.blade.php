<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Digital - {{ $barang->nama_barang }}</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="shortcut icon" href="{{ asset('img/assets/bg_esimba.png') }}" type="image/x-icon">
    <link rel="preconnect" crossorigin href="https://fonts.gstatic.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1b365d",
                        "accent": "#3b82f6",
                        "slate-custom": "#f8fafc",
                    },
                    fontFamily: {
                        "sans": ["Plus Jakarta Sans", "sans-serif"]
                    },
                },
            },
        }
    </script>

    <style>
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24 }

        /* Smooth Entry Animations */
        @keyframes revealUp {
            from { opacity: 0; transform: translateY(30px); filter: blur(10px); }
            to { opacity: 1; transform: translateY(0); filter: blur(0); }
        }

        .animate-reveal { animation: revealUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        /* Premium Glassmorphism */
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        /* Luxury Gradient Text */
        .text-gradient {
            background: linear-gradient(135deg, #1b365d 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        body { background-color: #f8fafc; }
    </style>
</head>

<body class="font-sans text-slate-900 antialiased overflow-x-hidden">

<div class="max-w-6xl mx-auto px-6 py-10 lg:py-16 space-y-12">

    @if (session('success'))
    <div class="animate-reveal p-4 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-3 text-emerald-700 shadow-sm mb-8">
        <span class="material-symbols-outlined text-emerald-500">verified</span>
        <p class="text-sm font-semibold">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Header Navigation --}}
    <nav class="flex justify-between items-center animate-reveal">
        <div class="flex items-center gap-6">
            @php
                $backUrl = str_contains(url()->previous(), '/rak/') ? url()->previous() : route('user.inventaris');
            @endphp
            <a href="{{ $backUrl }}" class="group flex items-center gap-2 text-slate-400 hover:text-primary transition-all duration-300">
                <div class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center group-hover:border-primary group-hover:bg-primary/5">
                    <span class="material-symbols-outlined text-xl transition-transform group-hover:-translate-x-1">arrow_back</span>
                </div>
                <span class="text-xs font-black uppercase tracking-widest">Kembali</span>
            </a>
        </div>

        <div class="flex items-center gap-4">
             <div class="h-10 w-[1px] bg-slate-200 hidden sm:block"></div>
             <img src="{{ asset('img/assets/logo_esimba_bluebg.png') }}" alt="Logo" class="h-8 opacity-80">
        </div>
    </nav>

    {{-- Main Content Grid --}}
    <main class="grid grid-cols-1 lg:grid-cols-12 gap-12">

        {{-- Left: Visual Identity --}}
        <div class="lg:col-span-5 space-y-8 animate-reveal delay-1">
            <div class="relative group">
                <div class="absolute -inset-4 bg-primary/5 rounded-[3rem] blur-2xl transition-opacity group-hover:opacity-100"></div>
                <div class="relative bg-white p-3 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-white">
                    <div class="aspect-square rounded-[2rem] overflow-hidden bg-slate-50 flex items-center justify-center">
                        @if ($barang->foto)
                            <img src="{{ asset('storage/' . $barang->foto) }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                        @else
                            <span class="material-symbols-outlined text-8xl text-slate-200">inventory_2</span>
                        @endif
                    </div>
                </div>

                {{-- Status Float --}}
                <div class="absolute -bottom-4 right-8 bg-white px-6 py-3 rounded-2xl shadow-xl border border-slate-50 flex items-center gap-3">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">{{ $barang->kondisi }}</span>
                </div>
            </div>

            {{-- Digital Passport (QR Section) --}}
            <div class="bg-primary rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl shadow-primary/20">
                <div class="absolute top-0 right-0 p-8 opacity-10">
                    <span class="material-symbols-outlined text-8xl">qr_code_2</span>
                </div>
                <div class="relative z-10 flex flex-col items-center">
                    <div class="bg-white p-4 rounded-3xl shadow-inner mb-6">
                        <img src="{{ asset('storage/' . $barang->qr_code) }}" class="w-28 h-28">
                    </div>
                    <div class="text-center">
                        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-blue-300/60 mb-2">Digital Asset Passport</p>
                        <code class="text-[11px] font-mono bg-white/10 px-4 py-2 rounded-xl block break-all">
                            {{ $barang->uuid }}
                        </code>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Content Details --}}
        <div class="lg:col-span-7 space-y-10 animate-reveal delay-2">

            {{-- Title & Category --}}
            <div class="space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-primary/5 text-primary rounded-lg border border-primary/10">
                    <span class="text-[10px] font-black uppercase tracking-widest">Aset BMN • {{ $barang->kode_barang }}</span>
                </div>
                <h1 class="text-4xl lg:text-5xl font-extrabold text-slate-900 tracking-tight leading-tight">
                    {{ $barang->nama_barang }}
                </h1>
                <p class="text-xl text-slate-400 font-medium italic">
                    {{ $barang->merk ?? 'Standard Issue' }} <span class="mx-2 text-slate-200">|</span> <span class="text-primary">{{ $barang->kategori }}</span>
                </p>
            </div>

            {{-- Quick Stats Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm transition-hover hover:border-primary/20">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Nilai Aset</p>
                    <p class="text-lg font-bold text-primary">Rp {{ number_format($barang->nilai_perolehan, 0, ',', '.') }}</p>
                </div>
                <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">NUP</p>
                    <p class="text-lg font-bold text-slate-700">#{{ $barang->nup ?? '000' }}</p>
                </div>
                <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm hidden sm:block">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Kuantitas</p>
                    <p class="text-lg font-bold text-slate-700">{{ $barang->jumlah }} Unit</p>
                </div>
            </div>

            {{-- Detailed Specifications --}}
            <div class="glass-panel rounded-[2.5rem] p-10 space-y-10">
                <div class="flex items-center gap-4 border-b border-slate-100 pb-6">
                    <div class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center text-white">
                        <span class="material-symbols-outlined">analytics</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Informasi Teknis</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none">Parameter Aset Terdaftar</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                    @php
                        $specs = [
                            ['label' => 'Unit Kerja', 'val' => $barang->unit_kerja ?? '-', 'icon' => 'corporate_fare'],
                            ['label' => 'Nomor Seri / SN', 'val' => $barang->nomor_seri ?? 'N/A', 'icon' => 'barcode'],
                            ['label' => 'Asal Pengadaan', 'val' => $barang->asal_pengadaan ?? 'Internal', 'icon' => 'account_balance'],
                            ['label' => 'Tanggal Input', 'val' => $barang->created_at->format('d M Y'), 'icon' => 'history'],
                            ['label' => 'Lokasi', 'val' => $barang->ruangan, 'icon' => 'apartment'],
                            ['label' => 'Tahun Perolehan', 'val' => $barang->tanggal_perolehan ? \Carbon\Carbon::parse($barang->tanggal_perolehan)->format('Y') : '-', 'icon' => 'calendar_today'],
                        ];
                    @endphp

                    @foreach($specs as $s)
                    <div class="flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-primary group-hover:text-white transition-all duration-500">
                            <span class="material-symbols-outlined text-lg">{{ $s['icon'] }}</span>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.15em]">{{ $s['label'] }}</p>
                            <p class="text-sm font-bold text-slate-700 leading-tight">{{ $s['val'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Catatan --}}
                <div class="pt-8 mt-4 border-t border-slate-50">
                     <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-2">Catatan Tambahan</p>
                     <p class="text-sm text-slate-500 leading-relaxed italic">
                        "{{ $barang->catatan ?? 'Tidak ada informasi deskripsi tambahan yang dilampirkan untuk aset ini.' }}"
                     </p>
                </div>
            </div>

            {{-- Photo Location Section --}}
            <div class="animate-reveal delay-3">
                <div class="flex items-center justify-between mb-4 px-4">
                    <h4 class="text-xs font-black uppercase tracking-widest text-slate-400">Titik Penempatan Statis</h4>
                    <span class="material-symbols-outlined text-primary text-sm">verified_user</span>
                </div>
                <div class="relative group rounded-[2rem] overflow-hidden bg-slate-200 aspect-[21/9] border border-white shadow-lg">
                    @if ($barang->posisi)
                        <img src="{{ asset('storage/' . $barang->posisi) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                            <p class="text-white text-[10px] font-bold uppercase tracking-widest">Dokumentasi Lokasi Terverifikasi</p>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-slate-400 gap-2">
                            <span class="material-symbols-outlined text-4xl opacity-20">not_listed_location</span>
                            <p class="text-[9px] font-black uppercase tracking-widest">Foto posisi belum tersedia</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Maintenance & Reporting Action --}}
            <div class="pt-6 animate-reveal delay-3">
                <a href="{{ route('user.inventaris.lapor-kerusakan.form', $barang->id) }}"
                    class="flex items-center justify-between p-6 bg-white rounded-3xl border border-rose-100 shadow-sm hover:shadow-xl hover:border-rose-300 transition-all duration-300 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500 group-hover:bg-rose-500 group-hover:text-white transition-all">
                            <span class="material-symbols-outlined">report_problem</span>
                        </div>
                        <div>
                            <h5 class="text-sm font-black text-slate-800 uppercase tracking-tight">Lapor Kondisi Aset</h5>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Laporkan kerusakan atau kendala fisik</p>
                        </div>
                    </div>
                    <span class="material-symbols-outlined text-slate-300 group-hover:translate-x-1 transition-transform">chevron_right</span>
                </a>
            </div>

        </div>
    </main>
</div>

</body>
</html>
