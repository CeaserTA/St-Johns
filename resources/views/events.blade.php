<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Church Events &amp; Announcements - St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @include('partials.theme-config')
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#163e7b",
                        "secondary": "#c1272d",
                        "accent": "#d4af37",
                        "background-light": "#f5f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px",
                    },
                },
            },
        }
    </script>
    <style>
        .font-display {
            font-family: 'Inter', sans-serif;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Carousel styles */
        .carousel-slide {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .carousel-slide.active {
            display: block;
            opacity: 1;
        }

        .carousel-indicator.active {
            width: 2rem !important;
            background-color: white !important;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 transition-colors duration-200">
    
    @include('partials.navbar')

    @include('partials.announcement')

    {{-- Success Message --}}
    @if ($message = Session::get('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ $message }}</p>
            </div>
        </div>
    @endif

    {{-- Error Message --}}
    @if ($message = Session::get('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                <p class="font-bold">Error</p>
                <p>{{ $message }}</p>
            </div>
        </div>
    @endif

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Section: Featured Carousel -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold">What's Happening This Week</h2>
                @if($thisWeekEvents->count() > 1)
                <div class="flex gap-2">
                    <button onclick="previousSlide()" class="p-2 rounded-full border border-slate-200 dark:border-slate-800 hover:bg-white dark:hover:bg-slate-800 transition-colors">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button onclick="nextSlide()" class="p-2 rounded-full border border-slate-200 dark:border-slate-800 hover:bg-white dark:hover:bg-slate-800 transition-colors">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
                @endif
            </div>
            
            @if($thisWeekEvents->count() > 0)
            <div class="relative overflow-hidden rounded-xl aspect-[21/7]">
                @foreach($thisWeekEvents as $index => $weekEvent)
                <div class="carousel-slide {{ $index === 0 ? 'active' : '' }} absolute inset-0 bg-slate-200 dark:bg-slate-800" data-slide="{{ $index }}">
                    <!-- Slide Content -->
                    <div class="absolute inset-0 bg-cover bg-center" 
                         style="background-image: url('{{ $weekEvent->image_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBJuBVtqw9UvSxdwxXR4HOoRKNwjmp9luc3fMocyA9NTqdPQivYkifWnUaMwnjyQq3T4squ6UlhiwnVUaXW1dGBb9iQTqAWj2ZWY0cDsr8_w0zYXf4_sbb551OYF9iq1ViLJ1oSTTDppAlvmUWZuWIo8Etdwaaf_zx3Twh1p4XfM8eHKL64rCtraA9U_aCR3AJcZ_L-6y2nwV4LQ3nNURKG3gPTol5sCwQWKy93zdr-wzJtb_VykEtdfU3XC_2Nsxabk4C2zBpbrrgU' }}');">
                        <div class="absolute inset-0 bg-gradient-to-r from-slate-900/80 via-slate-900/40 to-transparent flex flex-col justify-center px-8 text-white">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-accent text-slate-900 text-xs font-bold rounded-full mb-3 w-fit">
                                <span class="material-symbols-outlined text-sm leading-none">star</span> THIS WEEK
                            </span>
                            <h3 class="text-3xl font-extrabold mb-2 max-w-xl leading-tight">{{ $weekEvent->title }}</h3>
                            <p class="text-base text-slate-200 mb-4 max-w-md">{{ $weekEvent->excerpt }}</p>
                            <div class="flex gap-3">
                                <button onclick="openEventModal({{ $weekEvent->id }}, '{{ addslashes($weekEvent->title) }}')" class="bg-primary hover:bg-blue-600 px-5 py-2.5 rounded-lg font-bold transition-transform active:scale-95 text-sm">
                                    Register Now
                                </button>
                                <button onclick="viewDetails({{ $weekEvent->id }})" class="bg-white/10 backdrop-blur-sm border border-white/20 hover:bg-white/20 px-5 py-2.5 rounded-lg font-bold transition-colors text-sm">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <!-- Carousel Indicators -->
                @if($thisWeekEvents->count() > 1)
                <div class="absolute bottom-4 right-8 flex gap-2 z-10">
                    @foreach($thisWeekEvents as $index => $weekEvent)
                        <button onclick="goToSlide({{ $index }})" class="carousel-indicator w-2 h-2 bg-white/40 rounded-full transition-all" data-indicator="{{ $index }}"></button>
                    @endforeach
                </div>
                @endif
            </div>
            @else
            <!-- No events this week - show placeholder -->
            <div class="relative overflow-hidden rounded-xl bg-slate-200 dark:bg-slate-800 aspect-[21/7] flex group">
                <div class="absolute inset-0 bg-gradient-to-r from-primary/80 via-primary/60 to-primary/40 flex flex-col justify-center items-center px-8 text-white text-center">
                    <span class="material-symbols-outlined text-5xl mb-3 opacity-50">event_available</span>
                    <h3 class="text-2xl font-extrabold mb-2">No Events This Week</h3>
                    <p class="text-base text-white/90">Check out our upcoming events below!</p>
                </div>
            </div>
            @endif
        </section>

        <!-- Filter Navigation -->
        <nav class="flex justify-center mb-8">
            <div class="inline-flex p-1 bg-slate-100 dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
                <button onclick="filterItems('all')" id="filter-all" class="px-6 py-2 text-sm font-bold rounded-lg bg-white dark:bg-slate-700 shadow-sm text-primary">
                    All
                </button>
                <button onclick="filterItems('event')" id="filter-event" class="px-6 py-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                    Future Events
                </button>
                <button onclick="filterItems('announcement')" id="filter-announcement" class="px-6 py-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                    Announcements
                </button>
            </div>
        </nav>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events->where('is_active', true) as $item)
                @if($item->is_event)
                    <!-- Event Card -->
                    <div class="event-card group bg-white dark:bg-slate-900 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col" data-type="event">
                        <div class="relative aspect-video overflow-hidden">
                            <img alt="{{ $item->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                                 src="{{ $item->image_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuA-fKy9IwvMJcFgNjBgGeqCsxWDf45Y4A3gyZUE0COYXjV920Ecw2UpyEdz8lSsQqNt776sga6zUAQS8SPhICaU176kI8yjAEMMbs4eK9MicH34I1kLcLiReOivpIM5AbWccAQyTb-EKZ-l-UrAetKIMAAI-C97PCSC2V2192XhCBWzDDGQuKv45DxBy8RiXAe8PgX196bflqvN9A49hfA5Or-6_WfSO1P0G6VWUR_0DQujdRDI0UigGGPic8rQmPJ7ha6OdUxX-tTB' }}" />
                            <div class="absolute top-3 left-3 bg-primary text-white text-center py-0.5 px-2 rounded-lg shadow-lg">
                                <span class="block text-[10px] font-bold uppercase tracking-wider">
                                    {{ $item->starts_at ? $item->starts_at->format('M') : ($item->date ? $item->date->format('M') : 'TBD') }}
                                </span>
                                <span class="block text-lg font-bold leading-none">
                                    {{ $item->starts_at ? $item->starts_at->format('d') : ($item->date ? $item->date->format('d') : '--') }}
                                </span>
                            </div>
                            @if($item->is_upcoming)
                            <div class="absolute bottom-3 right-3 inline-flex items-center gap-1 px-2 py-0.5 bg-red-500 text-white text-[9px] font-black rounded-md animate-pulse shadow-lg">
                                <div class="w-1.5 h-1.5 bg-white rounded-full"></div> UPCOMING
                            </div>
                            @endif
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <div class="flex items-center gap-2 text-primary text-xs font-bold mb-2">
                                <span class="material-symbols-outlined text-sm">schedule</span>
                                {{ $item->formatted_time ?? 'TBD' }} • {{ $item->location ?? 'Location TBD' }}
                            </div>
                            <h3 class="text-lg font-bold mb-2 text-slate-900 dark:text-white">{{ $item->title }}</h3>
                            <p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-2 mb-4">{{ $item->excerpt }}</p>
                            <div class="mt-auto">
                                <button onclick="openEventModal({{ $item->id }}, '{{ addslashes($item->title) }}')" class="w-full bg-primary hover:bg-blue-600 text-white font-bold py-2 rounded-lg transition-colors text-sm">
                                    Register
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Announcement Card -->
                    <div class="announcement-card bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm hover:shadow-md transition-all p-6 flex flex-col" data-type="announcement">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500">
                                <span class="material-symbols-outlined text-lg">campaign</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">ANNOUNCEMENT</span>
                                <span class="block text-xs font-medium text-slate-500">Posted {{ $item->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <h3 class="text-lg font-bold mb-2 text-slate-900 dark:text-white">{{ $item->title }}</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-4">{{ $item->excerpt }}</p>
                        <div class="mt-auto">
                            <button onclick="viewAnnouncementDetails({{ $item->id }})" class="w-full py-2 border-2 border-slate-200 dark:border-slate-700 hover:border-primary dark:hover:border-primary text-slate-900 dark:text-slate-100 hover:text-primary dark:hover:text-primary font-bold rounded-lg transition-all text-sm">
                                Read More
                            </button>
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl">event_busy</span>
                    </div>
                    <p class="text-slate-500 text-lg">No events or announcements available at this time.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($events->count() > 6)
        <div class="mt-16 flex flex-col items-center">
            <button class="group flex items-center gap-2 px-10 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-full font-bold shadow-sm hover:shadow-md transition-all active:scale-95">
                Load More
                <span class="material-symbols-outlined group-hover:translate-y-0.5 transition-transform">keyboard_arrow_down</span>
            </button>
            <p class="mt-4 text-xs text-slate-500 dark:text-slate-400">Showing {{ min(6, $events->count()) }} of {{ $events->count() }} items</p>
        </div>
        @endif
    </main>

    @include('partials.footer')

    <!-- Registration Modal -->
    <div id="registrationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 px-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 w-full max-w-md shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Event Registration</h3>
                <button id="closeModalBtn" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form id="eventForm" action="{{ route('event.registrations.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-1 text-slate-700 dark:text-slate-300">First Name</label>
                        <input type="text" name="first_name" required
                            class="w-full border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1 text-slate-700 dark:text-slate-300">Last Name</label>
                        <input type="text" name="last_name"
                            class="w-full border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1 text-slate-700 dark:text-slate-300">Email</label>
                    <input type="email" name="email"
                        class="w-full border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1 text-slate-700 dark:text-slate-300">Phone</label>
                    <input type="tel" name="phone"
                        class="w-full border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1 text-slate-700 dark:text-slate-300">Event</label>
                    <div id="modalEventTitle" class="w-full border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 bg-slate-50 dark:bg-slate-800 text-sm text-slate-700 dark:text-slate-300">
                        Please select an event
                    </div>
                    <input type="hidden" name="event_id" id="event_id" />
                    <input type="hidden" name="event_name" id="event_name_hidden" />
                </div>

                <div class="flex justify-end space-x-2 mt-6">
                    <button type="button" id="closeModalBtn2" class="px-4 py-2 bg-slate-200 dark:bg-slate-700 text-slate-900 dark:text-white rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-blue-600 transition-colors font-bold">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Details Modal -->
    <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl w-full max-w-2xl shadow-2xl max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 p-6 flex items-center justify-between">
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white" id="detailsTitle">Details</h3>
                <button id="closeDetailsBtn" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div id="detailsContent" class="p-6">
                <!-- Content will be loaded dynamically -->
            </div>
        </div>
    </div>

    <script>
        const registrationModal = document.getElementById('registrationModal');
        const detailsModal = document.getElementById('detailsModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const closeModalBtn2 = document.getElementById('closeModalBtn2');
        const closeDetailsBtn = document.getElementById('closeDetailsBtn');

        function openEventModal(id, title) {
            const idField = document.getElementById('event_id');
            const nameHidden = document.getElementById('event_name_hidden');
            const titleEl = document.getElementById('modalEventTitle');
            if (idField) idField.value = id;
            if (nameHidden) nameHidden.value = title;
            if (titleEl) titleEl.textContent = title;
            registrationModal.classList.remove('hidden');
            registrationModal.classList.add('flex');
        }

        closeModalBtn.addEventListener('click', () => {
            registrationModal.classList.add('hidden');
            registrationModal.classList.remove('flex');
        });

        closeModalBtn2.addEventListener('click', () => {
            registrationModal.classList.add('hidden');
            registrationModal.classList.remove('flex');
        });

        registrationModal.addEventListener('click', (e) => {
            if (e.target === registrationModal) {
                registrationModal.classList.add('hidden');
                registrationModal.classList.remove('flex');
            }
        });

        function viewDetails(id) {
            // Fetch event details from public route
            fetch(`/events/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const event = data.event;
                        document.getElementById('detailsTitle').textContent = event.title;
                        
                        let content = `
                            <div class="space-y-4">
                                ${event.description ? `<p class="text-slate-600 dark:text-slate-400">${event.description}</p>` : ''}
                                ${event.content ? `<div class="prose dark:prose-invert max-w-none">${event.content}</div>` : ''}
                                ${event.location ? `
                                    <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                                        <span class="material-symbols-outlined">location_on</span>
                                        <span>${event.location}</span>
                                    </div>
                                ` : ''}
                                ${event.formatted_date_time ? `
                                    <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                                        <span class="material-symbols-outlined">schedule</span>
                                        <span>${event.formatted_date_time}</span>
                                    </div>
                                ` : ''}
                            </div>
                        `;
                        
                        document.getElementById('detailsContent').innerHTML = content;
                        detailsModal.classList.remove('hidden');
                        detailsModal.classList.add('flex');
                    }
                })
                .catch(error => {
                    console.error('Error loading details:', error);
                    document.getElementById('detailsContent').innerHTML = '<p class="text-red-500">Error loading details</p>';
                    detailsModal.classList.remove('hidden');
                    detailsModal.classList.add('flex');
                });
        }

        function viewAnnouncementDetails(id) {
            // Fetch announcement details from public route
            fetch(`/events/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const announcement = data.event;
                        document.getElementById('detailsTitle').textContent = announcement.title;
                        
                        let content = `
                            <div class="space-y-4">
                                ${announcement.description ? `
                                    <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-lg">
                                        <p class="text-slate-700 dark:text-slate-300 font-medium">${announcement.description}</p>
                                    </div>
                                ` : ''}
                                ${announcement.content ? `
                                    <div class="prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-400">
                                        ${announcement.content.replace(/\n/g, '<br>')}
                                    </div>
                                ` : ''}
                                <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 pt-4 border-t border-slate-200 dark:border-slate-700">
                                    <span class="material-symbols-outlined text-sm">schedule</span>
                                    <span>Posted ${announcement.created_at ? new Date(announcement.created_at).toLocaleDateString() : ''}</span>
                                </div>
                                ${announcement.expires_at ? `
                                    <div class="flex items-center gap-2 text-sm text-orange-600 dark:text-orange-400">
                                        <span class="material-symbols-outlined text-sm">event_busy</span>
                                        <span>Expires ${new Date(announcement.expires_at).toLocaleDateString()}</span>
                                    </div>
                                ` : ''}
                            </div>
                        `;
                        
                        document.getElementById('detailsContent').innerHTML = content;
                        detailsModal.classList.remove('hidden');
                        detailsModal.classList.add('flex');
                    }
                })
                .catch(error => {
                    console.error('Error loading announcement:', error);
                    document.getElementById('detailsContent').innerHTML = '<p class="text-red-500">Error loading announcement</p>';
                    detailsModal.classList.remove('hidden');
                    detailsModal.classList.add('flex');
                });
        }

        closeDetailsBtn.addEventListener('click', () => {
            detailsModal.classList.add('hidden');
            detailsModal.classList.remove('flex');
        });

        detailsModal.addEventListener('click', (e) => {
            if (e.target === detailsModal) {
                detailsModal.classList.add('hidden');
                detailsModal.classList.remove('flex');
            }
        });

        // Filter functionality
        function filterItems(type) {
            const eventCards = document.querySelectorAll('.event-card');
            const announcementCards = document.querySelectorAll('.announcement-card');
            const filterButtons = document.querySelectorAll('[id^="filter-"]');

            // Update button styles
            filterButtons.forEach(btn => {
                btn.classList.remove('bg-white', 'dark:bg-slate-700', 'shadow-sm', 'text-primary');
                btn.classList.add('text-slate-600', 'dark:text-slate-400');
            });

            const activeBtn = document.getElementById(`filter-${type}`);
            activeBtn.classList.add('bg-white', 'dark:bg-slate-700', 'shadow-sm', 'text-primary');
            activeBtn.classList.remove('text-slate-600', 'dark:text-slate-400');

            // Filter cards
            if (type === 'all') {
                eventCards.forEach(card => card.style.display = 'flex');
                announcementCards.forEach(card => card.style.display = 'flex');
            } else if (type === 'event') {
                eventCards.forEach(card => card.style.display = 'flex');
                announcementCards.forEach(card => card.style.display = 'none');
            } else if (type === 'announcement') {
                eventCards.forEach(card => card.style.display = 'none');
                announcementCards.forEach(card => card.style.display = 'flex');
            }
        }

        // Form submission
        document.getElementById('eventForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const form = this;
            const data = {
                first_name: form.querySelector('[name="first_name"]').value,
                last_name: form.querySelector('[name="last_name"]').value || '',
                email: form.querySelector('[name="email"]').value || null,
                phone: form.querySelector('[name="phone"]').value || null,
                event_id: form.querySelector('[name="event_id"]').value || null,
                event_name: form.querySelector('[name="event_name"]') ? form.querySelector('[name="event_name"]').value : (document.getElementById('modalEventTitle') ? document.getElementById('modalEventTitle').textContent : null),
            };

            if (!data.first_name || !data.event_id) {
                alert('Please provide your name and select an event.');
                return;
            }

            try {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const resp = await fetch('{{ route('event.registrations.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                if (!resp.ok) {
                    const err = await resp.json().catch(() => null);
                    alert((err && err.message) ? err.message : 'Registration failed.');
                    return;
                }

                alert('Thank you for registering!');
                registrationModal.classList.add('hidden');
                registrationModal.classList.remove('flex');
                form.reset();
            } catch (error) {
                console.error('Event registration error', error);
                alert('Registration failed. Please try again later.');
            }
        });

        // Handle QR code registration parameter
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const registerEventId = urlParams.get('register');

            if (registerEventId) {
                const eventCards = document.querySelectorAll('[onclick*="openEventModal"]');
                let eventTitle = 'Event';

                eventCards.forEach(card => {
                    const onclickAttr = card.getAttribute('onclick');
                    if (onclickAttr && onclickAttr.includes(`openEventModal(${registerEventId},`)) {
                        const titleMatch = onclickAttr.match(/openEventModal\(\d+,\s*'([^']+)'\)/);
                        if (titleMatch) {
                            eventTitle = titleMatch[1];
                        }
                    }
                });

                setTimeout(() => {
                    openEventModal(registerEventId, eventTitle);
                }, 500);
            }

            // Initialize carousel
            initCarousel();
        });

        // Carousel functionality
        let currentSlide = 0;
        let carouselInterval;

        function initCarousel() {
            const slides = document.querySelectorAll('.carousel-slide');
            if (slides.length <= 1) return; // No need for carousel with 1 or 0 slides

            // Start auto-rotation
            startCarouselAutoRotate();
        }

        function showSlide(index) {
            const slides = document.querySelectorAll('.carousel-slide');
            const indicators = document.querySelectorAll('.carousel-indicator');
            
            if (slides.length === 0) return;

            // Wrap around
            if (index >= slides.length) {
                currentSlide = 0;
            } else if (index < 0) {
                currentSlide = slides.length - 1;
            } else {
                currentSlide = index;
            }

            // Update slides
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === currentSlide);
            });

            // Update indicators
            indicators.forEach((indicator, i) => {
                indicator.classList.toggle('active', i === currentSlide);
            });
        }

        function nextSlide() {
            showSlide(currentSlide + 1);
            resetCarouselAutoRotate();
        }

        function previousSlide() {
            showSlide(currentSlide - 1);
            resetCarouselAutoRotate();
        }

        function goToSlide(index) {
            showSlide(index);
            resetCarouselAutoRotate();
        }

        function startCarouselAutoRotate() {
            carouselInterval = setInterval(() => {
                nextSlide();
            }, 5000); // Change slide every 5 seconds
        }

        function resetCarouselAutoRotate() {
            clearInterval(carouselInterval);
            startCarouselAutoRotate();
        }
    </script>

</body>

</html>
