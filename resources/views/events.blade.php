<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Events - St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @include('partials.theme-config')
</head>

<body class="bg-background-light font-display text-text-light">
    @include('partials.navbar')

        @include('partials.announcement')

    {{-- Success Message --}}
    @if ($message = Session::get('success'))
        <div class="mb-6 max-w-7xl mx-auto px-6">
            <div
                class="bg-green-50 border-l-4 border-green-500 text-green-800 p-5 rounded-r-lg shadow-md flex items-start gap-4">
                <svg class="w-7 h-7 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="font-bold text-lg text-green-900">Success!</p>
                    <p class="mt-1">{{ $message }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Error Message --}}
    @if ($message = Session::get('error'))
        <div class="mb-6 max-w-7xl mx-auto px-6">
            <div
                class="bg-red-50 border-l-4 border-secondary text-secondary p-5 rounded-r-lg shadow-md flex items-start gap-4">
                <svg class="w-7 h-7 text-secondary flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="font-bold text-lg">Error</p>
                    <p class="mt-1">{{ $message }}</p>
                </div>
            </div>
        </div>
    @endif

    <main class="flex-grow py-16 lg:py-18 bg-[#F8F7F2]">
        <div class="max-w-7xl mx-auto px-4">

            <!-- HERO – Sacred, Warm & Compact -->
            <section class="text-center py-12">
                <p class="text-accent font-bold uppercase tracking-widest text-xs mb-3">
                    Fellowship • Worship • Celebration
                </p>
                <h1 class="text-5xl md:text-6xl font-black text-primary mb-5 leading-tight">
                    Upcoming Events
                </h1>
                <div class="w-28 h-1 bg-accent mx-auto mb-4"></div>
                <p class="text-lg md:text-xl text-gray-700 max-w-3xl mx-auto leading-relaxed">
                    Come celebrate, grow, and connect with us at
                    <span class="text-primary font-bold">St. John’s Parish Church Entebbe</span>.
                    There’s always something meaningful happening in our family.
                </p>
                <p class="mt-5 text-secondary italic text-lg font-medium">
                    “Let us not give up meeting together…” — Hebrews 10:25
                </p>
            </section>

            <!-- EVENTS GRID – Clean, Sacred & Consistent -->
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($events->take(4) as $event)
                    <article
                        class="group bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-400 border border-gray-100 overflow-hidden hover:border-accent/30 hover:-translate-y-3">

                        <!-- Top: Date Badge on Gold -->
                        <div class="bg-accent text-primary p-2 text-center">
                            <div class="text-5xl font-black leading-none">
                                {{ \Carbon\Carbon::parse($event->date)->format('d') }}
                            </div>
                            <div class="text-lg font-bold uppercase tracking-wider text-primary/90 mt-1">
                                {{ \Carbon\Carbon::parse($event->date)->format('M Y') }}
                            </div>
                        </div>

                        <!-- Body: Clean & Warm -->
                        <div class="p-5 space-y-5">
                            <h3 class="text-2xl font-bold text-primary line-clamp-2 group-hover:text-secondary transition">
                                {{ $event->title }}
                            </h3>

                            <p class="text-sm text-gray-600 line-clamp-3 leading-relaxed">
                                {{ Str::limit($event->description, 100) }}
                            </p>

                            <!-- Time & Location – Sacred Red Icons -->
                            <div class="space-y-3 text-sm text-gray-700">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $event->time }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="truncate">{{ $event->location }}</span>
                                </div>
                            </div>

                            <!-- Button – Red to Gold Hover -->
                            <button onclick="openEventModal({{ $event->id }}, '{{ addslashes($event->title) }}')"
                                class="w-full py-3.5 bg-secondary hover:bg-accent text-white hover:text-primary font-bold rounded-xl shadow-md hover:shadow-xl transform hover:scale-105 transition-all duration-300 text-base">
                                Register Now
                            </button>
                        </div>
                    </article>
                @endforeach

                <!-- Placeholder Cards -->
                @if($events->count() < 4)
                    @for($i = $events->count(); $i < 4; $i++)
                        <div
                            class="bg-white/70 border-2 border-dashed border-gray-300 rounded-3xl flex flex-col items-center justify-center p-12 text-center space-y-4">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-500 font-medium">More events<br>coming soon...</p>
                        </div>
                    @endfor
                @endif
            </section>

        </div>
    </main>

    @include('partials.footer')

    <!-- Modal -->
    <div id="registrationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-md">
            <h3 class="text-xl font-bold mb-4 text-text-light dark:text-text-dark">Event Registration</h3>

            <form id="eventForm" action="{{ route('event.registrations.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm mb-1">First Name</label>
                        <input type="text" name="first_name"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm mb-1">Last Name</label>
                        <input type="text" name="last_name"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700"
                            required>
                    </div>
                </div>

                <div>
                    <label class="block text-sm mb-1">Email</label>
                    <input type="email" name="email"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700"
                        required>
                </div>

                <div>
                    <label class="block text-sm mb-1">Phone</label>
                    <input type="tel" name="phone"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700">
                </div>

                <div>
                    <label class="block text-sm mb-1">Event</label>
                    <div id="modalEventTitle"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-sm text-gray-700">
                        Please select an event</div>
                    <input type="hidden" name="event_id" id="event_id" />
                    <input type="hidden" name="event_name" id="event_name_hidden" />
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" id="closeModalBtn"
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded">Cancel</button>

                    <button type="submit"
                        class="px-4 py-2 bg-primary text-white rounded hover:bg-secondary">Register</button>
                </div>
            </form>

        </div>
    </div>

    <script>
        const openModalBtn = document.getElementById('openModalBtn');
        const registrationModal = document.getElementById('registrationModal');
        const closeModalBtn = document.getElementById('closeModalBtn');

        // If the old CTA exists, hook it up; otherwise each event card will open the modal.
        if (openModalBtn) {
            openModalBtn.addEventListener('click', () => {
                registrationModal.classList.remove('hidden');
                registrationModal.classList.add('flex');
            });
        }

        // Open the registration modal for a specific event id + title
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

        // Optional: close modal when clicking outside the modal content
        registrationModal.addEventListener('click', (e) => {
            if (e.target === registrationModal) {
                registrationModal.classList.add('hidden');
                registrationModal.classList.remove('flex');
            }
        });

        // Handle form submission via AJAX
        document.getElementById('eventForm').addEventListener('submit', async function (e) {
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

            // Basic client-side check
            if (!data.first_name || !data.event_id) {
                alert('Please provide your name and select an event.');
                return;
            }

            try {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                // include last_name if present
                data.last_name = form.querySelector('[name="last_name"]') ? form.querySelector('[name="last_name"]').value : '';

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

                const json = await resp.json();
                alert('Thank you for registering!');
                registrationModal.classList.add('hidden');
                registrationModal.classList.remove('flex');
                form.reset();
            } catch (error) {
                console.error('Event registration error', error);
                alert('Registration failed. Please try again later.');
            }
        });
    </script>

    <script src="script.js"></script>
</body>

</html>