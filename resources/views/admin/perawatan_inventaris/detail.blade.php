@extends('layouts.admin.main')

@section('content')
<style>
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up {
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .delay-100 { animation-delay: 100ms; }
    .delay-200 { animation-delay: 200ms; }
</style>

<div class="p-6 md:p-8 min-h-screen bg-slate-50/50">
    <div class="max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8 animate-fade-up">
            <div>
                <h2 class="text-3xl font-extrabold text-[#1b365d] tracking-tight">Detail Perawatan BMN</h2>
                <p class="text-sm text-slate-500 mt-1 font-medium">Informasi lengkap proses perbaikan dan estimasi biaya.</p>
            </div>
            <a href="{{ route('perawatan_inventaris.index') }}" class="group inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-300">
                <span class="transform transition-transform duration-300 group-hover:-translate-x-1">←</span>
                Kembali
            </a>
        </div>

        {{-- Card Utama --}}
        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-xl shadow-slate-200/40 overflow-hidden animate-fade-up delay-100 opacity-0">

            {{-- Top Banner --}}
            <div class="bg-gradient-to-r from-[#1b365d] to-[#2a5491] p-6 sm:px-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4 text-white">
                    <div class="p-3 bg-white/10 rounded-xl backdrop-blur-sm border border-white/20">
                        <i class="fa-solid fa-boxes-stacked text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-blue-200 font-medium uppercase tracking-widest mb-0.5">Kode: {{ $data->barang->kode_barang }}</p>
                        <h3 class="text-xl font-bold leading-tight">{{ $data->barang->nama_barang }}</h3>
                    </div>
                </div>

                {{-- Status Badge --}}
                <div>
                    @php
                        $statusClasses = match($data->status) {
                            'selesai' => 'bg-emerald-500 text-white shadow-emerald-500/30',
                            'proses' => 'bg-amber-500 text-white shadow-amber-500/30',
                            'diperbaiki' => 'bg-blue-500 text-white shadow-blue-500/30',
                            'tidak_dapat_diperbaiki' => 'bg-red-500 text-white shadow-red-500/30',
                            default => 'bg-slate-500 text-white shadow-slate-500/30'
                        };
                    @endphp
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest shadow-lg {{ $statusClasses }}">
                        @if($data->status == 'selesai') <i class="fa-solid fa-check"></i>
                        @elseif($data->status == 'proses') <i class="fa-solid fa-gear fa-spin"></i>
                        @elseif($data->status == 'diperbaiki') <i class="fa-solid fa-wrench"></i>
                        @elseif($data->status == 'tidak_dapat_diperbaiki') <i class="fa-solid fa-triangle-exclamation"></i>
                        @else <i class="fa-solid fa-clock"></i> @endif
                        {{ str_replace('_', ' ', $data->status) }}
                    </span>
                </div>
            </div>

            <div class="p-6 sm:p-10 grid grid-cols-1 lg:grid-cols-2 gap-10">

                {{-- Kiri: Informasi Data --}}
                <div class="space-y-8">

                    {{-- Grid Waktu & Teknisi --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Tanggal Perawatan</label>
                            <p class="text-sm font-bold text-[#1b365d]">
                                {{ \Carbon\Carbon::parse($data->tanggal_perawatan)->translatedFormat('d F Y') }}
                            </p>
                        </div>

                        <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100">
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-blue-400 mb-1">Ditangani Oleh</label>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="w-6 h-6 rounded-full bg-[#1b365d] flex items-center justify-center text-white text-[10px] font-bold">
                                    {{ strtoupper(substr($data->user->nama_lengkap ?? 'T', 0, 1)) }}
                                </div>
                                <p class="text-sm font-bold text-[#1b365d] truncate">
                                    {{ $data->user->nama_lengkap ?? 'Sistem / Belum Ditentukan' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Biaya --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Estimasi Biaya Perbaikan</label>
                        <div class="inline-flex items-center gap-3 px-5 py-3 bg-emerald-50 rounded-xl border border-emerald-100 text-emerald-700">
                            <i class="fa-solid fa-wallet text-lg opacity-80"></i>
                            <span class="text-lg font-black tracking-tight">
                                {{ $data->biaya ? 'Rp ' . number_format($data->biaya, 0, ',', '.') : 'Rp 0' }}
                            </span>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2">Riwayat & Catatan Tim Perbaikan</label>
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100 relative group transition-all hover:bg-white hover:border-slate-200 hover:shadow-md">
                            <i class="fa-solid fa-quote-left absolute top-5 left-5 text-slate-200 text-2xl group-hover:text-[#1b365d]/10 transition-colors"></i>
                            <p class="text-sm text-slate-600 leading-relaxed italic relative z-10 pl-8 whitespace-pre-wrap">{{ $data->deskripsi ?? 'Tidak ada catatan terlampir.' }}</p>
                        </div>
                    </div>

                </div>

                {{-- Kanan: Foto Bukti --}}
                <div class="flex flex-col items-center sm:items-end justify-start animate-fade-up delay-200 opacity-0">
                    <div class="w-full">
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-3 w-full">Foto Bukti Setelah Perbaikan</label>
                        @if ($data->foto_bukti)
                            <div class="group relative overflow-hidden rounded-3xl shadow-lg border-4 border-white aspect-[4/3] w-full">
                                <img src="{{ asset('storage/' . $data->foto_bukti) }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105" alt="Bukti Perbaikan">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#1b365d]/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-4">
                                    <span class="text-white text-xs font-bold tracking-wider uppercase"><i class="fa-solid fa-image mr-1"></i> Bukti Tim Perbaikan</span>
                                </div>
                            </div>
                        @else
                            <div class="w-full aspect-[4/3] bg-slate-50 rounded-3xl border-2 border-dashed border-slate-300 flex flex-col items-center justify-center text-slate-400">
                                <i class="fa-solid fa-image-slash text-4xl mb-3 text-slate-300"></i>
                                <p class="text-sm font-medium">Foto bukti tidak tersedia</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Tombol Verifikasi --}}
            @if($data->status == 'proses' || $data->status == 'diperbaiki')
            <div class="bg-slate-50 border-t border-slate-100 p-6 flex justify-end">
                <form action="{{ route('perawatan_inventaris.verifikasiSelesai', $data->id) }}" method="POST" id="form-verifikasi-{{ $data->id }}">
                    @csrf
                    <button type="button" onclick="konfirmasiVerifikasi('{{ $data->id }}')" class="inline-flex items-center gap-2 px-8 py-3 rounded-xl text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-200 transition-all hover:-translate-y-0.5 active:scale-95">
                        <i class="fa-solid fa-check-double"></i> Verifikasi Selesai Diperbaiki
                    </button>
                </form>
            </div>
            @endif

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Konfirmasi Verifikasi Selesai (Tema Elegan BMN)
    function konfirmasiVerifikasi(id) {
        Swal.fire({
            title: 'Verifikasi Perbaikan BMN?',
            text: "Verifikasi Barang agar bisa digunakan kembali.",
            icon: 'info',
            iconColor: '#10b981',
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: '<i class="fa-solid fa-check-double mr-1"></i> Ya, Verifikasi',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-700 dark:bg-gray-800 p-6',
                title: 'text-xl font-bold text-gray-800 dark:text-white mb-2',
                htmlContainer: 'text-gray-500 dark:text-gray-400 text-sm',
                actions: 'mt-6 w-full flex justify-center gap-3',
                confirmButton: 'bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2.5 px-6 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg',
                cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 font-semibold py-2.5 px-6 rounded-xl transition-all duration-300'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-verifikasi-' + id).submit();
            }
        });
    }
</script>

@endsection
