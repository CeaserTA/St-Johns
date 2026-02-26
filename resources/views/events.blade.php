<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Events & Announcements — St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600&family=Jost:wght@300;400;500;600&family=Material+Symbols+Outlined&display=swap" rel="stylesheet">
    @include('partials.theme-config')
<style>
:root{
    --navy:#0c1b3a;--navy2:#142450;--gold:#c8973a;--gold2:#e8b96a;
    --cream:#fdf8f0;--sand:#f5ede0;--text:#1a1a2e;--muted:#6b7080;
    --border:#e2d9cc;--white:#ffffff;--red:#c0392b;--green:#1a7a4a;
}

/* Animations */
@keyframes fadeUp    { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
@keyframes pulse-dot { 0%,100%{opacity:1} 50%{opacity:.4} }
.fade-up   { animation:fadeUp .75s ease both }
.fade-up-1 { animation-delay:.08s }
.fade-up-2 { animation-delay:.18s }
.fade-up-3 { animation-delay:.28s }
.badge-dot { animation:pulse-dot 1.4s ease infinite; display:inline-block; }

/* Carousel */
.carousel-slide               { position:absolute;inset:0;opacity:0;transition:opacity .55s ease;pointer-events:none; }
.carousel-slide.active        { opacity:1;pointer-events:auto; }
.carousel-bg                  { position:absolute;inset:0;background-size:cover;background-position:center;transform:scale(1.04);transition:transform 8s ease; }
.carousel-slide.active .carousel-bg { transform:scale(1); }
.carousel-dot                 { width:6px;height:6px;background:rgba(255,255,255,.3);border:none;cursor:pointer;transition:all .3s; }
.carousel-dot.active          { width:22px;background:var(--gold); }

/* Pseudo-element effects */
.event-card::after {
    content:'';position:absolute;bottom:0;left:0;right:0;height:3px;
    background:linear-gradient(90deg,var(--gold),var(--gold2));
    transform:scaleX(0);transform-origin:left;transition:transform .35s ease;
}
.event-card:hover::after { transform:scaleX(1); }

.ann-item::before {
    content:'';position:absolute;left:0;top:0;bottom:0;width:3px;
    background:var(--gold);transform:scaleY(0);transform-origin:bottom;transition:transform .25s;
}
.ann-item:hover::before { transform:scaleY(1); }

/* Shimmer button */
.btn-shimmer                  { position:relative;overflow:hidden; }
.btn-shimmer::before          { content:'';position:absolute;inset:0;background:var(--gold2);transform:translateX(-101%);transition:transform .3s ease; }
.btn-shimmer:hover::before    { transform:translateX(0); }
.btn-shimmer > *              { position:relative;z-index:1; }

/* Featured card image zoom */
.featured-img                 { transition:transform .7s ease; }
.featured-card:hover .featured-img { transform:scale(1.03); }

/* Filter tab */
.filter-tab.active { background:var(--navy)!important;color:var(--gold2)!important;border-color:var(--navy)!important; }

/* Field inputs */
.field-input { width:100%;padding:12px 16px;background:var(--cream);border:1px solid var(--border);font-family:'Jost',sans-serif;font-size:14px;color:var(--text);transition:all .2s;outline:none; }
.field-input:focus { background:#fff;border-color:var(--gold);box-shadow:0 0 0 3px rgba(200,151,58,.1); }
.field-input::placeholder { color:#b5b9c4; }
.field-readonly { padding:12px 16px;background:var(--sand);border:1px solid transparent;font-family:'Jost',sans-serif;font-size:13px;color:var(--muted);font-weight:300; }

/* Modals */
.modal-overlay     { position:fixed;inset:0;z-index:999;background:rgba(12,27,58,.75);backdrop-filter:blur(6px);display:none;align-items:center;justify-content:center;padding:20px;overflow-y:auto; }
.modal-overlay.open { display:flex; }
.modal-box         { position:relative;background:#fff;width:100%;max-width:560px;overflow:hidden;box-shadow:0 32px 100px rgba(0,0,0,.3);animation:fadeUp .35s ease both; }
.modal-box.wide    { max-width:700px; }

@media(max-width:1024px) {
    .main-layout { grid-template-columns:1fr!important; }
    .ann-sidebar { border-left:none!important;border-top:1px solid var(--border);padding-left:0!important;padding-top:32px!important; }
}
@media(max-width:640px) {
    .events-grid { grid-template-columns:1fr!important; }
    .modal-header-inner { padding:28px 24px 22px!important; }
    .modal-body-inner   { padding:24px!important; }
    .form-2col { grid-template-columns:1fr!important; }
}
</style>
</head>

<body style="font-family:'Jost',sans-serif;background:var(--cream);color:var(--text);overflow-x:hidden;">

@include('partials.navbar')
@include('partials.login-modal')
@include('partials.announcement')

{{-- Flash messages --}}
@if ($message = Session::get('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof showToast === 'function') {
        showToast('{{ addslashes($message) }}', 'success');
    }
});
</script>
@endif
@if ($message = Session::get('error'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof showToast === 'function') {
        showToast('{{ addslashes($message) }}', 'error');
    }
});
</script>
@endif


{{-- ══════════════════════════════════════
     PAGE HERO
══════════════════════════════════════ --}}
<section class="relative overflow-hidden text-center px-10 py-[72px]"
         style="background:var(--navy);background-image:repeating-linear-gradient(45deg,transparent,transparent 40px,rgba(201,168,76,.03) 40px,rgba(201,168,76,.03) 41px);">
    <span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none select-none leading-none"
          style="font-size:380px;color:rgba(200,151,58,.04);font-family:serif;">✝</span>
    <div class="relative z-10 max-w-[680px] mx-auto">
        <p class="fade-up fade-up-1 inline-flex items-center gap-2.5 justify-center mb-3.5 text-[10px] font-semibold tracking-[.22em] uppercase"
           style="color:var(--gold);">
            <span style="display:block;width:28px;height:1px;background:var(--gold);"></span>
            Life at St. John's
        </p>
        <h1 class="fade-up fade-up-2 font-semibold leading-[.95] tracking-[-0.01em] mt-3.5 mb-[18px]"
            style="font-family:'Cormorant Garamond',serif;font-size:clamp(48px,8vw,84px);color:#fff;">
            Events &amp;<br><em style="font-style:italic;color:var(--gold2);font-weight:300;">Announcements</em>
        </h1>
        <p class="fade-up fade-up-3 text-[13px] font-light leading-[1.8]" style="color:rgba(255,255,255,.45);">
            Stay connected with everything happening in our parish community.
        </p>
    </div>
</section>


{{-- ══════════════════════════════════════
     CAROUSEL
══════════════════════════════════════ --}}
<div class="max-w-[1200px] mx-auto px-10 pt-14 max-sm:px-5">

    <div class="flex items-baseline justify-between mb-5">
        <div>
            <span class="block text-[11px] font-semibold tracking-[.18em] uppercase mb-1" style="color:var(--gold);">This Week</span>
            <span class="text-[28px] font-semibold" style="font-family:'Cormorant Garamond',serif;color:var(--navy);">What's Happening</span>
        </div>
        @if(isset($thisWeekEvents) && $thisWeekEvents->count() > 1)
        <div class="flex gap-2">
            <button onclick="previousSlide()"
                    class="w-[38px] h-[38px] rounded-full flex items-center justify-center cursor-pointer transition-all duration-200"
                    style="border:1px solid var(--border);background:#fff;color:var(--muted);"
                    onmouseover="this.style.borderColor='var(--navy)';this.style.color='var(--navy)';"
                    onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--muted)';">
                <span class="material-symbols-outlined" style="font-size:20px;">chevron_left</span>
            </button>
            <button onclick="nextSlide()"
                    class="w-[38px] h-[38px] rounded-full flex items-center justify-center cursor-pointer transition-all duration-200"
                    style="border:1px solid var(--border);background:#fff;color:var(--muted);"
                    onmouseover="this.style.borderColor='var(--navy)';this.style.color='var(--navy)';"
                    onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--muted)';">
                <span class="material-symbols-outlined" style="font-size:20px;">chevron_right</span>
            </button>
        </div>
        @endif
    </div>

    @if(isset($thisWeekEvents) && $thisWeekEvents->count() > 0)
    <div class="relative overflow-hidden" style="aspect-ratio:21/7;background:var(--navy2);">
        @foreach($thisWeekEvents as $index => $weekEvent)
        <div class="carousel-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
            <div class="carousel-bg" style="background-image:url('{{ $weekEvent->image_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBJuBVtqw9UvSxdwxXR4HOoRKNwjmp9luc3fMocyA9NTqdPQivYkifWnUaMwnjyQq3T4squ6UlhiwnVUaXW1dGBb9iQTqAWj2ZWY0cDsr8_w0zYXf4_sbb551OYF9iq1ViLJ1oSTTDppAlvmUWZuWIo8Etdwaaf_zx3Twh1p4XfM8eHKL64rCtraA9U_aCR3AJcZ_L-6y2nwV4LQ3nNURKG3gPTol5sCwQWKy93zdr-wzJtb_VykEtdfU3XC_2Nsxabk4C2zBpbrrgU' }}');"></div>
            <div class="absolute inset-0 flex flex-col justify-center text-white max-sm:px-7"
                 style="padding:40px 52px;background:linear-gradient(to right,rgba(12,27,58,.9) 0%,rgba(12,27,58,.55) 55%,rgba(12,27,58,.08) 100%);">
                <div class="inline-flex items-center gap-1.5 w-fit mb-4"
                     style="padding:5px 14px;background:var(--gold);color:var(--navy);font-size:9px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;">
                    <span class="material-symbols-outlined" style="font-size:12px;">star</span>
                    <span>This Week</span>
                </div>
                <h3 class="font-semibold leading-[1.1] max-w-[480px] mb-3"
                    style="font-family:'Cormorant Garamond',serif;font-size:clamp(28px,4vw,44px);color:#fff;">
                    {{ $weekEvent->title }}
                </h3>
                <p class="font-light max-w-[380px] mb-7 leading-[1.7]"
                   style="font-size:13.5px;color:rgba(255,255,255,.65);">{{ $weekEvent->excerpt }}</p>
                <div class="flex gap-3 flex-wrap">
                    <button class="btn-shimmer inline-flex items-center gap-2 border-none cursor-pointer"
                            style="padding:13px 28px;background:var(--gold);color:var(--navy);font-family:'Jost',sans-serif;font-size:11px;font-weight:600;letter-spacing:.18em;text-transform:uppercase;"
                            onclick="openEventModal({{ $weekEvent->id }}, '{{ addslashes($weekEvent->title) }}')">
                        <span>Register Now</span>
                        <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span>
                    </button>
                    <button class="inline-flex items-center gap-2 cursor-pointer transition-all duration-200"
                            style="padding:12px 26px;background:transparent;color:#fff;border:1px solid rgba(255,255,255,.3);font-family:'Jost',sans-serif;font-size:11px;font-weight:500;letter-spacing:.14em;text-transform:uppercase;"
                            onmouseover="this.style.borderColor='var(--gold2)';this.style.color='var(--gold2)';"
                            onmouseout="this.style.borderColor='rgba(255,255,255,.3)';this.style.color='#fff';"
                            onclick="viewDetails({{ $weekEvent->id }})">
                        <span class="material-symbols-outlined" style="font-size:16px;">open_in_new</span>
                        View Details
                    </button>
                </div>
            </div>
            @if($weekEvent->starts_at || isset($weekEvent->date))
            <div class="absolute top-6 right-7 text-center" style="background:var(--navy);border:1px solid rgba(200,151,58,.3);padding:10px 16px;">
                <span class="block" style="font-size:9px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--gold);">{{ ($weekEvent->starts_at ?? $weekEvent->date)->format('M') }}</span>
                <span class="block leading-none" style="font-family:'Cormorant Garamond',serif;font-size:32px;font-weight:700;color:#fff;">{{ ($weekEvent->starts_at ?? $weekEvent->date)->format('d') }}</span>
            </div>
            @endif
        </div>
        @endforeach
        @if($thisWeekEvents->count() > 1)
        <div class="absolute bottom-5 right-6 flex gap-1.5 z-10">
            @foreach($thisWeekEvents as $index => $w)
            <button class="carousel-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})" data-indicator="{{ $index }}"></button>
            @endforeach
        </div>
        @endif
    </div>

    @else
    <div class="flex flex-col items-center justify-center gap-3 text-center"
         style="aspect-ratio:21/7;background:var(--navy2);color:rgba(255,255,255,.35);">
        <span class="material-symbols-outlined" style="font-size:48px;opacity:.3;">event_available</span>
        <p style="font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:600;">No Featured Events This Week</p>
        <small style="font-size:12px;font-weight:300;">Browse upcoming events and announcements below.</small>
    </div>
    @endif
