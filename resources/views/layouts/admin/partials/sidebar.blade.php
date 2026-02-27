<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    /* Elegant Hover Animation */
    .nav-item {
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .nav-item i {
        transition: transform 0.3s ease;
    }

    .nav-item:hover i {
        transform: scale(1.2) rotate(-5deg);
    }

    /* Active Link Indicator */
    .nav-active::before {
        content: "";
        position: absolute;
        left: 0;
        top: 20%;
        height: 60%;
        width: 4px;
        background: #ffffff;
        border-radius: 0 4px 4px 0;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }
</style>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-tvri_base_color border-r border-white/5 sm:translate-x-0 shadow-2xl"
    aria-label="Sidebar">
    <div class="h-full px-4 pb-4 overflow-y-auto no-scrollbar">
        <ul class="space-y-1.5 font-sans">

            @php
                $activeClass = 'bg-white/15 text-white shadow-inner nav-active';
                $inactiveClass = 'text-white/70 hover:bg-white/10 hover:text-white';
            @endphp

            {{-- === GENERAL === --}}
            <li class="pt-4 pb-2">
                <div class="flex items-center px-3">
                    <span class="text-[10px] font-bold tracking-[2px] text-white/40 uppercase">GENERAL</span>
                </div>
            </li>

            {{-- Dashboard --}}
            <li>
                <a href="{{ route('dashboard.index') }}"
                    class="nav-item flex items-center p-2.5 rounded-xl transition-all {{ request()->routeIs('dashboard.*') ? $activeClass : $inactiveClass }}">
                    <div
                        class="w-8 h-8 flex items-center justify-center rounded-lg {{ request()->routeIs('dashboard.*') ? 'bg-blue-500' : 'bg-white/5' }} mr-1">
                        <i class="fa-solid fa-house text-sm"></i>
                    </div>
                    <span class="ms-2 text-sm font-medium">Dashboard</span>
                </a>
            </li>

            {{-- === DATA MASTER BMN === --}}
            <li>
                <button type="button"
                    class="nav-item flex items-center w-full p-2.5 text-white/70 rounded-xl hover:bg-white/10 hover:text-white transition-all group"
                    data-collapse-toggle="dropdown-bmn">
                    <div
                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 mr-1 group-hover:bg-blue-500 transition-colors">
                        <i class="fa-solid fa-boxes-stacked text-sm"></i>
                    </div>
                    <span class="flex-1 ms-2 text-left text-sm font-medium">Data Master</span>
                    <i class="fa-solid fa-chevron-down text-[10px] opacity-50 transition-transform duration-300"
                        id="arrow-bmn"></i>
                </button>

                {{-- Hapus users.* dari pengecekan routeIs di bawah ini --}}
                <ul id="dropdown-bmn"
                    class="{{ request()->routeIs('barang.bmn_index', 'bmn.ruangan.*', 'bmn.kategori.*', 'bmn.jenis_kerusakan.*', 'jabatan.*') ? 'block' : 'hidden' }} py-2 space-y-1 ml-4 border-l border-white/10 mt-1">
                    <li>
                        <a href="{{ route('barang.bmn_index') }}"
                            class="flex items-center p-2 pl-6 rounded-lg text-xs {{ request()->routeIs('barang.bmn_index') ? 'text-white font-bold' : 'text-white/60 hover:text-white' }}">
                            <i class="fa-solid fa-box-archive w-4 text-blue-400 mr-3"></i> Barang
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bmn.ruangan.index') }}"
                            class="flex items-center p-2 pl-6 rounded-lg text-xs {{ request()->routeIs('bmn.ruangan.*') ? 'text-white font-bold' : 'text-white/60 hover:text-white' }}">
                            <i class="fa-solid fa-door-open w-4 text-emerald-400 mr-3"></i> Ruangan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bmn.kategori.index') }}"
                            class="flex items-center p-2 pl-6 rounded-lg text-xs {{ request()->routeIs('bmn.kategori.*') ? 'text-white font-bold' : 'text-white/60 hover:text-white' }}">
                            <i class="fa-solid fa-tags w-4 text-yellow-400 mr-3"></i> Kategori
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bmn.pengguna.index') }}"
                            class="flex items-center p-2 pl-6 rounded-lg text-xs {{ request()->routeIs('bmn.pengguna.*') ? 'text-white font-bold' : 'text-white/60 hover:text-white' }}">
                            <i class="fa-solid fa-user-tag w-4 text-purple-400 mr-3"></i> Pengguna
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bmn.unit_kerja.index') }}"
                            class="flex items-center p-2 pl-6 rounded-lg text-xs {{ request()->routeIs('bmn.unit_kerja.*') ? 'text-white font-bold' : 'text-white/60 hover:text-white' }}">
                            <i class="fa-solid fa-building-user w-4 text-cyan-400 mr-3"></i> Unit Kerja
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('bmn.jenis_kerusakan.index') }}"
                            class="flex items-center p-2 pl-6 rounded-lg text-xs {{ request()->routeIs('bmn.jenis_kerusakan.*') ? 'text-white font-bold' : 'text-white/60 hover:text-white' }}">
                            <i class="fa-solid fa-triangle-exclamation w-4 text-red-400 mr-3"></i> Jenis Kerusakan
                        </a>
                    </li>
                </ul>
            </li>

            {{-- === MAINTENANCE BMN === --}}
            <li class="pt-4 pb-2">
                <div class="flex items-center px-3">
                    <span class="text-[10px] font-bold tracking-[2px] text-white/40 uppercase">Maintenance BMN</span>
                </div>
            </li>

            <li>
                <button type="button"
                    class="nav-item flex items-center w-full p-2.5 text-white/70 rounded-xl hover:bg-white/10 hover:text-white transition-all group"
                    data-collapse-toggle="dropdown-perawatan-bmn">
                    <div
                        class="w-8 h-8 flex items-center justify-center rounded-lg bg-white/5 mr-1 group-hover:bg-blue-500 transition-colors">
                        <i class="fa-solid fa-hand-holding-medical"></i>
                    </div>
                    <span class="flex-1 ms-2 text-left text-sm font-medium">Perawatan BMN</span>
                    <i class="fa-solid fa-chevron-down text-[10px] opacity-50 transition-transform duration-300"
                        id="arrow-bmn"></i>
                </button>

                <ul id="dropdown-perawatan-bmn"
                    class="{{ request()->routeIs('perawatan_inventaris.*', 'rencana_penghapusan.*', 'admin.laporan-kerusakan.*', 'data_penghapusan.*') ? 'block' : 'hidden' }} py-2 space-y-1 ml-4 border-l border-white/10 mt-1">
                    <li>
                        <a href="{{ route('perawatan_inventaris.index') }}"
                            class="flex items-center p-2 pl-6 rounded-lg text-xs {{ request()->routeIs('perawatan_inventaris.*') ? 'text-white font-bold' : 'text-white/60 hover:text-white' }}">
                            <i class="fa-solid fa-screwdriver-wrench w-4 text-green-400 mr-3"></i> Perawatan Inventaris
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('rencana_penghapusan.index', ['status' => 'pending']) }}"
                            class="flex items-center p-2 pl-6 rounded-lg text-xs {{ request()->routeIs('rencana_penghapusan.*') ? 'text-white font-bold' : 'text-white/60 hover:text-white' }}">
                            <i class="fa-solid fa-file-signature w-4 text-yellow-400 mr-3"></i> Rencana Penghapusan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('data_penghapusan.index') }}"
                            class="flex items-center p-2 pl-6 rounded-lg text-xs {{ request()->routeIs('data_penghapusan.*') ? 'text-white font-bold' : 'text-white/60 hover:text-white' }}">
                            <i class="fa-solid fa-file-circle-xmark w-4 text-blue-400 mr-3"></i> Data Penghapusan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.laporan-kerusakan.index') }}"
                            class="flex items-center p-2 pl-6 rounded-lg text-xs {{ request()->routeIs('admin.laporan-kerusakan.*') ? 'text-white font-bold' : 'text-white/60 hover:text-white' }}">
                            <i class="fa-solid fa-clipboard-list w-4 text-red-400 mr-3"></i> Laporan Kerusakan
                        </a>
                    </li>
                </ul>
            </li>

            {{-- === USER SECTION === --}}
            <li class="pt-4 pb-2">
                <div class="flex items-center px-3">
                    <span class="text-[10px] font-bold tracking-[2px] text-white/40 uppercase">User</span>
                </div>
            </li>

            {{-- Pengguna --}}
            <li>
                <a href="{{ route('users.index') }}"
                    class="nav-item flex items-center p-2.5 rounded-xl transition-all {{ request()->routeIs('users.*') ? $activeClass : $inactiveClass }}">
                    <div
                        class="w-8 h-8 flex items-center justify-center rounded-lg {{ request()->routeIs('users.*') ? 'bg-blue-500' : 'bg-white/5' }} mr-1">
                        <i class="fa-solid fa-user-gear text-sm"></i>
                    </div>
                    <span class="ms-2 text-sm font-medium">Data Pengguna</span>
                </a>
            </li>

            {{-- === LAINNYA === --}}
            <li class="pt-4 pb-2">
                <div class="flex items-center px-3">
                    <span class="text-[10px] font-bold tracking-[2px] text-white/40 uppercase">Dokumentasi</span>
                </div>
            </li>

            <li>
                <a href="{{ route('buku-panduan.index') }}"
                    class="nav-item flex items-center p-2.5 rounded-xl transition-all {{ request()->routeIs('buku-panduan.*') ? $activeClass : $inactiveClass }}">
                    <div
                        class="w-8 h-8 flex items-center justify-center rounded-lg {{ request()->routeIs('buku-panduan.*') ? 'bg-blue-500' : 'bg-white/5' }} mr-1">
                        <i class="fa-solid fa-bookmark"></i>
                    </div>
                    <span class="ms-2 text-sm font-medium">Buku Panduan</span>
                </a>
            </li>

            {{-- Logout --}}
            <li class="mt-10 pt-4 border-t border-white/10">
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center p-3 rounded-xl bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all group">
                    <i class="fa-solid fa-power-off group-hover:rotate-90 transition-transform duration-300"></i>
                    <span class="ms-3 text-sm font-bold">LOGOUT</span>
                </a>
            </li>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>

        </ul>
    </div>
</aside>
