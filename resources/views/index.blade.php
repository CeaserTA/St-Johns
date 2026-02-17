<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Fallback: precompiled Tailwind CSS in case the CDN script is unavailable -->
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@3.1.0/dist/tailwind.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css">
    @include('partials.theme-config')

</head>

<body class="bg-background-light font-display text-text-light">
    <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">
            @include('partials.navbar')

            @include('partials.announcement')

            @if ($message = Session::get('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 m-4 rounded" role="alert">
                    <p class="font-bold">Success</p>
                    <p>{{ $message }}</p>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 m-4 rounded" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ $message }}</p>
                </div>
            @endif

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
                            <button id="joinBtn"
                                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-12 px-5 bg-accent text-primary text-base font-bold leading-normal tracking-[0.015em] hover:opacity-90 transition-opacity">
                                <span class="truncate">Join Our Church</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Welcome Introduction Section -->
                <section
                    class="w-full py-12 lg:py-16 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                    <div class="w-full px-6 lg:px-8 max-w-7xl mx-auto">

                        <div class="grid gap-8 lg:grid-cols-3 items-start">

                            <!-- Column 1: Intro (tightened) -->
                            <div class="space-y-5">
                                <span class="inline-block uppercase tracking-widest text-xs font-bold text-primary">
                                    Who We Are
                                </span>
                                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white leading-tight">
                                    A welcoming parish for every stage of faith
                                </h2>
                                <div class="space-y-4 text-gray-700 dark:text-gray-300 text-base leading-relaxed">
                                    <p>
                                        St. John's Parish Church Entebbe is more than a Sunday gathering.
                                        We are a home for seekers, families, students, and long-time believers.
                                    </p>
                                    <p>
                                        Whether you're visiting for the first time or looking for a place to belong,
                                        you’ll find warmth and meaning here.
                                    </p>
                                </div>
                            </div>

                            <!-- Column 2: Heartbeat Card (compact & beautiful) -->
                            <div
                                class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-primary/10 overflow-hidden">
                                <div class="bg-gradient-to-r from-primary to-secondary text-white px-6 py-4">
                                    <h3 class="text-2xl font-bold">Our Heartbeat</h3>
                                </div>
                                <div class="p-6 space-y-5 text-sm">
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-white mb-1">Mission</h4>
                                        <p class="text-gray-600 dark:text-gray-300">
                                            To proclaim Christ, nurture believers, and serve our community with
                                            compassion.
                                        </p>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-white mb-1">Vision</h4>
                                        <p class="text-gray-600 dark:text-gray-300">
                                            To be a lighthouse of hope in Entebbe — equipping disciples and reaching new
                                            generations.
                                        </p>
                                    </div>
                                    <div
                                        class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <div class="text-center">
                                            <div class="text-3xl font-bold text-primary">1948</div>
                                            <div class="text-xs uppercase tracking-wider text-gray-500">Founded</div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-3xl font-bold text-primary">600+</div>
                                            <div class="text-xs uppercase tracking-wider text-gray-500">Members</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 3: Two small cards (tight & clean) -->
                            <div class="space-y-5">
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow border border-gray-200 dark:border-gray-700">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">What to Expect</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                                        Friendly greeters, uplifting worship, and practical biblical teaching.
                                        Come as you are — we’ll save you a seat.
                                    </p>
                                </div>

                                <div
                                    class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow border border-gray-200 dark:border-gray-700">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Ways to Connect
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
                                        Small groups, outreach teams, youth & adult programs — there’s a place for you.
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
                
                <!-- church ministeries and groups -->
                <section class="py-16 bg-gray-50 dark:bg-gray-900">
                    <div class="container mx-auto px-6 lg:px-8">
                        <div class="text-center mb-12">
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                                Church Groups & Ministries
                            </h2>
                            <p class="mt-3 text-gray-600 dark:text-gray-400">
                                Find your place to belong, grow, and serve
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                            <!-- Fathers Union -->
                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 dark:border-gray-700">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                                        <span class="material-symbols-outlined text-primary text-2xl">group</span>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">Fathers Union</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                                            A community of men committed to leadership, fellowship and spiritual growth.
                                        </p>

                                        <!-- CLEAR BUTTON - impossible to miss -->
                                        <button
                                            class="joinGroupBtn mt-4 w-full bg-primary text-white text-sm font-semibold py-2.5 px-4 rounded-lg hover:bg-secondary hover:shadow-md transform hover:scale-105 transition-all duration-200 shadow"
                                            data-group="Fathers Union">
                                            Join Group
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Mothers Union -->
                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 dark:border-gray-700">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-pink-100 dark:bg-pink-900/30 rounded-xl flex items-center justify-center">
                                        <span
                                            class="material-symbols-outlined text-pink-600 dark:text-pink-400 text-2xl">diversity_3</span>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">Mothers Union</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                                            Women united in prayer, service, and building strong Christian homes.
                                        </p>
                                        <button
                                            class="joinGroupBtn mt-4 w-full bg-primary text-white text-sm font-semibold py-2.5 px-4 rounded-lg hover:bg-secondary hover:shadow-md transform hover:scale-105 transition-all duration-200 shadow"
                                            data-group="Mothers Union">
                                            Join Group
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Worship / Choir -->
                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 dark:border-gray-700">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                                        <span
                                            class="material-symbols-outlined text-purple-600 dark:text-purple-400 text-2xl">music_note</span>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">Worship (Choir)</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                                            Leading the church in worship through music, praise and joyful singing.
                                        </p>
                                        <button
                                            class="joinGroupBtn mt-4 w-full bg-primary text-white text-sm font-semibold py-2.5 px-4 rounded-lg hover:bg-secondary hover:shadow-md transform hover:scale-105 transition-all duration-200 shadow"
                                            data-group="Worship (Choir)">
                                            Join Group
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Prayer & Spiritual Growth -->
                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 dark:border-gray-700">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                                        <span
                                            class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-2xl">volunteer_activism</span>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">Prayer & Spiritual
                                            Growth</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                                            Intercessors committed to deepening faith through prayer.
                                        </p>
                                        <button
                                            class="joinGroupBtn mt-4 w-full bg-primary text-white text-sm font-semibold py-2.5 px-4 rounded-lg hover:bg-secondary hover:shadow-md transform hover:scale-105 transition-all duration-200 shadow"
                                            data-group="Prayer & Spiritual Growth">
                                            Join Group
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Service & Outreach -->
                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 dark:border-gray-700">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                                        <span
                                            class="material-symbols-outlined text-green-600 dark:text-green-400 text-2xl">travel_explore</span>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">Service & Outreach
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                                            Bringing hope through community service, charity, and missions.
                                        </p>
                                        <button
                                            class="joinGroupBtn mt-4 w-full bg-primary text-white text-sm font-semibold py-2.5 px-4 rounded-lg hover:bg-secondary hover:shadow-md transform hover:scale-105 transition-all duration-200 shadow"
                                            data-group="Service & Outreach">
                                            Join Group
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Church Administration & Support -->
                            <div
                                class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-5 border border-gray-100 dark:border-gray-700">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center">
                                        <span
                                            class="material-symbols-outlined text-orange-600 dark:text-orange-400 text-2xl">admin_panel_settings</span>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg text-gray-900 dark:text-white">Church
                                            Administration & Support</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 leading-relaxed">
                                            Ushers, media team, protocol, and workers supporting church operations.
                                        </p>
                                        <button
                                            class="joinGroupBtn mt-4 w-full bg-primary text-white text-sm font-semibold py-2.5 px-4 rounded-lg hover:bg-secondary hover:shadow-md transform hover:scale-105 transition-all duration-200 shadow"
                                            data-group="Church Administration & Support">
                                            Join Group
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
            </main>

            @include('partials.member-modals')
            @include('partials.footer')


        </div>
    </div>

    <!-- Registration modal (hidden by default) -->
    <div id="registrationModal"
        class="fixed inset-0 z-50 hidden flex items-center justify-center px-4 py-8 overflow-y-auto bg-black/40 backdrop-blur-sm">

        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50" data-modal-backdrop></div>

        <!-- Modal Panel -->
        <div
            class="relative w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">

            <!-- Close Button -->
            <button type="button" data-modal-close
                class="absolute top-5 right-6 text-gray-400 hover:text-gray-600 text-3xl font-light transition">
                ×
            </button>

            <!-- Header -->
            <div class="bg-gradient-to-r from-[#163e7b] to-[#1e56a0] text-white px-10 py-8 text-center">
                <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight">
                    Member Registration
                </h2>
                <p class="mt-3 text-white/90 text-lg font-medium">
                    Become a part of St. John’s family today
                </p>
            </div>

            <div class="p-8 lg:p-10 max-h-[75vh] overflow-y-auto">
                <form id="memberForm" class="space-y-8" method="POST" action="{{ route('members.store') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Personal Information -->
                    <div class="bg-gray-50/70 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-2xl font-bold text-[#163e7b] mb-5 flex items-center">
                            <span class="material-symbols-outlined mr-3 text-[#163e7b]">person</span>
                            Personal Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="fullname" required
                                    class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#163e7b]/20 focus:border-[#163e7b] transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Date of Birth <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="dateOfBirth" required max="2024-12-31" min="1900-01-01"
                                    class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#163e7b]/20 focus:border-[#163e7b] transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Gender <span
                                        class="text-red-500">*</span></label>
                                <select name="gender" required
                                    class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#163e7b]/20 focus:border-[#163e7b] transition">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Marital Status <span
                                        class="text-red-500">*</span></label>
                                <select name="maritalStatus" required
                                    class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#163e7b]/20 focus:border-[#163e7b] transition">
                                    <option value="">Select Status</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="widowed">Widowed</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-gray-50/70 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-2xl font-bold text-[#163e7b] mb-5 flex items-center">
                            <span class="material-symbols-outlined mr-3 text-[#163e7b]">contact_phone</span>
                            Contact Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Phone Number <span
                                        class="text-red-500">*</span></label>
                                <input type="tel" name="phone" required
                                    class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#163e7b]/20 focus:border-[#163e7b] transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                <input type="email" name="email"
                                    class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#163e7b]/20 focus:border-[#163e7b] transition">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Residential Address
                                    (Village & Zone)</label>
                                <textarea name="address" rows="3"
                                    class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#163e7b]/20 focus:border-[#163e7b] transition resize-none"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Church Information -->
                    <div class="bg-gray-50/70 rounded-xl p-6 border border-gray-200">
                        <h3 class="text-2xl font-bold text-[#163e7b] mb-5 flex items-center">
                            <span class="material-symbols-outlined mr-3 text-[#163e7b]">church</span>
                            Church Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Date Joined <span
                                        class="text-red-500">*</span></label>
                                <input type="date" name="dateJoined" required
                                    class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#163e7b]/20 focus:border-[#163e7b] transition">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Cell (Zone) <span
                                        class="text-red-500">*</span></label>
                                <select name="cell" required
                                    class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#163e7b]/20 focus:border-[#163e7b] transition">
                                    <option value="">Select Your Cell</option>
                                    <option value="north">North Cell</option>
                                    <option value="east">East Cell</option>
                                    <option value="south">South Cell</option>
                                    <option value="west">West Cell</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Image -->
                    <div class="bg-gray-50/70 rounded-xl p-6 border border-gray-200">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Upload Photo (Optional)</label>
                        <input type="file" name="profileImage" accept="image/*"
                            class="block w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-6 file:rounded-lg file:border-0 file:bg-[#163e7b] file:text-white hover:file:bg-[#1e56a0] transition cursor-pointer">
                    </div>

                    <!-- Account Creation Option -->
                    <div class="bg-blue-50/70 rounded-xl p-6 border-2 border-blue-200">
                        <div class="flex items-start">
                            <input type="checkbox" id="createAccount" name="create_account" value="1" 
                                   class="mt-1 rounded border-gray-300 text-[#163e7b] focus:ring-[#163e7b] w-5 h-5">
                            <div class="ml-3">
                                <label for="createAccount" class="block text-sm font-semibold text-gray-800 cursor-pointer">
                                    Create an account to access services, updates, and groups
                                </label>
                                <p class="text-xs text-gray-600 mt-1">
                                    With an account, you can register for services, join groups, and track your donations online.
                                </p>
                            </div>
                        </div>

                        <!-- Password fields (hidden by default) -->
                        <div id="accountFields" class="hidden mt-5 space-y-4 pt-4 border-t border-blue-200">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password" id="password" 
                                       class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#163e7b]/20 focus:border-[#163e7b] transition"
                                       placeholder="Minimum 8 characters">
                                <p class="text-xs text-gray-500 mt-1">Choose a strong password with at least 8 characters</p>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-[#163e7b]/20 focus:border-[#163e7b] transition"
                                       placeholder="Re-enter your password">
                            </div>
                        </div>
                    </div>

                    <!-- Success Notice -->
                    <div id="formNotice"
                        class="hidden p-5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-center font-bold text-lg">
                        Member registered successfully! Redirecting...
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end pt-6">
                        <button type="submit"
                            class="px-10 py-4 bg-[#163e7b] hover:bg-[#1e56a0] text-white font-bold text-lg rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                            Complete Registration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- registration javacsript -->
    <script>
        (function () {
            const openBtn = document.getElementById('joinBtn');
            const modal = document.getElementById('registrationModal');
            const closeBtn = modal ? modal.querySelector('[data-modal-close]') : null;
            const backdrop = modal ? modal.querySelector('[data-modal-backdrop]') : null;

            function openModal() {
                if (!modal) return;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                if (!modal) return;
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }

            if (openBtn) openBtn.addEventListener('click', openModal);
            if (closeBtn) closeBtn.addEventListener('click', closeModal);
            if (backdrop) backdrop.addEventListener('click', closeModal);
            // Close on Escape
            document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeModal(); });

            // Show/hide password fields based on checkbox
            const createAccountCheckbox = document.getElementById('createAccount');
            const accountFields = document.getElementById('accountFields');
            const passwordInput = document.getElementById('password');
            const passwordConfirm = document.getElementById('password_confirmation');
            
            if (createAccountCheckbox) {
                createAccountCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        accountFields.classList.remove('hidden');
                        passwordInput.required = true;
                        passwordConfirm.required = true;
                    } else {
                        accountFields.classList.add('hidden');
                        passwordInput.required = false;
                        passwordConfirm.required = false;
                        passwordInput.value = '';
                        passwordConfirm.value = '';
                    }
                });
            }

            // Optional: simple demo submit handling (shows notice briefly)
            const form = document.getElementById('memberForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    // Show the success notice before form submits to server
                    const notice = document.getElementById('formNotice');
                    if (notice) {
                        notice.classList.remove('hidden');
                        // Allow form to submit naturally to server after a short delay for UX
                        setTimeout(() => {
                            form.submit();
                        }, 500);
                    }
                });
            }
        })();
    </script>


    <!-- JOIN GROUP MODAL -->
    <div id="joinGroupModal"
        class="fixed inset-0 z-50 hidden flex items-center justify-center px-4 bg-black/60 backdrop-blur-sm">
        <div
            class="relative w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">

            <!-- Close Button -->
            <button type="button" id="closeModalBtn"
                class="absolute top-4 right-5 text-3xl text-gray-400 hover:text-gray-700 z-10">
                ×
            </button>

            <!-- Header -->
            <div class="bg-gradient-to-r from-primary to-secondary text-white px-8 py-10 text-center">
                <h3 id="modalGroupName" class="text-2xl font-bold">Join Group</h3>
                <p class="mt-2 text-white/90">We’re so excited to have you!</p>
            </div>

            <!-- Form: only ask for email to match members lookup in DB -->
            <form id="joinGroupForm" action="{{ route('groups.join') }}" method="POST" class="p-6 space-y-5">
                @csrf
                <input type="hidden" name="group" id="groupInput">

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email <span
                            class="text-red-500">*</span></label>
                    <input type="email" name="email" required
                        class="w-full px-5 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-4 focus:ring-primary/20 focus:border-primary transition">
                    <p class="text-xs text-gray-500 mt-2">Enter your registration email. If you are not yet a member,
                        please complete full registration first.</p>
                </div>

                <!-- Success Message (hidden by default) -->
                <div id="successMessage"
                    class="hidden p-4 bg-emerald-50 border border-emerald-300 text-emerald-700 rounded-xl text-center font-bold">
                    Thank you! You’ve successfully joined <span id="successGroup"></span>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-4">
                    <button type="button" id="cancelBtn"
                        class="flex-1 py-3 border border-gray-300 dark:border-gray-600 rounded-xl font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 bg-primary hover:bg-secondary text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition">
                        Join Group
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- join javacsrip -->
    <script>
        const modal = document.getElementById('joinGroupModal');
        const groupTitle = document.getElementById('modalGroupName');
        const groupInput = document.getElementById('groupInput');
        const successGroup = document.getElementById('successGroup');
        const form = document.getElementById('joinGroupForm');

        // Open modal when any "Join Group" button is clicked
        document.querySelectorAll('.joinGroupBtn').forEach(button => {
            button.addEventListener('click', function () {
                const groupName = (this.getAttribute('data-group') || '').trim();

                groupTitle.textContent = `Join ${groupName}`;
                groupInput.value = groupName;
                successGroup.textContent = groupName;

                modal.classList.remove('hidden');
            });
        });

        // Close modal
        document.getElementById('closeModalBtn').onclick = () => modal.classList.add('hidden');
        document.getElementById('cancelBtn').onclick = () => modal.classList.add('hidden');
        modal.addEventListener('click', (e) => {
            if (e.target === modal) modal.classList.add('hidden');
        });

        // Optional: Show success & auto-close after submit (safely attach only if form exists)
        const joinForm = document.getElementById('joinGroupForm');
        if (joinForm) {
            joinForm.addEventListener('submit', function (e) {
                // allow normal submit to backend which will handle member lookup/create and pivot attach
                // show a quick success state for UX while the request completes
                setTimeout(() => {
                    const success = document.getElementById('successMessage');
                    if (success) success.classList.remove('hidden');
                    document.querySelectorAll('#joinGroupForm input, #joinGroupForm button[type="submit"]').forEach(el => el.disabled = true);
                    setTimeout(() => modal.classList.add('hidden'), 1500);
                }, 300);
            });
        }
    </script>

    <script src="script.js"></script>
</body>

</html>