</div>


{{-- ══════════════════════════════════════
     FILTER BAR
══════════════════════════════════════ --}}
<div class="max-w-[1200px] mx-auto px-10 pt-12 flex items-center justify-between flex-wrap gap-4 max-sm:px-5">
    <div class="flex">
        <button class="filter-tab active cursor-pointer transition-all duration-200"
                style="padding:9px 22px;font-family:'Jost',sans-serif;font-size:11px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;border:1px solid var(--border);background:var(--navy);color:var(--gold2);"
                onclick="switchTab('all',this)">All</button>
        <button class="filter-tab cursor-pointer transition-all duration-200"
                style="padding:9px 22px;font-family:'Jost',sans-serif;font-size:11px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;border:1px solid var(--border);border-left:none;background:transparent;color:var(--muted);"
                onmouseover="if(!this.classList.contains('active')){this.style.borderColor='var(--navy)';this.style.color='var(--navy)';}"
                onmouseout="if(!this.classList.contains('active')){this.style.borderColor='var(--border)';this.style.color='var(--muted)';}"
                onclick="switchTab('events',this)">Events</button>
        <button class="filter-tab cursor-pointer transition-all duration-200"
                style="padding:9px 22px;font-family:'Jost',sans-serif;font-size:11px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;border:1px solid var(--border);border-left:none;background:transparent;color:var(--muted);"
                onmouseover="if(!this.classList.contains('active')){this.style.borderColor='var(--navy)';this.style.color='var(--navy)';}"
                onmouseout="if(!this.classList.contains('active')){this.style.borderColor='var(--border)';this.style.color='var(--muted)';}"
                onclick="switchTab('announcements',this)">Announcements</button>
    </div>
    <span id="filter-count-label" style="font-size:11px;color:var(--muted);font-weight:300;">Showing all items</span>
