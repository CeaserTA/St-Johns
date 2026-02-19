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
:root {
    --navy:#0c1b3a;--navy2:#142450;--gold:#c8973a;--gold2:#e8b96a;
    --cream:#fdf8f0;--sand:#f5ede0;--text:#1a1a2e;--muted:#6b7080;
    --border:#e2d9cc;--white:#ffffff;--red:#c0392b;--green:#1a7a4a;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Jost',sans-serif;background:var(--cream);color:var(--text);overflow-x:hidden;}
@keyframes fadeUp{from{opacity:0;transform:translateY(24px)}to{opacity:1;transform:translateY(0)}}
@keyframes pulse-dot{0%,100%{opacity:1}50%{opacity:.4}}
.fade-up{animation:fadeUp .75s ease both;}
.fade-up-1{animation-delay:.08s}.fade-up-2{animation-delay:.18s}.fade-up-3{animation-delay:.28s}
.eyebrow{display:inline-flex;align-items:center;gap:10px;font-size:10px;font-weight:600;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);}
.eyebrow::before{content:'';display:block;width:28px;height:1px;background:var(--gold);}
.flash{display:flex;align-items:flex-start;gap:12px;padding:16px 24px;margin:16px 24px;font-size:14px;}
.flash.success{background:#edf7f2;border-left:3px solid var(--green);color:#155d38;}
.flash.error{background:#fdf2f0;border-left:3px solid var(--red);color:#8b2020;}
.flash-title{font-weight:600;margin-bottom:2px;}

/* PAGE HERO */
.page-hero{background:var(--navy);padding:72px 40px 64px;position:relative;overflow:hidden;text-align:center;}
.page-hero::before{content:'';position:absolute;inset:0;background:repeating-linear-gradient(45deg,transparent,transparent 40px,rgba(201,168,76,.03) 40px,rgba(201,168,76,.03) 41px);pointer-events:none;}
.page-hero-cross{position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);font-size:380px;color:rgba(200,151,58,.04);pointer-events:none;user-select:none;font-family:serif;line-height:1;}
.page-hero-inner{position:relative;z-index:1;max-width:680px;margin:0 auto;}
.page-hero h1{font-family:'Cormorant Garamond',serif;font-size:clamp(48px,8vw,84px);font-weight:600;color:#fff;line-height:.95;letter-spacing:-.01em;margin:14px 0 18px;}
.page-hero h1 em{font-style:italic;color:var(--gold2);font-weight:300;}
.page-hero .sub{font-size:13px;font-weight:300;color:rgba(255,255,255,.45);line-height:1.8;}

/* CAROUSEL */
.carousel-wrap{max-width:1200px;margin:0 auto;padding:56px 40px 0;}
.carousel-header{display:flex;align-items:baseline;justify-content:space-between;margin-bottom:20px;}
.carousel-title{font-family:'Cormorant Garamond',serif;font-size:28px;font-weight:600;color:var(--navy);}
.carousel-nav{display:flex;gap:8px;}
.carousel-btn{width:38px;height:38px;border:1px solid var(--border);background:var(--white);border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--muted);transition:all .2s;}
.carousel-btn:hover{border-color:var(--navy);color:var(--navy);}
.carousel-btn .material-symbols-outlined{font-size:20px;}
.carousel-container{position:relative;border-radius:2px;overflow:hidden;aspect-ratio:21/7;background:var(--navy2);}
.carousel-slide{position:absolute;inset:0;opacity:0;transition:opacity .55s ease;pointer-events:none;}
.carousel-slide.active{opacity:1;pointer-events:auto;}
.carousel-bg{position:absolute;inset:0;background-size:cover;background-position:center;transform:scale(1.04);transition:transform 8s ease;}
.carousel-slide.active .carousel-bg{transform:scale(1);}
.carousel-overlay{position:absolute;inset:0;background:linear-gradient(to right,rgba(12,27,58,.88) 0%,rgba(12,27,58,.5) 55%,rgba(12,27,58,.1) 100%);display:flex;flex-direction:column;justify-content:center;padding:40px 52px;color:#fff;}
.carousel-badge{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;background:var(--gold);color:var(--navy);font-size:9px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;width:fit-content;margin-bottom:16px;}
.carousel-badge .material-symbols-outlined{font-size:13px;}
.carousel-event-title{font-family:'Cormorant Garamond',serif;font-size:clamp(28px,4vw,44px);font-weight:600;line-height:1.1;color:#fff;max-width:480px;margin-bottom:12px;}
.carousel-event-excerpt{font-size:13.5px;font-weight:300;color:rgba(255,255,255,.65);max-width:380px;margin-bottom:28px;line-height:1.7;}
.carousel-ctas{display:flex;gap:12px;flex-wrap:wrap;}
.btn-carousel-primary{display:inline-flex;align-items:center;gap:8px;padding:13px 28px;background:var(--gold);color:var(--navy);font-family:'Jost',sans-serif;font-size:11px;font-weight:600;letter-spacing:.18em;text-transform:uppercase;border:none;cursor:pointer;transition:all .25s;position:relative;overflow:hidden;}
.btn-carousel-primary::before{content:'';position:absolute;inset:0;background:var(--gold2);transform:translateX(-100%);transition:transform .3s ease;}
.btn-carousel-primary:hover::before{transform:translateX(0);}
.btn-carousel-primary span{position:relative;z-index:1;}
.btn-carousel-secondary{display:inline-flex;align-items:center;gap:8px;padding:12px 26px;background:transparent;color:#fff;border:1px solid rgba(255,255,255,.3);font-family:'Jost',sans-serif;font-size:11px;font-weight:500;letter-spacing:.14em;text-transform:uppercase;cursor:pointer;transition:all .22s;}
.btn-carousel-secondary:hover{border-color:var(--gold2);color:var(--gold2);}
.carousel-date-badge{position:absolute;top:24px;right:28px;background:var(--navy);border:1px solid rgba(200,151,58,.3);padding:10px 16px;text-align:center;}
.carousel-date-mon{font-size:9px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--gold);display:block;}
.carousel-date-day{font-family:'Cormorant Garamond',serif;font-size:32px;font-weight:700;color:#fff;line-height:1;display:block;}
.carousel-indicators{position:absolute;bottom:20px;right:24px;display:flex;gap:6px;z-index:10;}
.carousel-dot{width:6px;height:6px;background:rgba(255,255,255,.3);border:none;cursor:pointer;transition:all .3s;}
.carousel-dot.active{width:22px;background:var(--gold);}
.carousel-empty{background:var(--navy2);display:flex;align-items:center;justify-content:center;flex-direction:column;gap:12px;color:rgba(255,255,255,.35);aspect-ratio:21/7;border-radius:2px;}
.carousel-empty .material-symbols-outlined{font-size:48px;opacity:.3;}
.carousel-empty p{font-family:'Cormorant Garamond',serif;font-size:22px;font-weight:600;}
.carousel-empty small{font-size:12px;font-weight:300;}

/* FILTER */
.filter-wrap{max-width:1200px;margin:0 auto;padding:44px 40px 0;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px;}
.filter-tabs{display:flex;gap:4px;}
.filter-tab{padding:9px 22px;font-family:'Jost',sans-serif;font-size:11px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;border:1px solid var(--border);background:transparent;color:var(--muted);cursor:pointer;transition:all .2s;}
.filter-tab:hover{border-color:var(--navy);color:var(--navy);}
.filter-tab.active{background:var(--navy);color:var(--gold2);border-color:var(--navy);}
.filter-count{font-size:11px;color:var(--muted);font-weight:300;}

/* CONTENT GRID */
.content-grid{max-width:1200px;margin:0 auto;padding:32px 40px 80px;display:grid;grid-template-columns:repeat(3,1fr);gap:24px;}

/* Event card */
.event-card{background:var(--white);border:1px solid var(--border);border-radius:2px;overflow:hidden;display:flex;flex-direction:column;transition:all .3s ease;position:relative;}
.event-card::after{content:'';position:absolute;bottom:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--gold),var(--gold2));transform:scaleX(0);transform-origin:left;transition:transform .35s ease;}
.event-card:hover{box-shadow:0 16px 48px rgba(12,27,58,.09);transform:translateY(-3px);border-color:transparent;}
.event-card:hover::after{transform:scaleX(1);}
.event-img-wrap{position:relative;aspect-ratio:16/9;overflow:hidden;background:var(--sand);}
.event-img-wrap img{width:100%;height:100%;object-fit:cover;transition:transform .5s ease;}
.event-card:hover .event-img-wrap img{transform:scale(1.04);}
.event-date-stamp{position:absolute;top:16px;left:16px;background:var(--navy);border:1px solid rgba(200,151,58,.25);padding:6px 12px;text-align:center;}
.event-date-mon{font-size:8px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;color:var(--gold);display:block;}
.event-date-day{font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:700;color:#fff;line-height:1;display:block;}
.event-upcoming-badge{position:absolute;bottom:12px;right:12px;display:inline-flex;align-items:center;gap:5px;padding:4px 10px;background:var(--red);color:#fff;font-size:8px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;}
.badge-dot{width:5px;height:5px;background:#fff;border-radius:50%;animation:pulse-dot 1.4s ease infinite;}
.event-body{padding:22px 22px 20px;flex:1;display:flex;flex-direction:column;}
.event-meta{display:flex;align-items:center;gap:6px;font-size:11px;color:var(--gold);font-weight:600;letter-spacing:.08em;margin-bottom:10px;}
.event-meta .material-symbols-outlined{font-size:14px;}
.event-title{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:600;color:var(--navy);line-height:1.2;margin-bottom:10px;}
.event-excerpt{font-size:13px;color:var(--muted);line-height:1.75;font-weight:300;margin-bottom:20px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.btn-event{margin-top:auto;width:100%;padding:12px;background:var(--navy);color:var(--gold2);font-family:'Jost',sans-serif;font-size:10px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;border:none;cursor:pointer;transition:background .2s;display:flex;align-items:center;justify-content:center;gap:8px;}
.btn-event:hover{background:var(--navy2);}

/* Announcement card */
.announcement-card{background:var(--cream);border:1px solid var(--border);border-radius:2px;padding:28px 26px;display:flex;flex-direction:column;transition:all .25s ease;position:relative;overflow:hidden;}
.announcement-card::before{content:'';position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--gold);transform:scaleY(0);transform-origin:bottom;transition:transform .25s;}
.announcement-card:hover{border-color:rgba(200,151,58,.3);box-shadow:0 8px 28px rgba(12,27,58,.07);transform:translateY(-2px);}
.announcement-card:hover::before{transform:scaleY(1);}
.announcement-eyebrow{display:flex;align-items:center;gap:10px;margin-bottom:16px;}
.announcement-icon{width:36px;height:36px;background:var(--navy);border-radius:2px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.announcement-icon .material-symbols-outlined{font-size:18px;color:var(--gold2);}
.announcement-tag{font-size:9px;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);display:block;}
.announcement-date{font-size:11px;color:var(--muted);font-weight:300;}
.announcement-title{font-family:'Cormorant Garamond',serif;font-size:20px;font-weight:600;color:var(--navy);line-height:1.25;margin-bottom:10px;}
.announcement-excerpt{font-size:13px;color:var(--muted);line-height:1.75;font-weight:300;flex:1;margin-bottom:20px;}
.btn-announcement{width:100%;padding:12px;background:transparent;color:var(--navy);border:1px solid var(--border);font-family:'Jost',sans-serif;font-size:10px;font-weight:600;letter-spacing:.18em;text-transform:uppercase;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:8px;}
.btn-announcement:hover{border-color:var(--navy);background:var(--navy);color:var(--gold2);}

.empty-state{grid-column:1/-1;text-align:center;padding:72px 0;}
.load-more-wrap{text-align:center;padding:0 0 64px;}
.btn-load-more{display:inline-flex;align-items:center;gap:10px;padding:14px 36px;background:var(--white);color:var(--navy);border:1px solid var(--border);font-family:'Jost',sans-serif;font-size:11px;font-weight:600;letter-spacing:.18em;text-transform:uppercase;cursor:pointer;transition:all .2s;}
.btn-load-more:hover{border-color:var(--navy);}
.load-more-sub{font-size:11px;color:var(--muted);margin-top:10px;}

/* MODALS */
.modal-overlay{position:fixed;inset:0;z-index:999;background:rgba(12,27,58,.72);backdrop-filter:blur(4px);display:none;align-items:center;justify-content:center;padding:20px;overflow-y:auto;}
.modal-overlay.open{display:flex;}
.modal-box{position:relative;background:var(--white);width:100%;max-width:560px;border-radius:2px;overflow:hidden;box-shadow:0 32px 100px rgba(0,0,0,.28);animation:fadeUp .35s ease both;}
.modal-box.wide{max-width:700px;}
.modal-close{position:absolute;top:18px;right:20px;width:36px;height:36px;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;color:rgba(255,255,255,.7);font-size:20px;transition:all .2s;z-index:10;}
.modal-close:hover{background:rgba(255,255,255,.2);color:#fff;}
.modal-header{background:var(--navy);padding:38px 44px 30px;position:relative;overflow:hidden;}
.modal-header::after{content:'✝';position:absolute;right:20px;bottom:-30px;font-size:140px;color:rgba(200,151,58,.06);pointer-events:none;}
.modal-header h3{font-family:'Cormorant Garamond',serif;font-size:30px;font-weight:600;color:#fff;margin:10px 0 6px;position:relative;z-index:1;}
.modal-header p{font-size:13px;color:rgba(255,255,255,.4);font-weight:300;position:relative;z-index:1;}
.modal-event-badge{display:inline-block;margin-top:12px;padding:5px 14px;background:rgba(200,151,58,.15);border:1px solid rgba(200,151,58,.3);font-size:12px;color:var(--gold2);font-weight:400;position:relative;z-index:1;}
.modal-body{padding:36px 44px 40px;}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:18px;}
.form-row.full{grid-template-columns:1fr;}
.field-label{display:block;font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--navy);margin-bottom:8px;}
.field-req{color:var(--gold);}
.field-input{width:100%;padding:12px 16px;background:var(--cream);border:1px solid var(--border);font-family:'Jost',sans-serif;font-size:14px;color:var(--text);transition:all .2s;outline:none;border-radius:0;}
.field-input:focus{background:var(--white);border-color:var(--gold);box-shadow:0 0 0 3px rgba(200,151,58,.1);}
.field-input::placeholder{color:#b5b9c4;}
.field-input.readonly{background:var(--sand);color:var(--muted);cursor:default;border-color:transparent;font-size:13px;font-weight:300;}
.modal-actions{display:flex;gap:12px;margin-top:28px;}
.btn-modal-submit{flex:1;padding:15px;background:var(--navy);color:var(--gold2);font-family:'Jost',sans-serif;font-size:11px;font-weight:600;letter-spacing:.2em;text-transform:uppercase;border:none;cursor:pointer;transition:background .2s;}
.btn-modal-submit:hover{background:var(--navy2);}
.btn-modal-cancel{padding:15px 24px;background:transparent;color:var(--muted);border:1px solid var(--border);font-family:'Jost',sans-serif;font-size:11px;font-weight:500;letter-spacing:.12em;text-transform:uppercase;cursor:pointer;transition:all .2s;}
.btn-modal-cancel:hover{border-color:var(--navy);color:var(--navy);}
.details-prose p{font-size:14px;color:#4a4f5e;line-height:1.85;font-weight:300;margin-bottom:16px;}
.details-meta-row{display:flex;align-items:center;gap:10px;padding:12px 0;border-bottom:1px solid var(--border);font-size:13px;color:var(--muted);}
.details-meta-row:first-child{border-top:1px solid var(--border);margin-top:20px;}
.details-meta-row .material-symbols-outlined{font-size:16px;color:var(--gold);flex-shrink:0;}
.details-excerpt{font-family:'Cormorant Garamond',serif;font-size:18px;font-weight:400;font-style:italic;color:var(--muted);line-height:1.6;padding:16px 0 20px;border-bottom:1px solid var(--border);margin-bottom:16px;}

@media(max-width:1024px){.content-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:640px){
    .content-grid,.carousel-wrap,.filter-wrap{padding:24px 20px;}
    .content-grid{grid-template-columns:1fr;}
    .page-hero{padding:56px 20px 48px;}
    .carousel-overlay{padding:28px;}
    .modal-header{padding:28px 24px 22px;}
    .modal-body{padding:24px;}
    .form-row{grid-template-columns:1fr;}
}
</style>
</head>
<body>
@include('partials.navbar')
@include('partials.announcement')

@if ($message = Session::get('success'))
    <div class="flash success" role="alert">
        <span class="material-symbols-outlined" style="font-size:18px;flex-shrink:0;color:var(--green);">check_circle</span>
        <div><div class="flash-title">Success</div>{{ $message }}</div>
    </div>
@endif
@if ($message = Session::get('error'))
    <div class="flash error" role="alert">
        <span class="material-symbols-outlined" style="font-size:18px;flex-shrink:0;color:var(--red);">error</span>
        <div><div class="flash-title">Error</div>{{ $message }}</div>
    </div>
@endif

{{-- PAGE HERO --}}
<section class="page-hero">
    <div class="page-hero-cross">✝</div>
    <div class="page-hero-inner">
        <p class="eyebrow fade-up fade-up-1" style="justify-content:center;">Life at St. John's</p>
        <h1 class="fade-up fade-up-2">Events &<br><em>Announcements</em></h1>
        <p class="sub fade-up fade-up-3">Stay connected with everything happening in our parish community.</p>
    </div>
</section>

{{-- CAROUSEL --}}
<div class="carousel-wrap">
    <div class="carousel-header">
        <div class="carousel-title">
            <span style="font-family:'Jost',sans-serif;font-size:11px;font-weight:600;letter-spacing:.18em;text-transform:uppercase;color:var(--gold);display:block;margin-bottom:4px;">This Week</span>
            What's Happening
        </div>
        @if(isset($thisWeekEvents) && $thisWeekEvents->count() > 1)
        <div class="carousel-nav">
            <button class="carousel-btn" onclick="previousSlide()"><span class="material-symbols-outlined">chevron_left</span></button>
            <button class="carousel-btn" onclick="nextSlide()"><span class="material-symbols-outlined">chevron_right</span></button>
        </div>
        @endif
    </div>

    @if(isset($thisWeekEvents) && $thisWeekEvents->count() > 0)
    <div class="carousel-container">
        @foreach($thisWeekEvents as $index => $weekEvent)
        <div class="carousel-slide {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}">
            <div class="carousel-bg" style="background-image:url('{{ $weekEvent->image_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBJuBVtqw9UvSxdwxXR4HOoRKNwjmp9luc3fMocyA9NTqdPQivYkifWnUaMwnjyQq3T4squ6UlhiwnVUaXW1dGBb9iQTqAWj2ZWY0cDsr8_w0zYXf4_sbb551OYF9iq1ViLJ1oSTTDppAlvmUWZuWIo8Etdwaaf_zx3Twh1p4XfM8eHKL64rCtraA9U_aCR3AJcZ_L-6y2nwV4LQ3nNURKG3gPTol5sCwQWKy93zdr-wzJtb_VykEtdfU3XC_2Nsxabk4C2zBpbrrgU' }}');"></div>
            <div class="carousel-overlay">
                <div class="carousel-badge">
                    <span class="material-symbols-outlined" style="font-size:12px;">star</span>
                    <span>This Week</span>
                </div>
                <h3 class="carousel-event-title">{{ $weekEvent->title }}</h3>
                <p class="carousel-event-excerpt">{{ $weekEvent->excerpt }}</p>
                <div class="carousel-ctas">
                    <button class="btn-carousel-primary" onclick="openEventModal({{ $weekEvent->id }}, '{{ addslashes($weekEvent->title) }}')">
                        <span>Register Now</span>
                        <span class="material-symbols-outlined" style="font-size:16px;position:relative;z-index:1;">arrow_forward</span>
                    </button>
                    <button class="btn-carousel-secondary" onclick="viewDetails({{ $weekEvent->id }})">
                        <span class="material-symbols-outlined" style="font-size:16px;">open_in_new</span>
                        View Details
                    </button>
                </div>
            </div>
            @if($weekEvent->starts_at || isset($weekEvent->date))
            <div class="carousel-date-badge">
                <span class="carousel-date-mon">{{ ($weekEvent->starts_at ?? $weekEvent->date)->format('M') }}</span>
                <span class="carousel-date-day">{{ ($weekEvent->starts_at ?? $weekEvent->date)->format('d') }}</span>
            </div>
            @endif
        </div>
        @endforeach
        @if($thisWeekEvents->count() > 1)
        <div class="carousel-indicators">
            @foreach($thisWeekEvents as $index => $w)
            <button class="carousel-dot {{ $index === 0 ? 'active' : '' }}" onclick="goToSlide({{ $index }})" data-indicator="{{ $index }}"></button>
            @endforeach
        </div>
        @endif
    </div>
    @else
    <div class="carousel-empty">
        <span class="material-symbols-outlined">event_available</span>
        <p>No Featured Events This Week</p>
        <small>Browse upcoming events and announcements below.</small>
    </div>
    @endif
</div>

{{-- FILTER BAR --}}
<div class="filter-wrap">
    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterItems('all',this)">All</button>
        <button class="filter-tab" onclick="filterItems('event',this)">Events</button>
        <button class="filter-tab" onclick="filterItems('announcement',this)">Announcements</button>
    </div>
    <span class="filter-count" id="filter-count-label">Showing all items</span>
</div>

{{-- CONTENT GRID --}}
<div class="content-grid" id="contentGrid">
    @forelse($events->where('is_active', true) as $item)
        @if($item->is_event)
        <div class="event-card" data-type="event">
            <div class="event-img-wrap">
                <img alt="{{ $item->title }}" src="{{ $item->image_url ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuA-fKy9IwvMJcFgNjBgGeqCsxWDf45Y4A3gyZUE0COYXjV920Ecw2UpyEdz8lSsQqNt776sga6zUAQS8SPhICaU176kI8yjAEMMbs4eK9MicH34I1kLcLiReOivpIM5AbWccAQyTb-EKZ-l-UrAetKIMAAI-C97PCSC2V2192XhCBWzDDGQuKv45DxBy8RiXAe8PgX196bflqvN9A49hfA5Or-6_WfSO1P0G6VWUR_0DQujdRDI0UigGGPic8rQmPJ7ha6OdUxX-tTB' }}" />
                <div class="event-date-stamp">
                    <span class="event-date-mon">{{ $item->starts_at ? $item->starts_at->format('M') : ($item->date ? $item->date->format('M') : '?') }}</span>
                    <span class="event-date-day">{{ $item->starts_at ? $item->starts_at->format('d') : ($item->date ? $item->date->format('d') : '--') }}</span>
                </div>
                @if($item->is_upcoming)
                <div class="event-upcoming-badge"><div class="badge-dot"></div>Upcoming</div>
                @endif
            </div>
            <div class="event-body">
                <div class="event-meta">
                    <span class="material-symbols-outlined">schedule</span>
                    {{ $item->formatted_time ?? 'TBD' }}
                    @if($item->location)<span style="color:var(--border);">·</span>{{ $item->location }}@endif
                </div>
                <div class="event-title">{{ $item->title }}</div>
                <p class="event-excerpt">{{ $item->excerpt }}</p>
                <div style="display:flex;gap:10px;margin-top:auto;">
                    <button class="btn-event" style="flex:1;" onclick="openEventModal({{ $item->id }}, '{{ addslashes($item->title) }}')">
                        <span>Register</span>
                        <span class="material-symbols-outlined" style="font-size:15px;">arrow_forward</span>
                    </button>
                    <button onclick="viewDetails({{ $item->id }})"
                        style="padding:12px 14px;background:transparent;border:1px solid var(--border);color:var(--muted);cursor:pointer;transition:all .2s;flex-shrink:0;"
                        onmouseover="this.style.borderColor='var(--navy)';this.style.color='var(--navy)'"
                        onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--muted)'">
                        <span class="material-symbols-outlined" style="font-size:18px;display:block;">open_in_new</span>
                    </button>
                </div>
            </div>
        </div>
        @else
        <div class="announcement-card" data-type="announcement">
            <div class="announcement-eyebrow">
                <div class="announcement-icon"><span class="material-symbols-outlined">campaign</span></div>
                <div>
                    <span class="announcement-tag">Announcement</span>
                    <span class="announcement-date">{{ $item->created_at->diffForHumans() }}</span>
                </div>
            </div>
            <div class="announcement-title">{{ $item->title }}</div>
            <p class="announcement-excerpt">{{ $item->excerpt }}</p>
            <button class="btn-announcement" onclick="viewAnnouncementDetails({{ $item->id }})">
                <span>Read More</span>
                <span class="material-symbols-outlined" style="font-size:15px;">arrow_forward</span>
            </button>
        </div>
        @endif
    @empty
        <div class="empty-state">
            <span class="material-symbols-outlined" style="font-size:52px;color:var(--border);">event_busy</span>
            <p style="font-family:'Cormorant Garamond',serif;font-size:24px;font-weight:600;color:var(--muted);margin-top:16px;">Nothing here yet</p>
            <p style="font-size:13px;color:#bbb;margin-top:6px;">Events and announcements will appear here as they're added.</p>
        </div>
    @endforelse
</div>

@if(isset($events) && $events->count() > 6)
<div class="load-more-wrap">
    <button class="btn-load-more">
        <span>Load More</span>
        <span class="material-symbols-outlined">keyboard_arrow_down</span>
    </button>
    <div class="load-more-sub">Showing {{ min(6, $events->count()) }} of {{ $events->count() }} items</div>
</div>
@endif

@include('partials.footer')

{{-- REGISTRATION MODAL --}}
<div id="registrationModal" class="modal-overlay">
    <div class="modal-box">
        <button class="modal-close" onclick="closeRegistrationModal()">×</button>
        <div class="modal-header">
            <p class="eyebrow" style="color:var(--gold);">Event Registration</p>
            <h3>Reserve Your<br>Spot</h3>
            <p>Fill in your details and we'll confirm your place.</p>
            <div class="modal-event-badge" id="modalEventBadge">Select an event</div>
        </div>
        <div class="modal-body">
            <form id="eventForm" action="{{ route('event.registrations.store') }}" method="POST">
                @csrf
                <input type="hidden" name="event_id" id="event_id" />
                <input type="hidden" name="event_name" id="event_name_hidden" />
                <div class="form-row">
                    <div>
                        <label class="field-label">First Name <span class="field-req">*</span></label>
                        <input type="text" name="first_name" required class="field-input" placeholder="Your first name">
                    </div>
                    <div>
                        <label class="field-label">Last Name</label>
                        <input type="text" name="last_name" class="field-input" placeholder="Your last name">
                    </div>
                </div>
                <div class="form-row">
                    <div>
                        <label class="field-label">Email</label>
                        <input type="email" name="email" class="field-input" placeholder="you@example.com">
                    </div>
                    <div>
                        <label class="field-label">Phone</label>
                        <input type="tel" name="phone" class="field-input" placeholder="+256 …">
                    </div>
                </div>
                <div class="form-row full">
                    <div>
                        <label class="field-label">Event</label>
                        <div id="modalEventTitle" class="field-input readonly">Please select an event</div>
                    </div>
                </div>
                <div class="modal-actions">
                    <button type="submit" class="btn-modal-submit">Confirm Registration</button>
                    <button type="button" class="btn-modal-cancel" onclick="closeRegistrationModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- DETAILS MODAL --}}
<div id="detailsModal" class="modal-overlay">
    <div class="modal-box wide">
        <button class="modal-close" onclick="closeDetailsModal()">×</button>
        <div class="modal-header">
            <p class="eyebrow" style="color:var(--gold);">Details</p>
            <h3 id="detailsTitle">Details</h3>
            <p id="detailsSubtitle"></p>
        </div>
        <div class="modal-body">
            <div id="detailsContent" class="details-prose"></div>
        </div>
    </div>
</div>

@include('partials.member-modals')

<script>
function openRegistrationModal(){document.getElementById('registrationModal').classList.add('open');document.body.style.overflow='hidden';}
function closeRegistrationModal(){document.getElementById('registrationModal').classList.remove('open');document.body.style.overflow='';}
function closeDetailsModal(){document.getElementById('detailsModal').classList.remove('open');document.body.style.overflow='';}
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

function viewDetails(id){
    fetch(`/updates/${id}`,{headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.json()).then(data=>{
        if(data.success){
            const ev=data.event;
            document.getElementById('detailsTitle').textContent=ev.title;
            document.getElementById('detailsSubtitle').textContent=ev.location||'';
            let html='';
            if(ev.excerpt) html+=`<div class="details-excerpt">${ev.excerpt}</div>`;
            if(ev.description) html+=`<p>${ev.description}</p>`;
            if(ev.content) html+=`<div>${ev.content}</div>`;
            html+='<div>';
            if(ev.formatted_date_time) html+=`<div class="details-meta-row"><span class="material-symbols-outlined">calendar_month</span><span>${ev.formatted_date_time}</span></div>`;
            if(ev.location) html+=`<div class="details-meta-row"><span class="material-symbols-outlined">location_on</span><span>${ev.location}</span></div>`;
            html+='</div>';
            html+=`<div style="margin-top:28px;"><button onclick="closeDetailsModal();openEventModal(${id},'${ev.title.replace(/'/g,"\\'")}');" class="btn-modal-submit" style="width:auto;padding:14px 32px;">Register for this Event</button></div>`;
            document.getElementById('detailsContent').innerHTML=html;
            document.getElementById('detailsModal').classList.add('open');
            document.body.style.overflow='hidden';
        }
    }).catch(()=>{
        document.getElementById('detailsContent').innerHTML='<p style="color:var(--red)">Error loading details.</p>';
        document.getElementById('detailsModal').classList.add('open');
    });
}

function viewAnnouncementDetails(id){
    fetch(`/updates/${id}`,{headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.json()).then(data=>{
        if(data.success){
            const ann=data.event;
            document.getElementById('detailsTitle').textContent=ann.title;
            document.getElementById('detailsSubtitle').textContent='Announcement';
            let html='';
            if(ann.description) html+=`<div class="details-excerpt">${ann.description}</div>`;
            if(ann.content) html+=`<div class="details-prose">${ann.content.replace(/\n/g,'<br>')}</div>`;
            html+='<div>';
            if(ann.created_at) html+=`<div class="details-meta-row"><span class="material-symbols-outlined">schedule</span><span>Posted ${new Date(ann.created_at).toLocaleDateString('en-GB',{day:'numeric',month:'long',year:'numeric'})}</span></div>`;
            if(ann.expires_at) html+=`<div class="details-meta-row"><span class="material-symbols-outlined">event_busy</span><span>Expires ${new Date(ann.expires_at).toLocaleDateString('en-GB',{day:'numeric',month:'long',year:'numeric'})}</span></div>`;
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

function filterItems(type,btn){
    const cards=document.querySelectorAll('.event-card,.announcement-card');
    document.querySelectorAll('.filter-tab').forEach(t=>t.classList.remove('active'));
    if(btn) btn.classList.add('active');
    let shown=0;
    cards.forEach(card=>{const match=type==='all'||card.dataset.type===type;card.style.display=match?'flex':'none';if(match)shown++;});
    const lbl=document.getElementById('filter-count-label');
    if(lbl) lbl.textContent=type==='all'?`Showing all ${shown} items`:`Showing ${shown} ${type}${shown!==1?'s':''}`;
}

document.getElementById('eventForm').addEventListener('submit',async function(e){
    e.preventDefault();
    const form=this;
    const btn=form.querySelector('.btn-modal-submit');
    const orig=btn.textContent;
    btn.disabled=true; btn.textContent='Submitting…';
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

function showToast(msg,type='success'){
    const t=document.createElement('div');
    t.style.cssText=`position:fixed;top:24px;right:24px;z-index:9999;padding:16px 22px;min-width:280px;font-family:'Jost',sans-serif;font-size:13px;border-radius:2px;animation:fadeUp .3s ease both;${type==='success'?'background:#0c1b3a;color:#e8b96a;border-left:3px solid #c8973a;':'background:#fff;color:#c0392b;border-left:3px solid #c0392b;box-shadow:0 8px 24px rgba(0,0,0,.12);'}`;
    t.textContent=msg;
    document.body.appendChild(t);
    setTimeout(()=>t.remove(),5000);
}

let currentSlide=0,carouselInterval;
function showSlide(i){const s=document.querySelectorAll('.carousel-slide'),d=document.querySelectorAll('.carousel-dot');if(!s.length)return;currentSlide=((i%s.length)+s.length)%s.length;s.forEach((el,j)=>el.classList.toggle('active',j===currentSlide));d.forEach((el,j)=>el.classList.toggle('active',j===currentSlide));}
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