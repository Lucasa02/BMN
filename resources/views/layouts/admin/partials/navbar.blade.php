<nav class="fixed top-0 z-50 w-full bg-tvri_base_color/90 backdrop-blur-md border-b border-white/10 shadow-lg">
  <style>
    /* Logo Shine Effect */
    .logo-container {
      position: relative;
      overflow: hidden;
      background: white;
      padding: 0.35rem;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }

    .logo-container::after {
      content: "";
      position: absolute;
      top: -50%;
      left: -60%;
      width: 20%;
      height: 200%;
      background: rgba(255, 255, 255, 0.4);
      transform: rotate(30deg);
      transition: none;
    }

    .logo-container:hover::after {
      left: 120%;
      transition: all 0.6s ease-in-out;
    }

    .logo-container:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    /* Custom Dropdown Animation */
    #user-dropdown {
      animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>

  <div class="px-4 py-2.5 lg:px-6">
    <div class="flex items-center justify-between">
      <div class="flex items-center justify-start">
        <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" class="p-2 mr-2 text-white rounded-lg sm:hidden hover:bg-white/10">
          <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M3 5h14M3 10h14M3 15h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
        </button>

        <a href="{{ route('dashboard.index') }}" class="flex items-center group">
          <div class="logo-container">
            <img src="{{ asset('img/assets/bmn_logo.png') }}" class="h-8 transition-transform group-hover:scale-110" alt="Logo" />
          </div>
          <div class="flex flex-col ms-3">
            <span class="text-lg font-bold tracking-wider text-white uppercase">INVENTARA</span>
            <span class="text-[10px] text-blue-200 font-medium -mt-1 tracking-widest uppercase">Management System v1.0</span>
          </div>
        </a>
      </div>

      <div class="flex items-center gap-4">
        <div class="flex items-center">
          <button type="button" class="flex items-center gap-3 p-1.5 rounded-full hover:bg-white/10 transition-all border border-transparent hover:border-white/20" data-dropdown-toggle="user-dropdown">
            <div class="hidden text-right md:block">
               <p class="text-xs font-semibold text-white leading-none">{{ Auth::user()->nama_lengkap }}</p>
               <p class="text-[10px] text-blue-200 opacity-80 uppercase tracking-tighter">Administrator</p>
            </div>
            <img class="w-9 h-9 rounded-full border-2 border-white/50 shadow-sm" 
                 src="{{ Auth::user()->foto ? asset('storage/uploads/foto_user/' . Auth::user()->foto) : Avatar::create(Auth::user()->nama_lengkap)->toBase64() }}">
          </button>

          <div class="z-50 hidden my-4 text-base list-none bg-white rounded-2xl shadow-2xl border border-gray-100 min-w-[200px]" id="user-dropdown">
            <div class="px-4 py-3 border-b border-gray-50">
              <span class="block text-sm font-bold text-gray-900">{{ Auth::user()->nama_lengkap }}</span>
              <span class="block text-xs text-gray-500 truncate">{{ Auth::user()->email }}</span>
            </div>
            <ul class="py-2">
              <li><a href="{{ route('profil.index') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors"><i class="fa-solid fa-user-gear mr-3"></i> My Profile</a></li>
              <li><hr class="my-1 border-gray-100"></li>
              <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout').submit();" class="flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                  <i class="fa-solid fa-arrow-right-from-bracket mr-3"></i> Sign Out
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>