</div>
<div class="max-w-[1200px] mx-auto px-10 max-sm:px-5">
    <div style="height:1px;background:var(--border);margin-top:0;"></div>
</div>


{{-- ══════════════════════════════════════
     SPLIT LAYOUT — Events (left) + Announcements sidebar (right)
══════════════════════════════════════ --}}
@php
    $allActive     = isset($events) ? $events->where('is_active', true) : collect();
    $activeEvents  = $allActive->where('is_event', true)->values();
    $announcements = $allActive->where('is_event', false)->values();
    $featuredEvent = $activeEvents->first();
    $restEvents    = $activeEvents->skip(1)->values();
@endphp

<div class="max-w-[1200px] mx-auto px-10 pt-10 pb-20 max-sm:px-5">
    <div class="main-layout grid gap-0" style="grid-template-columns:1fr 360px;align-items:start;">

        {{-- ════════════════════════════════
             LEFT — EVENTS COLUMN
        ════════════════════════════════ --}}
        <div id="eventsSection" style="padding-right:48px;">

            {{-- Section label --}}
            <div class="flex items-center gap-3 mb-7">
                <span style="display:inline-block;width:24px;height:1px;background:var(--gold);"></span>
                <span style="font-size:10px;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);">Upcoming Events</span>
                <div style="flex:1;height:1px;background:var(--border);"></div>
            </div>

            @if($activeEvents->isEmpty())
            <div class="text-center py-16">
                <span class="material-symbols-outlined" style="font-size:52px;color:var(--border);">event_busy</span>
                <p style="font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:600;color:var(--muted);margin-top:16px;">No Events Yet</p>
                <p style="font-size:13px;color:#bbb;margin-top:6px;">Events will appear here as they are added.</p>
            </div>
            @else

            {{-- ── FEATURED EVENT — wide hero card ── --}}
            @if($featuredEvent)
            <div class="featured-card relative overflow-hidden cursor-pointer mb-6"
                 style="background:var(--navy2);box-shadow:0 24px 56px -10px rgba(12,27,58,.2);">

                {{-- Image --}}
                <div class="relative overflow-hidden" style="aspect-ratio:16/7;">
                    <div class="featured-img absolute inset-0 bg-cover bg-center"
                         style="background-image:url('{{ $featuredEvent->image_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuA-fKy9IwvMJcFgNjBgGeqCsxWDf45Y4A3gyZUE0COYXjV920Ecw2UpyEdz8lSsQqNt776sga6zUAQS8SPhICaU176kI8yjAEMMbs4eK9MicH34I1kLcLiReOivpIM5AbWccAQyTb-EKZ-l-UrAetKIMAAI-C97PCSC2V2192XhCBWzDDGQuKv45DxBy8RiXAe8PgX196bflqvN9A49hfA5Or-6_WfSO1P0G6VWUR_0DQujdRDI0UigGGPic8rQmPJ7ha6OdUxX-tTB' }}');"></div>
                    <div class="absolute inset-0" style="background:linear-gradient(to top,rgba(12,27,58,.95) 0%,rgba(12,27,58,.4) 50%,rgba(12,27,58,.05) 100%);"></div>

                    {{-- Upcoming badge --}}
                    @if($featuredEvent->is_upcoming)
                    <div class="absolute top-4 left-4 inline-flex items-center gap-1.5"
                         style="padding:4px 12px;background:var(--red);color:#fff;font-size:8px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;">
                        <span class="badge-dot w-[5px] h-[5px] rounded-full" style="background:#fff;"></span>Upcoming
                    </div>
                    @endif

                    {{-- Date badge top-right --}}
                    @if($featuredEvent->starts_at || isset($featuredEvent->date))
                    <div class="absolute top-4 right-4 text-center" style="background:var(--navy);border:1px solid rgba(200,151,58,.3);padding:8px 14px;">
                        <span class="block" style="font-size:8px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--gold);">
                            {{ ($featuredEvent->starts_at ?? $featuredEvent->date)->format('M') }}
                        </span>
                        <span class="block leading-none" style="font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:700;color:#fff;">
                            {{ ($featuredEvent->starts_at ?? $featuredEvent->date)->format('d') }}
                        </span>
                    </div>
                    @endif

                    {{-- Content over image --}}
                    <div class="absolute bottom-0 left-0 right-0 text-white" style="padding:28px 28px 24px;">
                        <div class="inline-flex items-center gap-2 mb-3"
                             style="padding:4px 12px;border:1px solid rgba(200,151,58,.4);color:var(--gold);font-size:9px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;">
                            <span class="material-symbols-outlined" style="font-size:12px;">event_available</span>Featured Event
                        </div>
                        <h2 class="font-semibold text-white leading-tight mb-2"
                            style="font-family:'Cormorant Garamond',serif;font-size:clamp(24px,3vw,36px);">
                            {{ $featuredEvent->title }}
                        </h2>
                        <div class="flex items-center gap-2 mb-4" style="font-size:11px;font-weight:600;color:rgba(200,151,58,.9);letter-spacing:.06em;">
                            <span class="material-symbols-outlined" style="font-size:14px;">schedule</span>
                            {{ $featuredEvent->formatted_time ?? 'TBD' }}
                            @if($featuredEvent->location)
                            <span style="color:rgba(255,255,255,.25);">·</span>{{ $featuredEvent->location }}
                            @endif
                        </div>
                        <div class="flex gap-2.5 flex-wrap">
                            <button class="btn-shimmer inline-flex items-center gap-2 border-none cursor-pointer"
                                    style="padding:11px 22px;background:var(--gold);color:var(--navy);font-family:'Jost',sans-serif;font-size:10px;font-weight:600;letter-spacing:.18em;text-transform:uppercase;"
                                    onclick="openEventModal({{ $featuredEvent->id }}, '{{ addslashes($featuredEvent->title) }}')">
                                <span>Register Now</span>
                                <span class="material-symbols-outlined" style="font-size:15px;">arrow_forward</span>
                            </button>
                            <button class="inline-flex items-center gap-2 cursor-pointer transition-all duration-200"
                                    style="padding:10px 18px;background:rgba(255,255,255,.1);color:#fff;border:1px solid rgba(255,255,255,.25);font-family:'Jost',sans-serif;font-size:10px;font-weight:500;letter-spacing:.14em;text-transform:uppercase;"
                                    onmouseover="this.style.borderColor='var(--gold2)';this.style.color='var(--gold2)';"
                                    onmouseout="this.style.borderColor='rgba(255,255,255,.25)';this.style.color='#fff';"
                                    onclick="viewDetails({{ $featuredEvent->id }})">
                                <span class="material-symbols-outlined" style="font-size:15px;">open_in_new</span>Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- ── REMAINING EVENTS — 2-col magazine grid ── --}}
            @if($restEvents->isNotEmpty())
            <div class="events-grid grid gap-5" style="grid-template-columns:repeat(2,1fr);">
                @foreach($restEvents as $item)
                <div class="event-card relative flex flex-col overflow-hidden cursor-pointer transition-all duration-300 ease-out"
                     style="background:#fff;border:1px solid var(--border);"
                     onmouseover="this.style.boxShadow='0 16px 40px rgba(12,27,58,.1)';this.style.transform='translateY(-4px)';this.style.borderColor='rgba(200,151,58,.2)';"
                     onmouseout="this.style.boxShadow='';this.style.transform='';this.style.borderColor='var(--border)';"
                     data-type="event">

                    {{-- Image --}}
                    <div class="relative overflow-hidden" style="aspect-ratio:3/2;background:var(--sand);">
                        <img alt="{{ $item->title }}"
                             src="{{ $item->image_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuA-fKy9IwvMJcFgNjBgGeqCsxWDf45Y4A3gyZUE0COYXjV920Ecw2UpyEdz8lSsQqNt776sga6zUAQS8SPhICaU176kI8yjAEMMbs4eK9MicH34I1kLcLiReOivpIM5AbWccAQyTb-EKZ-l-UrAetKIMAAI-C97PCSC2V2192XhCBWzDDGQuKv45DxBy8RiXAe8PgX196bflqvN9A49hfA5Or-6_WfSO1P0G6VWUR_0DQujdRDI0UigGGPic8rQmPJ7ha6OdUxX-tTB' }}"
                             class="w-full h-full object-cover"
                             style="transition:transform .5s ease;"
                             onmouseover="this.style.transform='scale(1.05)';"
                             onmouseout="this.style.transform='scale(1)';" />

                        {{-- Date stamp --}}
                        <div class="absolute top-3 left-3 text-center" style="background:var(--navy);border:1px solid rgba(200,151,58,.25);padding:5px 10px;">
                            <span class="block" style="font-size:7px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--gold);">
                                {{ $item->starts_at ? $item->starts_at->format('M') : ($item->date ? $item->date->format('M') : '?') }}
                            </span>
                            <span class="block leading-none" style="font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:700;color:#fff;">
                                {{ $item->starts_at ? $item->starts_at->format('d') : ($item->date ? $item->date->format('d') : '--') }}
                            </span>
                        </div>

                        @if($item->is_upcoming)
                        <div class="absolute bottom-2.5 right-2.5 inline-flex items-center gap-1"
                             style="padding:3px 8px;background:var(--red);color:#fff;font-size:7px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;">
                            <span class="badge-dot w-[4px] h-[4px] rounded-full" style="background:#fff;"></span>Upcoming
                        </div>
                        @endif
                    </div>

                    {{-- Body --}}
                    <div class="flex flex-col flex-1" style="padding:18px 18px 16px;">
                        <div class="flex items-center gap-1.5 mb-2" style="font-size:10px;font-weight:600;color:var(--gold);letter-spacing:.06em;">
                            <span class="material-symbols-outlined" style="font-size:13px;">schedule</span>
                            {{ $item->formatted_time ?? 'TBD' }}
                            @if($item->location)<span style="color:var(--border);">·</span>{{ $item->location }}@endif
                        </div>
                        <div class="font-semibold leading-[1.2] mb-2"
                             style="font-family:'Cormorant Garamond',serif;font-size:18px;color:var(--navy);">
                            {{ $item->title }}
                        </div>
                        <p class="font-light leading-[1.7] mb-4 flex-1"
                           style="font-size:12px;color:var(--muted);display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                            {{ $item->excerpt }}
                        </p>
                        <div class="mt-auto flex gap-2">
                            <button class="flex-1 flex items-center justify-center gap-1.5 border-none cursor-pointer transition-colors duration-200"
                                    style="padding:10px;background:var(--navy);color:var(--gold2);font-family:'Jost',sans-serif;font-size:9px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;"
                                    onmouseover="this.style.background='var(--navy2)';"
                                    onmouseout="this.style.background='var(--navy)';"
                                    onclick="openEventModal({{ $item->id }}, '{{ addslashes($item->title) }}')">
                                <span>Register</span>
                                <span class="material-symbols-outlined" style="font-size:13px;">arrow_forward</span>
                            </button>
                            <button class="flex-shrink-0 flex items-center justify-center cursor-pointer transition-all duration-200"
                                    style="padding:10px 12px;background:transparent;border:1px solid var(--border);color:var(--muted);"
                                    onmouseover="this.style.borderColor='var(--navy)';this.style.color='var(--navy)';"
                                    onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--muted)';"
                                    onclick="viewDetails({{ $item->id }})">
                                <span class="material-symbols-outlined" style="font-size:16px;display:block;">open_in_new</span>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @endif {{-- end events isEmpty --}}

            {{-- Load more events --}}
            @if($activeEvents->count() > 5)
            <div class="text-center mt-8">
                <button class="inline-flex items-center gap-2.5 cursor-pointer transition-all duration-200"
                        style="padding:13px 32px;background:#fff;color:var(--navy);border:1px solid var(--border);font-family:'Jost',sans-serif;font-size:11px;font-weight:600;letter-spacing:.18em;text-transform:uppercase;"
                        onmouseover="this.style.borderColor='var(--navy)';"
                        onmouseout="this.style.borderColor='var(--border)';">
                    <span>Load More Events</span>
                    <span class="material-symbols-outlined">keyboard_arrow_down</span>
                </button>
                <div style="font-size:11px;color:var(--muted);margin-top:10px;font-weight:300;">
                    Showing {{ min(5, $activeEvents->count()) }} of {{ $activeEvents->count() }} events
                </div>
            </div>
            @endif
        </div>


        {{-- ════════════════════════════════
             RIGHT — ANNOUNCEMENTS SIDEBAR
        ════════════════════════════════ --}}
        <div id="announcementsSection" class="ann-sidebar" style="padding-left:48px;border-left:1px solid var(--border);position:sticky;top:24px;">

            {{-- Section label --}}
            <div class="flex items-center gap-3 mb-7">
                <span style="display:inline-block;width:24px;height:1px;background:var(--gold);"></span>
                <span style="font-size:10px;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);">Notice Board</span>
            </div>

            @if($announcements->isEmpty())
            <div class="text-center py-10">
                <span class="material-symbols-outlined" style="font-size:40px;color:var(--border);">campaign</span>
                <p style="font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:600;color:var(--muted);margin-top:12px;">No Announcements</p>
            </div>
            @else

            {{-- Stacked announcement list --}}
            <div class="flex flex-col gap-0">
                @foreach($announcements as $index => $item)
                <div class="ann-item relative overflow-hidden cursor-pointer transition-all duration-200"
                     style="padding:18px 0 18px 16px;{{ !$loop->last ? 'border-bottom:1px solid var(--border);' : '' }}"
                     onmouseover="this.style.background='rgba(200,151,58,.04)';"
                     onmouseout="this.style.background='transparent';"
                     data-type="announcement"
                     onclick="viewAnnouncementDetails({{ $item->id }})">

                    {{-- Tag + date row --}}
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="flex items-center gap-2">
                            <span style="display:inline-flex;align-items:center;justify-content:center;width:22px;height:22px;background:var(--navy);flex-shrink:0;">
                                <span class="material-symbols-outlined" style="font-size:13px;color:var(--gold2);">campaign</span>
                            </span>
                            <span style="font-size:9px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--gold);">Announcement</span>
                        </div>
                        <span style="font-size:10px;color:var(--muted);font-weight:300;">{{ $item->created_at->diffForHumans() }}</span>
                    </div>

                    {{-- Title --}}
                    <h4 class="font-semibold leading-snug mb-1.5 transition-colors duration-200"
                        style="font-family:'Cormorant Garamond',serif;font-size:16px;color:var(--navy);">
                        {{ $item->title }}
                    </h4>

                    {{-- Excerpt --}}
                    <p style="font-size:12px;color:var(--muted);line-height:1.65;font-weight:300;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                        {{ $item->excerpt }}
                    </p>

                    {{-- Read more --}}
                    <span class="inline-flex items-center gap-1 mt-2 transition-colors duration-200"
                          style="font-size:9px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:rgba(12,27,58,.5);">
                        Read More <span class="material-symbols-outlined" style="font-size:12px;">arrow_forward</span>
                    </span>
                </div>
                @endforeach
            </div>

            {{-- Load more announcements --}}
            @if($announcements->count() > 5)
            <div class="mt-6 text-center">
                <button class="w-full cursor-pointer transition-all duration-200"
                        style="padding:11px;background:transparent;color:var(--navy);border:1px solid var(--border);font-family:'Jost',sans-serif;font-size:10px;font-weight:600;letter-spacing:.18em;text-transform:uppercase;"
                        onmouseover="this.style.borderColor='var(--navy)';this.style.background='var(--navy)';this.style.color='var(--gold2)';"
                        onmouseout="this.style.borderColor='var(--border)';this.style.background='transparent';this.style.color='var(--navy)';">
                    View All Announcements
                </button>
                <div style="font-size:10px;color:var(--muted);margin-top:8px;font-weight:300;">{{ $announcements->count() }} total announcements</div>
            </div>
            @endif

            @endif
        </div>
        {{-- end announcements sidebar --}}

    </div>{{-- end main-layout --}}
