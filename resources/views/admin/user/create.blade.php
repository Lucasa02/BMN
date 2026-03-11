@extends('layouts.admin.main')

@section('content')
<div class="p-6 transition-all duration-500 ease-in-out animate-fade-in-up">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white tracking-tight">Tambah Pengguna Baru</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Silahkan isi formulir di bawah ini untuk mendaftarkan user baru ke dalam sistem.</p>
        </div>
        <div>
            <a href="{{ route('users.index') }}"
               class="flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 transition-all duration-200">
                <i class="fas fa-arrow-left mr-2 text-xs"></i> Kembali ke Daftar
            </a>
        </div>
    </div>

    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-3xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="p-8">
            <form action="{{ route('users.store') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="grid gap-6 sm:grid-cols-2">

                    <div class="sm:col-span-2">
                        <label for="nama_lengkap" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400 text-xs"></i>
                            </div>
                            <input type="text" name="nama_lengkap" id="nama_lengkap"
                                class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#1b365d] focus:border-[#1b365d] block w-full pl-10 p-3 transition-all"
                                placeholder="Nama lengkap tanpa gelar" value="{{ old('nama_lengkap') }}" autocomplete="off" />
                        </div>
                        @error('nama_lengkap')
                            <p class="text-red-500 text-xs mt-1 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nip" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">NIP</label>
                        <input type="text" name="nip" id="nip"
                            class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#1b365d] focus:border-[#1b365d] block w-full p-3 transition-all"
                            placeholder="Masukkan NIP" value="{{ old('nip') }}">
                        @error('nip')
                            <p class="text-red-500 text-xs mt-1 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nomor_hp" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Nomor HP</label>
                        <div class="relative">
                             <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-400 text-xs">+62</span>
                            </div>
                            <input type="text" name="nomor_hp" id="nomor_hp"
                                class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#1b365d] focus:border-[#1b365d] block w-full pl-12 p-3 transition-all"
                                placeholder="813xxxxxxx" value="{{ old('nomor_hp') }}">
                        </div>
                        @error('nomor_hp')
                            <p class="text-red-500 text-xs mt-1 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="email" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Alamat Email</label>
                        <input type="email" name="email" id="email"
                            class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#1b365d] focus:border-[#1b365d] block w-full p-3 transition-all"
                            placeholder="user@instansi.com" value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Hak Akses (Role)</label>
                        <select id="role" name="role"
                            class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#1b365d] focus:border-[#1b365d] block w-full p-3 transition-all cursor-pointer">
                            <option value="">-- Pilih Role --</option>
                            @if (Auth::user()->role == 'superadmin')
                                <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                            @endif
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="tim_perbaikan" {{ old('role') == 'tim_perbaikan' ? 'selected' : '' }}>Tim Perbaikan</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-xs mt-1 italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2 hidden animate-fade-in" id="passwordContainer">
                        <label for="password" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">Kata Sandi Akun</label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-[#1b365d] focus:border-[#1b365d] block w-full p-3 pr-10 transition-all"
                                placeholder="Masukkan password minimal 8 karakter">
                            <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer" onclick="togglePassword()">
                                <i id="eyeIcon" class="fas fa-eye text-gray-400 hover:text-[#1b365d]"></i>
                            </span>
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1">*Wajib diisi karena Anda memilih role dengan hak akses login.</p>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1 italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-10 flex items-center justify-end space-x-3 border-t border-gray-100 pt-8">
                    <button type="reset" class="px-6 py-2.5 text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">
                        Reset
                    </button>
                    <button type="submit"
                        class="flex items-center px-8 py-3 text-sm font-bold text-white bg-[#1b365d] rounded-xl shadow-lg shadow-[#1b365d]/30 hover:bg-[#142845] hover:shadow-[#1b365d]/50 transition-all duration-300 transform hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i> Simpan Data Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .animate-fade-in-up { animation: fadeInUp 0.6s ease-out; }
    .animate-fade-in { animation: fadeIn 0.4s ease-in; }

    /* Custom Focus Style */
    input:focus, select:focus {
        outline: none;
        box-shadow: 0 0 0 4px rgba(27, 54, 93, 0.1);
    }
</style>
@endsection

@section('scripts')
<script>
    function togglePasswordVisibility() {
    const roleSelect = document.getElementById("role");
    const passwordContainer = document.getElementById("passwordContainer");
    const passwordInput = document.getElementById("password");

    // Ubah pengecekan value menjadi tim_perbaikan
    if (roleSelect.value === "superadmin" || roleSelect.value === "admin" || roleSelect.value === "tim_perbaikan") {
        passwordContainer.classList.remove("hidden");
        passwordInput.setAttribute("required", "required");
    } else {
        passwordContainer.classList.add("hidden");
        passwordInput.removeAttribute("required");
    }
}

    document.getElementById("role").addEventListener("change", togglePasswordVisibility);
    window.onload = togglePasswordVisibility;

    function togglePasswordVisibility() {
        const roleSelect = document.getElementById("role");
        const passwordContainer = document.getElementById("passwordContainer");
        const passwordInput = document.getElementById("password");

        // Hapus "teknisi" dari pengecekan ini
        if (roleSelect.value === "superadmin" || roleSelect.value === "admin") {
            passwordContainer.classList.remove("hidden");
            passwordInput.setAttribute("required", "required");
        } else {
            passwordContainer.classList.add("hidden");
            passwordInput.removeAttribute("required");
        }
    }
</script>
@endsection
