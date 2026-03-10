@extends('layouts.admin.main')

@section('content')
    <style>
      /* Tambahkan rule global untuk halaman ini */
        .poppins-wrapper {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Memastikan elemen form juga terkena efeknya */
        .poppins-wrapper input,
        .poppins-wrapper select,
        .poppins-wrapper button,
        .poppins-wrapper textarea {
            font-family: 'Poppins', sans-serif !important;
        }
        /* Animasi muncul dari bawah untuk card */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animasi Kilauan (Shine) untuk tombol */
        @keyframes shine {
            100% {
                left: 125%;
            }
        }

        /* Animasi masuk untuk tombol filter (BARU) */
        @keyframes scaleIn {
            0% { opacity: 0; transform: scale(0.9); }
            100% { opacity: 1; transform: scale(1); }
        }

        .filter-action-enter {
            animation: scaleIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }

        .animate-card {
            animation: fadeInUp 0.5s ease backwards;
        }

        .animate-shine {
            animation: shine 0.8s hover;
        }

        /* Efek Glassmorphism untuk Header */
        .glass-header {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Hover Lift Effect */
        .hover-lift {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .hover-lift:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Custom Gradient Button */
        .btn-gradient-blue {
            background: linear-gradient(135deg, #1b365d 0%, #2d5a9e 100%);
            transition: all 0.3s ease;
        }

        .btn-gradient-blue:hover {
            filter: brightness(115%);
            box-shadow: 0 4px 15px rgba(27, 54, 93, 0.4);
        }
    </style>

    @php
        $ruanganNames = $list_ruangan->pluck('nama_ruangan')->toArray();
    @endphp

    <div class="px-6 py-6 poppins-wrapper">
        {{-- HEADER & TOOLS --}}
        <div
            class="glass-header sticky top-4 z-30 mb-8 p-4 rounded-2xl shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-blue-50 rounded-xl text-[#1b365d]">
                    <i class="fa-solid fa-boxes-stacked text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Inventaris BMN</h1>
                    <p class="text-xs text-gray-500">Manajemen Barang Milik Negara</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @if (request()->has('search') || request()->has('filter') || request()->has('ruangan_filter'))
                    <a href="{{ route('barang.bmn_index') }}"
                        class="text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-xl text-sm px-4 py-2.5 transition-all">
                        <i class="fa-solid fa-arrows-rotate mr-2"></i> Reset
                    </a>
                @endif

                <button id="dropdownRightButton" data-dropdown-toggle="dropdownRight"
                    class="btn-gradient-blue text-white font-medium rounded-xl text-sm px-5 py-2.5 flex items-center shadow-lg"
                    type="button">
                    <i class="fa-solid fa-circle-plus mr-2"></i> Akses Cepat
                </button>

                <div id="dropdownRight"
                    class="z-40 hidden bg-white divide-y divide-gray-100 rounded-2xl shadow-2xl w-52 border border-gray-100 overflow-hidden">
                    <ul class="py-2 text-sm text-gray-700">
                        <li>
                            <a href="{{ route('bmn.create', 'general') }}"
                                class="block px-4 py-3 hover:bg-blue-50 hover:text-[#1b365d] transition-colors">
                                <i class="fa-solid fa-plus-circle mr-2 opacity-70"></i> Tambah Barang
                            </a>
                        </li>
                        <li>
                            <button data-modal-target="print-modal" data-modal-toggle="print-modal"
                                class="w-full text-left block px-4 py-3 hover:bg-blue-50 hover:text-[#1b365d] transition-colors">
                                <i class="fa-solid fa-print mr-2 opacity-70"></i> Menu Cetak & QR
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- SEARCH & FILTER BAR --}}
        <form id="filterForm" class="mb-8" action="{{ url()->current() }}" method="GET">
            <div class="bg-white p-2 md:p-3 rounded-2xl shadow-sm border border-gray-100 flex flex-col lg:flex-row items-center gap-3">

                {{-- Group 1: Search & Sort --}}
                <div class="flex items-center gap-2 w-full lg:w-1/3">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-magnifying-glass text-xs text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="block w-full pl-10 pr-4 py-2.5 bg-gray-50/50 border-none focus:ring-2 focus:ring-[#1b365d] rounded-xl text-sm transition-all"
                            placeholder="Cari aset...">
                    </div>

                    <select name="sort" onchange="this.form.submit()"
                        class="w-32 bg-gray-50/50 border-none focus:ring-2 focus:ring-[#1b365d] text-gray-600 text-xs font-bold rounded-xl py-2.5 transition-all cursor-pointer">
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>A - Z</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Z - A</option>
                    </select>
                </div>

                {{-- Divider Line (Desktop Only) --}}
                <div class="hidden lg:block w-px h-8 bg-gray-100"></div>

                {{-- Group 2: Dynamic Filters --}}
                <div class="flex flex-col sm:flex-row items-center gap-2 w-full lg:flex-1">
                    <div class="grid grid-cols-2 gap-2 w-full">
                        {{-- Tipe Filter --}}
                        <select id="filter_type" name="filter_type"
                            class="bg-gray-50/50 border-none focus:ring-2 focus:ring-[#1b365d] text-gray-600 text-xs font-semibold rounded-xl py-2.5 transition-all cursor-pointer">
                            <option value="">Semua Filter</option>
                            <option value="ruangan" {{ request('filter_type') == 'ruangan' ? 'selected' : '' }}>Ruangan</option>
                            <option value="kategori" {{ request('filter_type') == 'kategori' ? 'selected' : '' }}>Kategori</option>
                            <option value="unit_kerja" {{ request('filter_type') == 'unit_kerja' ? 'selected' : '' }}>Unit Kerja</option>
                        </select>

                        {{-- Nilai Filter --}}
                        <select id="filter_value" name="filter_value" onchange="this.form.submit()"
                            class="bg-gray-50/50 border-none focus:ring-2 focus:ring-[#1b365d] text-gray-600 text-xs font-semibold rounded-xl py-2.5 transition-all cursor-pointer {{ !request('filter_type') ? 'opacity-50' : '' }}"
                            {{ !request('filter_type') ? 'disabled' : '' }}>
                            <option value="">Pilih Data...</option>
                            @if(request('filter_type') == 'ruangan')
                                @foreach($list_ruangan as $r)
                                    <option value="{{ $r->nama_ruangan }}" {{ request('filter_value') == $r->nama_ruangan ? 'selected' : '' }}>{{ $r->nama_ruangan }}</option>
                                @endforeach
                            @elseif(request('filter_type') == 'kategori')
                                @foreach($list_kategori as $k)
                                    <option value="{{ $k->nama_kategori }}" {{ request('filter_value') == $k->nama_kategori ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                                @endforeach
                            @elseif(request('filter_type') == 'unit_kerja')
                                @foreach($list_unit_kerja as $u)
                                    <option value="{{ $u->nama_unit_kerja }}" {{ request('filter_value') == $u->nama_unit_kerja ? 'selected' : '' }}>{{ $u->nama_unit_kerja }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                {{-- Group 3: Actions --}}
                <div class="flex items-center gap-2 w-full lg:w-auto">
                    <button type="submit"
                        class="flex-1 lg:flex-none bg-[#1b365d] hover:bg-[#2d5a9e] text-white px-6 py-2.5 rounded-xl text-xs font-bold transition-all shadow-sm">
                        Terapkan
                    </button>

                    @if(request()->anyFilled(['search', 'filter_type', 'filter_value']))
                        {{-- Tombol PDF Berdasarkan Filter --}}
                        <a href="{{ route('barang.print-barang', array_merge(request()->query(), ['kategori' => 'bmn', 'ruangan' => request('filter_type') == 'ruangan' ? request('filter_value') : 'all'])) }}"
                            target="_blank"
                            class="filter-action-enter p-2.5 bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-xl transition-all shadow-sm"
                            title="Cetak PDF Hasil Filter">
                            <i class="fa-solid fa-file-pdf"></i>
                        </a>

                        {{-- Tombol QR Berdasarkan Filter --}}
                        <a href="{{ route('barang.print-qrcode', array_merge(request()->query(), ['kategori' => 'bmn', 'ruangan' => request('filter_type') == 'ruangan' ? request('filter_value') : 'all'])) }}"
                            target="_blank"
                            class="filter-action-enter p-2.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl transition-all shadow-sm"
                            title="Cetak QR Hasil Filter">
                            <i class="fa-solid fa-qrcode"></i>
                        </a>

                        <a href="{{ route('barang.bmn_index') }}"
                            class="filter-action-enter p-2.5 text-rose-500 bg-rose-50 hover:bg-rose-100 rounded-xl transition-all"
                            title="Reset Semua">
                            <i class="fa-solid fa-filter-circle-xmark"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>

        {{-- GRID CARDS --}}
        @if ($barang->isEmpty())
            <div class="animate-card">
                <x-empty-data></x-empty-data>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach ($barang as $index => $b)
                    @php
                        $detailRoute = route('bmn.show', [strtolower($b->ruangan), $b->id]);
                        $fotoPath = $b->foto ? asset('storage/' . $b->foto) : asset('img/no-image.png');
                        $isRuangan = in_array($b->ruangan, $ruanganNames);

                        // 1. Cek Rencana Penghapusan (Prioritas Utama)
                        $isRencanaPenghapusan = $b->perawatan->where('jenis_perawatan', 'rencana_penghapusan')->isNotEmpty();

                        // 2. Cek Maintenance Biasa (Tidak termasuk rencana penghapusan)
                        $cek_perawatan = $b->perawatan
                            ->where('jenis_perawatan', '!=', 'rencana_penghapusan')
                            ->whereIn('status', ['pending', 'proses'])
                            ->count() > 0;

                        $cek_laporan = \App\Models\LaporanKerusakan::where('barang_id', $b->id)
                            ->whereIn('status', ['disetujui', 'proses'])
                            ->exists();

                        $sedang_maintenance = $cek_perawatan || $cek_laporan;

                        // Tentukan class border
                        $borderClass = 'border-gray-100';
                        if ($isRencanaPenghapusan) {
                            $borderClass = 'border-red-300 ring-4 ring-red-50';
                        } elseif ($sedang_maintenance) {
                            $borderClass = 'border-amber-300 ring-4 ring-amber-50';
                        }
                    @endphp

                    <div class="animate-card group bg-white rounded-[2.5rem] border {{ $borderClass }} shadow-sm hover-lift overflow-hidden flex flex-col relative"
                        style="animation-delay: {{ $index * 0.05 }}s">

                        <div class="relative h-52 bg-slate-50 overflow-hidden">
                            <div class="absolute top-4 left-4 z-10 flex flex-col gap-2">
                                <span class="bg-white/90 backdrop-blur text-[#1b365d] text-[9px] font-black px-3 py-1.5 rounded-full shadow-sm uppercase tracking-[0.1em] w-fit">
                                    {{ $b->kategori }}
                                </span>

                                {{-- LABEL STATUS KHUSUS --}}
                                @if($isRencanaPenghapusan)
                                    <span class="bg-red-100/90 backdrop-blur text-red-700 border border-red-200 text-[9px] font-black px-3 py-1.5 rounded-full shadow-sm uppercase tracking-[0.1em] flex items-center gap-1.5 w-fit">
                                        <i class="fa-solid fa-trash-can animate-pulse"></i> Rencana Penghapusan
                                    </span>
                                @elseif($sedang_maintenance)
                                    <span class="bg-amber-100/90 backdrop-blur text-amber-700 border border-amber-200 text-[9px] font-black px-3 py-1.5 rounded-full shadow-sm uppercase tracking-[0.1em] flex items-center gap-1.5 w-fit">
                                        <i class="fa-solid fa-gear fa-spin" style="--fa-animation-duration: 3s;"></i> Maintenance
                                    </span>
                                @endif
                            </div>

                            <img src="{{ $fotoPath }}" alt="{{ $b->nama_barang }}"
                                class="w-full h-full object-contain p-8 group-hover:scale-110 transition-transform duration-700 ease-out {{ ($sedang_maintenance || $isRencanaPenghapusan) ? 'grayscale opacity-80' : '' }}">

                            <div class="absolute inset-0 bg-gradient-to-t from-[#1b365d]/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col">
                            <h3
                                class="font-bold text-gray-800 text-sm mb-5 line-clamp-2 leading-snug h-10 group-hover:text-[#1b365d] transition-colors tracking-tight">
                                {{ $b->nama_barang }}
                            </h3>

                            <div class="space-y-4 mb-6">
                                {{-- KONDISI BADGE --}}
                                <div class="flex justify-between items-center bg-slate-50 rounded-xl px-3 py-2 border border-slate-100">
                                    <span class="text-[9px] uppercase tracking-widest text-slate-400 font-black">Kondisi</span>
                                    @if($isRencanaPenghapusan)
                                        <span class="text-[10px] font-black px-2 py-0.5 rounded-lg text-red-700 bg-red-100/50">
                                            PENGHAPUSAN
                                        </span>
                                    @elseif($sedang_maintenance)
                                        <span class="text-[10px] font-black px-2 py-0.5 rounded-lg text-amber-700 bg-amber-100/50">
                                            DIPERBAIKI
                                        </span>
                                    @else
                                        <span class="text-[10px] font-black px-2 py-0.5 rounded-lg {{ in_array($b->kondisi, ['Baik', 'Sangat Baik']) ? 'text-emerald-700 bg-emerald-100/50' : 'text-rose-700 bg-rose-100/50' }}">
                                            {{ strtoupper($b->kondisi) }}
                                        </span>
                                    @endif
                                </div>

                                <div class="flex flex-col gap-2.5 px-1">
                                    {{-- LOKASI --}}
                                    <div class="flex items-center gap-2 text-[#1b365d]">
                                        <div class="w-5 h-5 rounded-md bg-blue-50 flex items-center justify-center">
                                            <i class="fa-solid {{ $isRuangan ? 'fa-location-dot' : 'fa-user-tie' }} text-[10px]"></i>
                                        </div>
                                        <span class="text-[11px] font-bold truncate">{{ $b->ruangan }}</span>
                                    </div>

                                    {{-- UNIT KERJA --}}
                                    <div class="flex items-center gap-2 text-[#1b365d]">
                                      <div class="w-5 h-5 rounded-md bg-blue-50 flex items-center justify-center">
                                          <i class="fa-solid fa-building-user text-[10px]"></i>
                                      </div>
                                      <span class="text-[11px] font-bold truncate">{{ $b->unit_kerja ?? '-' }}</span>
                                  </div>

                                    {{-- KODE BARANG --}}
                                    <div class="flex items-center gap-2 text-slate-400 pt-1.5 border-t border-slate-50">
                                        <i class="fa-solid fa-barcode text-[10px]"></i>
                                        <span class="text-[10px] font-mono tracking-tighter uppercase">{{ $b->kode_barang ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-auto pt-4 flex items-center gap-2">
                                <a href="{{ $detailRoute }}"
                                    class="flex-1 bg-slate-50 hover:bg-[#1b365d] text-[#1b365d] hover:text-white py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all text-center">
                                    Detail
                                </a>

                                @if (Auth::user()->role == 'superadmin')
                                    <a href="{{ route('bmn.edit', [strtolower($b->ruangan), $b->id]) }}"
                                        class="p-2.5 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white rounded-xl transition-all shadow-sm">
                                        <i class="fa-regular fa-pen-to-square text-sm"></i>
                                    </a>
                                    <button
                                        onclick="confirmDelete('{{ route('bmn.delete', [strtolower($b->ruangan), $b->id]) }}')"
                                        data-modal-target="delete-modal" data-modal-toggle="delete-modal"
                                        class="p-2.5 bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white rounded-xl transition-all shadow-sm">
                                        <i class="fa-regular fa-trash-can text-sm"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- PAGINATION --}}
        <div class="mt-12 bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            {{ $barang->appends(request()->query())->links() }}
        </div>
    </div>

    {{-- MODAL CETAK (LAMA) --}}
    <div id="print-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-md bg-gray-900/40 transition-all duration-300">
        <div class="relative p-4 w-full max-w-md max-h-full animate-card">
            <div
                class="relative bg-white rounded-[2.5rem] shadow-2xl dark:bg-gray-800 border border-white/20 overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-[#1b365d] via-blue-600 to-[#1b365d]">
                </div>

                <div class="flex items-center justify-between p-6 border-b border-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-[#1b365d]">
                            <i class="fa-solid fa-print text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Opsi Cetak BMN</h3>
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold">Laporan & QR Code</p>
                        </div>
                    </div>
                    <button type="button" data-modal-hide="print-modal"
                        class="text-gray-400 bg-transparent hover:bg-gray-100 rounded-xl text-sm w-9 h-9 inline-flex justify-center items-center transition-colors">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <div class="p-8">
                    <form id="printForm" method="GET" target="_blank" class="space-y-6">
                        <input type="hidden" name="kategori" value="bmn">
                        <div class="relative">
                            <label class="block mb-2 text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Pilih Lokasi / Ruangan</label>
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#1b365d]">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <select id="print_ruangan" name="ruangan"
                                    class="bg-gray-50 border border-gray-100 text-gray-700 text-sm rounded-2xl block w-full pl-11 p-3.5 focus:ring-2 focus:ring-[#1b365d] appearance-none cursor-pointer transition-all">
                                    <option value="all">Seluruh Ruangan</option>
                                    @foreach ($list_ruangan as $rm)
                                        <option value="{{ $rm->nama_ruangan }}">{{ $rm->nama_ruangan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <button type="button" onclick="submitPrint('{{ route('barang.print-barang') }}')"
                                class="group flex flex-col items-center justify-center gap-2 p-4 bg-white border border-gray-100 rounded-2xl hover:border-[#1b365d] hover:shadow-xl transition-all">
                                <div
                                    class="w-12 h-12 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-file-pdf text-xl"></i>
                                </div>
                                <span class="text-xs font-bold text-gray-700">Data PDF</span>
                            </button>

                            <button type="button" onclick="submitPrint('{{ route('barang.print-qrcode') }}')"
                                class="group flex flex-col items-center justify-center gap-2 p-4 bg-white border border-gray-100 rounded-2xl hover:border-indigo-500 hover:shadow-xl transition-all">
                                <div
                                    class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-qrcode text-xl"></i>
                                </div>
                                <span class="text-xs font-bold text-gray-700">QR Barang</span>
                            </button>

                            <button type="button" id="btn_qr_ruangan"
                                onclick="submitPrint('{{ route('barang.print-qr-ruangan') }}')"
                                class="col-span-2 relative group overflow-hidden bg-slate-900 text-white p-4 rounded-2xl flex items-center justify-center gap-3 hover:bg-slate-800 transition-all shadow-lg active:scale-[0.98]">
                                <i
                                    class="fa-solid fa-door-open text-lg text-blue-400 group-hover:rotate-12 transition-transform"></i>
                                <span class="font-bold text-sm tracking-wide">Cetak QR Label Ruangan</span>
                                <div
                                    class="absolute top-0 -inset-full h-full w-1/2 z-5 block transform -skew-x-12 bg-gradient-to-r from-transparent to-white/10 opacity-40 group-hover:animate-shine">
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL HAPUS --}}
    <div id="delete-modal" tabindex="-1"
        class="hidden fixed inset-0 z-50 justify-center items-center backdrop-blur-sm bg-gray-900/40 transition-all">
        <div class="relative p-4 w-full max-w-md animate-card">
            <div class="relative bg-white rounded-[2.5rem] shadow-2xl p-8 text-center border border-gray-100">
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-triangle-exclamation text-4xl"></i>
                </div>
                <h3 class="mb-2 text-xl font-bold text-gray-800">Hapus Data BMN?</h3>
                <p class="mb-8 text-sm text-gray-500 leading-relaxed">Tindakan ini tidak dapat dibatalkan. Seluruh riwayat aset ini akan terhapus secara permanen.</p>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" data-modal-hide="delete-modal"
                            class="flex-1 px-5 py-3 text-sm font-bold text-gray-700 bg-gray-100 rounded-2xl hover:bg-gray-200 transition-all">Batal</button>
                        <button type="submit"
                            class="flex-1 px-5 py-3 text-sm font-bold text-white bg-red-600 rounded-2xl hover:bg-red-700 shadow-lg shadow-red-200 transition-all">Ya, Hapus Aset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // 1. Logika Filter Dinamis
    document.getElementById('filter_type').addEventListener('change', function() {
        const type = this.value;
        const valueSelect = document.getElementById('filter_value');

        valueSelect.innerHTML = '<option value="">Pilih Data...</option>';

        if (!type) {
            valueSelect.disabled = true;
            valueSelect.classList.add('opacity-50');
            window.location.href = "{{ route('barang.bmn_index') }}";
            return;
        }

        valueSelect.disabled = false;
        valueSelect.classList.remove('opacity-50');

        let options = [];
        if (type === 'ruangan') {
            options = @json($list_ruangan->pluck('nama_ruangan'));
        } else if (type === 'kategori') {
            options = @json($list_kategori->pluck('nama_kategori'));
        } else if (type === 'unit_kerja') {
            options = @json($list_unit_kerja->pluck('nama_unit_kerja'));
        }

        options.forEach(opt => {
            const el = document.createElement('option');
            el.value = opt;
            el.textContent = opt;
            if(opt === "{{ request('filter_value') }}") el.selected = true;
            valueSelect.appendChild(el);
        });
    });

    // 2. Fungsi Submit Print
    function submitPrint(actionUrl) {
        const form = document.getElementById('printForm');
        form.action = actionUrl;
        form.submit();
    }

    // 3. Fungsi Confirm Delete
    function confirmDelete(url) {
        const form = document.getElementById('deleteForm');
        form.action = url;
    }
</script>
@endsection
