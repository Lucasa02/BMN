@extends('layouts.admin.main')

@section('content')

<div class="px-6 py-8">
    {{-- Header Page --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white tracking-tight">Daftar Perawatan</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Pantau status pemeliharaan seluruh inventaris secara real-time.</p>
        </div>
        
        <div class="flex gap-3">
        </div>
    </div>

    {{-- Empty State --}}
    @if ($data->isEmpty())
    <div class="flex flex-col items-center justify-center py-24 bg-white dark:bg-gray-800 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700 shadow-inner">
        <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-full mb-4">
            <span class="material-symbols-outlined text-6xl text-gray-300">inventory_2</span>
        </div>
        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Belum Ada Data</h3>
        <p class="text-gray-500 mt-2">Semua data perawatan akan muncul di sini.</p>
    </div>
    @endif

    {{-- Grid Card --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-8">
        @foreach($data as $row)
            @php
                $statusColors = [
                    'proses' => 'from-amber-400 to-orange-500 text-amber-950 shadow-amber-200',
                    'pending' => 'from-slate-400 to-slate-500 text-white shadow-slate-200',
                    'selesai' => 'from-emerald-400 to-teal-500 text-emerald-950 shadow-emerald-200',
                ];
                $warnaStatus = $statusColors[$row->status] ?? 'from-gray-400 to-gray-500 text-white';
                $jenis = str_replace('_', ' ', $row->jenis_perawatan);
            @endphp

            <div class="group bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 dark:border-gray-700 flex flex-col h-full transform hover:-translate-y-2">
                
                {{-- Foto Barang dengan Zoom Effect --}}
                <div class="relative h-52 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <img 
                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-in-out {{ $row->barang->foto ? '' : 'grayscale' }}"
                        src="{{ $row->barang->foto ? asset('storage/'.$row->barang->foto) : asset('img/no-image.png') }}"
                        alt="{{ $row->barang->nama_barang }}"
                    >

                    {{-- Floating Badge Jenis --}}
                    <div class="absolute top-4 left-4 z-20">
                        <span class="px-3 py-1 bg-white/90 backdrop-blur-sm text-gray-800 text-[10px] font-black uppercase tracking-widest rounded-lg shadow-sm">
                            {{ $jenis }}
                        </span>
                    </div>

                    {{-- Quick Action Eye --}}
                    <a href="{{ route('perawatan_inventaris.detail', $row->id) }}" 
                       class="absolute bottom-4 right-4 z-20 p-3 bg-white text-blue-600 rounded-2xl shadow-xl translate-y-12 group-hover:translate-y-0 transition-transform duration-500 opacity-0 group-hover:opacity-100 hover:bg-blue-600 hover:text-white">
                        <i class="fa-solid fa-eye text-lg"></i>
                    </a>
                </div>

                <div class="p-6 flex flex-col flex-grow">
                    {{-- Judul & Tanggal --}}
                    <div class="mb-4">
                        <h3 class="font-bold text-gray-900 dark:text-white text-lg leading-tight mb-1 group-hover:text-blue-600 transition-colors">
                            {{ $row->barang->nama_barang ?? 'Tanpa Nama' }}
                        </h3>
                        <div class="flex items-center gap-2 text-xs text-gray-400 font-medium">
                            <i class="fa-regular fa-calendar"></i>
                            {{ \Carbon\Carbon::parse($row->tanggal_perawatan)->format('d M Y') }}
                        </div>
                    </div>

                    {{-- Status Badge (Gradient Style) --}}
                    <div class="mb-6">
                        <span class="inline-block px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-tighter bg-gradient-to-r {{ $warnaStatus }} shadow-sm">
                            {{ $row->status }}
                        </span>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-auto pt-4 border-t border-gray-50 dark:border-gray-700 grid grid-cols-1 gap-2">
                        @if($row->status != 'proses' && $row->status != 'selesai')
                            <a href="{{ route('perawatan_inventaris.perbaiki', $row->id) }}"
                                class="flex items-center justify-center gap-2 py-2.5 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-xl text-xs font-bold hover:bg-blue-600 hover:text-white transition-all">
                                <i class="fa-solid fa-screwdriver-wrench"></i> Mulai Perbaiki
                            </a>
                        @endif

                        @if($row->status == 'proses')
                            <a href="{{ route('perawatan_inventaris.selesaiForm', $row->id) }}"
                                class="flex items-center justify-center gap-2 py-2.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-xl text-xs font-bold hover:bg-emerald-600 hover:text-white transition-all">
                                <i class="fa-solid fa-check-double"></i> Selesaikan
                            </a>
                        @endif

                        @if($row->status != 'pending')
                            <a href="{{ route('perawatan_inventaris.hapuskan', $row->id) }}"
                                onclick="return confirm('Yakin ingin mengajukan penghapusan?')"
                                class="flex items-center justify-center gap-2 py-2.5 text-red-500 hover:text-red-700 text-xs font-bold transition-colors">
                                <i class="fa-solid fa-trash-can"></i> Rencana Penghapusan
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    /* Scrollbar minimalis untuk kesan modern */
    ::-webkit-scrollbar {
        width: 6px;
    }
    ::-webkit-scrollbar-track {
        background: transparent;
    }
    ::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
    .dark ::-webkit-scrollbar-thumb {
        background: #334155;
    }
</style>

@endsection