</div>


@include('partials.footer')


{{-- ══════════════════════════════════════
     REGISTRATION MODAL
══════════════════════════════════════ --}}
<div id="registrationModal" class="modal-overlay">
    <div class="modal-box">
        <button class="absolute top-[18px] right-5 z-10 w-9 h-9 rounded-full flex items-center justify-center cursor-pointer transition-all duration-200"
                style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.7);font-size:20px;"
                onmouseover="this.style.background='rgba(255,255,255,.2)';this.style.color='#fff';"
                onmouseout="this.style.background='rgba(255,255,255,.1)';this.style.color='rgba(255,255,255,.7)';"
                onclick="closeRegistrationModal()">×</button>

        <div class="modal-header-inner relative overflow-hidden" style="background:var(--navy);padding:38px 44px 30px;">
            <span class="absolute right-5 bottom-[-30px] pointer-events-none" style="font-size:140px;color:rgba(200,151,58,.06);font-family:serif;">✝</span>
            <p class="relative z-10 inline-flex items-center gap-2.5 mb-2" style="font-size:10px;font-weight:600;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);">
                <span style="display:block;width:28px;height:1px;background:var(--gold);"></span>Event Registration
            </p>
            <h3 class="relative z-10 font-semibold text-white mt-2.5 mb-1.5" style="font-family:'Cormorant Garamond',serif;font-size:30px;">Reserve Your<br>Spot</h3>
            <p class="relative z-10" style="font-size:13px;color:rgba(255,255,255,.4);font-weight:300;">Fill in your details and we'll confirm your place.</p>
            <div id="modalEventBadge" class="relative z-10 inline-block mt-3" style="padding:5px 14px;background:rgba(200,151,58,.15);border:1px solid rgba(200,151,58,.3);font-size:12px;color:var(--gold2);">Select an event</div>
        </div>

        <div class="modal-body-inner" style="padding:36px 44px 40px;">
            <form id="eventForm" action="{{ route('event.registrations.store') }}" method="POST">
                @csrf
                <input type="hidden" name="event_id" id="event_id" />
                <input type="hidden" name="event_name" id="event_name_hidden" />
                <div class="form-2col grid grid-cols-2 gap-[18px] mb-[18px]">
                    <div>
                        <label class="block mb-2" style="font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--navy);">First Name <span style="color:var(--gold);">*</span></label>
                        <input type="text" name="first_name" required class="field-input" placeholder="Your first name">
                    </div>
                    <div>
                        <label class="block mb-2" style="font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--navy);">Last Name</label>
                        <input type="text" name="last_name" class="field-input" placeholder="Your last name">
                    </div>
                </div>
                <div class="form-2col grid grid-cols-2 gap-[18px] mb-[18px]">
                    <div>
                        <label class="block mb-2" style="font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--navy);">Email</label>
                        <input type="email" name="email" class="field-input" placeholder="you@example.com">
                    </div>
                    <div>
                        <label class="block mb-2" style="font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--navy);">Phone</label>
                        <input type="tel" name="phone" class="field-input" placeholder="+256 …">
                    </div>
                </div>
                <div class="mb-[18px]">
                    <label class="block mb-2" style="font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--navy);">Event</label>
                    <div id="modalEventTitle" class="field-readonly">Please select an event</div>
                </div>
                <div class="flex gap-3 mt-7">
                    <button type="submit" class="btn-modal-submit flex-1 cursor-pointer transition-colors duration-200"
                            style="padding:15px;background:var(--navy);color:var(--gold2);font-family:'Jost',sans-serif;font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;border:none;"
                            onmouseover="this.style.background='var(--navy2)';"
                            onmouseout="this.style.background='var(--navy)';">Confirm Registration</button>
                    <button type="button" class="cursor-pointer transition-all duration-200"
                            style="padding:15px 24px;background:transparent;color:var(--muted);border:1px solid var(--border);font-family:'Jost',sans-serif;font-size:11px;font-weight:500;letter-spacing:.12em;text-transform:uppercase;"
                            onmouseover="this.style.borderColor='var(--navy)';this.style.color='var(--navy)';"
                            onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--muted)';"
                            onclick="closeRegistrationModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     DETAILS MODAL
