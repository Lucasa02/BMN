<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="{{ asset('img/assets/bg_esimba.png') }}" type="image/x-icon" />
    <title>Lengkapi Data Perbaikan | BMN</title>
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

        /* Elegant Glassmorphism */
        .glass-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 10px 40px -10px rgba(27, 54, 93, 0.15);
        }

        /* Premium Buttons */
        .btn-premium {
            background: linear-gradient(135deg, #1b365d 0%, #2a5298 100%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .btn-premium:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(27, 54, 93, 0.5);
        }

        .btn-outline-premium {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        .btn-outline-premium:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-2px);
        }

        /* Custom Form Inputs */
        .form-input-premium {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 0.875rem 1.25rem;
            font-size: 0.875rem;
            transition: all 0.3s;
            color: #1e293b;
            width: 100%;
        }
        .form-input-premium:focus {
            outline: none;
            border-color: #1b365d;
            box-shadow: 0 0 0 4px rgba(27, 54, 93, 0.1);
            background-color: #ffffff;
        }

        /* PERBAIKAN: Menghilangkan panah spinner pada input number */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield; /* Firefox */
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen font-sans text-slate-800 antialiased selection:bg-[#1b365d] selection:text-white">
    <div class="absolute top-0 left-0 right-0 z-[100]"><x-notify::notify /></div>

    <div class="bg-[#1b365d] relative overflow-hidden pb-24">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
        <div class="absolute -right-20 -top-20 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

        <nav class="relative z-50 w-full border-b border-white/10">
            <div class="px-4 py-4 lg:px-8 max-w-7xl mx-auto">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('user.teknisi.detail', $laporan->uuid) }}" class="text-white hover:text-[#d4af37] transition-colors p-2 -ml-2 rounded-lg hover:bg-white/10 flex items-center gap-2 text-sm font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Detail
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
    </div>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20 pb-24">

        {{-- KARTU UTAMA --}}
        <div class="animate-fade-in-up glass-card rounded-[2rem] overflow-hidden">

            {{-- Identitas Barang Banner --}}
            <div class="bg-gradient-to-r from-[#1b365d] to-[#2a5298] px-8 py-5 flex items-center gap-4 border-b border-[#1b365d]">
                <div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm border border-white/20 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] text-blue-200 font-bold uppercase tracking-widest mb-0.5">Objek Perbaikan</p>
                    <p class="text-white font-extrabold text-lg tracking-wide leading-tight">{{ $laporan->barang->nama_barang }}</p>
                </div>
            </div>

            {{-- Form Wrapper --}}
            <div class="p-8 sm:p-10">
                <form id="formPerbaikan" action="{{ route('user.teknisi.perbaikanSubmit', $laporan->uuid) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-[#1b365d] mb-2.5">
                            Catatan Tindakan / Komponen yang Diganti
                        </label>
                        <textarea name="deskripsi" rows="4" required placeholder="Contoh: Mengganti kapasitor dan membersihkan motherboard..."
                            class="form-input-premium resize-none"></textarea>
                    </div>

                    {{-- Biaya --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-[#1b365d] mb-2.5">
                            Total Biaya Perbaikan
                        </label>
                        <div class="flex items-center bg-[#f8fafc] border border-[#e2e8f0] rounded-[1rem] overflow-hidden transition-all focus-within:border-[#1b365d] focus-within:ring-4 focus-within:ring-[#1b365d]/10 focus-within:bg-white">
                            <span class="pl-5 pr-2 py-3 text-slate-500 font-bold text-sm select-none border-r border-[#e2e8f0]/50 bg-slate-100/50">Rp</span>
                            <input type="number" name="biaya" required placeholder="0" min="0"
                                class="w-full bg-transparent border-none focus:ring-0 p-3.5 text-sm font-medium text-slate-800" style="box-shadow: none;">
                        </div>
                    </div>

                    {{-- Status Hasil Perbaikan (Penambahan Radio Button) --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-[#1b365d] mb-2.5">
                            Status Hasil Perbaikan
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label class="relative flex items-start p-4 border border-[#e2e8f0] rounded-2xl cursor-pointer hover:bg-slate-50 transition-all focus-within:ring-2 focus-within:ring-[#1b365d] focus-within:border-[#1b365d]">
                                <input type="radio" name="status_perbaikan" value="diperbaiki" class="mt-1 w-5 h-5 text-[#1b365d] border-slate-300 focus:ring-[#1b365d]" required checked>
                                <span class="ml-3">
                                    <span class="block text-sm font-bold text-slate-800">Dapat Diperbaiki</span>
                                    <span class="block text-xs text-slate-500 mt-1">Barang berhasil diperbaiki dan siap untuk diverifikasi.</span>
                                </span>
                            </label>

                            <label class="relative flex items-start p-4 border border-[#e2e8f0] rounded-2xl cursor-pointer hover:bg-red-50 transition-all focus-within:ring-2 focus-within:ring-red-500 focus-within:border-red-500">
                                <input type="radio" name="status_perbaikan" value="tidak_dapat_diperbaiki" class="mt-1 w-5 h-5 text-red-500 border-slate-300 focus:ring-red-500" required>
                                <span class="ml-3">
                                    <span class="block text-sm font-bold text-slate-800">Tidak Dapat Diperbaiki</span>
                                    <span class="block text-xs text-slate-500 mt-1">Kerusakan terlalu parah, disarankan untuk penghapusan.</span>
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- Foto --}}
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-[#1b365d] mb-2.5">
                            Lampiran Visual Selesai
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-2xl bg-slate-50/50 hover:bg-slate-100/50 transition-colors relative group">
                            <div class="space-y-2 text-center">
                                <svg class="mx-auto h-12 w-12 text-slate-400 group-hover:text-[#1b365d] transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-slate-600 justify-center">
                                    <label for="foto_bukti" class="relative cursor-pointer bg-transparent rounded-md font-bold text-[#1b365d] hover:text-[#d4af37] focus-within:outline-none transition-colors">
                                        <span>Pilih file foto</span>
                                        <input id="foto_bukti" name="foto_bukti" type="file" class="sr-only" required accept="image/*">
                                    </label>
                                    <p class="pl-1">atau tarik dan lepas di sini</p>
                                </div>
                                <p class="text-[10px] text-slate-500 uppercase tracking-wider">PNG, JPG, JPEG hingga 4MB</p>
                            </div>
                            <div id="file-name-display" class="absolute bottom-2 left-0 right-0 text-center text-xs font-bold text-[#1b365d] hidden"></div>
                        </div>
                    </div>

                    <hr class="my-8 border-slate-200">

                    {{-- Action --}}
                    <div class="flex flex-col-reverse sm:flex-row justify-end items-center gap-4">
                        <a href="{{ route('user.teknisi.detail', $laporan->uuid) }}" class="btn-outline-premium w-full sm:w-auto text-center px-8 py-3.5 rounded-xl text-sm font-bold text-slate-600 shadow-sm">
                            Batal
                        </a>

                        <button type="button"
                                onclick="konfirmasiSubmit()"
                                class="btn-premium w-full sm:w-auto px-8 py-3.5 rounded-xl text-sm font-bold text-white shadow-lg flex justify-center items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Kirim Data Perbaikan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @notifyJs

    {{-- Script SweetAlert2 untuk Notifikasi Elegan --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Script UX Tambahan: Menampilkan nama file saat gambar dipilih
        document.getElementById('foto_bukti').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const display = document.getElementById('file-name-display');
            if (fileName) {
                display.textContent = 'Terpilih: ' + fileName;
                display.classList.remove('hidden');
            } else {
                display.classList.add('hidden');
            }
        });

        function konfirmasiSubmit() {
            const form = document.getElementById('formPerbaikan');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Pengiriman',
                text: "Data perbaikan ini akan dikirim untuk diverifikasi. Lanjutkan?",
                icon: 'question',
                iconColor: '#1b365d',
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: 'Ya, Simpan Data',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                color: '#1e293b',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[2rem] shadow-2xl border border-slate-100',
                    actions: 'flex gap-4 w-full justify-center mt-6',
                    confirmButton: 'bg-[#1b365d] hover:bg-[#152a4a] text-white rounded-xl px-6 py-3 font-bold text-sm transition-all shadow-md',
                    cancelButton: 'bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl px-6 py-3 font-bold text-sm transition-all shadow-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses Data...',
                        text: 'Menyinkronkan dengan sistem BMN',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>
