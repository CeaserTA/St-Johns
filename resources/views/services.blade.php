<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Services - St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link rel="stylesheet" href="styles.css">
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
                <a href="{{ route('home') }}" class="text-lg font-bold leading-tight tracking-[-0.015em] text-gray-800">
                St. John's Parish Church Entebbe
                </a>
            </div>
            
                <nav class="hidden sm:flex flex-1 justify-end gap-8">
                <div class="flex items-center gap-9">
                <a class="text-sm font-medium leading-normal text-gray-800 hover:text-primary transition-colors" href="{{ route('home') }}">Home</a>
                <a class="text-sm font-medium leading-normal text-gray-800 hover:text-primary transition-colors" href="{{ route('services') }}">Services</a>
                <a class="text-sm font-medium leading-normal text-gray-800 hover:text-primary transition-colors" href="{{ route('events') }}">Events</a>
                    <a class="text-sm font-medium leading-normal text-gray-800 dark:text-white hover:text-primary dark:hover:text-secondary transition-colors" href="{{ route('admin.login') }}">Admin Portal</a>
                </div>
            </nav>
            </header>
 <!-- Main Content -->
            <main>
                <section
                    class="text-center py-16 bg-gradient-to-b from-primary/10 to-white dark:from-background-dark dark:to-background-dark">
                    <h1 class="text-4xl font-bold text-text-light dark:text-text-dark mb-4">Our Services</h1>
                    <p class="max-w-2xl mx-auto text-text-muted-light dark:text-text-muted-dark">
                        We gather to worship, grow, and serve together as one family in Christ. Join us throughout the
                        week for uplifting worship, prayer, and fellowship.
                    </p>
                </section>

                <!-- SERVICES SECTION -->
                <section class="py-16 bg-gray-50 dark:bg-background-dark/40">
                    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-12">
                        <h2 class="text-3xl font-bold text-text-light dark:text-text-dark mb-3">
                            Church Services & Ministries
                        </h2>
                        <p class="text-text-muted-light dark:text-text-muted-dark max-w-2xl mx-auto">
                            Find your place to belong — our church offers uplifting services and ministries for
                            everyone.
                        </p>
                    </div>

                    <div class="grid gap-8 md:grid-cols-3 max-w-6xl mx-auto">
                        <!-- Counseling -->
                        <div
                            class="group-card bg-white dark:bg-background-dark border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-sm">
                            <span
                                class="material-symbols-outlined text-4xl text-primary dark:text-secondary mb-3">psychology</span>
                            <h3 class="text-lg font-semibold mb-2 text-text-light dark:text-text-dark">Counseling</h3>
                            <p class="text-sm text-text-muted-light dark:text-text-muted-dark mb-3">
                                Spiritual and emotional guidance sessions designed to bring peace and clarity to your
                                life.
                            </p>
                            <p class="text-sm text-text-muted-light dark:text-text-muted-dark"><strong>Tuesday:</strong>
                                10:00 AM</p>
                        </div>

                        <!-- Baptism -->
                        <div
                            class="group-card bg-white dark:bg-background-dark border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-sm">
                            <span
                                class="material-symbols-outlined text-4xl text-primary dark:text-secondary mb-3">water_drop</span>
                            <h3 class="text-lg font-semibold mb-2 text-text-light dark:text-text-dark">Baptism</h3>
                            <p class="text-sm text-text-muted-light dark:text-text-muted-dark mb-3">
                                Celebrate your faith and renewal through this sacred baptism ceremony.
                            </p>
                            <p class="text-sm text-text-muted-light dark:text-text-muted-dark">
                                <strong>Saturday:</strong> 2:00 PM</p>
                        </div>

                        <!-- Youth Retreat -->
                        <div
                            class="group-card bg-white dark:bg-background-dark border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-sm">
                            <span
                                class="material-symbols-outlined text-4xl text-primary dark:text-secondary mb-3">hiking</span>
                            <h3 class="text-lg font-semibold mb-2 text-text-light dark:text-text-dark">Youth Retreat
                            </h3>
                            <p class="text-sm text-text-muted-light dark:text-text-muted-dark mb-3">
                                A weekend getaway for youth to grow in faith, unity, and spiritual strength.
                            </p>
                            <p class="text-sm text-text-muted-light dark:text-text-muted-dark"><strong>2nd
                                    Saturday:</strong> 9:00 AM</p>
                        </div>
                    </div>
                </section>

                <!-- REGISTRATION FORM SECTION -->
                <section class="py-20 bg-gradient-to-r from-primary to-secondary text-white">
                    <div
                        class="max-w-6xl mx-auto px-4 sm:px-4 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                        <!-- LEFT TEXT -->
                        <div>
                            <h2 class="text-4xl font-bold mb-4">Register for a Church Service</h2>
                            <p class="text-white/90 mb-6">
                                We’d love to welcome you to St. John’s Parish Church Entebbe! Fill out this form to let
                                us know which service you’d like to attend — our team will prepare everything for your
                                visit.
                            </p>
                            <p class="text-white/80">
                                Whether you’re new to the community or just visiting, your presence means a lot to us.
                                Choose your service, and we’ll be ready to receive you warmly.
                            </p>
                        </div>

                        <!-- RIGHT FORM -->
                        <div class="bg-white rounded-2xl shadow-lg p-8 sm:p-10 text-gray-800">
                            <form class="space-y-6"action="{{ route('service.register') }}" method="POST">
                                @csrf
                            <!-- Full Name -->
                                <div>
                                    <label for="fullname" class="block text-sm font-medium text-gray-700 mb-1">Full
                                        Name</label>
                                    <input id="fullname" name="fullname" type="text" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input id="email" name="email" type="email" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                                </div>

                                <!-- Address -->
                                <div>
                                    <label for="address"
                                        class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <input id="address" name="address" type="text"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                                </div>

                                <!-- Contact -->
                                <div>
                                    <label for="contact"
                                        class="block text-sm font-medium text-gray-700 mb-1">Contact</label>
                                    <input id="contact" name="contact" type="tel"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                                </div>

                               
                                <!-- Service Dropdown -->
                                <div>
                                    <label for="service" class="block text-sm font-medium text-gray-700 mb-1">Select a
                                        Service</label>
                                    <select id="service" name="service" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none">
                                        <option value="" disabled selected>Select a service</option>
                                        <option value="Counseling">Counseling</option>
                                        <option value="Baptism">Baptism</option>
                                        <option value="Youth Retreat">Youth Retreat</option>
                                    </select>
                                </div>

                                <!-- Submit -->
                                <div class="pt-2">
                                    <button type="submit"
                                        class="w-full bg-primary hover:bg-secondary text-white font-semibold py-3 px-6 rounded-lg shadow-md transition">
                                        Submit Your Registration
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>



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

    <script src="script.js"></script>
</body>
</html>

