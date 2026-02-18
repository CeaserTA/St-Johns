<!-- Header - Modern & Perfectly Aligned -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-lg shadow-sm border-b border-gray-100">
  <div class="max-w-7xl mx-auto px-5 py-4 flex items-center justify-between">

    <!-- Logo + Church Name (perfectly aligned with nav) -->
    <a href="{{ route('home') }}" class="flex items-center gap-4 hover:opacity-90 transition">
      <img src="assets/Logo Final.png" 
           alt="St. John's Parish Church Logo" 
           class="h-14 w-auto object-contain">

      <div class="leading-tight">
        <h1 class="text-xl font-bold text-primary tracking-tight">
          St. John's Parish Church
        </h1>
        <p class="text-xs font-semibold text-secondary uppercase tracking-widest">
          Entebbe
        </p>
      </div>
    </a>

    <!-- Desktop Navigation: primary links only -->
    <nav class="hidden md:flex items-center gap-6">
      <a href="{{ route('home') }}" 
         class="text-sm font-medium text-gray-700 hover:text-secondary transition">
        Home
      </a>
      <a href="{{ route('services') }}" 
         class="text-sm font-medium text-gray-700 hover:text-secondary transition">
        Services
      </a>
      <a href="{{ route('updates') }}" 
         class="text-sm font-medium text-gray-700 hover:text-secondary transition">
        Updates
      </a>
      <a href="{{ route('giving.index') }}" 
         class="text-sm font-medium text-gray-700 hover:text-secondary transition">
        Give
      </a>
    </nav>

    <!-- Actions (Admin Portal + Member Profile) -->
    <div class="hidden md:flex items-center gap-4">
      @guest
        <a href="{{ route('login') }}" 
           class="px-4 py-2 bg-secondary text-white text-sm font-bold rounded-full hover:bg-secondary/90 transition shadow-sm">
          Admin Portal
        </a>
      @endguest

      @auth
        @if(auth()->user() && auth()->user()->role === 'admin')
          <a href="{{ route('dashboard') }}" 
             class="px-4 py-2 bg-secondary text-white text-sm font-bold rounded-full hover:bg-secondary/90 transition shadow-sm">
            Admin Portal
          </a>
        @elseif(auth()->user() && auth()->user()->role === 'member')
          <!-- Member Profile Dropdown -->
          <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false"
                    class="flex items-center gap-2 px-3 py-2 rounded-full hover:bg-gray-100 transition">
              @if(auth()->user()->member && auth()->user()->member->profile_image)
                <img src="{{ auth()->user()->member->profile_image_url }}" 
                     alt="{{ auth()->user()->name }}" 
                     class="w-8 h-8 rounded-full object-cover border-2 border-primary">
              @else
                <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm">
                  {{ substr(auth()->user()->name, 0, 1) }}
                </div>
              @endif
              <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
              <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" 
                   fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50"
                 style="display: none;">
              
              <!-- User Info -->
              <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
              </div>

              <!-- Menu Items -->
              <a href="#" onclick="showMyRegistrationsModal(); return false;" 
                 class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                My Service Registrations
              </a>

              <a href="#" onclick="showPendingPaymentsModal(); return false;" 
                 class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Pending Payments
              </a>

              <a href="#" onclick="showMyGivingModal(); return false;" 
                 class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                My Giving History
              </a>

              <a href="#" onclick="showProfileSettingsModal(); return false;" 
                 class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Profile Settings
              </a>

              <div class="border-t border-gray-100 mt-2 pt-2">
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" 
                          class="flex items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition w-full text-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                  </button>
                </form>
              </div>
            </div>
          </div>
        @endif
      @endauth
    </div>

    <!-- Mobile Menu Button -->
    <button class="md:hidden p-2 hover:bg-gray-100 rounded-lg transition">
      <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

  </div>
</header>