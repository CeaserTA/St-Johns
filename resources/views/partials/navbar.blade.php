<!-- Header - Modern & Perfectly Aligned -->
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

    <!-- Desktop Navigation -->
    <nav class="hidden md:flex items-center gap-10">
      <a href="{{ route('home') }}" 
         class="text-sm font-medium text-gray-700 hover:text-secondary transition">
        Home
      </a>
      <a href="{{ route('services') }}" 
         class="text-sm font-medium text-gray-700 hover:text-secondary transition">
        Services
      </a>
      <a href="{{ route('events') }}" 
         class="text-sm font-medium text-gray-700 hover:text-secondary transition">
        Events
      </a>
      <a href="{{ route('admin.login') }}" 
         class="px-6 py-2.5 bg-secondary text-white text-sm font-bold rounded-full hover:bg-secondary/90 transition shadow-sm">
        Admin Portal
      </a>
    </nav>

    <!-- Mobile Menu Button -->
    <button class="md:hidden p-2 hover:bg-gray-100 rounded-lg transition">
      <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

  </div>
</header>