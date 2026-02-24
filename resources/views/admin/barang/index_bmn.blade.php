@extends('layouts.admin.main')

@section('content')
    <style>
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
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            transition: all 0.3s ease;
        }

        .btn-gradient-blue:hover {
            filter: brightness(115%);
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.4);
        }
    </style>

    @php
        $ruanganNames = $list_ruangan->pluck('nama_ruangan')->toArray();
    @endphp

    <div class="px-6 py-6">
        {{-- HEADER & TOOLS --}}
        <div
            class="glass-header sticky top-4 z-30 mb-8 p-4 rounded-2xl shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-blue-100 rounded-xl text-blue-700">
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
                                class="block px-4 py-3 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                <i class="fa-solid fa-plus-circle mr-2 opacity-70"></i> Tambah Barang
                            </a>
                        </li>
                        <li>
                            <button data-modal-target="print-modal" data-modal-toggle="print-modal"
                                class="w-full text-left block px-4 py-3 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                <i class="fa-solid fa-print mr-2 opacity-70"></i> Menu Cetak & QR
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- SEARCH & FILTER BAR --}}
        <form class="mb-8" action="{{ url()->current() }}" method="GET">
            <div class="flex flex-col md:flex-row gap-3 bg-white p-3 rounded-2xl shadow-sm border border-gray-100">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="block w-full pl-11 pr-4 py-3 bg-gray-50 border-none focus:ring-2 focus:ring-blue-500 rounded-xl text-sm transition-all"
                        placeholder="Cari nama barang, kode, atau spesifikasi...">
                </div>

                <div class="flex gap-2">
                    <select name="ruangan_filter" onchange="this.form.submit()"
                        class="bg-gray-50 border-none focus:ring-2 focus:ring-blue-500 text-gray-700 text-sm rounded-xl block p-3 transition-all">
                        <option value="">Semua Ruangan</option>
                        @foreach ($list_ruangan as $rm)
                            <option value="{{ $rm->nama_ruangan }}"
                                {{ request('ruangan_filter') == $rm->nama_ruangan ? 'selected' : '' }}>
                                {{ $rm->nama_ruangan }}
                            </option>
                        @endforeach
                    </select>

                    <select name="filter"
                        class="bg-gray-50 border-none focus:ring-2 focus:ring-blue-500 text-gray-700 text-sm rounded-xl block p-3 transition-all">
                        <option value="nama_barang" {{ request('filter') == 'nama_barang' ? 'selected' : '' }}>Nama</option>
                        <option value="kode_barang" {{ request('filter') == 'kode_barang' ? 'selected' : '' }}>Kode</option>
                        <option value="kategori" {{ request('filter') == 'kategori' ? 'selected' : '' }}>Kategori</option>
                        <option value="ruangan" {{ request('filter') == 'ruangan' ? 'selected' : '' }}>Lokasi</option>
                    </select>

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 rounded-xl font-medium transition-colors shadow-md shadow-blue-200">
                        Cari
                    </button>
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
                    @endphp

                    <div class="animate-card group bg-white rounded-3xl border border-gray-100 shadow-sm hover-lift overflow-hidden flex flex-col"
                        style="animation-delay: {{ $index * 0.05 }}s">

                        <div class="relative h-52 bg-gray-50 overflow-hidden">
                            <div class="absolute top-3 left-3 z-10">
                                <span
                                    class="bg-white/90 backdrop-blur text-blue-900 text-[10px] font-extrabold px-3 py-1.5 rounded-full shadow-sm uppercase tracking-wider">
                                    {{ $b->kategori }}
                                </span>
                            </div>

                            <img src="{{ $fotoPath }}" alt="{{ $b->nama_barang }}"
                                class="w-full h-full object-contain p-6 group-hover:scale-110 transition-transform duration-700 ease-out">

                            <div
                                class="absolute inset-0 bg-gradient-to-t from-blue-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>

                        <div class="p-5 flex-1 flex flex-col">
                            <h3
                                class="font-bold text-gray-800 text-sm mb-4 line-clamp-2 leading-snug h-10 group-hover:text-blue-700 transition-colors">
                                {{ $b->nama_barang }}
                            </h3>

                            <div class="space-y-3 mb-5">
                                <div
                                    class="flex justify-between items-center bg-gray-50 rounded-xl px-3 py-2 border border-gray-50">
                                    <span class="text-[10px] uppercase tracking-wide text-gray-400 font-bold">Kondisi</span>
                                    <span
                                        class="text-[11px] font-bold px-2 py-0.5 rounded-lg {{ in_array($b->kondisi, ['Baik', 'Sangat Baik']) ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50' }}">
                                        {{ $b->kondisi }}
                                    </span>
                                </div>

                                <div class="flex flex-col gap-1 px-1">
                                    <div class="flex items-center gap-2 text-gray-500">
                                        <i
                                            class="fa-solid {{ $isRuangan ? 'fa-location-dot' : 'fa-user-tie' }} text-[10px]"></i>
                                        <span class="text-[11px] font-medium truncate">{{ $b->ruangan }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-gray-400">
                                        <i class="fa-solid fa-barcode text-[10px]"></i>
                                        <span
                                            class="text-[11px] font-mono tracking-tighter">{{ $b->kode_barang ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-auto pt-4 border-t border-gray-100 flex items-center gap-2">
                                <a href="{{ $detailRoute }}"
                                    class="flex-1 bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white py-2.5 rounded-xl text-xs font-bold transition-all text-center">
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

    {{-- MODAL CETAK (VERSI MEWAH) --}}
    <div id="print-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-md bg-gray-900/40 transition-all duration-300">
        <div class="relative p-4 w-full max-w-md max-h-full animate-card">
            <div
                class="relative bg-white rounded-[2rem] shadow-2xl dark:bg-gray-800 border border-white/20 overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-800">
                </div>

                <div class="flex items-center justify-between p-6 border-b border-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                            <i class="fa-solid fa-print text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Opsi Cetak BMN</h3>
                            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-semibold">Laporan & QR Code
                            </p>
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
                            <label class="block mb-2 text-xs font-bold text-gray-500 uppercase tracking-wider ml-1">Pilih
                                Lokasi / Ruangan</label>
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-blue-500">
                                    <i class="fa-solid fa-location-dot"></i>
                                </div>
                                <select id="print_ruangan" name="ruangan"
                                    class="bg-gray-50 border border-gray-100 text-gray-700 text-sm rounded-2xl block w-full pl-11 p-3.5 focus:ring-2 focus:ring-blue-500 appearance-none cursor-pointer transition-all">
                                    <option value="all">Seluruh Ruangan</option>
                                    @foreach ($list_ruangan as $rm)
                                        <option value="{{ $rm->nama_ruangan }}">{{ $rm->nama_ruangan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <button type="button" onclick="submitPrint('{{ route('barang.print-barang') }}')"
                                class="group flex flex-col items-center justify-center gap-2 p-4 bg-white border border-gray-100 rounded-2xl hover:border-blue-500 hover:shadow-xl transition-all">
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

    {{-- MODAL HAPUS (DISESUAIKAN) --}}
    <div id="delete-modal" tabindex="-1"
        class="hidden fixed inset-0 z-50 justify-center items-center backdrop-blur-sm bg-gray-900/40 transition-all">
        <div class="relative p-4 w-full max-w-md animate-card">
            <div class="relative bg-white rounded-[2rem] shadow-2xl p-8 text-center border border-gray-100">
                <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-triangle-exclamation text-4xl"></i>
                </div>
                <h3 class="mb-2 text-xl font-bold text-gray-800">Hapus Data BMN?</h3>
                <p class="mb-8 text-sm text-gray-500 leading-relaxed">Tindakan ini tidak dapat dibatalkan. Seluruh riwayat
                    aset ini akan terhapus secara permanen.</p>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" data-modal-hide="delete-modal"
                            class="flex-1 px-5 py-3 text-sm font-bold text-gray-700 bg-gray-100 rounded-2xl hover:bg-gray-200 transition-all">Batal</button>
                        <button type="submit"
                            class="flex-1 px-5 py-3 text-sm font-bold text-white bg-red-600 rounded-2xl hover:bg-red-700 shadow-lg shadow-red-200 transition-all">Ya,
                            Hapus Aset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function submitPrint(url) {
            const form = document.getElementById('printForm');
            form.action = url;
            form.submit();
        }

        function confirmDelete(url) {
            document.getElementById('deleteForm').action = url;
        }
    </script>
@endsection
