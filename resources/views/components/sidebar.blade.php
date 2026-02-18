<!-- Mobile Sidebar Overlay -->
<div id="sidebarOverlay" class="hidden fixed inset-0 bg-black bg-opacity-50 md:hidden z-30" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside id="sidebar" class="w-64 flex-shrink-0 bg-primary text-white flex flex-col fixed h-screen md:relative md:translate-x-0 transform -translate-x-full transition-transform duration-300 ease-in-out z-40">
    <div class="p-6 text-2xl font-bold border-b border-primary/80 flex-shrink-0 flex items-center justify-between">
        <span>St. Johns Admin</span>
        <button id="closeSidebarBtn" class="md:hidden text-white hover:bg-primary/80 p-2 rounded" onclick="toggleSidebar()">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <nav class="flex-1 overflow-y-auto">
        <ul>
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('dashboard') ? 'bg-primary/80' : 'hover:bg-primary/80' }}" onclick="closeMobileSidebar()">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-10 0h3" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.members') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.members*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}" onclick="closeMobileSidebar()">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Members
                </a>
            </li>
            <li>
                <a href="{{ route('admin.services') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.services*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}" onclick="closeMobileSidebar()">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Services
                </a>
            </li>
            <li>
                <a href="{{ route('admin.events') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.events*') || request()->routeIs('admin.announcements*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}" onclick="closeMobileSidebar()">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                    Updates
                </a>
            </li>
            <li>
                <a href="{{ route('admin.groups') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.groups*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}" onclick="closeMobileSidebar()">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m0-4a4 4 0 110-8 4 4 0 010 8z" />
                    </svg>
                    Groups
                </a>
            </li>
            <li>
                <a href="{{ route('admin.givings') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.givings*') || request()->routeIs('admin.giving*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}" onclick="closeMobileSidebar()">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Giving ❤️
                </a>
            </li>
            <li>
                <a href="{{ route('admin.qr-codes') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->routeIs('admin.qr-codes*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}" onclick="closeMobileSidebar()">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 16h4.01M12 8h4.01M8 12h.01M16 8h.01M8 16h.01M8 8h.01M12 16h.01" />
                    </svg>
                    QR Codes
                </a>
            </li>

        </ul>
    </nav>
</aside>
