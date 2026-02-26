@extends('auth.template')

@section('content')
<style>
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .animated-gradient {
        background: linear-gradient(-45deg, #1b365d, #254677, #132947, #1b365d);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
    }

    .bmn-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg stroke='%23ffffff' stroke-width='0.5' stroke-opacity='0.08'%3E%3Cpath d='M40 40c0-11.046-8.954-20-20-20S0 28.954 0 40s8.954 20 20 20 20-8.954 20-20zm40 0c0-11.046-8.954-20-20-20s-20 8.954-20 20 8.954 20 20 20 20-8.954 20-20zM0 0c0 11.046 8.954 20 20 20s20-8.954 20-20-8.954-20-20-20S0-11.046 0 0zm40 0c0 11.046 8.954 20 20 20s20-8.954 20-20-8.954-20-20-20-20 8.954-20 20z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
</style>

<div class="min-h-screen flex relative overflow-hidden items-center justify-center font-sans px-4">
    <div class="absolute inset-0 animated-gradient"></div>
    <div class="absolute inset-0 bmn-pattern"></div>
    <div class="absolute inset-0 opacity-20"
        style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.2) 1px, transparent 0); background-size: 30px 30px;">
    </div>

    <div class="w-full max-w-md relative z-10">
        <div class="bg-white/95 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/20 p-8 sm:p-10">

            <div class="flex flex-col items-center mb-8">
                <div class="mb-6">
                    <img src="{{ asset('img/assets/logo_esimba_bluebg.png') }}" alt="Logo ESIMBA" class="h-16 w-auto object-contain">
                </div>

                <h2 class="text-2xl font-bold text-gray-900">Verifikasi Keamanan</h2>
                <p class="text-gray-500 text-sm mt-1">Sistem Informasi Barang Milik Negara</p>
            </div>

            <form class="space-y-5" action="{{ route('password.validation') }}" method="POST">
                @csrf
                <div class="space-y-2">
                    <label for="password" class="text-sm font-semibold text-gray-700 ml-1">Password</label>
                    <div class="relative group">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#1b365d] transition-colors">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </div>
                        <input type="password" name="password" id="password" required autofocus
                            class="w-full pl-12 pr-12 py-3.5 bg-gray-50 border-2 border-gray-100 rounded-xl focus:bg-white focus:border-[#1b365d] focus:outline-none transition-all placeholder:text-gray-300"
                            placeholder="Masukkan password Anda">

                        <button type="button" onclick="togglePassword()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#1b365d] transition-colors">
                            <i id="eyeIcon" data-lucide="eye" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <a href="{{ route('password.request') }}"
                        class="text-sm font-bold text-[#1b365d] hover:text-blue-700 transition-colors">
                        Lupa Password?
                    </a>
                </div>

                <button type="submit"
                    class="w-full bg-[#1b365d] hover:bg-[#254677] text-white h-13 py-3.5 rounded-xl font-bold shadow-lg shadow-blue-900/20 flex items-center justify-center gap-2 transition-all active:scale-[0.98]">
                    Masuk ke Dashboard
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-center">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-red-600 transition-colors">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        Bukan akun Anda? Keluar
                    </button>
                </form>
            </div>
        </div>

        <p class="text-center text-white/50 text-xs mt-6 tracking-widest uppercase">Version 1.0 &bull; ESIMBA</p>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    // Inisialisasi Lucide Icons
    lucide.createIcons();

    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            // Update icon secara manual jika menggunakan library Lucide
            eyeIcon.setAttribute('data-lucide', 'eye-off');
        } else {
            passwordInput.type = 'password';
            eyeIcon.setAttribute('data-lucide', 'eye');
        }
        lucide.createIcons(); // Refresh icons
    }
</script>
@endsection