══════════════════════════════════════ --}}
<div id="detailsModal" class="modal-overlay">
    <div class="modal-box wide">
        <button class="absolute top-[18px] right-5 z-10 w-9 h-9 rounded-full flex items-center justify-center cursor-pointer transition-all duration-200"
                style="background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);color:rgba(255,255,255,.7);font-size:20px;"
                onmouseover="this.style.background='rgba(255,255,255,.2)';this.style.color='#fff';"
                onmouseout="this.style.background='rgba(255,255,255,.1)';this.style.color='rgba(255,255,255,.7)';"
                onclick="closeDetailsModal()">×</button>
        <div class="modal-header-inner relative overflow-hidden" style="background:var(--navy);padding:38px 44px 30px;">
            <span class="absolute right-5 bottom-[-30px] pointer-events-none" style="font-size:140px;color:rgba(200,151,58,.06);font-family:serif;">✝</span>
            <p class="relative z-10 inline-flex items-center gap-2.5 mb-2" style="font-size:10px;font-weight:600;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);">
                <span style="display:block;width:28px;height:1px;background:var(--gold);"></span>Details
            </p>
            <h3 id="detailsTitle" class="relative z-10 font-semibold text-white mt-2.5 mb-1" style="font-family:'Cormorant Garamond',serif;font-size:30px;"></h3>
            <p id="detailsSubtitle" class="relative z-10" style="font-size:13px;color:rgba(255,255,255,.4);font-weight:300;"></p>
        </div>
        <div class="modal-body-inner" style="padding:36px 44px 40px;">
            <div id="detailsContent"></div>
        </div>
    </div>
