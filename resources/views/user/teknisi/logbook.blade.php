<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="{{ asset('img/assets/bg_esimba.png') }}" type="image/x-icon" />
  <title>Logbook Tim Perbaikan | BMN</title>
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
    .delay-200 { animation-delay: 200ms; }

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

    .btn-danger-premium {
      background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .btn-danger-premium:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px -5px rgba(220, 38, 38, 0.4);
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
      border-radius: 0.75rem;
      padding: 0.625rem 1rem;
      font-size: 0.875rem;
      transition: all 0.3s;
    }
    .form-input-premium:focus {
      outline: none;
      border-color: #1b365d;
      box-shadow: 0 0 0 3px rgba(27, 54, 93, 0.1);
      background-color: #ffffff;
    }
  </style>
</head>

<body class="bg-slate-50 min-h-screen font-sans text-slate-800 antialiased selection:bg-[#1b365d] selection:text-white">
  <div class="absolute top-0 left-0 right-0 z-[100]"><x-notify::notify /></div>

  <div class="bg-[#1b365d] relative overflow-hidden pb-32">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 32px 32px;"></div>
    <div class="absolute -right-20 -top-20 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

    <nav class="relative z-50 w-full border-b border-white/10">
      <div class="px-4 py-4 lg:px-8 max-w-7xl mx-auto">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-4">
            <a href="{{ route('user.teknisi.index') }}" class="text-white hover:text-[#d4af37] transition-colors p-2 -ml-2 rounded-lg hover:bg-white/10 flex items-center gap-2 text-sm font-medium">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
              </svg>
              Kembali ke Dasbor
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

    <section class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-16 text-center animate-fade-in-up">
      <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4 tracking-tight drop-shadow-md">
        Riwayat <span class="text-[#d4af37]">Logbook</span>
      </h1>
      <p class="text-blue-100 text-base md:text-lg max-w-2xl mx-auto font-light">
        Pantau dan unduh laporan perbaikan inventaris Barang Milik Negara yang telah Anda selesaikan.
      </p>
    </section>
  </div>

  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-20 pb-24">
    <div class="glass-card rounded-2xl p-6 sm:p-8 animate-fade-in-up delay-100">

      <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between mb-8 pb-6 border-b border-gray-100 gap-6">
        <div>
          <h2 class="text-2xl font-extrabold text-[#1b365d] flex items-center gap-2 mb-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#d4af37]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            Tugas Selesai
          </h2>
          <p class="text-sm text-slate-500 font-medium">
            Periode aktif: <span class="text-[#1b365d] font-bold">{{ $periodeText }}</span>
          </p>
        </div>

        <div class="flex flex-wrap gap-3 w-full lg:w-auto">
          <a href="{{ route('user.teknisi.logbook.pdf', request()->all()) }}" class="btn-danger-premium w-full sm:w-auto px-6 py-2.5 text-sm font-bold text-white rounded-xl flex items-center justify-center gap-2 shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Unduh Laporan PDF
          </a>
        </div>
      </div>

      <form method="GET" action="{{ route('user.teknisi.logbook') }}" class="mb-8 bg-slate-50/50 p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-end gap-5">

        <div class="w-full md:w-auto flex-1 md:flex-none">
          <label for="filter_type" class="block text-xs font-bold text-[#1b365d] mb-1.5 uppercase tracking-wider">Mode Filter</label>
          <select id="filter_type" onchange="toggleFilter()" class="form-input-premium w-full md:w-48 cursor-pointer">
            <option value="month">Per Bulan</option>
            <option value="week">Per Minggu</option>
          </select>
        </div>

        <div id="div_filter_month" class="w-full md:w-auto flex-1 md:flex-none transition-all">
          <label for="filter_month" class="block text-xs font-bold text-[#1b365d] mb-1.5 uppercase tracking-wider">Pilih Bulan</label>
          <input type="month" name="filter_month" id="filter_month" value="{{ request('filter_month') }}" class="form-input-premium w-full md:w-56 cursor-pointer">
        </div>

        <div id="div_filter_week" class="w-full md:w-auto flex-1 md:flex-none transition-all" style="display: none;">
          <label for="filter_week" class="block text-xs font-bold text-[#1b365d] mb-1.5 uppercase tracking-wider">Pilih Minggu</label>
          <input type="week" name="filter_week" id="filter_week" value="{{ request('filter_week') }}" class="form-input-premium w-full md:w-56 cursor-pointer">
        </div>

        <div class="flex gap-3 w-full md:w-auto pt-2 md:pt-0">
          <button type="submit" class="btn-premium flex-1 md:flex-none px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow-md">
            Terapkan
          </button>
          @if(request()->has('filter_month') || request()->has('filter_week'))
            <a href="{{ route('user.teknisi.logbook') }}" class="btn-outline-premium flex-1 md:flex-none px-6 py-2.5 text-sm font-bold text-slate-600 text-center rounded-xl shadow-sm">
              Reset
            </a>
          @endif
        </div>
      </form>

      <div class="mb-6">
        <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-extrabold px-3 py-1.5 rounded-lg shadow-sm">
          <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
          {{ $logbook->total() }} Pekerjaan Tercatat
        </span>
      </div>

      @if($logbook->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 bg-slate-50/50 rounded-2xl border-2 border-dashed border-slate-200">
          <div class="bg-white p-4 rounded-full shadow-sm mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
          </div>
          <h3 class="text-xl font-bold text-[#1b365d] mb-1">Belum Ada Riwayat</h3>
          <p class="text-slate-500 font-medium text-center">Tidak ditemukan data perbaikan yang dikerjakan pada periode ini.</p>
        </div>
      @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
          @foreach ($logbook as $index => $l)

          @php
              // Logika Pewarnaan Badge & Ikon berdasarkan Status
              $badgeBg = 'bg-slate-50 border-slate-200 text-slate-700';
              $iconPath = '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />'; // Ikon default: Jam/Proses
              $statusText = str_replace('_', ' ', $l->status);

              if($l->status == 'selesai') {
                  $badgeBg = 'bg-emerald-50 border-emerald-200 text-emerald-700';
                  $iconPath = '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />';
              } elseif($l->status == 'diperbaiki') {
                  $badgeBg = 'bg-blue-50 border-blue-200 text-blue-700';
                  $iconPath = '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />';
              } elseif($l->status == 'tidak_dapat_diperbaiki') {
                  $badgeBg = 'bg-red-50 border-red-200 text-red-700';
                  $iconPath = '<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />';
              } elseif($l->status == 'proses') {
                  $badgeBg = 'bg-amber-50 border-amber-200 text-amber-700';
              }
          @endphp

          <div class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-400 flex flex-col group overflow-hidden animate-fade-in-up" style="animation-delay: {{ ($index % 6) * 100 }}ms;">

            <div class="p-5 flex gap-4 relative">
              <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-slate-200 to-slate-400 {{ $l->status == 'tidak_dapat_diperbaiki' ? 'from-red-400 to-red-600' : ($l->status == 'selesai' || $l->status == 'diperbaiki' ? 'from-emerald-400 to-emerald-600' : '') }}"></div>

              <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0 border border-slate-100 shadow-inner mt-1">
                <img src="{{ $l->barang->foto ? asset('storage/' . $l->barang->foto) : asset('img/no-image.png') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" alt="Barang">
              </div>

              <div class="flex-1 min-w-0">
                <div class="flex justify-between items-start mb-1.5">
                  <span class="inline-flex items-center gap-1 {{ $badgeBg }} text-[9px] font-extrabold px-2 py-0.5 rounded border uppercase tracking-wider">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                      {!! $iconPath !!}
                    </svg>
                    {{ $statusText }}
                  </span>
                </div>
                <h3 class="font-extrabold text-[#1b365d] text-sm leading-tight line-clamp-2">{{ $l->barang->nama_barang }}</h3>
                <p class="text-[10px] text-slate-400 mt-1.5 font-medium flex items-center gap-1">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  {{ $l->updated_at->format('d M Y, H:i') }}
                </p>
              </div>
            </div>

            <div class="px-5 pb-5 flex-1">
              <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 h-[4.5rem] relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-300 absolute top-2.5 left-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-[11px] text-slate-600 font-medium pl-6 leading-relaxed line-clamp-2 mt-0.5" title="{{ $l->deskripsi }}">
                  {{ $l->deskripsi }}
                </p>
              </div>
            </div>
          </div>
          @endforeach
        </div>

        <div class="mt-8 flex justify-center">
          <div class="bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-100">
            {{ $logbook->links() }}
          </div>
        </div>
      @endif
    </div>
  </section>

  @notifyJs

  {{-- Script untuk Toggle Input Bulan / Minggu --}}
  <script>
    function toggleFilter() {
        const type = document.getElementById('filter_type').value;
        const monthDiv = document.getElementById('div_filter_month');
        const weekDiv = document.getElementById('div_filter_week');
        const monthInput = document.getElementById('filter_month');
        const weekInput = document.getElementById('filter_week');

        if (type === 'month') {
            monthDiv.style.display = 'block';
            weekDiv.style.display = 'none';
            weekInput.value = ''; // Kosongkan input minggu agar tidak ikut terkirim
        } else {
            monthDiv.style.display = 'none';
            weekDiv.style.display = 'block';
            monthInput.value = ''; // Kosongkan input bulan agar tidak ikut terkirim
        }
    }

    // Set dropdown awal sesuai dengan filter yang aktif di URL
    document.addEventListener('DOMContentLoaded', function() {
        @if(request()->has('filter_week') && request('filter_week') != '')
            document.getElementById('filter_type').value = 'week';
        @else
            document.getElementById('filter_type').value = 'month';
        @endif
        toggleFilter();
    });
  </script>
</body>
</html>
