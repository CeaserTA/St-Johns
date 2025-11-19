<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Events - Admin — St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link rel="stylesheet" href="/styles.css">
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
            <!-- Admin Sidebar + Main Split -->
            <div class="flex h-full">
                <!-- Sidebar (copied style from other admin pages) -->
                <aside class="w-64 bg-blue-800 text-white flex flex-col">
                    <div class="p-6 text-2xl font-bold border-b border-blue-900">St. Johns Admin</div>
                    <nav class="mt-6 flex-1">
                        <ul>
                            <li>
                                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 hover:bg-blue-700 transition {{ request()->routeIs('dashboard') ? 'bg-blue-700' : '' }}">Dashboard</a>
                            </li>
                            <li>
                                <a href="{{ route('members') }}" class="flex items-center px-6 py-3 transition rounded-r-lg {{ request()->routeIs('members*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">Members</a>
                            </li>
                            <li>
                                <a href="{{ route('service.register') }}" class="flex items-center px-6 py-3 transition rounded-r-lg {{ (request()->routeIs('service.register') || request()->routeIs('service.registrations')) ? 'bg-blue-700' : 'hover:bg-blue-700' }}">Services</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.events') }}" class="flex items-center px-6 py-3 transition rounded-r-lg {{ request()->routeIs('admin.events*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">Events</a>
                            </li>
                            <li>
                                <a href="{{ url('/groups') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->is('groups*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">Groups</a>
                            </li>
                            <li>
                                <a href="{{ url('/announcements') }}" class="flex items-center px-6 py-3 rounded-r-lg transition {{ request()->is('announcements*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">Announcements</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="flex w-full items-center px-6 py-3 hover:bg-blue-700 rounded-r-lg transition">Logout</button></form>
                            </li>
                        </ul>
                    </nav>
                </aside>

                <!-- Main Content Area -->
                <main class="flex-1 p-8 overflow-y-auto">
                    <header class="mb-8 flex items-center justify-between">
                        <h1 class="text-2xl font-semibold">Events — Overview</h1>
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline text-sm">← Back to dashboard</a>
                    </header>

                    <section class="py-12 bg-gray-50">
                        <div class="container mx-auto px-4">
                            <h2 class="text-3xl font-bold text-center text-text-light mb-8">Upcoming Church Events</h2>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Event Card 1 -->
                                <div class="event-card bg-white rounded-xl shadow p-6">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="text-primary"><span class="material-symbols-outlined !text-4xl">calendar_month</span></div>
                                        <span class="material-symbols-outlined text-gray-400">check_circle</span>
                                    </div>
                                    <h3 class="text-xl font-bold mb-2">Sunday Worship</h3>
                                    <p class="text-text-muted-light text-sm mb-4">Join us for uplifting worship and inspiring sermons every Sunday.</p>
                                    <div class="space-y-2 text-sm">
                A                        <div class="flex items-center text-text-muted-light"><span class="material-symbols-outlined !text-lg mr-2">event</span><span>Every Sunday</span></div>
                                        <div class="flex items-center text-text-muted-light"><span class="material-symbols-outlined !text-lg mr-2">schedule</span><span>8:00 AM - 10:00 AM</span></div>
                                        <div class="flex items-center text-text-muted-light"><span class="material-symbols-outlined !text-lg mr-2">location_on</span><span>St. John’s Church, Entebbe</span></div>
                                    </div>
                                </div>

                                <!-- Event Card 2 -->
                                <div class="event-card bg-white rounded-xl shadow p-6">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="text-primary"><span class="material-symbols-outlined !text-4xl">calendar_month</span></div>
                                        <span class="material-symbols-outlined text-gray-400">check_circle</span>
                                    </div>
                                    <h3 class="text-xl font-bold mb-2">Bible Study</h3>
                                    <p class="text-text-muted-light text-sm mb-4">Deepen your faith and understanding of the scriptures in our weekly study group.</p>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex items-center text-text-muted-light"><span class="material-symbols-outlined !text-lg mr-2">event</span><span>Wednesdays</span></div>
                                        <div class="flex items-center text-text-muted-light"><span class="material-symbols-outlined !text-lg mr-2">schedule</span><span>6:00 PM - 7:30 PM</span></div>
                                        <div class="flex items-center text-text-muted-light"><span class="material-symbols-outlined !text-lg mr-2">location_on</span><span>Church Hall, Entebbe</span></div>
                                    </div>
                                </div>

                                <!-- Event Card 3 -->
                                <div class="event-card bg-white rounded-xl shadow p-6">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="text-primary"><span class="material-symbols-outlined !text-4xl">calendar_month</span></div>
                                        <span class="material-symbols-outlined text-gray-400">check_circle</span>
                                    </div>
                                    <h3 class="text-xl font-bold mb-2">Community Outreach</h3>
                                    <p class="text-text-muted-light text-sm mb-4">Participate in acts of service, helping the local community and those in need.</p>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex items-center text-text-muted-light"><span class="material-symbols-outlined !text-lg mr-2">event</span><span>Monthly</span></div>
                                        <div class="flex items-center text-text-muted-light"><span class="material-symbols-outlined !text-lg mr-2">schedule</span><span>9:00 AM - 12:00 PM</span></div>
                                        <div class="flex items-center text-text-muted-light"><span class="material-symbols-outlined !text-lg mr-2">location_on</span><span>Community Center, Entebbe</span></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>
                </main>
            </div>
        </div>
    </div>
    <script src="/script.js"></script>
</body>
</html>