</div>

@include('partials.member-modals')

<script>
/* ── Modals ── */
function openRegistrationModal()  { document.getElementById('registrationModal').classList.add('open'); document.body.style.overflow='hidden'; }
function closeRegistrationModal() { document.getElementById('registrationModal').classList.remove('open'); document.body.style.overflow=''; }
function closeDetailsModal()      { document.getElementById('detailsModal').classList.remove('open'); document.body.style.overflow=''; }
document.getElementById('registrationModal').addEventListener('click',e=>{if(e.target.id==='registrationModal')closeRegistrationModal();});
document.getElementById('detailsModal').addEventListener('click',e=>{if(e.target.id==='detailsModal')closeDetailsModal();});
document.addEventListener('keydown',e=>{if(e.key==='Escape'){closeRegistrationModal();closeDetailsModal();}});

function openEventModal(id,title){
    document.getElementById('event_id').value=id;
    document.getElementById('event_name_hidden').value=title;
    document.getElementById('modalEventTitle').textContent=title;
    document.getElementById('modalEventBadge').textContent=title;
    openRegistrationModal();
}

/* ── Tab switcher ── */
function switchTab(tab, btn) {
    document.querySelectorAll('.filter-tab').forEach(t=>{
        t.classList.remove('active');
        t.style.background='transparent'; t.style.color='var(--muted)'; t.style.borderColor='var(--border)';
    });
    btn.classList.add('active');
    const ev  = document.getElementById('eventsSection');
    const ann = document.getElementById('announcementsSection');
    const lbl = document.getElementById('filter-count-label');
    if(tab==='all')         { ev.style.display=''; ann.style.display=''; lbl.textContent='Showing all items'; }
    else if(tab==='events') { ev.style.display=''; ann.style.display='none'; lbl.textContent='Showing events only'; }
    else                    { ev.style.display='none'; ann.style.display=''; lbl.textContent='Showing announcements only'; }
}

