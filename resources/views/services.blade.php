<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Services - St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700" rel="stylesheet" />

    @include('partials.theme-config')
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-text-light dark:text-text-dark min-h-screen">

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

<!-- Services Page Hero – Shorter & Cleaner -->
<!-- HERO – Wider, breathes better, no wasted space -->
<section class="py-16 bg-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-12"> <!-- Wider container + more padding on large screens -->
        <div class="text-center max-w-4xl mx-auto"> <!-- Text stays readable but not cramped -->
            <p class="text-accent font-bold uppercase tracking-widest text-xs mb-3">
                Worship • Sacraments • Community
            </p>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-primary leading-tight mb-6">
                Our Services
            </h1>
            <div class="w-20 h-1 bg-accent mx-auto mb-8"></div>

            <div class="space-y-4 text-base md:text-lg text-gray-700 leading-relaxed">
                <p>
                    At <span class="text-primary font-semibold">St. John’s Parish Church Entebbe</span>, every service
                    is an invitation to encounter the living God.
                </p>
                <p class="text-gray-600">
                    Whether through the beauty of the Holy Eucharist, the joy of baptism and marriage, the comfort of
                    reconciliation, or the hope of Christian burial — we are here to walk with you in every season of faith and life.
                </p>
                <p class="italic text-secondary font-medium">
                    "Come to me, all you who are weary and burdened, and I will give you rest." — Matthew 11:28
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Church Services Grid – Tighter & Faster -->
<section class="py-12 bg-gray-50 dark:bg-gray-900"> <!-- Reduced padding -->
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-10">
            <p class="text-accent font-bold uppercase tracking-widest text-xs mb-2">
                Sacraments & Spiritual Care
            </p>
            <h2 class="text-4xl font-black text-primary mb-3">Our Services</h2>
            <div class="w-20 h-1 bg-accent mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6"> <!-- Reduced gap-8 → gap-6 -->

            <!-- Confirmation -->
            <div class="bg-white rounded-3xl p-6 shadow hover:shadow-xl transition-all border border-gray-100 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-accent/10 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-primary mb-3">Confirmation</h3>
                <p class="text-sm text-gray-600 leading-snug">
                    A powerful moment of personal commitment as young people and adults affirm their baptismal vows
                    and receive the strengthening gift of the Holy Spirit.
                </p>
            </div>

            <!-- Baptism -->
            <div class="bg-white rounded-3xl p-6 shadow hover:shadow-xl transition-all border border-gray-100 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-primary/10 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 13l-7 8-7-8m14 0v-2a4 4 0 00-4-4h-2a4 4 0 00-4 4v2"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-primary mb-3">Baptism</h3>
                <p class="text-sm text-gray-600 leading-snug">
                    The joyous beginning of Christian life — welcoming infants, children, and adults into God’s
                    family through water and the Holy Spirit.
                </p>
            </div>

            <!-- Holy Matrimony -->
            <div class="bg-white rounded-3xl p-6 shadow hover:shadow-xl transition-all border border-gray-100 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-secondary/10 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-primary mb-3">Holy Matrimony</h3>
                <p class="text-sm text-gray-600 leading-snug">
                    Celebrating the sacred covenant of marriage — two lives becoming one under God’s blessing,
                    surrounded by family and prayer.
                </p>
            </div>

            <!-- Counseling -->
            <div class="bg-white rounded-3xl p-6 shadow hover:shadow-xl transition-all border border-gray-100 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-accent/10 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L4 20V4a2 2 0 012-2h8a2 2 0 012 2v2"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-primary mb-3">Counseling</h3>
                <p class="text-sm text-gray-600 leading-snug">
                    Compassionate, confidential guidance from our clergy and trained counselors for life’s
                    challenges, marriage preparation, grief, and spiritual growth.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- SERVICE REGISTRATION – EVEN SHORTER -->
<section class="py-12 bg-white"> <!-- Reduced from py-20 → py-12 -->
    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-10 items-center">

        <div class="space-y-6">
            <p class="text-secondary font-bold uppercase tracking-widest text-xs mb-2">
                You Are Welcome Here
            </p>
            <h2 class="text-4xl md:text-5xl font-black leading-tight text-primary">
                Register for a<br>
                <span class="text-secondary">Church Service</span>
            </h2>

            <div class="space-y-4 text-base text-gray-800">
                <p>
                    We are overjoyed that you’re considering joining us at
                    <strong>St. John’s Parish Church Entebbe</strong>.
                </p>
                <p>
                    Whether it’s baptism, confirmation, holy matrimony, or spiritual counseling — 
                    we are here to walk with you every step of the way.
                </p>
                <p class="italic text-secondary font-medium">
                    “Where two or three are gathered in my name, there am I among them.” — Matthew 18:20
                </p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-8 border border-gray-100">
            <h3 class="text-2xl font-bold text-center mb-6 text-primary">
                Let Us Know You're Coming
            </h3>

            <form action="{{ route('service.register') }}" method="POST" class="space-y-5">
                @csrf
                <!-- All your fields – same as before, just tighter spacing -->
                <div class="grid sm:grid-cols-2 gap-5">
                    <input name="fullname" type="text" required placeholder="Full Name *" class="px-5 py-3 border border-gray-300 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
                    <input name="email" type="email" required placeholder="Email *" class="px-5 py-3 border border-gray-300 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
                </div>
                <input name="address" type="text" placeholder="Address" class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
                <input name="contact" type="tel" placeholder="Contact Number" class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
                <select name="service" required class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:border-secondary focus:ring-4 focus:ring-secondary/10 transition">
                    <option value="" disabled selected>Choose a service...</option>
                    <option value="Confirmation">Confirmation</option>
                    <option value="Baptism">Baptism</option>
                    <option value="Holy Matrimony">Holy Matrimony</option>
                    <option value="Counseling">Counseling</option>
                    <option value="Sunday Service Visit">Sunday Service Visit</option>
                </select>

                <button type="submit" class="w-full bg-secondary hover:bg-red-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
                    Submit Registration →
                </button>
            </form>
        </div>
    </div>
</section>

    @include('partials.footer')
</body>

</html>