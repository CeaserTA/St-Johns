<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600&family=Jost:wght@300;400;500;600&family=Material+Symbols+Outlined&display=swap" rel="stylesheet">
    @include('partials.theme-config')

    <style>
        /* Animations — cannot be done in Tailwind CDN without config */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up   { animation: fadeUp 0.8s ease both; }
        .fade-up-1 { animation-delay: 0.1s; }
        .fade-up-2 { animation-delay: 0.25s; }
        .fade-up-3 { animation-delay: 0.4s; }

        @keyframes bounce {
            0%, 100% { transform: translateY(0) rotate(45deg); }
            50%       { transform: translateY(6px) rotate(45deg); }
        }
        .scroll-arrow {
            width: 18px; height: 18px;
            border-right: 1.5px solid rgba(255,255,255,0.3);
            border-bottom: 1.5px solid rgba(255,255,255,0.3);
            transform: rotate(45deg);
            animation: bounce 2s infinite;
        }

        /* Eyebrow — pseudo-element line can't be done in Tailwind */
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: #c8973a;
        }
        .eyebrow::before {
            content: '';
            display: block;
            width: 28px;
            height: 1px;
            background: #c8973a;
        }

        /* Connect card left-bar hover — pseudo-element */
        .connect-card::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: #c8973a;
            transform: scaleY(0);
            transform-origin: bottom;
            transition: transform 0.25s;
        }
        .connect-card:hover::before { transform: scaleY(1); }

        /* Group card bottom bar — pseudo-element */
        .group-card::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, #c8973a, #e8b96a);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.35s ease;
        }
        .group-card:hover::after { transform: scaleX(1); }

        /* Heartbeat card cross watermark */
        .heartbeat-card::after {
            content: '✝';
            position: absolute;
            right: -10px; bottom: -20px;
            font-size: 120px;
            color: rgba(200,151,58,0.06);
            pointer-events: none;
        }

        /* Modal header cross watermark */
        .modal-header::after {
            content: '✝';
            position: absolute;
            right: 20px; bottom: -30px;
            font-size: 140px;
            color: rgba(200,151,58,0.07);
            pointer-events: none;
        }

        /* Select arrow */
        select.field-input {
            appearance: none;
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%236b7080'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
        }

        /* Button hover slide effect — requires pseudo-element */
        .btn-primary { position: relative; overflow: hidden; }
        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: #e8b96a;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        .btn-primary:hover::before { transform: translateX(0); }
        .btn-primary span { position: relative; z-index: 1; }

        /* Account fields hidden/show */
        .account-fields { display: none; grid-template-columns: 1fr 1fr; gap: 18px; }
        .account-fields.visible { display: grid; }

        /* Font families */
        .serif { font-family: 'Cormorant Garamond', serif; }
        body   { font-family: 'Jost', sans-serif; }
    </style>
</head>