/* ── viewDetails ── */
function viewDetails(id){
    fetch(`/updates/${id}`,{headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.json()).then(data=>{
        if(data.success){
            const ev=data.event;
            document.getElementById('detailsTitle').textContent=ev.title;
            document.getElementById('detailsSubtitle').textContent=ev.location||'';
            let html='';
            if(ev.excerpt) html+=`<div style="font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:400;font-style:italic;color:var(--muted);line-height:1.6;padding:16px 0 20px;border-bottom:1px solid var(--border);margin-bottom:16px;">${ev.excerpt}</div>`;
            if(ev.description) html+=`<p style="font-size:14px;color:#4a4f5e;line-height:1.85;font-weight:300;margin-bottom:16px;">${ev.description}</p>`;
            if(ev.content) html+=`<div style="font-size:14px;color:#4a4f5e;line-height:1.85;">${ev.content}</div>`;
            html+='<div style="margin-top:20px;">';
            if(ev.formatted_date_time) html+=`<div style="display:flex;align-items:center;gap:10px;padding:12px 0;border-bottom:1px solid var(--border);font-size:13px;color:var(--muted);"><span class="material-symbols-outlined" style="font-size:16px;color:var(--gold);flex-shrink:0;">calendar_month</span><span>${ev.formatted_date_time}</span></div>`;
            if(ev.location) html+=`<div style="display:flex;align-items:center;gap:10px;padding:12px 0;border-bottom:1px solid var(--border);font-size:13px;color:var(--muted);"><span class="material-symbols-outlined" style="font-size:16px;color:var(--gold);flex-shrink:0;">location_on</span><span>${ev.location}</span></div>`;
            html+='</div>';
            html+=`<div style="margin-top:28px;"><button onclick="closeDetailsModal();openEventModal(${id},'${ev.title.replace(/'/g,"\\'")}');" style="padding:14px 32px;background:var(--navy);color:var(--gold2);font-family:'Jost',sans-serif;font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;border:none;cursor:pointer;" onmouseover="this.style.background='var(--navy2)';" onmouseout="this.style.background='var(--navy)';">Register for this Event</button></div>`;
            document.getElementById('detailsContent').innerHTML=html;
            document.getElementById('detailsModal').classList.add('open');
            document.body.style.overflow='hidden';
        }
    }).catch(()=>{
        document.getElementById('detailsContent').innerHTML='<p style="color:var(--red)">Error loading details.</p>';
        document.getElementById('detailsModal').classList.add('open');
    });
}

/* ── viewAnnouncementDetails ── */
function viewAnnouncementDetails(id){
    fetch(`/updates/${id}`,{headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.json()).then(data=>{
        if(data.success){
            const ann=data.event;
            document.getElementById('detailsTitle').textContent=ann.title;
            document.getElementById('detailsSubtitle').textContent='Announcement';
            let html='';
            if(ann.description) html+=`<div style="font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:400;font-style:italic;color:var(--muted);line-height:1.6;padding:16px 0 20px;border-bottom:1px solid var(--border);margin-bottom:16px;">${ann.description}</div>`;
            if(ann.content) html+=`<div style="font-size:14px;color:#4a4f5e;line-height:1.85;font-weight:300;">${ann.content.replace(/\n/g,'<br>')}</div>`;
            html+='<div style="margin-top:20px;">';
            if(ann.created_at) html+=`<div style="display:flex;align-items:center;gap:10px;padding:12px 0;border-bottom:1px solid var(--border);font-size:13px;color:var(--muted);"><span class="material-symbols-outlined" style="font-size:16px;color:var(--gold);flex-shrink:0;">schedule</span><span>Posted ${new Date(ann.created_at).toLocaleDateString('en-GB',{day:'numeric',month:'long',year:'numeric'})}</span></div>`;
            if(ann.expires_at) html+=`<div style="display:flex;align-items:center;gap:10px;padding:12px 0;border-bottom:1px solid var(--border);font-size:13px;color:var(--muted);"><span class="material-symbols-outlined" style="font-size:16px;color:var(--gold);flex-shrink:0;">event_busy</span><span>Expires ${new Date(ann.expires_at).toLocaleDateString('en-GB',{day:'numeric',month:'long',year:'numeric'})}</span></div>`;
            html+='</div>';
            document.getElementById('detailsContent').innerHTML=html;
            document.getElementById('detailsModal').classList.add('open');
            document.body.style.overflow='hidden';
        }
    }).catch(()=>{
        document.getElementById('detailsContent').innerHTML='<p style="color:var(--red)">Error loading announcement.</p>';
        document.getElementById('detailsModal').classList.add('open');
    });
}

/* ── Form submit ── */
document.getElementById('eventForm').addEventListener('submit',async function(e){
    e.preventDefault();
    const form=this,btn=form.querySelector('.btn-modal-submit'),orig=btn.textContent;
    btn.disabled=true;btn.textContent='Submitting…';
    const data={first_name:form.querySelector('[name="first_name"]').value,last_name:form.querySelector('[name="last_name"]').value||'',email:form.querySelector('[name="email"]').value||null,phone:form.querySelector('[name="phone"]').value||null,event_id:form.querySelector('[name="event_id"]').value||null,event_name:form.querySelector('[name="event_name"]').value||null};
    if(!data.first_name||!data.event_id){showToast('Please provide your name and ensure an event is selected.','error');btn.disabled=false;btn.textContent=orig;return;}
    try{
        const token=document.querySelector('meta[name="csrf-token"]').content;
        const resp=await fetch('{{ route("event.registrations.store") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':token,'Accept':'application/json'},body:JSON.stringify(data)});
        const result=await resp.json();
        if(resp.ok){closeRegistrationModal();form.reset();showToast('Registration confirmed! We look forward to seeing you.','success');}
        else showToast(result.message||'Registration failed. Please try again.','error');
    }catch{showToast('Something went wrong. Please try again.','error');}
    finally{btn.disabled=false;btn.textContent=orig;}
});

