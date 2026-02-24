<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ESIMPROD - Login Page</title>
    <link rel="shortcut icon" href="{{ asset('img/assets/esimprod_logo_bg.png') }}" type="image/x-icon">
    <link href="https://fonts.cdnfonts.com/css/avenir" rel="stylesheet">
    <script src="https://kit.fontawesome.com/your-code.js" crossorigin="anonymous"></script> {{-- Pastikan FontAwesome terload --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 overflow-hidden">

    <x-auth-validation></x-auth-validation>

    <div class="flex flex-col lg:flex-row justify-center items-center w-full h-screen">
        <div class="w-1/2 h-full hidden lg:block">
            <img src="{{ asset('img/assets/login_2.jpeg') }}" alt="Login Image" class="object-cover w-full h-full">
        </div>

        <div class="flex flex-col justify-center items-center lg:p-20 md:p-52 sm:p-20 p-8 w-full lg:w-1/2">
            <h1 class="text-4xl font-bold mb-2 text-center text-[#1b365d]">Login</h1>
            <p class="mb-8 text-gray-500">Pilih metode masuk ke sistem</p>

            <div class="flex gap-4 mb-10 w-full max-w-md">
                <button id="btnScan"
                    class="flex-1 flex flex-col items-center justify-center p-4 bg-[#1b365d] text-white rounded-2xl shadow-lg hover:scale-105 transition-all">
                    <i class="fas fa-qrcode text-2xl mb-2"></i>
                    <span class="text-sm font-medium">Scan ID Card</span>
                </button>
                <button id="btnManual"
                    class="flex-1 flex flex-col items-center justify-center p-4 bg-white border-2 border-[#1b365d] text-[#1b365d] rounded-2xl shadow-sm hover:scale-105 transition-all">
                    <i class="fas fa-keyboard text-2xl mb-2"></i>
                    <span class="text-sm font-medium">Input Manual</span>
                </button>
            </div>

            <div id="scannerContainer" class="w-full max-w-md hidden mb-6">
                <div id="reader" class="overflow-hidden rounded-xl border-2 border-[#1b365d]"></div>
                <p class="text-center text-xs text-gray-400 mt-2 italic">Arahkan QR Code pada ID Card ke Kamera</p>
            </div>

            <form action="{{ route('login.process') }}" method="POST" class="w-full max-w-md" id="loginForm">
                @csrf
                <input type="hidden" name="gambar" id="gambar">

                <div id="manualInputGroup" class="hidden animate-fade-in">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode User</label>
                    <input type="text" id="kode_user" name="kode_user" placeholder="Contoh: USR123456"
                        class="w-full border-2 border-gray-200 rounded-xl py-3 px-4 focus:outline-none focus:border-[#1b365d] transition-all"
                        autocomplete="off">
                    <button type="submit"
                        class="w-full mt-4 bg-[#1b365d] text-white py-3 rounded-xl font-bold shadow-lg hover:bg-[#142845]">
                        Masuk Sekarang
                    </button>
                </div>
            </form>

            <div class="mt-8 w-full max-w-md">
                <div class="relative flex py-5 items-center">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="flex-shrink mx-4 text-gray-400 text-sm">Atau</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>
                <a href="{{ route('user.inventaris') }}"
                    class="block w-full text-center py-3 px-4 text-gray-600 font-semibold rounded-xl border-2 border-gray-200 hover:bg-gray-50 transition-all">
                    Masuk Sebagai Tamu
                </a>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        const btnScan = document.getElementById('btnScan');
        const btnManual = document.getElementById('btnManual');
        const scannerContainer = document.getElementById('scannerContainer');
        const manualInputGroup = document.getElementById('manualInputGroup');
        const kodeInput = document.getElementById('kode_user');
        const html5QrCode = new Html5Qrcode("reader");

        // --- Logika Tombol Manual ---
        btnManual.addEventListener('click', () => {
            const isManualOpen = !manualInputGroup.classList.contains('hidden');

            if (isManualOpen) {
                // Jika sudah terbuka, maka tutup
                manualInputGroup.classList.add('hidden');

                // Kembalikan UI Button Manual ke style semula (Putih)
                btnManual.classList.remove('bg-[#1b365d]', 'text-white');
                btnManual.classList.add('bg-white', 'text-[#1b365d]', 'border-2', 'border-[#1b365d]');
            } else {
                // Jika tertutup, maka buka
                stopScanner(); // Pastikan kamera mati
                scannerContainer.classList.add('hidden');

                manualInputGroup.classList.remove('hidden');
                kodeInput.focus();

                // Update UI Button Manual jadi aktif (Navy)
                btnManual.classList.add('bg-[#1b365d]', 'text-white');
                btnManual.classList.remove('bg-white', 'text-[#1b365d]', 'border-2', 'border-[#1b365d]');

                // Pastikan UI Button Scan kembali ke style tidak aktif
                btnScan.classList.remove('bg-[#1b365d]', 'text-white');
                btnScan.classList.add('bg-white', 'text-[#1b365d]', 'border-2', 'border-[#1b365d]');
            }
        });

        // --- Logika Tombol Scan ---
        btnScan.addEventListener('click', () => {
            const isScannerOpen = !scannerContainer.classList.contains('hidden');

            if (isScannerOpen) {
                // Jika sedang terbuka, maka tutup
                stopScanner();
                scannerContainer.classList.add('hidden');

                // Kembalikan UI Button ke style semula (Putih)
                btnScan.classList.remove('bg-[#1b365d]', 'text-white');
                btnScan.classList.add('bg-white', 'text-[#1b365d]', 'border-2', 'border-[#1b365d]');
            } else {
                // Jika sedang tertutup, maka buka
                manualInputGroup.classList.add('hidden'); // Sembunyikan input manual jika ada

                // Reset style tombol manual ke semula
                btnManual.classList.remove('bg-[#1b365d]', 'text-white');
                btnManual.classList.add('bg-white', 'text-[#1b365d]', 'border-2', 'border-[#1b365d]');

                scannerContainer.classList.remove('hidden');
                startScanner();

                // Update UI Button Scan jadi aktif (Navy)
                btnScan.classList.add('bg-[#1b365d]', 'text-white');
                btnScan.classList.remove('bg-white', 'text-[#1b365d]', 'border-2', 'border-[#1b365d]');
            }
        });

        function startScanner() {
            const config = {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            };
            html5QrCode.start({
                facingMode: "environment"
            }, config, (decodedText) => {
                // Jika Berhasil Scan
                kodeInput.value = decodedText;
                stopScanner();
                document.getElementById('loginForm').submit();
            });
        }

        function stopScanner() {
            // Mengecek apakah scanner sedang aktif sebelum di stop
            if (html5QrCode && html5QrCode.isScanning) {
                html5QrCode.stop().then(() => {
                    console.log("Scanner stopped.");
                }).catch((err) => {
                    console.warn("Error stopping scanner: ", err);
                });
            }
        }

        // Penghapusan Logika Keydown Otomatis (Sesuai Request)
        // Logika "delta < 80" dihapus agar tidak bentrok dengan input manual
    </script>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body>

</html>