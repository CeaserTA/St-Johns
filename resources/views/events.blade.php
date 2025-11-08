<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Events - St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link rel="stylesheet" href="styles.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#3A5C83",
                        "secondary": "#F2C94C",
                        "background-light": "#F8F9FA",
                        "background-dark": "#101922",
                        "text-light": "#333333",
                        "text-dark": "#F8F9FA",
                        "text-muted-light": "#4c739a",
                        "text-muted-dark": "#a0aec0",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                },
            },
        }
    </script> 
</head>
<body class="bg-background-light font-display text-text-light">
    <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">
            <!-- Header - Full Width Navbar -->
            <!-- Header - Full Width Navbar -->
            <header class="sticky top-0 z-50 flex items-center bg-background-light/80 p-4 pb-2 justify-between backdrop-blur-sm shadow-sm">
            <div class="flex items-center gap-3">
                <img src="assets/Logo Final.png" alt="St. John's Parish Church Logo" class="h-112 w-auto object-contain" style="max-height: 50px;">
                <a href="{{route('home')}}" class="text-lg font-bold leading-tight tracking-[-0.015em] text-gray-800">
                St. John's Parish Church Entebbe
                </a>
            </div>
            
            <nav class="hidden sm:flex flex-1 justify-end gap-8">
                <div class="flex items-center gap-9">
                <a class="text-sm font-medium leading-normal text-gray-800 hover:text-primary transition-colors" href="{{ route('home') }}">Home</a>
                <a class="text-sm font-medium leading-normal text-gray-800 hover:text-primary transition-colors" href="{{ route('services') }}">Services</a>
                <a class="text-sm font-medium leading-normal text-gray-800 hover:text-primary transition-colors" href="{{ route('events') }}">Events</a>
                <a class="text-sm font-medium leading-normal text-gray-800 hover:text-primary transition-colors" href="{{ route('admin.login') }}">Admin Portal</a>
                </div>
            </nav>
            </header>

                        <!-- Main Content -->
            <main class="flex-grow px-4 py-8 sm:px-6 w-full">
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-text-light dark:text-text-dark mb-2">Upcoming Events</h1>
                    <p class="text-text-muted-light dark:text-text-muted-dark">Discover and register for parish events,
                        workshops, and gatherings.</p>
                </div>

                <section id="eventsSection" class="py-12 bg-gray-50 dark:bg-gray-900">
                    <div class="container mx-auto px-4">
                        <h2 class="text-3xl font-bold text-center text-text-light dark:text-text-dark mb-8">
                            Upcoming Church Events
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Event Card 1 -->
                            <div class="event-card bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="text-primary dark:text-secondary">
                                        <span class="material-symbols-outlined !text-4xl">calendar_month</span>
                                    </div>
                                    <span class="material-symbols-outlined text-gray-400">check_circle</span>
                                </div>
                                <h3 class="text-xl font-bold text-text-light dark:text-text-dark mb-2">Sunday Worship
                                </h3>
                                <p class="text-text-muted-light dark:text-text-muted-dark text-sm mb-4">
                                    Join us for uplifting worship and inspiring sermons every Sunday.
                                </p>
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center text-text-muted-light dark:text-text-muted-dark">
                                        <span class="material-symbols-outlined !text-lg mr-2">event</span>
                                        <span>Every Sunday</span>
                                    </div>
                                    <div class="flex items-center text-text-muted-light dark:text-text-muted-dark">
                                        <span class="material-symbols-outlined !text-lg mr-2">schedule</span>
                                        <span>8:00 AM - 10:00 AM</span>
                                    </div>
                                    <div class="flex items-center text-text-muted-light dark:text-text-muted-dark">
                                        <span class="material-symbols-outlined !text-lg mr-2">location_on</span>
                                        <span>St. John’s Church, Entebbe</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Event Card 2 -->
                            <div class="event-card bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="text-primary dark:text-secondary">
                                        <span class="material-symbols-outlined !text-4xl">calendar_month</span>
                                    </div>
                                    <span class="material-symbols-outlined text-gray-400">check_circle</span>
                                </div>
                                <h3 class="text-xl font-bold text-text-light dark:text-text-dark mb-2">Bible Study</h3>
                                <p class="text-text-muted-light dark:text-text-muted-dark text-sm mb-4">
                                    Deepen your faith and understanding of the scriptures in our weekly study group.
                                </p>
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center text-text-muted-light dark:text-text-muted-dark">
                                        <span class="material-symbols-outlined !text-lg mr-2">event</span>
                                        <span>Wednesdays</span>
                                    </div>
                                    <div class="flex items-center text-text-muted-light dark:text-text-muted-dark">
                                        <span class="material-symbols-outlined !text-lg mr-2">schedule</span>
                                        <span>6:00 PM - 7:30 PM</span>
                                    </div>
                                    <div class="flex items-center text-text-muted-light dark:text-text-muted-dark">
                                        <span class="material-symbols-outlined !text-lg mr-2">location_on</span>
                                        <span>Church Hall, Entebbe</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Event Card 3 -->
                            <div class="event-card bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="text-primary dark:text-secondary">
                                        <span class="material-symbols-outlined !text-4xl">calendar_month</span>
                                    </div>
                                    <span class="material-symbols-outlined text-gray-400">check_circle</span>
                                </div>
                                <h3 class="text-xl font-bold text-text-light dark:text-text-dark mb-2">Community
                                    Outreach</h3>
                                <p class="text-text-muted-light dark:text-text-muted-dark text-sm mb-4">
                                    Participate in acts of service, helping the local community and those in need.
                                </p>
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center text-text-muted-light dark:text-text-muted-dark">
                                        <span class="material-symbols-outlined !text-lg mr-2">event</span>
                                        <span>Monthly</span>
                                    </div>
                                    <div class="flex items-center text-text-muted-light dark:text-text-muted-dark">
                                        <span class="material-symbols-outlined !text-lg mr-2">schedule</span>
                                        <span>9:00 AM - 12:00 PM</span>
                                    </div>
                                    <div class="flex items-center text-text-muted-light dark:text-text-muted-dark">
                                        <span class="material-symbols-outlined !text-lg mr-2">location_on</span>
                                        <span>Community Center, Entebbe</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Central Register Button -->
                        <div class="mt-8 text-center">
                            <button id="openModalBtn"
                                class="py-3 px-6 bg-primary text-white font-semibold rounded-lg hover:bg-opacity-90 transition-colors">
                                Register for Event
                            </button>
                        </div>
                    </div>

            </main>
            <!-- Footer -->
            <footer class="navbar flex flex-col gap-8 px-5 py-10 text-center @container  w-full">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-10 sm:gap-6 w-full">
                
                <!-- Left: Logo -->
                <div class="flex items-center gap-3">
                <img src="assets/Logo Final.png" alt="St. John's Parish Church Logo" class="h-12 w-auto object-contain">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-300 ">St. John's Parish Church Entebbe</h2>
                </div>

                <!-- Center: Social Media Icons -->
                <div class="flex items-center gap-6">
                <a href="#" aria-label="Facebook" class="hover:text-blue-400 transition-colors">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                    </svg>
                </a>
                <a href="#" aria-label="Twitter" class="hover:text-blue-400 transition-colors">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743A11.65 11.65 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                </a>
                <a href="#" aria-label="YouTube" class="hover:text-blue-400 transition-colors">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.506 2.506 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.418-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15.194V8.806L15.194 12Z" />
                    </svg>
                </a>
                </div>

                <!-- Right: Navigation Links -->
                <div class="flex flex-wrap justify-center sm:justify-end gap-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="hover:text-blue-400 transition-colors">Home</a>
                <a href="{{ route('services') }}" class="hover:text-blue-400 transition-colors">Services</a>
                <a href="{{ route('events') }}" class="hover:text-blue-400 transition-colors">Events</a>
                <a href="contact.html" class="hover:text-blue-400 transition-colors">Contact</a>
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="border-t border-gray-700 mt-10 pt-6 text-center text-sm text-gray-300">
                <p>© 2025 St. John's Parish Church Entebbe. All Rights Reserved.</p>
            </div>
            </footer>
        </div>
    </div>

       <!-- Modal -->
    <div id="registrationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 w-full max-w-md">
            <h3 class="text-xl font-bold mb-4 text-text-light dark:text-text-dark">Event Registration</h3>
            <form id="eventForm" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-text-light dark:text-text-dark mb-1">First Name</label>
                        <input type="text" name="first_name"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-text-light dark:text-text-dark"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-light dark:text-text-dark mb-1">Last Name</label>
                        <input type="text" name="last_name"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-text-light dark:text-text-dark"
                            required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-text-light dark:text-text-dark mb-1">Email</label>
                    <input type="email" name="email"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-text-light dark:text-text-dark"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-text-light dark:text-text-dark mb-1">Phone</label>
                    <input type="tel" name="phone"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-text-light dark:text-text-dark">
                </div>
                <div>
                    <label class="block text-sm font-medium text-text-light dark:text-text-dark mb-1">Select
                        Event</label>
                    <select name="event_name"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded px-3 py-2 bg-white dark:bg-gray-700 text-text-light dark:text-text-dark"
                        required>
                        <option value="">-- Choose an Event --</option>
                        <option value="Sunday Worship">Sunday Worship</option>
                        <option value="Bible Study">Bible Study</option>
                        <option value="Community Outreach">Community Outreach</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" id="closeModalBtn"
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded hover:bg-gray-400 dark:hover:bg-gray-500">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-primary text-white rounded hover:bg-opacity-90">Register</button>
                </div>
            </form>
        </div>
    </div>
    </section>

    <script>
        const openModalBtn = document.getElementById('openModalBtn');
        const registrationModal = document.getElementById('registrationModal');
        const closeModalBtn = document.getElementById('closeModalBtn');

        openModalBtn.addEventListener('click', () => {
            registrationModal.classList.remove('hidden');
            registrationModal.classList.add('flex');
        });

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
                email: form.querySelector('[name="email"]').value,
                phone: form.querySelector('[name="phone"]').value || null,
                event_name: form.querySelector('[name="event_name"]').value,
            };

            // Basic client-side check
            if (!data.first_name || !data.event_name) {
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