/* ── Toast ── */
function showToast(msg,type='success'){
    const t=document.createElement('div');
    const styles={success:'background:#10b981;color:#ffffff;border-left:4px solid #059669;',error:'background:#ef4444;color:#ffffff;border-left:4px solid #dc2626;'};
    t.style.cssText=`position:fixed;top:24px;left:24px;z-index:9999;padding:16px 22px;min-width:280px;font-family:'Jost',sans-serif;font-size:14px;font-weight:500;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.15);animation:slideInLeft .3s ease both;${styles[type]||styles.success}`;
    t.textContent=msg;document.body.appendChild(t);
    if(!document.getElementById('toast-anim')){const s=document.createElement('style');s.id='toast-anim';s.textContent='@keyframes slideInLeft{from{opacity:0;transform:translateX(-100px);}to{opacity:1;transform:translateX(0);}}';document.head.appendChild(s);}
    setTimeout(()=>t.remove(),5000);
}

/* ── Carousel ── */
let currentSlide=0,carouselInterval;
function showSlide(i){
    const s=document.querySelectorAll('.carousel-slide'),d=document.querySelectorAll('.carousel-dot');
    if(!s.length)return;
    currentSlide=((i%s.length)+s.length)%s.length;
    s.forEach((el,j)=>el.classList.toggle('active',j===currentSlide));
    d.forEach((el,j)=>el.classList.toggle('active',j===currentSlide));
}
function nextSlide(){showSlide(currentSlide+1);resetAuto();}
function previousSlide(){showSlide(currentSlide-1);resetAuto();}
function goToSlide(i){showSlide(i);resetAuto();}
function resetAuto(){clearInterval(carouselInterval);carouselInterval=setInterval(()=>nextSlide(),5500);}

document.addEventListener('DOMContentLoaded',function(){
    if(document.querySelectorAll('.carousel-slide').length>1) resetAuto();
    const r=new URLSearchParams(window.location.search).get('register');
    if(r){let t='Event';document.querySelectorAll('[onclick*="openEventModal"]').forEach(el=>{const m=el.getAttribute('onclick').match(/openEventModal\((\d+),\s*'([^']+)'\)/);if(m&&m[1]===r)t=m[2];});setTimeout(()=>openEventModal(r,t),600);}
});
</script>
</body>
</html>