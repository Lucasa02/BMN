<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Perbaikan - Teknisi | BMN</title>
    @notifyCss
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom Elegant Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }

        /* Elegant Glassmorphism */
        .glass-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 10px 40px -10px rgba(27, 54, 93, 0.15);
        }

        /* Image Hover Overlay */
        .img-overlay-gradient {
            background: linear-gradient(to top, rgba(27, 54, 93, 0.8) 0%, transparent 50%);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen font-sans text-slate-800 antialiased selection:bg-[#1b365d] selection:text-white">
    <div class="absolute top-0 left-0 right-0 z-[100]"><x-notify::notify /></div>

    <div class="bg-[#1b365d] relative overflow-hidden pb-32">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
        <div class="absolute -right-20 -top-20 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

        <nav class="relative z-50 w-full border-b border-white/10">
            <div class="px-4 py-4 lg:px-8 max-w-7xl mx-auto">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('user.teknisi.index') }}" class="text-white hover:text-[#d4af37] transition-colors p-2 -ml-2 rounded-lg hover:bg-white/10 flex items-center gap-2 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Dasbor
                        </a>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-white p-1 rounded shadow-sm mr-2">
                            <img src="{{ asset('img/assets/logo_esimba_bluebg.png') }}" class="h-5" alt="BMN" />
                        </div>
                        <span class="text-sm font-bold text-white tracking-wide hidden sm:block">E-SIMBA <span class="text-[#d4af37]">BMN</span></span>
                    </div>
                </div>
            </div>
        </nav>

        <section class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-16 text-center animate-fade-in-up">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4 tracking-tight drop-shadow-md">
                Detail <span class="text-[#d4af37]">Perbaikan</span>
            </h1>
            <p class="text-blue-100 text-base md:text-lg max-w-2xl mx-auto font-light">
                Periksa rincian kerusakan dengan cermat sebelum melakukan tindakan pada inventaris terkait.
            </p>
        </section>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-20 pb-24">

        {{-- KARTU UTAMA --}}
        <div class="animate-fade-in-up delay-100 glass-card rounded-[2rem] overflow-hidden">
            <div class="p-8 sm:p-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                    {{-- INFORMASI KIRI --}}
                    <div class="lg:col-span-7 space-y-8">
                        {{-- Nama Barang --}}
                        <div class="relative pl-6 before:content-[''] before:absolute before:left-0 before:top-1 before:bottom-1 before:w-1.5 before:bg-gradient-to-b before:from-[#1b365d] before:to-[#d4af37] before:rounded-full">
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1.5">Identitas Aset / Barang</label>
                            <p class="text-2xl sm:text-3xl font-extrabold text-[#1b365d] leading-tight">{{ $laporan->barang->nama_barang }}</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            {{-- Tanggal --}}
                            <div class="bg-slate-50/80 p-5 rounded-2xl border border-slate-100 shadow-sm transition-all hover:shadow-md">
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mb-2">Waktu Laporan</label>
                                <div class="flex items-center gap-3">
                                    <div class="p-2.5 bg-white rounded-xl shadow-sm border border-slate-100 text-[#1b365d]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-extrabold text-slate-700">{{ $laporan->updated_at->translatedFormat('d F Y') }}</p>
                                        <p class="text-xs font-medium text-slate-500">{{ $laporan->updated_at->format('H:i') }} WIB</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Pelapor --}}
                            <div class="bg-slate-50/80 p-5 rounded-2xl border border-slate-100 shadow-sm transition-all hover:shadow-md">
                                <label class="block text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mb-2">Dilaporkan Oleh</label>
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-[#1b365d] to-[#2a5298] shadow-md flex items-center justify-center text-white font-extrabold text-sm border border-[#1b365d]/50">
                                        {{ strtoupper(substr($laporan->user->nama_lengkap ?? 'A', 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-extrabold text-slate-700 truncate">{{ $laporan->user->nama_lengkap ?? 'Tidak diketahui' }}</p>
                                        <p class="text-[10px] text-slate-500 font-medium">Pengguna BMN</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Keluhan & Deskripsi --}}
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">Deskripsi Keluhan</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-wider bg-rose-50 text-rose-700 border border-rose-100 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5"></span>
                                    {{ $laporan->jenis_kerusakan }}
                                </span>
                            </div>
                            <div class="bg-slate-50/80 p-6 rounded-2xl border border-slate-100 relative group transition-all hover:bg-white hover:shadow-lg hover:border-slate-200">
                                <svg class="absolute top-4 left-4 w-6 h-6 text-slate-200 transform -scale-x-100 group-hover:text-[#d4af37]/30 transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                                <p class="text-slate-600 leading-relaxed text-sm italic relative z-10 pl-8">
                                    "{{ $laporan->deskripsi }}"
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- FOTO KANAN --}}
                    <div class="lg:col-span-5 flex flex-col items-center justify-center">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-3 w-full text-left lg:text-center">Lampiran Visual</label>
                        @if ($laporan->foto)
                            <div class="group relative overflow-hidden rounded-3xl shadow-lg w-full aspect-[4/3] border border-slate-100 bg-white p-1.5">
                                <div class="w-full h-full rounded-2xl overflow-hidden relative">
                                    <img src="{{ asset('storage/'.$laporan->foto) }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110" alt="Foto Kerusakan">
                                    <div class="absolute inset-0 img-overlay-gradient opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                        <span class="text-white text-xs font-medium backdrop-blur-sm bg-white/20 px-3 py-1 rounded-lg">Bukti Laporan</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="w-full aspect-[4/3] bg-slate-50 rounded-3xl border-2 border-dashed border-slate-300 flex flex-col items-center justify-center text-slate-400 transition-colors hover:bg-slate-100 hover:border-slate-400">
                                <div class="bg-white p-4 rounded-full shadow-sm mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-slate-500">Nirvisual</p>
                                <p class="text-[10px] uppercase tracking-wider text-slate-400 mt-1">Tidak ada foto terlampir</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- AREA AKSI (BAGIAN BAWAH) --}}
            <div class="bg-slate-50/80 p-6 sm:px-10 flex flex-col sm:flex-row items-center justify-between gap-6 border-t border-slate-100">
                <div class="text-center sm:text-left flex items-center gap-4">
                    <div class="hidden sm:flex h-12 w-12 bg-white rounded-full shadow-sm items-center justify-center text-[#1b365d] border border-slate-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-[#1b365d] text-lg tracking-wide">Tindak Lanjut Perbaikan</h4>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Lengkapi form perbaikan untuk menyelesaikan tugas ini.</p>
                    </div>
                </div>

                <a href="{{ route('user.teknisi.perbaikan', $laporan->uuid) }}" class="group relative w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-3.5 text-sm font-bold text-white bg-gradient-to-r from-[#1b365d] to-[#2a5298] rounded-xl overflow-hidden transition-all duration-300 shadow-lg hover:shadow-[0_10px_20px_-10px_rgba(27,54,93,0.5)] hover:-translate-y-1">
                    <span class="relative z-10 flex items-center gap-2">
                        Proses Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </span>
                    <div class="absolute inset-0 h-full w-full bg-white/20 transform scale-x-0 origin-left transition-transform duration-500 group-hover:scale-x-100 z-0"></div>
                </a>
            </div>
        </div>
    </div>

    @notifyJs
</body>
</html>
