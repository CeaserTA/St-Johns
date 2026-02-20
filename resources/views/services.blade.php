<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Services — St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600&family=Jost:wght@300;400;500;600&family=Material+Symbols+Outlined&display=swap" rel="stylesheet">
    @include('partials.theme-config')

    <style>
        /* Animations */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up   { animation: fadeUp 0.75s ease both; }
        .fade-up-1 { animation-delay: 0.1s; }
        .fade-up-2 { animation-delay: 0.25s; }
        .fade-up-3 { animation-delay: 0.4s; }

        /* Eyebrow pseudo-element */
        .eyebrow { display:inline-flex; align-items:center; gap:10px; font-size:10px; font-weight:600; letter-spacing:0.22em; text-transform:uppercase; color:#c8973a; }
        .eyebrow::before { content:''; display:block; width:28px; height:1px; background:#c8973a; }

        /* Page hero diagonal stripe pattern */
        .page-hero::before { content:''; position:absolute; inset:0; background:repeating-linear-gradient(45deg,transparent,transparent 40px,rgba(201,168,76,0.03) 40px,rgba(201,168,76,0.03) 41px); pointer-events:none; }

        /* Service card top-bar pseudo */
        .service-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#c8973a,#e8b96a); transform:scaleX(0); transform-origin:left; transition:transform 0.35s ease; }
        .service-card:hover::before { transform:scaleX(1); }

        /* Register card cross watermark */
        .register-card::after { content:'✝'; position:absolute; right:-12px; bottom:-28px; font-size:160px; color:rgba(200,151,58,0.05); pointer-events:none; }

        /* Modal header cross watermark */
        .modal-header::after { content:'✝'; position:absolute; right:20px; bottom:-30px; font-size:140px; color:rgba(200,151,58,0.06); pointer-events:none; }

        /* Btn slide hover */
        .btn-submit-dark { position:relative; overflow:hidden; }
        .btn-submit-dark::before { content:''; position:absolute; inset:0; background:#e8b96a; transform:translateX(-100%); transition:transform 0.3s ease; }
        .btn-submit-dark:hover::before { transform:translateX(0); }
        .btn-submit-dark span { position:relative; z-index:1; }

        /* Select arrows */
        select.field-select-dark { appearance:none; cursor:pointer; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='rgba(200,151,58,0.7)'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 18px center; }
        select.field-input-sm { appearance:none; cursor:pointer; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%236b7080'/%3E%3C/svg%3E"); background-repeat:no-repeat; background-position:right 16px center; }

        /* Form divider lines */
        .form-divider::before, .form-divider::after { content:''; flex:1; height:1px; background:#e2d9cc; }

        body  { font-family:'Jost', sans-serif; }
        .serif { font-family:'Cormorant Garamond', serif; }
    </style>
</head>

<body class="bg-[#fdf8f0] text-[#1a1a2e] overflow-x-hidden">

@include('partials.navbar')
@include('partials.announcement')

{{-- Flash messages --}}
@if ($message = Session::get('success'))
    <div class="flex items-start gap-3 px-6 py-4 mx-6 my-4 bg-[#edf7f2] border-l-4 border-[#1a7a4a] text-[#155d38] text-sm" role="alert">
        <span class="material-symbols-outlined flex-shrink-0 text-[#1a7a4a]" style="font-size:18px;">check_circle</span>
        <div><div class="font-semibold mb-0.5">Success</div>{{ $message }}</div>
    </div>
@endif
@if ($message = Session::get('error'))
    <div class="flex items-start gap-3 px-6 py-4 mx-6 my-4 bg-[#fdf2f0] border-l-4 border-[#c0392b] text-[#8b2020] text-sm" role="alert">
        <span class="material-symbols-outlined flex-shrink-0 text-[#c0392b]" style="font-size:18px;">error</span>
        <div><div class="font-semibold mb-0.5">Error</div>{{ $message }}</div>
    </div>
@endif
@if(session('show_member_registration'))
    <div class="flex items-start gap-3 px-6 py-4 mx-6 my-4 bg-[#e8f4ff] border-l-4 border-blue-500 text-blue-800 text-sm" role="alert">
        <span class="material-symbols-outlined flex-shrink-0 text-blue-500" style="font-size:18px;">info</span>
        <div>
            <div class="font-semibold mb-1">Member Registration Required</div>
            <p>You must register as a church member before creating an account. Please visit our church office or contact us to complete your member registration.</p>
            @if(session('prefill_email'))
                <p class="mt-2 text-xs opacity-80">Email: {{ session('prefill_email') }}</p>
            @endif
        </div>
    </div>
@endif

{{-- ═══════════════ PAGE HERO ═══════════════ --}}
<section class="page-hero bg-[#0c1b3a] py-14 px-10 relative overflow-hidden text-center">
    <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-[400px] leading-none pointer-events-none select-none serif"
         style="color:rgba(200,151,58,0.04);">✝</div>
    <div class="relative z-10 max-w-[700px] mx-auto">
        <p class="eyebrow fade-up fade-up-1 justify-center">Worship · Sacraments · Community</p>
        <h1 class="serif fade-up fade-up-2 font-semibold text-white leading-[0.95] tracking-tight mt-3.5 mb-5"
            style="font-size:clamp(52px,8vw,88px);">
            Our<br><em class="italic text-[#e8b96a] font-light">Services</em>
        </h1>
        <p class="fade-up fade-up-2 text-sm font-light text-white/50 leading-[1.8] max-w-[520px] mx-auto mb-2.5">
            Every service is an invitation to encounter the living God. From the beauty of the Holy Eucharist to the comfort of reconciliation — we walk with you in every season.
        </p>
        <p class="fade-up fade-up-3 serif text-[15px] italic text-white/35 mt-6">
            "Come to me, all you who are weary and burdened, and I will give you rest." — Matthew 11:28
        </p>
    </div>
</section>

{{-- ═══════════════ SERVICES GRID ═══════════════ --}}
<section class="bg-white py-14">
    <div class="max-w-[1200px] mx-auto px-10">

        <div class="text-center mb-12">
            <p class="eyebrow justify-center mb-3.5">Sacraments & Spiritual Care</p>
            <h2 class="serif font-semibold text-[#0c1b3a] leading-[1.1] mt-3 mb-4"
                style="font-size:clamp(34px,5vw,52px);">What We Offer</h2>
            <p class="text-sm text-[#6b7080] max-w-[500px] mx-auto leading-[1.75] font-light">
                Sacred moments — celebrated with reverence, warmth, and the full community of faith.
            </p>
        </div>

        @php
            $svgPaths = [
                'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                'M19 13l-7 8-7-8m14 0v-2a4 4 0 00-4-4h-2a4 4 0 00-4 4v2',
                'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                'M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L4 20V4a2 2 0 012-2h8a2 2 0 012 2v2',
                'M12 3v1m0 16v1m8.66-13l-.87.5M4.21 17.5l-.87.5M20.66 17.5l-.87-.5M4.21 6.5l-.87-.5M21 12h-1M4 12H3',
                'M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z',
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($services as $index => $service)
                <div class="service-card bg-[#fdf8f0] border border-[#e2d9cc] rounded-[2px] px-6 py-8 text-center relative overflow-hidden transition-all duration-300 hover:bg-white hover:shadow-[0_16px_48px_rgba(12,27,58,0.09)] hover:-translate-y-[3px] hover:border-transparent fade-up"
                     style="animation-delay:{{ $index * 0.07 }}s;">

                    <div class="w-14 h-14 mx-auto mb-5 bg-[#0c1b3a] rounded-[2px] flex items-center justify-center">
                        <svg class="w-[26px] h-[26px] text-[#e8b96a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $svgPaths[$index % count($svgPaths)] }}" />
                        </svg>
                    </div>

                    <div class="serif text-[21px] font-semibold text-[#0c1b3a] mb-2.5 leading-[1.2]">{{ $service->name }}</div>
                    <p class="text-[13px] text-[#6b7080] leading-[1.75] font-light mb-5">{{ $service->description }}</p>

                    @if($service->isFree())
                        <div class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-[rgba(26,122,74,0.08)] border border-[rgba(26,122,74,0.2)] text-[#1a7a4a] text-[10px] font-bold tracking-[0.16em] uppercase">
                            <span class="material-symbols-outlined" style="font-size:13px;">check_circle</span>
                            No Fee
                        </div>
                    @else
                        <div class="border-t border-[#e2d9cc] pt-4">
                            <span class="block text-[9px] tracking-[0.18em] uppercase text-[#6b7080] mb-1">Registration Fee</span>
                            <div class="serif text-[32px] font-bold text-[#0c1b3a] leading-none">{{ $service->formatted_fee }}</div>
                        </div>
                    @endif

                    @if($service->schedule)
                        <div class="inline-flex items-center gap-1.5 mt-3 text-[11px] text-[#6b7080]">
                            <span class="material-symbols-outlined text-[#c8973a]" style="font-size:13px;">calendar_month</span>
                            {{ $service->schedule }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="text-5xl opacity-30 mb-4">⛪</div>
                    <p class="serif text-[22px] text-[#6b7080]">No services listed yet</p>
                    <p class="text-[13px] text-[#bbb] mt-1.5">Please check back soon.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ═══════════════ REGISTRATION SECTION ═══════════════ --}}
<section class="bg-[#fdf8f0] py-14">
    <div class="max-w-[1200px] mx-auto px-10 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

        {{-- Left: copy --}}
        <div class="fade-up">
            <p class="eyebrow mb-4">You Are Welcome Here</p>
            <h2 class="serif font-semibold text-[#0c1b3a] leading-[1.1] mb-6"
                style="font-size:clamp(34px,5vw,52px);">
                Register for a<br>
                <em class="italic text-[#c8973a] font-light">Church Service</em>
            </h2>
            <p class="text-sm font-light text-[#4a4f5e] leading-[1.85] mb-3.5">
                We are overjoyed that you're considering joining us at <strong>St. John's Parish Church Entebbe</strong>. Every service is a sacred moment we are honoured to share with you.
            </p>
            <p class="text-sm font-light text-[#4a4f5e] leading-[1.85]">
                Whether it's baptism, confirmation, holy matrimony, or spiritual counseling — we are here to walk beside you every step of the way.
            </p>
            <div class="serif italic text-[15px] text-[#c8973a] mt-6 pl-4 border-l-2 border-[#c8973a] leading-[1.65]">
                "Where two or three are gathered in my name, there am I among them." — Matthew 18:20
            </div>
            <div class="mt-8 flex flex-col gap-4">
                @foreach(['Warm, prayerful atmosphere in every service','Trained clergy & counselors to guide you','Discreet, confidential pastoral care'] as $item)
                    <div class="flex items-center gap-3.5">
                        <div class="w-2 h-2 bg-[#c8973a] rounded-full flex-shrink-0"></div>
                        <span class="text-[13.5px] text-[#4a4f5e] font-light">{{ $item }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Right: form card --}}
        <div class="register-card fade-up fade-up-2 bg-[#0c1b3a] rounded-[2px] overflow-hidden shadow-[0_24px_64px_rgba(12,27,58,0.18)] relative">
            <div class="px-8 pt-7 pb-5 border-b border-[rgba(200,151,58,0.15)]">
                <p class="eyebrow mb-2.5">Service Registration</p>
                <h3 class="serif text-[24px] font-semibold text-white mb-1">Let Us Know<br>You're Coming</h3>
                <p class="text-[12px] text-white/40 font-light">Complete the form and our team will confirm your booking.</p>
            </div>
            <div class="px-8 py-7 relative z-10">
                <form action="{{ route('service.register') }}" method="POST">
                    @csrf
                    @auth
                        <div class="flex items-center gap-3 p-3.5 mb-5 bg-[rgba(200,151,58,0.1)] border border-[rgba(200,151,58,0.2)]">
                            <span class="material-symbols-outlined text-[#c8973a] flex-shrink-0" style="font-size:18px;">person</span>
                            <span class="text-[13px] text-white/70 font-light">
                                Registering as <strong class="text-[#e8b96a] font-medium">{{ Auth::user()->member->full_name ?? Auth::user()->name }}</strong>
                            </span>
                        </div>

                        <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-white/45 mb-2">Select a Service</label>
                        <select name="service_id" required
                                class="field-select-dark w-full px-4 py-3.5 bg-white/[0.07] border border-white/[0.12] text-white/85 font-[Jost] text-sm outline-none transition-colors duration-200 focus:border-[#c8973a]">
                            <option value="" disabled selected>Choose a service…</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" style="background:#142450; color:#fff;">
                                    {{ $service->name }}{{ !$service->isFree() ? '  ·  ' . $service->formatted_fee : '  ·  Free' }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn-submit-dark w-full mt-4 py-4 px-8 bg-[#c8973a] text-[#0c1b3a] font-[Jost] text-xs font-semibold tracking-[0.2em] uppercase border-0 cursor-pointer flex items-center justify-center gap-2.5">
                            <span>Register for Service</span>
                            <span class="material-symbols-outlined relative z-10" style="font-size:18px;">arrow_forward</span>
                        </button>

                        <p class="text-[11px] text-white/25 text-center mt-4 font-light">
                            Our team will reach out to confirm your registration within 24hrs.
                        </p>
                    @else
                        <div class="p-5 bg-[rgba(200,151,58,0.07)] border border-[rgba(200,151,58,0.18)]">
                            <p class="text-[13px] text-white/60 font-light mb-4">Please log in to register for a service. Don't have an account? Create one in seconds.</p>
                            <div class="flex gap-3">
                                <button onclick="showLoginModal()"
                                        class="flex-1 py-3 bg-[#c8973a] text-[#0c1b3a] font-[Jost] text-xs font-semibold tracking-[0.14em] uppercase border-0 cursor-pointer transition-colors duration-200 flex items-center justify-center hover:bg-[#e8b96a]">
                                    Log In
                                </button>
                                <a href="#" onclick="showQuickAccountModal(); return false;"
                                   class="flex-1 py-3 bg-transparent text-white/60 border border-white/[0.18] font-[Jost] text-xs font-medium tracking-[0.12em] uppercase transition-all duration-200 flex items-center justify-center hover:border-[#c8973a] hover:text-[#e8b96a] no-underline">
                                    Create Account
                                </a>
                            </div>
                        </div>
                    @endauth
                </form>
            </div>
        </div>

    </div>
</section>

{{-- ═══════════════ PAYMENT MODAL ═══════════════ --}}
<div id="paymentModal" class="fixed inset-0 z-[999] bg-[rgba(12,27,58,0.72)] backdrop-blur-sm hidden items-center justify-center p-5 overflow-y-auto">
    <div class="relative bg-white w-full max-w-[640px] rounded-[2px] overflow-hidden shadow-[0_32px_100px_rgba(0,0,0,0.3)]">

        <button onclick="closePaymentModal()"
                class="absolute top-4 right-5 w-9 h-9 bg-white/10 border border-white/20 rounded-full flex items-center justify-center cursor-pointer text-white/70 text-xl transition-all duration-200 hover:bg-white/20 hover:text-white z-10">×</button>

        <div class="modal-header bg-[#0c1b3a] px-11 pt-10 pb-8 relative overflow-hidden">
            <p class="eyebrow mb-2.5">Payment</p>
            <h3 class="serif text-[32px] font-semibold text-white leading-[1.1] mt-2.5 mb-1.5">Complete Your<br>Registration</h3>
            <p class="text-[13px] text-white/45 font-light">Submit payment proof to confirm your booking.</p>
        </div>

        <div class="px-11 py-9 max-h-[70vh] overflow-y-auto">

            {{-- Service detail strip --}}
            <div class="bg-[#f5ede0] border border-[#e2d9cc] px-5 py-4 mb-7 flex gap-6 flex-wrap">
                <div>
                    <span class="block text-[9px] tracking-[0.18em] uppercase text-[#6b7080] mb-0.5">Service</span>
                    <span id="modal-service-name" class="serif text-[17px] font-semibold text-[#0c1b3a]">—</span>
                </div>
                <div>
                    <span class="block text-[9px] tracking-[0.18em] uppercase text-[#6b7080] mb-0.5">Fee</span>
                    <span id="modal-service-fee" class="serif text-[17px] font-semibold text-[#c8973a]">—</span>
                </div>
                <div>
                    <span class="block text-[9px] tracking-[0.18em] uppercase text-[#6b7080] mb-0.5">Registration</span>
                    <span id="modal-registration-id" class="text-[13px] font-medium text-[#0c1b3a]">—</span>
                </div>
            </div>

            {{-- Payment methods --}}
            <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-[#0c1b3a] mb-3.5">How to Pay</label>
            <div class="flex flex-col gap-2.5 mb-7">
                <div class="border border-[#e2d9cc] px-4 py-4 flex items-start gap-3.5 transition-colors duration-200 hover:border-[#c8973a]">
                    <div class="text-[22px] flex-shrink-0 mt-0.5">📱</div>
                    <div>
                        <div class="text-[13px] font-semibold text-[#0c1b3a] mb-1">Mobile Money</div>
                        <div class="text-[12px] text-[#6b7080] font-light leading-[1.55]">
                            MTN: <strong>0772-567-789</strong> (St. John's Church)<br>
                            Airtel: <strong>0752-666-024</strong> (St. John's Church)
                        </div>
                    </div>
                </div>
                <div class="border border-[#e2d9cc] px-4 py-4 flex items-start gap-3.5 transition-colors duration-200 hover:border-[#c8973a]">
                    <div class="text-[22px] flex-shrink-0 mt-0.5">🏦</div>
                    <div>
                        <div class="text-[13px] font-semibold text-[#0c1b3a] mb-1">Bank Transfer</div>
                        <div class="text-[12px] text-[#6b7080] font-light leading-[1.55]">
                            Stanbic Bank Uganda<br>
                            A/C Name: <strong>St. John's Parish Church Entebbe</strong><br>
                            A/C No: <strong>9030XXXXXXXX</strong>
                        </div>
                    </div>
                </div>
                <div class="border border-[#e2d9cc] px-4 py-4 flex items-start gap-3.5 transition-colors duration-200 hover:border-[#c8973a]">
                    <div class="text-[22px] flex-shrink-0 mt-0.5">💵</div>
                    <div>
                        <div class="text-[13px] font-semibold text-[#0c1b3a] mb-1">Cash at Office</div>
                        <div class="text-[12px] text-[#6b7080] font-light leading-[1.55]">Mon–Fri, 9:00 AM – 5:00 PM · St. John's Parish, Entebbe</div>
                    </div>
                </div>
            </div>

            <div class="form-divider flex items-center gap-3.5 my-6 text-[#6b7080] text-[11px] tracking-[0.12em] uppercase">Submit Proof</div>

            <form id="paymentProofForm" class="flex flex-col gap-[18px]">
                @csrf
                <input type="hidden" id="proof-registration-id" name="registration_id">

                <div>
                    <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-[#0c1b3a] mb-2">
                        Payment Method Used <span class="text-[#c8973a]">*</span>
                    </label>
                    <select name="payment_method" required
                            class="field-input-sm w-full px-4 py-3 bg-[#fdf8f0] border border-[#e2d9cc] font-[Jost] text-sm text-[#1a1a2e] outline-none transition-all duration-200 focus:bg-white focus:border-[#c8973a] focus:shadow-[0_0_0_3px_rgba(200,151,58,0.1)]">
                        <option value="">Select payment method…</option>
                        <option value="mobile_money">Mobile Money (MTN / Airtel)</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="cash">Cash</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-[#0c1b3a] mb-2">
                        Transaction Reference <span class="text-[#c8973a]">*</span>
                    </label>
                    <input type="text" name="transaction_reference" required
                           class="w-full px-4 py-3 bg-[#fdf8f0] border border-[#e2d9cc] font-[Jost] text-sm text-[#1a1a2e] outline-none transition-all duration-200 focus:bg-white focus:border-[#c8973a] focus:shadow-[0_0_0_3px_rgba(200,151,58,0.1)] placeholder-[#b0b5c0]"
                           placeholder="e.g. MTN123456789">
                    <p class="text-[11px] text-[#6b7080] mt-1.5 font-light">Enter the transaction ID from your mobile money or bank receipt.</p>
                </div>

                <div>
                    <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-[#0c1b3a] mb-2">Additional Notes</label>
                    <textarea name="payment_notes" rows="2"
                              class="w-full px-4 py-3 bg-[#fdf8f0] border border-[#e2d9cc] font-[Jost] text-sm text-[#1a1a2e] outline-none transition-all duration-200 focus:bg-white focus:border-[#c8973a] resize-none placeholder-[#b0b5c0]"
                              placeholder="Any extra information…"></textarea>
                </div>

                <div class="flex gap-3.5 mt-2">
                    <button type="submit"
                            class="flex-1 py-[15px] bg-[#0c1b3a] text-[#e8b96a] font-[Jost] text-xs font-semibold tracking-[0.18em] uppercase border-0 cursor-pointer transition-colors duration-200 hover:bg-[#142450]">
                        Submit Proof
                    </button>
                    <button type="button" onclick="closePaymentModal()"
                            class="px-7 py-[15px] bg-transparent text-[#6b7080] border border-[#e2d9cc] font-[Jost] text-xs font-medium tracking-[0.12em] uppercase cursor-pointer transition-all duration-200 hover:border-[#0c1b3a] hover:text-[#0c1b3a]">
                        Pay Later
                    </button>
                </div>
            </form>

            <div class="mt-5 px-4 py-3.5 bg-[#f5ede0] border-l-4 border-[#c8973a] text-[12px] text-[#6b7080] leading-[1.6] font-light">
                <strong class="text-[#0c1b3a] font-semibold">Note:</strong> Your registration is confirmed. Payment verification may take up to 24 hours — we'll send a confirmation once approved.
            </div>
        </div>
    </div>
</div>

@include('partials.member-modals')
@include('partials.login-modal')
@include('partials.quick-account-modal')
@include('partials.footer')

<script>
let currentRegistrationData = null;

@if(session('show_payment_modal') && session('registration_data'))
    document.addEventListener('DOMContentLoaded', function () {
        showPaymentModal(@json(session('registration_data')));
    });
@endif

@if(session('show_account_creation'))
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function() {
            if (typeof showQuickAccountModal === 'function') {
                showQuickAccountModal();
                @if(session('prefill_email'))
                    const emailInput = document.getElementById('quickAccountEmail');
                    if (emailInput) emailInput.value = '{{ session('prefill_email') }}';
                @endif
            }
        }, 300);
    });
@endif

@if(session('show_member_registration'))
    document.addEventListener('DOMContentLoaded', function () {
        setTimeout(function() {
            if (typeof showMemberRegistrationModal === 'function') {
                showMemberRegistrationModal();
                @if(session('prefill_email'))
                    const emailInput = document.querySelector('#memberRegistrationModal input[name="email"]');
                    if (emailInput) emailInput.value = '{{ session('prefill_email') }}';
                @endif
                showToast('Please register as a church member first before creating an account.', 'info');
            } else {
                showToast('Please register as a church member first before creating an account.', 'info');
            }
        }, 300);
    });
@endif

function showPaymentModal(data) {
    currentRegistrationData = data;
    document.getElementById('modal-service-name').textContent    = data.service_name;
    document.getElementById('modal-service-fee').textContent     = data.service_fee;
    document.getElementById('modal-registration-id').textContent = '#' + data.registration_id;
    document.getElementById('proof-registration-id').value       = data.registration_id;
    const modal = document.getElementById('paymentModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closePaymentModal() {
    const modal = document.getElementById('paymentModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
    document.getElementById('paymentProofForm').reset();
}

document.getElementById('paymentModal').addEventListener('click', function (e) {
    if (e.target === this) closePaymentModal();
});
document.addEventListener('keydown', e => { if (e.key === 'Escape') closePaymentModal(); });

document.getElementById('paymentProofForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const submit = this.querySelector('[type=submit]');
    const orig   = submit.textContent;
    submit.disabled = true;
    submit.textContent = 'Submitting…';
    try {
        const res  = await fetch('{{ route("service.payment.proof") }}', {
            method: 'POST',
            body: new FormData(this),
            headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value }
        });
        const data = await res.json();
        if (data.success) {
            closePaymentModal();
            showToast('Payment proof submitted! We\'ll verify and confirm within 24 hours.', 'success');
            setTimeout(() => window.location.reload(), 2500);
        } else {
            showToast(data.message || 'Failed to submit. Please try again.', 'error');
        }
    } catch {
        showToast('Something went wrong. Please try again.', 'error');
    } finally {
        submit.disabled = false;
        submit.textContent = orig;
    }
});

function showToast(msg, type = 'success') {
    const t = document.createElement('div');
    const styles = {
        success: 'background:#0c1b3a; color:#e8b96a; border-left:3px solid #c8973a;',
        error:   'background:#fff; color:#c0392b; border-left:3px solid #c0392b; box-shadow:0 8px 24px rgba(0,0,0,.12);',
        info:    'background:#fff; color:#0c1b3a; border-left:3px solid #3b82f6; box-shadow:0 8px 24px rgba(0,0,0,.12);',
    };
    t.style.cssText = `position:fixed; top:24px; right:24px; z-index:9999; padding:16px 22px; min-width:280px; font-family:'Jost',sans-serif; font-size:13px; border-radius:2px; animation:fadeUp .3s ease both; ${styles[type] || styles.success}`;
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 5000);
}
</script>
</body>
</html>