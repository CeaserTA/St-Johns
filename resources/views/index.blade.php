<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css">
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0A2463",
                        "background-light": "#F8F7F2",
                        "background-dark": "#101922",
                        "accent": "#D4AF37",
                        "text-light-primary": "#111418",
                        "text-light-secondary": "#8A8D91",
                        "text-dark-primary": "#F8F7F2",
                        "text-dark-secondary": "#8A8D91",
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                },
            },
        }
    </script>

</head>

<body class="bg-background-light font-display text-text-light">
    <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">
            <!-- Header - Full Width Navbar -->
            <header
                class="sticky top-0 z-50 flex items-center bg-background-light/80 p-4 pb-2 justify-between backdrop-blur-sm shadow-sm">
                    <div class="flex items-center gap-3">
                    <img src="assets/Logo Final.png" alt="St. John's Parish Church Logo"
                        class="h-112 w-auto object-contain m-2" style="max-height: 50px;">
                    <a href="{{ route('home') }}"
                        class="text-lg font-bold leading-tight tracking-[-0.015em] text-gray-800">
                        St. John's Parish Church Entebbe
                    </a>
                </div>

                <nav class="hidden sm:flex flex-1 justify-end gap-8">
                    <div class="flex items-center gap-9">
                        <a class="text-sm font-medium leading-normal text-gray-800 hover:text-primary transition-colors"
                            href="{{ route('home') }}">Home</a>
                        <a class="text-sm font-medium leading-normal text-gray-800 hover:text-primary transition-colors"
                            href="{{ route('services') }}">Services</a>
                        <a class="text-sm font-medium leading-normal text-gray-800 hover:text-primary transition-colors"
                            href="{{ route('events') }}">Events</a>
                        <a class="text-sm font-medium leading-normal text-gray-800 hover:text-primary transition-colors"
                            href="{{ route('admin.login') }}">Admin Portal</a>
                    </div>
                </nav>
            </header>


            <!-- Main Content -->
            <main class="flex-grow w-full">
                <!-- Hero Section with Church Banner -->
                <div class="@container">
                    <div class="@[480px]:p-4">
                        <div class="flex min-h-[480px] flex-col gap-6 bg-cover bg-center bg-no-repeat @[480px]:gap-8 items-center justify-center p-4 @[480px]:rounded-xl"
                            data-alt="Inspiring photo of St. John's Parish Church Entebbe under a clear blue sky."
                            style='background-image: linear-gradient(rgba(10, 36, 99, 0.3) 0%, rgba(10, 36, 99, 0.6) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuBJuBVtqw9UvSxdwxXR4HOoRKNwjmp9luc3fMocyA9NTqdPQivYkifWnUaMwnjyQq3T4squ6UlhiwnVUaXW1dGBb9iQTqAWj2ZWY0cDsr8_w0zYXf4_sbb551OYF9iq1ViLJ1oSTTDppAlvmUWZuWIo8Etdwaaf_zx3Twh1p4XfM8eHKL64rCtraA9U_aCR3AJcZ_L-6y2nwV4LQ3nNURKG3gPTol5sCwQWKy93zdr-wzJtb_VykEtdfU3XC_2Nsxabk4C2zBpbrrgU");'>
                            <div class="flex flex-col gap-2 text-center">
                                <h2
                                    class="text-white text-4xl font-black leading-tight tracking-[-0.033em] @[480px]:text-5xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em]">
                                    Welcome Home
                                </h2>

                                <p
                                    class="text-white/90 text-sm font-normal leading-normal @[480px]:text-base @[480px]:font-normal @[480px]:leading-normal">
                                    Growing in Faith Together</p>
                            </div>
                            <button id="registerBtn" 
                                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-12 px-5 bg-accent text-primary text-base font-bold leading-normal tracking-[0.015em] hover:opacity-90 transition-opacity">
                                <span class="truncate">Join Our Parish</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Welcome Introduction Section -->
                <h3
                    class="text-center mb-4 text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                    This Week at St. John's</h3>

                <div class="mt-3 flex overflow-x-auto justify-center [-ms-scrollbar-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                    <div class="flex items-stretch px-4 gap-4">

                        <!-- Special Mass Schedule -->
                        <div
                            class="flex h-full w-72 flex-1 flex-col gap-3 rounded-xl bg-white shadow-[0_4px_12px_rgba(0,0,0,0.05)] min-w-60">
                            
                            <!-- Image -->
                            <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-t-xl flex flex-col"
                                style='background-image: url("assets/prayer.webp");'>
                            </div>

                            <!-- Content -->
                            <div class="flex flex-col flex-1 justify-between p-4 pt-1 gap-4">
                                <div>
                                    <p class="text-text-light-primary text-base font-bold leading-normal">
                                        Special Service Schedule
                                    </p>
                                    <p class="text-text-light-secondary text-sm font-normal leading-normal">
                                        Join us for a special Sunday service with uplifting worship and an inspiring sermon.
                                        <br><strong>Day:</strong> Every Sunday at 10:00 AM
                                    </p>

                                    <!-- Hidden Extra Info -->
                                    <div class="hidden mt-3 text-text-light-secondary text-sm leading-relaxed extra-info">
                                        Our Sunday services include powerful worship sessions, engaging sermons, and a welcoming community atmosphere. 
                                        Each week may feature guest speakers, choir performances, or youth-led worship experiences. 
                                        Everyone is invited to participate and be blessed.
                                    </div>
                                </div>

                                <!-- Read More Button -->
                                <button
                                    onclick="this.parentElement.querySelector('.extra-info').classList.toggle('hidden')"
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary/10 text-primary text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary/20 transition">
                                    <span class="truncate">Read More</span>
                                </button>
                            </div>
                        </div>


                        <!-- Annual Community Drive -->
                        <div
                            class="flex h-full w-72 flex-1 flex-col gap-3 rounded-xl bg-white shadow-[0_4px_12px_rgba(0,0,0,0.05)] min-w-60">
                            
                            <!-- Image -->
                            <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-t-xl flex flex-col"
                                style='background-image: url("assets/Community.webp");'>
                            </div>

                            <!-- Content -->
                            <div class="flex flex-col flex-1 justify-between p-4 pt-1 gap-4">
                                <div>
                                    <p class="text-text-light-primary text-base font-bold leading-normal">
                                        Annual Community Drive
                                    </p>
                                    <p class="text-text-light-secondary text-sm font-normal leading-normal">
                                        Participate in our yearly community drive to support local families with food and essentials.
                                        <br><strong>Day:</strong> Every first Saturday of the month
                                    </p>

                                    <!-- Hidden Extra Info -->
                                    <div class="hidden mt-3 text-text-light-secondary text-sm leading-relaxed extra-info">
                                        Each year, we gather as a parish to give back to our Entebbe community by collecting food, clothes, and supplies 
                                        for families in need. Volunteers are welcome to help with sorting, packing, and distribution. 
                                        Together, we make a lasting difference!
                                    </div>
                                </div>

                                <!-- Read More Button -->
                                <button
                                    onclick="this.parentElement.querySelector('.extra-info').classList.toggle('hidden')"
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary/10 text-primary text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary/20 transition">
                                    <span class="truncate">Read More</span>
                                </button>
                            </div>
                        </div>


                        <!-- Youth Fellowship Night -->
                        <div
                            class="flex h-full w-72 flex-1 flex-col gap-3 rounded-xl bg-white shadow-[0_4px_12px_rgba(0,0,0,0.05)] min-w-60">
                            
                            <!-- Image -->
                            <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-t-xl flex flex-col"
                                style='background-image: url("assets/Youth fellowship.jpeg");'>
                            </div>

                            <!-- Content -->
                            <div class="flex flex-col flex-1 justify-between p-4 pt-1 gap-4">
                                <div>
                                    <p class="text-text-light-primary text-base font-bold leading-normal">
                                        Youth Fellowship Night
                                    </p>
                                    <p class="text-text-light-secondary text-sm font-normal leading-normal">
                                        A fun and spiritual evening for teenagers and young adults with games, worship, and discussions.
                                        <br><strong>Day:</strong> Every Friday at 6:30 PM
                                    </p>

                                    <!-- Hidden Extra Info -->
                                    <div class="hidden mt-3 text-text-light-secondary text-sm leading-relaxed extra-info">
                                        Join us for a vibrant night of fellowship filled with music, laughter, and meaningful conversations.
                                        It’s a safe space to grow in faith, build friendships, and strengthen your walk with God.
                                    </div>
                                </div>

                                <!-- Read More Button -->
                                <button
                                    onclick="this.parentElement.querySelector('.extra-info').classList.toggle('hidden')"
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary/10 text-primary text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary/20 transition">
                                    <span class="truncate">Read More</span>
                                </button>
                            </div>
                        </div>


                        <!-- Bible Study Session (New Card) -->
                        <div
                            class="flex h-full w-72 flex-1 flex-col gap-3 rounded-xl bg-white shadow-[0_4px_12px_rgba(0,0,0,0.05)] min-w-60">
                            <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-t-xl flex flex-col"
                                style='background-image: url("assets/Discipline-of-Bible-Study.jpg");'>
                            </div>

                            <div class="flex flex-col flex-1 justify-between p-4 pt-1 gap-4">
                                <div>
                                    <p class="text-text-light-primary text-base font-bold leading-normal">
                                        Bible Study Session
                                    </p>
                                    <p class="text-text-light-secondary text-sm font-normal leading-normal">
                                        Weekly Bible study group for all ages, exploring Scripture and sharing reflections.
                                        <br><strong>Day:</strong> Every Wednesday at 7:00 PM
                                    </p>

                                    <!-- Hidden details -->
                                    <div id="bible-study-info" class="hidden mt-3 text-text-light-secondary text-sm leading-relaxed">
                                        Each session includes guided discussions, group prayers, and practical lessons to deepen
                                        understanding of God's Word. All are welcome — bring your Bible and an open heart.
                                    </div>
                                </div>

                                <!-- Read More Button -->
                                <button
                                    onclick="document.getElementById('bible-study-info').classList.toggle('hidden')"
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary/10 text-primary text-sm font-bold leading-normal tracking-[0.015em] hover:bg-primary/20 transition">
                                    <span class="truncate">Read More</span>
                                </button>
                            </div>
                        </div>


                    </div>
                </div>
                <section
                    class="w-full bg-gradient-to-b from-background-light via-white to-[#f4f6fb] py-16">
                    <div class="w-full px-6 lg:px-10">
                        <!-- 3 columns layout -->
                        <div class="grid gap-10 lg:grid-cols-3 items-start">

                            <!-- Column 1: Intro -->
                            <div class="space-y-6">
                                <span
                                    class="inline-block uppercase tracking-[0.3em] text-xs font-semibold text-primary mb-3">Who
                                    We Are</span>
                                <h2
                                    class="text-4xl font-bold text-text-light sm:text-5xl leading-tight">
                                    A welcoming parish for every stage of faith</h2>
                                <p class="text-lg text-text-muted-light leading-relaxed">
                                    St. John's Parish Church Entebbe is more than a Sunday gathering. We are a home for
                                    seekers, families, students, and long-time believers who desire a deeper connection
                                    with God and one another.
                                </p>
                                <p class="text-base text-text-muted-light leading-relaxed">
                                    Whether you're visiting for the very first time or looking for a parish to call
                                    home, we want your experience to feel warm, welcoming, and meaningful.
                                </p>
                            </div>

                            <!-- Column 2: Heartbeat Card -->
                            <aside
                                class="bg-white/90 backdrop-blur-md rounded-2xl shadow-lg border border-primary/10 overflow-hidden">
                                <div class="bg-secondary bg-sky-700 text-white px-6 py-5">
                                    <h3 class="text-2xl font-bold">Our Heartbeat</h3>
                                    <p class="text-sm text-white/80 mt-1">The vision that shapes every gathering and
                                        ministry effort.</p>
                                </div>
                                <div class="p-6 space-y-6">
                                    <div>
                                        <h4 class="text-lg font-semibold text-text-light mb-2">
                                            Mission</h4>
                                        <p
                                            class="text-sm text-text-muted-light leading-relaxed">
                                            To proclaim Christ, nurture believers, and serve our community with
                                            compassion, generosity, and grace.
                                        </p>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-semibold text-text-light mb-2">
                                            Vision</h4>
                                        <p
                                            class="text-sm text-text-muted-light leading-relaxed">
                                            To be a lighthouse of hope in Entebbe — equipping disciples, strengthening
                                            families, and reaching new generations for Jesus.
                                        </p>
                                    </div>
                                    <div
                                        class="grid grid-cols-2 gap-4 pt-2 border-t border-gray-200">
                                        <div>
                                            <span
                                                class="block text-3xl font-bold text-primary">1948</span>
                                            <span
                                                class="text-xs uppercase tracking-wide text-text-muted-light">Founded</span>
                                        </div>
                                        <div>
                                            <span
                                                class="block text-3xl font-bold text-primary">600+</span>
                                            <span
                                                class="text-xs uppercase tracking-wide text-text-muted-light">Active
                                                members</span>
                                        </div>
                                    </div>
                                </div>
                            </aside>

                            <!-- Column 3: Stacked Cards -->
                            <div class="space-y-6">
                                <div
                                    class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                                    <h3 class="text-xl font-semibold text-text-light mb-3">What to
                                        Expect</h3>
                                    <p class="text-sm text-text-muted-light leading-relaxed">
                                        Friendly greeters, uplifting worship, and a message that connects Scripture to
                                        everyday life. Come as you are—we'll save you a seat.
                                    </p>
                                </div>
                                <div
                                    class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                                    <h3 class="text-xl font-semibold text-text-light mb-3">Ways to
                                        Connect</h3>
                                    <p class="text-sm text-text-muted-light leading-relaxed">
                                        Join a small group, serve with our outreach teams, or participate in youth and
                                        adult discipleship programs. There's room for your gifts and story.
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>



            </main>

            <!-- Footer -->
            <footer class="navbar flex flex-col gap-8 px-5 py-10 text-center @container  w-full">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-10 sm:gap-6 w-full">

                    <!-- Left: Logo -->
                    <div class="flex items-center gap-3">
                        <img src="assets/Logo Final.png" alt="St. John's Parish Church Logo"
                            class="h-12 w-auto object-contain">
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-300 ">St. John's Parish Church Entebbe
                        </h2>
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

    <!-- Registration Modal -->
    <div id="registrationModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Member Registration</h2>
                <span class="close">&times;</span>
            </div>
            <form id="registrationForm" method="POST" action="{{ route('members.store') }}">
                @csrf
                <div class="form-group">
                    <label for="firstName">First Name *</label>
                    <input type="text" id="firstName" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name *</label>
                    <input type="text" id="lastName" name="last_name" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender *</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="contact">Contact *</label>
                    <input type="tel" id="contact" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="address">Address *</label>
                    <textarea id="address" name="address" rows="3" required></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary"
                        onclick="document.getElementById('registrationModal').classList.remove('show'); document.body.style.overflow = 'auto';">Cancel</button>
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>