<body class="bg-[#fdf8f0] text-[#1a1a2e] overflow-x-hidden">
<div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">
<div class="flex h-full grow flex-col">

    @include('partials.navbar')
    @include('partials.announcement')

    {{-- Flash messages --}}
    @if ($message = Session::get('success'))
        <div class="flex items-start gap-3 px-6 py-4 mx-6 my-4 rounded bg-[#edf7f2] border-l-4 border-[#1a7a4a] text-[#155d38] text-sm" role="alert">
            <span class="material-symbols-outlined flex-shrink-0 text-[#1a7a4a]" style="font-size:18px;">check_circle</span>
            <div><div class="font-semibold mb-0.5">Success</div>{{ $message }}</div>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="flex items-start gap-3 px-6 py-4 mx-6 my-4 rounded bg-[#fdf2f0] border-l-4 border-[#c0392b] text-[#8b2020] text-sm" role="alert">
            <span class="material-symbols-outlined flex-shrink-0 text-[#c0392b]" style="font-size:18px;">error</span>
            <div><div class="font-semibold mb-0.5">Error</div>{{ $message }}</div>
        </div>
    @endif

    <main class="flex-grow w-full">

        {{-- ═══════════════ HERO ═══════════════ --}}
        <section class="relative min-h-[75vh] flex items-center justify-center overflow-hidden">

            {{-- Background --}}
            <div class="absolute inset-0 bg-cover bg-center scale-[1.03] hover:scale-100 transition-transform duration-[8000ms]"
                 style="background-image: linear-gradient(to bottom, rgba(12,27,58,0.55) 0%, rgba(12,27,58,0.75) 60%, rgba(12,27,58,0.92) 100%), url('https://lh3.googleusercontent.com/aida-public/AB6AXuBJuBVtqw9UvSxdwxXR4HOoRKNwjmp9luc3fMocyA9NTqdPQivYkifWnUaMwnjyQq3T4squ6UlhiwnVUaXW1dGBb9iQTqAWj2ZWY0cDsr8_w0zYXf4_sbb551OYF9iq1ViLJ1oSTTDppAlvmUWZuWIo8Etdwaaf_zx3Twh1p4XfM8eHKL64rCtraA9U_aCR3AJcZ_L-6y2nwV4LQ3nNURKG3gPTol5sCwQWKy93zdr-wzJtb_VykEtdfU3XC_2Nsxabk4C2zBpbrrgU'); background-position: center 30%;">
            </div>

            {{-- Cross watermark --}}
            <div class="absolute right-[8%] top-1/2 -translate-y-1/2 text-[320px] leading-none pointer-events-none select-none serif"
                 style="color: rgba(200,151,58,0.07);">✝</div>

            {{-- Hero Content --}}
            <div class="relative z-10 text-center max-w-[780px] px-6">

                <div class="fade-up fade-up-1 flex items-center justify-center gap-3.5 text-[11px] font-semibold tracking-[0.28em] uppercase text-[#e8b96a] mb-6">
                    <span class="w-10 h-px bg-[#c8973a] opacity-70"></span>
                    St. John's Parish Church · Entebbe
                    <span class="w-10 h-px bg-[#c8973a] opacity-70"></span>
                </div>

                <h1 class="serif fade-up fade-up-2 font-semibold text-white leading-[0.95] tracking-tight mb-7"
                    style="font-size: clamp(56px, 9vw, 100px);">
                    Welcome<br>
                    <em class="italic text-[#e8b96a] font-light">Home</em>
                </h1>

                <p class="fade-up fade-up-2 text-sm font-light tracking-[0.18em] uppercase text-white/60 mb-12">
                    Growing in Faith Together
                </p>

                <p class="fade-up fade-up-3 serif text-base italic text-white/50 mb-12 leading-relaxed">
                    "Let us not grow weary in doing good,<br>for in due season we will reap." — Gal. 6:9
                </p>

                <div class="fade-up fade-up-3 flex items-center justify-center gap-4 flex-wrap">
                    <button id="joinBtn"
                        class="btn-primary inline-flex items-center gap-2.5 px-10 py-4 bg-[#c8973a] text-[#0c1b3a] text-xs font-semibold tracking-[0.18em] uppercase border-0 cursor-pointer transition-all duration-300">
                        <span>Join Our Church</span>
                    </button>
                    <a href="#groups"
                       class="inline-flex items-center gap-2.5 px-[38px] py-[15px] bg-transparent text-white text-xs font-medium tracking-[0.18em] uppercase border border-white/35 transition-all duration-300 hover:border-[#c8973a] hover:text-[#e8b96a] no-underline">
                        Explore Groups
                    </a>
                </div>
            </div>

            {{-- Scroll hint --}}
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center gap-1.5 text-white/35 text-[9px] tracking-[0.2em] uppercase">
                <div class="scroll-arrow"></div>
                <span>Scroll</span>
            </div>
        </section>

        {{-- ═══════════════ ABOUT ═══════════════ --}}
        <section class="about-section bg-white py-16 relative" id="about">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-[1200px] mx-auto px-10">

                {{-- Col 1: Intro --}}
                <div class="fade-up">
                    <p class="eyebrow mb-4">Who We Are</p>
                    <h2 class="serif text-[36px] font-semibold text-[#0c1b3a] leading-[1.1] mb-6">
                        A welcoming parish for every stage of faith
                    </h2>
                    <p class="text-[15px] leading-[1.85] text-[#4a4f5e] mb-4 font-light">
                        St. John's Parish Church Entebbe is more than a Sunday gathering — we are a home for seekers, families, students, and long-time believers.
                    </p>
                    <p class="text-[15px] leading-[1.85] text-[#4a4f5e] font-light">
                        Whether you're visiting for the first time or looking for a place to belong, you'll find warmth and meaning here.
                    </p>
                    <div class="mt-7 flex flex-col gap-4">
                        <div class="connect-card bg-[#f5ede0] border border-[#e2d9cc] rounded-[2px] p-6 relative transition-all duration-300 hover:border-[#c8973a] hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(200,151,58,0.1)]">
                            <h3 class="serif text-[20px] font-semibold text-[#0c1b3a] mb-2">What to Expect</h3>
                            <p class="text-[13.5px] text-[#6b7080] leading-[1.7] font-light">Friendly greeters, uplifting worship, and practical biblical teaching. Come as you are — we'll save you a seat.</p>
                        </div>
                        <div class="connect-card bg-[#f5ede0] border border-[#e2d9cc] rounded-[2px] p-6 relative transition-all duration-300 hover:border-[#c8973a] hover:-translate-y-0.5 hover:shadow-[0_8px_24px_rgba(200,151,58,0.1)]">
                            <h3 class="serif text-[20px] font-semibold text-[#0c1b3a] mb-2">Ways to Connect</h3>
                            <p class="text-[13.5px] text-[#6b7080] leading-[1.7] font-light">Small groups, outreach teams, youth & adult programs — there's a meaningful place for you here.</p>
                        </div>
                    </div>
                </div>

                {{-- Col 2: Heartbeat --}}
                <div class="heartbeat-card fade-up fade-up-1 bg-[#0c1b3a] rounded-[2px] overflow-hidden shadow-[0_20px_60px_rgba(12,27,58,0.18)] relative">
                    <div class="px-7 pt-7 pb-5 border-b border-[rgba(200,151,58,0.2)]">
                        <h3 class="serif text-[26px] font-semibold text-white mb-1">Our Heartbeat</h3>
                        <p class="text-[11px] tracking-[0.14em] uppercase text-[#c8973a] font-medium">Mission & Vision</p>
                    </div>
                    <div class="p-7">
                        <div class="mb-5">
                            <h4 class="text-[10px] font-semibold tracking-[0.16em] uppercase text-[#c8973a] mb-1.5">Mission</h4>
                            <p class="text-[13.5px] leading-[1.7] text-white/65 font-light">To proclaim Christ, nurture believers, and serve our community with compassion and grace.</p>
                        </div>
                        <div class="mb-5">
                            <h4 class="text-[10px] font-semibold tracking-[0.16em] uppercase text-[#c8973a] mb-1.5">Vision</h4>
                            <p class="text-[13.5px] leading-[1.7] text-white/65 font-light">To be a lighthouse of hope in Entebbe — equipping disciples and reaching new generations for Christ.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 border-t border-[rgba(200,151,58,0.15)]">
                        <div class="py-5 px-7 text-center border-r border-[rgba(200,151,58,0.15)]">
                            <span class="serif text-[38px] font-semibold text-[#e8b96a] leading-none block">1948</span>
                            <span class="text-[9px] tracking-[0.18em] uppercase text-white/40 mt-1 block">Founded</span>
                        </div>
                        <div class="py-5 px-7 text-center">
                            <span class="serif text-[38px] font-semibold text-[#e8b96a] leading-none block">600+</span>
                            <span class="text-[9px] tracking-[0.18em] uppercase text-white/40 mt-1 block">Members</span>
                        </div>
                    </div>
                </div>

                {{-- Col 3: Values --}}
                <div class="fade-up fade-up-2">
                    <p class="eyebrow mb-5">Core Values</p>
                    @foreach([
                        ['✝', 'Worship', 'We gather to exalt God through song, prayer, and the Word.'],
                        ['🤝', 'Community', 'We believe life is richer when lived in authentic relationship.'],
                        ['🌍', 'Mission', 'We actively serve Entebbe and beyond with love in action.'],
                        ['📖', 'Discipleship', 'We grow together through scripture, mentorship, and accountability.'],
                    ] as $val)
                    <div class="flex gap-4 py-5 border-b border-[#e2d9cc]">
                        <span class="text-[22px] flex-shrink-0 mt-0.5">{{ $val[0] }}</span>
                        <div>
                            <div class="serif text-[17px] font-semibold text-[#0c1b3a] mb-1">{{ $val[1] }}</div>
                            <div class="text-[13px] text-[#6b7080] leading-[1.65] font-light">{{ $val[2] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>

        {{-- ═══════════════ GROUPS ═══════════════ --}}
        <section class="bg-[#fdf8f0] py-16" id="groups">
            <div class="max-w-[1200px] mx-auto px-10">
                <div class="text-center mb-14">
                    <p class="eyebrow justify-center mb-3.5">Find Your Place</p>
                    <h2 class="serif font-semibold text-[#0c1b3a] leading-[1.1] mt-3 mb-4" style="font-size: clamp(36px, 5vw, 54px);">Church Groups & Ministries</h2>
                    <p class="text-[15px] font-light text-[#6b7080] max-w-[520px] mx-auto leading-[1.7]">Every person belongs somewhere. Discover a community where your gifts are welcomed and your faith grows.</p>
                </div>

                {{-- 4-column grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                        $groupStyles = [
                            ['icon' => 'group',                'bg' => 'background:#0c1b3a; color:#e8b96a;'],
                            ['icon' => 'diversity_3',          'bg' => 'background:#fce7f3; color:#be185d;'],
                            ['icon' => 'music_note',           'bg' => 'background:#f3e8ff; color:#7c3aed;'],
                            ['icon' => 'volunteer_activism',   'bg' => 'background:#dbeafe; color:#1d4ed8;'],
                            ['icon' => 'travel_explore',       'bg' => 'background:#d1fae5; color:#065f46;'],
                            ['icon' => 'admin_panel_settings', 'bg' => 'background:#fff7ed; color:#c2410c;'],
                        ];
                        $memberGroupIds = $memberGroupIds ?? [];
                    @endphp

                    @forelse($groups as $group)
                        @php
                            $style = $groupStyles[$loop->index % count($groupStyles)];
                            $alreadyMember = in_array($group->id, $memberGroupIds);
                            $canJoin = auth()->check() && auth()->user()->member && !$alreadyMember;
                            $displayIcon = $group->icon ?: $style['icon'];
                        @endphp
                        <div class="group-card bg-white border border-[#e2d9cc] rounded-[2px] overflow-hidden transition-all duration-300 relative hover:shadow-[0_16px_48px_rgba(12,27,58,0.1)] hover:-translate-y-[3px] hover:border-transparent">

                            <div class="p-7 pb-0 flex items-start gap-4">
                                <div class="w-12 h-12 rounded-[2px] flex items-center justify-center flex-shrink-0 text-[22px]" style="{{ $style['bg'] }}">
                                    @if($group->image_url)
                                        <img src="{{ $group->image_url }}" alt="{{ $group->name }}" class="w-full h-full object-cover rounded-[2px]">
                                    @else
                                        <span class="material-symbols-outlined" style="font-size:22px;">{{ $displayIcon }}</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="serif text-[20px] font-semibold text-[#0c1b3a] leading-[1.2] mb-1">{{ $group->name }}</div>
                                    @if($group->meeting_day || $group->location)
                                        <div class="text-[11px] text-[#6b7080] flex items-center gap-1.5">
                                            {{ $group->meeting_day }}{{ $group->meeting_day && $group->location ? ' · ' : '' }}{{ $group->location }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="p-7 pt-4">
                                <p class="text-[13.5px] text-[#6b7080] leading-[1.75] font-light mb-6">
                                    {{ $group->description ?: 'Join this group to grow in faith and fellowship with fellow believers.' }}
                                </p>

                                @if($alreadyMember)
                                    <div class="w-full py-3 px-5 flex items-center justify-center gap-2 text-[#1a7a4a] text-[11px] font-semibold tracking-[0.14em] uppercase border border-[rgba(26,122,74,0.3)]">
                                        <span class="material-symbols-outlined" style="font-size:16px;">check_circle</span>
                                        Member
                                    </div>
                                @elseif($canJoin)
                                    <button class="joinGroupBtn w-full py-3 px-5 bg-[#0c1b3a] text-[#e8b96a] text-[11px] font-semibold tracking-[0.16em] uppercase border-0 cursor-pointer transition-all duration-200 flex items-center justify-center gap-2 hover:bg-[#142450]"
                                            data-group="{{ $group->name }}">
                                        <span>Join Group</span>
                                        <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span>
                                    </button>
                                @elseif(auth()->check() && !auth()->user()->member)
                                    <div class="w-full py-3 px-5 bg-[#f5ede0] text-[#6b7080] text-[11px] font-medium tracking-[0.1em] uppercase border border-[#e2d9cc] flex items-center justify-center text-center">
                                        Complete registration to join
                                    </div>
                                @else
                                    <button onclick="showLoginModal()"
                                            class="w-full py-3 px-5 bg-transparent text-[#0c1b3a] text-[11px] font-semibold tracking-[0.14em] uppercase border border-[#e2d9cc] cursor-pointer transition-all duration-200 flex items-center justify-center gap-2 hover:border-[#0c1b3a] no-underline">
                                        <span class="material-symbols-outlined" style="font-size:16px;">lock</span>
                                        Log in to join
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-16 px-8">
                            <div class="text-5xl text-[#e2d9cc] mb-4">⛪</div>
                            <p class="serif text-[20px] text-[#6b7080]">No groups available yet</p>
                            <small class="text-[13px] text-[#bbb]">Check back soon — something wonderful is coming.</small>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

    </main>

    @include('partials.member-modals')
    @include('partials.login-modal')
    @include('partials.footer')
</div>
</div>

{{-- ═══════════════ REGISTRATION MODAL ═══════════════ --}}
<div id="registrationModal" class="fixed inset-0 z-[999] bg-[rgba(12,27,58,0.7)] backdrop-blur-sm hidden items-center justify-center p-5 overflow-y-auto">
    <div class="relative bg-white w-full max-w-[720px] rounded-[2px] overflow-hidden shadow-[0_32px_100px_rgba(0,0,0,0.3)] animate-[fadeUp_0.35s_ease_both]">
        <button type="button" data-modal-close
                class="absolute top-4 right-5 w-9 h-9 bg-white/10 border border-white/20 rounded-full flex items-center justify-center cursor-pointer text-white/70 text-xl transition-all duration-200 hover:bg-white/20 hover:text-white z-10">×</button>

        <div class="modal-header bg-[#0c1b3a] px-12 pt-11 pb-9 relative overflow-hidden">
            <p class="eyebrow mb-2.5">St. John's Parish · Entebbe</p>
            <h2 class="serif text-[38px] font-semibold text-white leading-[1.1] mb-2">Member<br>Registration</h2>
            <p class="text-[13px] text-white/50 font-light">Become part of the St. John's family today</p>
        </div>

        <div class="p-12 max-h-[70vh] overflow-y-auto">
            <form id="memberForm" method="POST" action="{{ route('members.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Personal Info --}}
                <div class="mb-9">
                    <div class="flex items-center gap-2.5 serif text-[20px] font-semibold text-[#0c1b3a] pb-3 border-b border-[#e2d9cc] mb-6">
                        <span class="material-symbols-outlined text-[#c8973a]" style="font-size:20px;">person</span>
                        Personal Information
                    </div>
                    <div class="grid grid-cols-2 gap-[18px]">
                        <div>
                            <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-[#0c1b3a] mb-2">Full Name<span class="text-[#c8973a] ml-0.5">*</span></label>
                            <input type="text" name="fullname" required class="field-input w-full px-4 py-3.5 bg-[#fdf8f0] border border-[#e2d9cc] font-[Jost] text-sm text-[#1a1a2e] outline-none transition-all duration-200 focus:bg-white focus:border-[#c8973a] focus:shadow-[0_0_0_3px_rgba(200,151,58,0.1)] placeholder-[#b0b5c0]" placeholder="Your full name">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-[#0c1b3a] mb-2">Date of Birth<span class="text-[#c8973a] ml-0.5">*</span></label>
                            <input type="date" name="dateOfBirth" required max="2024-12-31" min="1900-01-01" class="field-input w-full px-4 py-3.5 bg-[#fdf8f0] border border-[#e2d9cc] font-[Jost] text-sm text-[#1a1a2e] outline-none transition-all duration-200 focus:bg-white focus:border-[#c8973a] focus:shadow-[0_0_0_3px_rgba(200,151,58,0.1)]">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-[#0c1b3a] mb-2">Gender<span class="text-[#c8973a] ml-0.5">*</span></label>
                            <select name="gender" required class="field-input w-full px-4 py-3.5 bg-[#fdf8f0] border border-[#e2d9cc] font-[Jost] text-sm text-[#1a1a2e] outline-none transition-all duration-200 focus:bg-white focus:border-[#c8973a]">
                                <option value="">Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-[#0c1b3a] mb-2">Marital Status<span class="text-[#c8973a] ml-0.5">*</span></label>
                            <select name="maritalStatus" required class="field-input w-full px-4 py-3.5 bg-[#fdf8f0] border border-[#e2d9cc] font-[Jost] text-sm text-[#1a1a2e] outline-none transition-all duration-200 focus:bg-white focus:border-[#c8973a]">
                                <option value="">Select status</option>
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                                <option value="divorced">Divorced</option>
                                <option value="widowed">Widowed</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Contact Info --}}
                <div class="mb-9">
                    <div class="flex items-center gap-2.5 serif text-[20px] font-semibold text-[#0c1b3a] pb-3 border-b border-[#e2d9cc] mb-6">
                        <span class="material-symbols-outlined text-[#c8973a]" style="font-size:20px;">contact_phone</span>
                        Contact Information
                    </div>
                    <div class="grid grid-cols-2 gap-[18px]">
                        <div>
                            <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-[#0c1b3a] mb-2">Phone Number<span class="text-[#c8973a] ml-0.5">*</span></label>
                            <input type="tel" name="phone" required class="field-input w-full px-4 py-3.5 bg-[#fdf8f0] border border-[#e2d9cc] font-[Jost] text-sm text-[#1a1a2e] outline-none transition-all duration-200 focus:bg-white focus:border-[#c8973a] focus:shadow-[0_0_0_3px_rgba(200,151,58,0.1)] placeholder-[#b0b5c0]" placeholder="+256 ...">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-[#0c1b3a] mb-2">Email Address</label>
                            <input type="email" name="email" class="field-input w-full px-4 py-3.5 bg-[#fdf8f0] border border-[#e2d9cc] font-[Jost] text-sm text-[#1a1a2e] outline-none transition-all duration-200 focus:bg-white focus:border-[#c8973a] focus:shadow-[0_0_0_3px_rgba(200,151,58,0.1)] placeholder-[#b0b5c0]" placeholder="you@example.com">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-[#0c1b3a] mb-2">Residential Address</label>
                            <textarea name="address" rows="2" class="field-input w-full px-4 py-3.5 bg-[#fdf8f0] border border-[#e2d9cc] font-[Jost] text-sm text-[#1a1a2e] outline-none transition-all duration-200 focus:bg-white focus:border-[#c8973a] resize-none placeholder-[#b0b5c0]" placeholder="Village & Zone"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Church Info --}}
                <div class="mb-9">
                    <div class="flex items-center gap-2.5 serif text-[20px] font-semibold text-[#0c1b3a] pb-3 border-b border-[#e2d9cc] mb-6">
                        <span class="material-symbols-outlined text-[#c8973a]" style="font-size:20px;">church</span>
                        Church Information
                    </div>
                    <div class="grid grid-cols-2 gap-[18px]">
                        <div>
                            <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-[#0c1b3a] mb-2">Date Joined<span class="text-[#c8973a] ml-0.5">*</span></label>
                            <input type="date" name="dateJoined" required class="field-input w-full px-4 py-3.5 bg-[#fdf8f0] border border-[#e2d9cc] font-[Jost] text-sm text-[#1a1a2e] outline-none transition-all duration-200 focus:bg-white focus:border-[#c8973a]">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-[#0c1b3a] mb-2">Cell (Zone)<span class="text-[#c8973a] ml-0.5">*</span></label>
                            <select name="cell" required class="field-input w-full px-4 py-3.5 bg-[#fdf8f0] border border-[#e2d9cc] font-[Jost] text-sm text-[#1a1a2e] outline-none transition-all duration-200 focus:bg-white focus:border-[#c8973a]">
                                <option value="">Select your cell</option>
                                <option value="north">North Cell</option>
                                <option value="east">East Cell</option>
                                <option value="south">South Cell</option>
                                <option value="west">West Cell</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Photo upload --}}
                <div class="mb-9">
                    <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-[#0c1b3a] mb-3">
                        Profile Photo <span class="font-light normal-case tracking-normal text-[#6b7080]">(Optional)</span>
                    </label>
                    <div class="border-[1.5px] border-dashed border-[#e2d9cc] p-5 text-center transition-colors duration-200 cursor-pointer hover:border-[#c8973a]">
                        <label class="flex flex-col items-center gap-2 cursor-pointer">
                            <div class="w-10 h-10 bg-[#f5ede0] rounded-full flex items-center justify-center text-[18px] text-[#c8973a]">📷</div>
                            <strong class="text-[13px] text-[#0c1b3a] font-semibold">Click to upload photo</strong>
                            <span class="text-[12px] text-[#6b7080]">PNG, JPG up to 5MB</span>
                            <input type="file" name="profileImage" accept="image/*" class="hidden">
                        </label>
                    </div>
                </div>

                {{-- Account creation --}}
                <div class="bg-[#f5ede0] border border-[#e2d9cc] p-6 mb-7">
                    <label class="flex items-start gap-3.5 cursor-pointer">
                        <input type="checkbox" id="createAccount" name="create_account" value="1"
                               class="w-[18px] h-[18px] mt-0.5 flex-shrink-0 accent-[#0c1b3a] cursor-pointer">
                        <div>
                            <h4 class="text-sm font-semibold text-[#0c1b3a] mb-1">Create an online account</h4>
                            <p class="text-[12px] text-[#6b7080] font-light leading-[1.5]">Access services, join groups, and track your giving online.</p>
                        </div>
                    </label>
                    <div class="account-fields mt-5 pt-5 border-t border-[#e2d9cc]" id="accountFields">
                        <div>
                            <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-[#0c1b3a] mb-2">Password<span class="text-[#c8973a] ml-0.5">*</span></label>
                            <input type="password" name="password" id="password" class="field-input w-full px-4 py-3.5 bg-[#fdf8f0] border border-[#e2d9cc] font-[Jost] text-sm text-[#1a1a2e] outline-none transition-all duration-200 focus:bg-white focus:border-[#c8973a] placeholder-[#b0b5c0]" placeholder="Minimum 8 characters">
                        </div>
                        <div>
                            <label class="block text-[10px] font-semibold tracking-[0.14em] uppercase text-[#0c1b3a] mb-2">Confirm Password<span class="text-[#c8973a] ml-0.5">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="field-input w-full px-4 py-3.5 bg-[#fdf8f0] border border-[#e2d9cc] font-[Jost] text-sm text-[#1a1a2e] outline-none transition-all duration-200 focus:bg-white focus:border-[#c8973a] placeholder-[#b0b5c0]" placeholder="Re-enter password">
                        </div>
                    </div>
                </div>

                <div id="formNotice" class="hidden p-4 bg-[#edf7f2] border-l-4 border-[#1a7a4a] text-[#155d38] text-sm font-medium mb-5">
                    ✓ Registration submitted — redirecting…
                </div>

                <button type="submit"
                        class="w-full py-[17px] px-8 bg-[#0c1b3a] text-[#e8b96a] font-[Jost] text-xs font-semibold tracking-[0.2em] uppercase border-0 cursor-pointer transition-all duration-300 flex items-center justify-center gap-2.5 hover:bg-[#142450]">
                    <span>Complete Registration</span>
                    <span class="material-symbols-outlined" style="font-size:18px;">arrow_forward</span>
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ═══════════════ JOIN GROUP MODAL ═══════════════ --}}
<div id="joinGroupModal" class="fixed inset-0 z-[999] bg-[rgba(12,27,58,0.7)] backdrop-blur-sm hidden items-center justify-center p-5 overflow-y-auto">
    <div class="relative bg-white w-full max-w-[440px] rounded-[2px] overflow-hidden shadow-[0_32px_100px_rgba(0,0,0,0.3)]">
        <button type="button" id="closeJoinModal"
                class="absolute top-4 right-5 w-9 h-9 bg-white/10 border border-white/20 rounded-full flex items-center justify-center cursor-pointer text-white/70 text-xl transition-all duration-200 hover:bg-white/20 hover:text-white z-10">×</button>

        <div class="modal-header bg-[#0c1b3a] px-12 pt-11 pb-9 relative overflow-hidden">
            <p class="eyebrow mb-2.5">Ministry</p>
            <h2 id="modalGroupName" class="serif text-[38px] font-semibold text-white leading-[1.1] mb-2">Join Group</h2>
            <p class="text-[13px] text-white/50 font-light">We're so glad to have you!</p>
        </div>

        <form id="joinGroupForm" action="{{ route('groups.join') }}" method="POST">
            @csrf
            <input type="hidden" name="group" id="groupInput">
            <div class="px-10 py-8">
                <p class="text-[14px] text-[#6b7080] mb-7 font-light leading-[1.6]">You're about to join this ministry group. Confirm your choice and start growing in community.</p>
                <div class="flex gap-3.5">
                    <button type="button" id="cancelJoinBtn"
                            class="flex-1 py-3.5 bg-transparent border border-[#e2d9cc] text-[#6b7080] font-[Jost] text-xs font-semibold tracking-[0.14em] uppercase cursor-pointer transition-all duration-200 hover:border-[#0c1b3a] hover:text-[#0c1b3a]">
                        Cancel
                    </button>
                    <button type="submit"
                            class="flex-1 py-3.5 bg-[#0c1b3a] border-0 text-[#e8b96a] font-[Jost] text-xs font-semibold tracking-[0.14em] uppercase cursor-pointer transition-all duration-200 hover:bg-[#142450]">
                        Confirm & Join
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════ MY GROUPS MODAL ═══════════════ --}}
<div id="myGroupsModal" class="fixed inset-0 z-[999] bg-[rgba(12,27,58,0.7)] backdrop-blur-sm hidden items-center justify-center p-5 overflow-y-auto">
    <div class="relative bg-white w-full max-w-[520px] rounded-[2px] overflow-hidden shadow-[0_32px_100px_rgba(0,0,0,0.3)]">
        <button type="button" onclick="closeMyGroupsModal()"
                class="absolute top-4 right-5 w-9 h-9 bg-white/10 border border-white/20 rounded-full flex items-center justify-center cursor-pointer text-white/70 text-xl transition-all duration-200 hover:bg-white/20 hover:text-white z-10">×</button>

        <div class="modal-header bg-[#0c1b3a] px-12 pt-11 pb-9 relative overflow-hidden">
            <p class="eyebrow mb-2.5">Your Ministry</p>
            <h2 class="serif text-[38px] font-semibold text-white leading-[1.1] mb-2">My Groups</h2>
            <p class="text-[13px] text-white/50 font-light">Groups you currently belong to</p>
        </div>

        <div id="myGroupsContent" class="p-12 max-h-[70vh] overflow-y-auto">
            <div class="text-center py-16 px-8">
                <div class="text-5xl text-[#e2d9cc] mb-4">⏳</div>
                <p class="serif text-[20px] text-[#6b7080]">Loading…</p>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════ TOAST ═══════════════ --}}
<style>
.toast { position: fixed; top: 24px; right: 24px; z-index: 9999; padding: 16px 20px; min-width: 280px; font-size: 14px; font-weight: 500; display: flex; align-items: flex-start; gap: 12px; animation: fadeUp 0.3s ease both; border-radius: 2px; }
.toast.success { background: #0c1b3a; color: #e8b96a; border-left: 3px solid #c8973a; }
.toast.error   { background: #fff; color: #c0392b; border-left: 3px solid #c0392b; box-shadow: 0 8px 24px rgba(0,0,0,0.12); }
</style>

{{-- ═══════════════ SCRIPTS ═══════════════ --}}
<script>
(function () {
    // Modal open/close helpers
    function openModal(el)  { if (el) { el.classList.remove('hidden'); el.classList.add('flex'); document.body.style.overflow = 'hidden'; } }
    function closeModal(el) { if (el) { el.classList.add('hidden'); el.classList.remove('flex'); document.body.style.overflow = ''; } }

    // ── Registration Modal ──
    const regModal = document.getElementById('registrationModal');
    document.getElementById('joinBtn')?.addEventListener('click', () => openModal(regModal));
    regModal?.querySelector('[data-modal-close]')?.addEventListener('click', () => closeModal(regModal));
    regModal?.addEventListener('click', e => { if (e.target === regModal) closeModal(regModal); });

    // Password field toggle
    const createAccountCb = document.getElementById('createAccount');
    const accountFields   = document.getElementById('accountFields');
    const pwField         = document.getElementById('password');
    const pwConfirmField  = document.getElementById('password_confirmation');
    createAccountCb?.addEventListener('change', function () {
        const show = this.checked;
        accountFields.classList.toggle('visible', show);
        if (pwField) pwField.required = show;
        if (pwConfirmField) pwConfirmField.required = show;
        if (!show) { if (pwField) pwField.value = ''; if (pwConfirmField) pwConfirmField.value = ''; }
    });

    document.getElementById('memberForm')?.addEventListener('submit', function () {
        document.getElementById('formNotice')?.classList.remove('hidden');
    });

    // ── Join Group Modal ──
    const joinModal = document.getElementById('joinGroupModal');
    document.getElementById('closeJoinModal')?.addEventListener('click', () => closeModal(joinModal));
    document.getElementById('cancelJoinBtn')?.addEventListener('click', () => closeModal(joinModal));
    joinModal?.addEventListener('click', e => { if (e.target === joinModal) closeModal(joinModal); });

    // Join group AJAX
    document.querySelectorAll('.joinGroupBtn').forEach(btn => {
        btn.addEventListener('click', async function (e) {
            e.preventDefault();
            const groupName = this.dataset.group;
            const original  = this.innerHTML;
            this.disabled = true;
            this.innerHTML = '<span style="opacity:.6;">Joining…</span>';
            try {
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
                const res  = await fetch('{{ route("groups.join") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: JSON.stringify({ group: groupName })
                });
                const data = await res.json();
                if (data.success) {
                    this.outerHTML = `<div class="w-full py-3 px-5 flex items-center justify-center gap-2 text-[#1a7a4a] text-[11px] font-semibold tracking-[0.14em] uppercase border border-[rgba(26,122,74,0.3)]"><span class="material-symbols-outlined" style="font-size:16px;">check_circle</span>Member</div>`;
                    showToast(data.message || 'Successfully joined!', 'success');
                } else {
                    this.disabled = false;
                    this.innerHTML = original;
                    showToast(data.message || 'Could not join group.', 'error');
                }
            } catch {
                this.disabled = false;
                this.innerHTML = original;
                showToast('Something went wrong. Please try again.', 'error');
            }
        });
    });

    // Escape key
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            closeModal(regModal);
            closeModal(joinModal);
            closeModal(document.getElementById('myGroupsModal'));
        }
    });

    window.showToast = function(msg, type = 'success') {
        const t = document.createElement('div');
        t.className = `toast ${type}`;
        t.innerHTML = `<span>${msg}</span>`;
        document.body.appendChild(t);
        setTimeout(() => t.remove(), 4500);
    };
})();

// ── My Groups ──
function showMyGroupsModal() {
    const modal   = document.getElementById('myGroupsModal');
    const content = document.getElementById('myGroupsContent');
    modal.classList.remove('hidden'); modal.classList.add('flex');
    document.body.style.overflow = 'hidden';

    fetch('/api/my-groups', {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(r => r.json())
    .then(data => {
        const groups = (data.groups || []).filter(g => g.status !== 'rejected');
        if (groups.length > 0) {
            content.innerHTML = `<div class="px-1">` + groups.map(g => `
                <div class="flex items-center gap-3.5 py-4 border-b border-[#e2d9cc] last:border-0">
                    <div class="w-11 h-11 rounded-[2px] overflow-hidden flex-shrink-0 bg-[#f5ede0] flex items-center justify-center">
                        ${g.image_url ? `<img src="${g.image_url}" alt="${g.name}" class="w-full h-full object-cover">` : `<span class="material-symbols-outlined text-[#c8973a]" style="font-size:22px;">group</span>`}
                    </div>
                    <div>
                        <div class="serif text-[18px] font-semibold text-[#0c1b3a]">${g.name}</div>
                        <div class="text-[12px] text-[#6b7080]">${g.meeting_day || ''}${g.meeting_day && g.location ? ' · ' : ''}${g.location || ''}</div>
                    </div>
                    <button class="ml-auto px-4 py-1.5 bg-transparent border border-[rgba(192,57,43,0.25)] text-[#c0392b] text-[11px] font-semibold tracking-[0.1em] uppercase cursor-pointer transition-all duration-200 flex-shrink-0 hover:bg-[#fdf2f0] hover:border-[#c0392b]"
                            onclick="leaveGroup(${g.id}, '${g.name}')">Leave</button>
                </div>
            `).join('') + `</div>`;
        } else {
            content.innerHTML = `<div class="text-center py-16 px-8"><div class="text-5xl text-[#e2d9cc] mb-4">⛪</div><p class="serif text-[20px] text-[#6b7080]">No groups yet</p><small class="text-[13px] text-[#bbb]">Join a group to start connecting!</small></div>`;
        }
    })
    .catch(() => {
        content.innerHTML = `<div class="text-center py-16 px-8"><div class="text-5xl text-[#e2d9cc] mb-4">⚠️</div><p class="serif text-[20px] text-[#6b7080]">Could not load groups</p></div>`;
    });
}

function leaveGroup(id, name) {
    if (!confirm(`Leave "${name}"?`)) return;
    fetch(`/api/groups/${id}/leave`, {
        method: 'POST',
        headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(r => r.json())
    .then(data => { if (data.success) showMyGroupsModal(); else alert(data.message || 'Failed to leave group'); })
    .catch(() => alert('Failed to leave group'));
}

function closeMyGroupsModal() {
    const modal = document.getElementById('myGroupsModal');
    modal.classList.add('hidden'); modal.classList.remove('flex');
    document.body.style.overflow = '';
}

document.addEventListener('DOMContentLoaded', function () {
    document.documentElement.style.overflowY = 'auto';
    document.body.style.overflowY = 'auto';
});
</script>

<script src="script.js"></script>
</body>
</html>