@extends('layouts.admin.main')

@section('content')
<div class="p-6 transition-all duration-500 ease-in-out animate-fade-in-up">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Manajemen Pengguna</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola dan pantau seluruh kredensial pengguna sistem Anda.</p>
        </div>

        <div class="flex items-center space-x-3">
            @if (in_array(Route::currentRouteName(), ['users.search', 'users.jabatan']))
                <a href="{{ route('users.index') }}"
                    class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2 text-xs"></i> Kembali
                </a>
            @endif

            {{-- PERUBAHAN WARNA TOMBOL DI SINI --}}
            <a href="{{ route('users.create') }}"
                class="flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-[#1b365d] rounded-xl shadow-lg shadow-[#1b365d]/30 hover:bg-[#142845] hover:shadow-[#1b365d]/50 transition-all duration-300 transform hover:-translate-y-0.5">
                <i class="fas fa-plus mr-2"></i> User
            </a>
            {{-- AKHIR PERUBAHAN --}}
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 mb-6">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
            <form class="relative w-full lg:w-96" action="{{ route('users.search') }}" method="GET">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4-4m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" name="search" autocomplete="off"
                    class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-700 text-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                    placeholder="Cari nama atau NIP...">
            </form>

            <div class="flex flex-row items-center gap-3 w-full lg:w-auto">
                @if (Auth::user()->role == 'superadmin')
                    <div class="flex-1 sm:flex-none">
                        <x-filter-user-by-role></x-filter-user-by-role>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if ($user->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-12 text-center border border-dashed border-gray-300">
            <x-empty-data></x-empty-data>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300 font-semibold uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4 text-center">No.</th>
                            <th class="px-6 py-4">Informasi User</th>
                            @if (Auth::user()->role == 'superadmin')
                                <th class="px-6 py-4 text-center">Akses Role</th>
                            @endif
                            <th class="px-6 py-4">Jabatan</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($user as $row)
                        <tr class="hover:bg-indigo-50/30 dark:hover:bg-gray-700/50 transition-colors duration-200 group">
                            <td class="px-6 py-4 text-center font-medium text-gray-500">
                                {{ $user->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-indigo-600 font-bold border-2 border-white shadow-sm">
                                        {{ substr($row->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $row->nama_lengkap }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $row->kode_user }}</div>
                                    </div>
                                </div>
                            </td>
                            @if (Auth::user()->role == 'superadmin')
                            <td class="px-6 py-4 text-center">
                                @php
                                    $roleColor = [
                                        'superadmin' => 'bg-purple-100 text-purple-700 ring-purple-600/20',
                                        'admin' => 'bg-blue-100 text-blue-700 ring-blue-600/20',
                                        'tim_perbaikan' => 'bg-indigo-100 text-indigo-700 ring-indigo-600/20',
                                        'user' => 'bg-gray-100 text-gray-700 ring-gray-600/20'
                                    ][$row->role] ?? 'bg-gray-100 text-gray-700';
                                @endphp
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-bold ring-1 ring-inset {{ $roleColor }}">
                                    {{ $row->role == 'tim_perbaikan' ? 'Tim Perbaikan' : ucfirst($row->role) }}
                                </span>
                            </td>
                            @endif
                            <td class="px-6 py-4">
                                <span class="text-gray-700 dark:text-gray-300 font-medium italic">
                                    {{ $row->jabatan->jabatan }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <a href="{{ route('users.show', $row->uuid) }}"
                                       class="p-2 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-600 hover:text-white transition-all shadow-sm" title="Detail">
                                        <i class="fas fa-info-circle text-sm"></i>
                                    </a>

                                    @if (Auth::user()->role == 'superadmin')
                                        <a href="{{ route('users.edit', $row->uuid) }}"
                                           class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-600 hover:text-white transition-all shadow-sm" title="Ubah">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        <button onclick="confirmDelete('{{ route('users.destroy', ['uuid' => $row->uuid]) }}')"
                                                data-modal-target="delete-modal" data-modal-toggle="delete-modal"
                                                class="p-2 bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-600 hover:text-white transition-all shadow-sm">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    @endif

                                    <a href="{{ route('users.id.card', $row->uuid) }}" target="_blank"
                                       class="p-2 bg-slate-800 text-white rounded-lg hover:bg-black transition-all shadow-md" title="Cetak ID">
                                        <i class="fas fa-print text-sm"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 bg-gray-50/50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700">
                {{ $user->links() }}
            </div>
        </div>
    @endif
</div>

<div id="delete-modal" tabindex="-1" class="fixed inset-0 z-50 hidden overflow-y-auto overflow-x-hidden backdrop-blur-md bg-black/20 flex justify-center items-center">
    <div class="relative p-4 w-full max-w-md animate-zoom-in">
        <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 text-center border border-gray-100 dark:border-gray-700">
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-rose-100 mb-6">
                <i class="fas fa-exclamation-triangle text-3xl text-rose-600"></i>
            </div>
            <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Hapus Data Pengguna?</h3>
            <p class="mb-8 text-gray-500 text-sm">Tindakan ini tidak dapat dibatalkan. Semua data terkait user ini akan terhapus permanen.</p>

            <div class="flex justify-center space-x-3">
                <button data-modal-hide="delete-modal" type="button"
                        class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-all">
                    Batal
                </button>
                <form id="deleteForm" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="px-6 py-2.5 text-sm font-semibold text-white bg-rose-600 rounded-xl hover:bg-rose-700 shadow-lg shadow-rose-200 transition-all">
                        Ya, Hapus Data
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes zoomIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.6s ease-out; }
    .animate-zoom-in { animation: zoomIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
</style>
@endsection

@section('scripts')
<script>
    function confirmDelete(url) {
        document.getElementById('deleteForm').action = url;
    }
</script>
@endsection
