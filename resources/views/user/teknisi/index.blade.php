<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="shortcut icon" href="{{ asset('img/assets/bg_esimba.png') }}" type="image/x-icon" />
  <link href="https://fonts.cdnfonts.com/css/avenir" rel="stylesheet" />
  <title>Dashboard Tim Perbaikan | BMN</title>

  @notifyCss
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    /* Custom Elegant Animations */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes pulseGlow {
      0%, 100% { box-shadow: 0 0 15px rgba(27, 54, 93, 0.4); }
      50% { box-shadow: 0 0 25px rgba(27, 54, 93, 0.7); }
    }

    .animate-fade-in-up {
      animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
      opacity: 0;
    }

    .delay-100 { animation-delay: 100ms; }
    .delay-200 { animation-delay: 200ms; }
    .delay-300 { animation-delay: 300ms; }

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
    .btn-premium::after {
      content: '';
      position: absolute;
      top: 0; left: -100%; width: 50%; height: 100%;
      background: linear-gradient(to right, transparent, rgba(255,255,255,0.2), transparent);
      transform: skewX(-25deg);
      transition: all 0.7s;
    }
    .btn-premium:hover::after {
      left: 150%;
    }
    .btn-premium:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px -5px rgba(27, 54, 93, 0.5);
    }

    .btn-outline-premium {
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(5px);
      transition: all 0.3s ease;
    }
    .btn-outline-premium:hover {
      background: rgba(255, 255, 255, 0.2);
      transform: translateY(-3px);
    }

    /* Loader Overlay */
    .loading-overlay {
      background: rgba(27, 54, 93, 0.9);
      backdrop-filter: blur(10px);
      display: none;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    /* Scanner overrides */
    #reader { border-radius: 16px; overflow: hidden; border: 2px solid #1b365d; }
    .scanner-card { animation: fadeInUp 0.4s ease-out forwards; }
  </style>
</head>

<body class="bg-slate-50 min-h-screen font-sans text-slate-800 antialiased selection:bg-[#1b365d] selection:text-white">

  <div id="loading-animation" class="loading-overlay fixed inset-0">
    <div class="flex flex-col items-center animate-bounce">
      <div class="bg-white p-4 rounded-2xl shadow-[0_0_30px_rgba(255,255,255,0.3)] mb-4">
        <img src="{{ asset('img/assets/logo_esimba_bluebg.png') }}" class="h-12" alt="BMN" />
      </div>
      <p class="text-white tracking-[0.2em] text-sm font-semibold uppercase">Menyiapkan Data...</p>
    </div>
  </div>

  <div class="bg-[#1b365d] relative overflow-hidden pb-32">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
    <div class="absolute -right-20 -top-20 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

    <nav class="relative z-50 w-full border-b border-white/10">
      <div class="px-4 py-4 lg:px-8 max-w-7xl mx-auto">
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <div class="bg-white p-1.5 rounded-lg shadow-sm mr-3">
              <img src="{{ asset('img/assets/logo_esimba_bluebg.png') }}" class="h-7" alt="BMN" />
            </div>
            <div class="flex flex-col">
              <span class="text-xl font-bold text-white tracking-wide">E-SIMBA</span>
              <span class="text-[10px] text-[#d4af37] font-medium tracking-widest uppercase">Version 1.0</span>
            </div>
          </div>

          <div class="flex items-center relative">
            @auth
            <button type="button" class="flex items-center gap-3 text-sm rounded-full focus:ring-4 focus:ring-white/20 transition-all" data-dropdown-toggle="dropdown-user">
              <span class="hidden md:block text-white text-right">
                <p class="font-semibold text-sm">{{ Auth::user()->nama_lengkap }}</p>
                <p class="text-xs text-blue-200">{{ Auth::user()->jabatan->jabatan ?? 'Teknisi' }}</p>
              </span>
              <img class="w-10 h-10 rounded-full border-2 border-[#d4af37] object-cover" src="{{ Auth::user()->foto ? asset('storage/uploads/foto_user/' . Auth::user()->foto) : Avatar::create(Auth::user()->nama_lengkap)->toBase64() }}" alt="user photo" />
            </button>
            @endauth

            @guest
            <a href="{{ route('login') }}" class="text-[#1b365d] bg-white hover:bg-gray-100 font-bold px-6 py-2.5 rounded-lg text-sm transition-all shadow-lg">Login Portal</a>
            @endguest

            @auth
            <div id="dropdown-user" class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-xl shadow-2xl border border-gray-100 w-48">
              <ul class="py-2">
                <li><a href="{{ route('user.profil', ['from' => 'teknisi']) }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-slate-50 hover:text-[#1b365d] font-medium transition-colors">Profil Saya</a></li>
                <div class="my-1 border-t border-gray-100"></div>
                <li><a href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();" class="block px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 font-medium transition-colors">Keluar Sistem</a></li>
              </ul>
            </div>
            @endauth
          </div>
          <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </div>
      </div>
    </nav>

    <section class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-16 lg:pt-20 lg:pb-24 flex flex-col items-center text-center animate-fade-in-up">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-blue-100 text-xs font-semibold uppercase tracking-widest mb-6">
        <span class="w-2 h-2 rounded-full bg-[#d4af37] animate-pulse"></span>
        Portal Tim Perbaikan BMN
      </div>

      <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 tracking-tight drop-shadow-md">
        Selamat Bertugas, <span class="text-[#d4af37]">{{ Auth::check() ? explode(' ', Auth::user()->nama_lengkap)[0] : 'Tamu' }}</span>
      </h1>

      <p class="text-blue-100 text-lg md:text-xl max-w-2xl font-light mb-10">
        Kelola perbaikan, pantau antrean, dan perbarui status inventaris Barang Milik Negara dengan cepat dan akurat.
      </p>

      <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto px-4 sm:px-0">
        <button type="button" data-modal-target="teknisi-modal" data-modal-toggle="teknisi-modal" class="btn-premium text-white font-bold rounded-xl text-lg px-8 py-3.5 flex items-center justify-center gap-2 shadow-lg">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
          </svg>
          Scan QR Barang
        </button>
        <a href="{{ route('user.teknisi.logbook') }}" class="btn-outline-premium text-white font-bold rounded-xl text-lg px-8 py-3.5 flex items-center justify-center gap-2 shadow-lg">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
          </svg>
          Riwayat Logbook
        </a>
      </div>
    </section>
  </div>

  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-20 pb-24">
    <div class="glass-card rounded-2xl p-6 sm:p-8 animate-fade-in-up delay-100">

      <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 pb-4 border-b border-gray-100 gap-4">
        <div>
          <h2 class="text-2xl font-extrabold text-[#1b365d] flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#d4af37]" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
            </svg>
            Antrean Perbaikan
          </h2>
          <p class="text-sm text-slate-500 mt-1 font-medium">Daftar inventaris yang menunggu tindakan perbaikan.</p>
        </div>
        <div class="bg-[#1b365d]/5 border border-[#1b365d]/10 px-4 py-2 rounded-lg flex items-center gap-2">
          <span class="relative flex h-3 w-3">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#1b365d] opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-[#1b365d]"></span>
          </span>
          <span class="text-[#1b365d] font-bold text-sm">{{ isset($laporan_disetujui) ? $laporan_disetujui->count() : 0 }} Tugas Tersedia</span>
        </div>
      </div>

      @if(!isset($laporan_disetujui) || $laporan_disetujui->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 bg-slate-50/50 rounded-2xl border-2 border-dashed border-slate-200">
          <div class="bg-white p-4 rounded-full shadow-sm mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-[#1b365d] mb-1">Semua Tugas Selesai</h3>
          <p class="text-slate-500 font-medium text-center">Belum ada antrean perbaikan BMN saat ini. Kerja bagus!</p>
        </div>
      @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          @foreach ($laporan_disetujui as $index => $l)
          <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-400 flex flex-col group overflow-hidden animate-fade-in-up" style="animation-delay: {{ ($index + 2) * 100 }}ms;">

            <div class="p-5 flex gap-4 relative">
              <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-[#1b365d] to-[#d4af37]"></div>

              <div class="w-20 h-20 rounded-xl overflow-hidden shrink-0 border border-slate-100 shadow-inner">
                <img src="{{ $l->barang->foto ? asset('storage/' . $l->barang->foto) : asset('img/no-image.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Barang">
              </div>
              <div class="flex-1 min-w-0 py-1">
                <span class="inline-block bg-rose-50 text-rose-700 text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider mb-2 border border-rose-100">{{ $l->jenis_kerusakan }}</span>
                <h3 class="font-extrabold text-[#1b365d] text-base truncate">{{ $l->barang->nama_barang }}</h3>
                <p class="text-[11px] text-slate-400 mt-1 font-medium flex items-center gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  Disetujui: {{ $l->updated_at->format('d M Y') }}
                </p>
              </div>
            </div>

            <div class="px-5 pb-5 flex-1">
              <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 h-20 relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-300 absolute top-2 left-2" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                </svg>
                <p class="text-xs text-slate-600 font-medium italic line-clamp-3 pl-5 leading-relaxed">
                  {{ $l->deskripsi }}
                </p>
              </div>
            </div>

            <div class="p-4 pt-0">
              <a href="{{ route('user.teknisi.detail', $l->uuid) }}" class="flex justify-center items-center gap-2 w-full text-center bg-white border-2 border-[#1b365d] text-[#1b365d] hover:bg-[#1b365d] hover:text-white text-sm font-bold py-2.5 rounded-xl transition-all duration-300 group/btn">
                Tindak Lanjut
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover/btn:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
              </a>
            </div>
          </div>
          @endforeach
        </div>
      @endif
    </div>
  </section>

  <div id="teknisi-modal" tabindex="-1" aria-hidden="true" class="hidden fixed top-0 right-0 left-0 z-[60] overflow-y-auto overflow-x-hidden justify-center items-center w-full md:inset-0 h-full backdrop-blur-sm bg-slate-900/50">
    <div class="relative p-4 w-full max-w-md">
      <div class="relative bg-white rounded-2xl shadow-2xl animate-fade-in-up border border-slate-100">
        <div class="flex items-center justify-between p-5 border-b border-slate-100">
          <h3 class="text-lg font-extrabold text-[#1b365d] flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>
            Identifikasi BMN
          </h3>
          <button type="button" data-modal-hide="teknisi-modal" class="text-slate-400 bg-transparent hover:bg-rose-50 hover:text-rose-500 rounded-lg text-sm w-8 h-8 flex justify-center items-center transition-colors">
            ✕
          </button>
        </div>
        <div class="p-6 text-center">
          <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#1b365d]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg>
          </div>
          <p class="text-slate-600 mb-6 font-medium">Arahkan kamera ke QR Code yang terdapat pada label Barang Milik Negara.</p>
          <button type="button" onclick="openScanner()" data-modal-hide="teknisi-modal" class="w-full btn-premium text-white font-bold rounded-xl text-base px-5 py-3.5 shadow-lg">
            Buka Kamera Scanner
          </button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://unpkg.com/html5-qrcode"></script>

  <div id="scan-camera-modal" class="hidden fixed inset-0 z-[70] bg-slate-900/80 flex justify-center items-center backdrop-blur-md">
    <div class="w-[90%] max-w-sm bg-white p-5 rounded-3xl shadow-2xl relative scanner-card">
      <button id="btn-close-scanner" class="absolute -top-3 -right-3 bg-rose-500 text-white w-8 h-8 rounded-full shadow-lg hover:bg-rose-600 flex items-center justify-center text-sm font-bold transition-transform hover:scale-110 z-10">
        ✕
      </button>
      <div class="text-center mb-4">
        <h3 class="font-extrabold text-[#1b365d] text-lg">Scan Label BMN</h3>
        <p class="text-xs text-slate-500 font-medium">Posisikan QR code di dalam kotak</p>
      </div>
      <div id="reader" class="w-full aspect-square bg-slate-100 rounded-2xl overflow-hidden shadow-inner"></div>
    </div>
  </div>

  <div class="absolute top-0 left-0 right-0 z-[100]"><x-notify::notify /></div>
  @notifyJs

  <script>
    let html5QrCode = null;
    let scanningActive = false;
    let scannerAllowed = true;

    if (window.location.pathname.match(/^\/user\/scan-barang(\/.*)?$/)) {
      scannerAllowed = !window.location.pathname.match(/^\/user\/scan-barang\/.+/);
    }

    function showScannerModal() {
      document.getElementById('scan-camera-modal').classList.remove('hidden');
    }

    function hideScannerModal() {
      document.getElementById('scan-camera-modal').classList.add('hidden');
    }

    function cleanScannedString(s) {
      if (!s || typeof s !== 'string') return s;
      return s.trim().replace(/[\u0000-\u001F\u007F]+/g, "").replace(/\s+/g, " ");
    }

    function stopScanner() {
      scanningActive = false;
      if (html5QrCode) {
        html5QrCode.stop().then(() => {
          try { html5QrCode.clear(); } catch (e) {}
          html5QrCode = null;
        }).catch(err => {
          try { html5QrCode.clear(); } catch (e) {}
          html5QrCode = null;
        });
      }
      hideScannerModal();
    }

    function openScanner() {
      if (!scannerAllowed || scanningActive) return;

      showScannerModal();
      html5QrCode = new Html5Qrcode("reader");
      scanningActive = true;

      const config = {
        fps: 20,
        qrbox: { width: 250, height: 250 },
        aspectRatio: 1.0
      };

      html5QrCode.start({ facingMode: "environment" }, config, rawMessage => {
        stopScanner();

        let qrMessage = cleanScannedString(rawMessage || "");
        if (!qrMessage) return;

        document.getElementById('loading-animation').style.display = 'flex';

        let finalUrl = "";
        if (qrMessage.includes("/user/scan-barang/")) {
          const parts = qrMessage.split("/");
          const kodeBarang = parts.pop() || parts.pop();
          if (kodeBarang) {
            finalUrl = "/user/scan-barang/" + encodeURIComponent(kodeBarang) + "?from=teknisi";
          }
        } else {
          try {
            const parsed = new URL(qrMessage);
            finalUrl = parsed.href;
            // Tambahkan parameter dengan aman jika URL sudah memiliki query string
            finalUrl += (finalUrl.includes('?') ? '&' : '?') + 'from=teknisi';
          } catch (e) {
            finalUrl = "/user/scan-barang/" + encodeURIComponent(qrMessage) + "?from=teknisi";
          }
        }

        setTimeout(() => {
          if (finalUrl) location.assign(finalUrl);
        }, 1800);

      }).catch(err => {
        scanningActive = false;
        hideScannerModal();
      });
    }

    document.getElementById('btn-close-scanner').addEventListener('click', function (e) {
      e.preventDefault();
      stopScanner();
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === "Escape") stopScanner();
    });
  </script>
</body>
</html>
