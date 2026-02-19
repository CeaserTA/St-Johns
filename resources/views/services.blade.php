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
/* ── TOKENS (same as home) ── */
:root {
    --navy:   #0c1b3a;
    --navy2:  #142450;
    --gold:   #c8973a;
    --gold2:  #e8b96a;
    --cream:  #fdf8f0;
    --sand:   #f5ede0;
    --text:   #1a1a2e;
    --muted:  #6b7080;
    --border: #e2d9cc;
    --white:  #ffffff;
    --red:    #c0392b;
    --green:  #1a7a4a;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Jost', sans-serif; background: var(--cream); color: var(--text); overflow-x: hidden; }
.serif { font-family: 'Cormorant Garamond', serif; }

/* ── ANIMATIONS ── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
}
.fade-up   { animation: fadeUp 0.75s ease both; }
.fade-up-1 { animation-delay: 0.1s; }
.fade-up-2 { animation-delay: 0.25s; }
.fade-up-3 { animation-delay: 0.4s; }

/* ── EYEBROW ── */
.eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: var(--gold);
}
.eyebrow::before { content:''; display:block; width:28px; height:1px; background:var(--gold); }

/* ── FLASH MESSAGES ── */
.flash { display:flex; align-items:flex-start; gap:12px; padding:16px 24px; margin:16px 24px; border-radius:2px; font-size:14px; }
.flash.success { background:#edf7f2; border-left:3px solid var(--green); color:#155d38; }
.flash.error   { background:#fdf2f0; border-left:3px solid var(--red); color:#8b2020; }
.flash-title   { font-weight:600; margin-bottom:2px; }

/* ════════════════════════════
   PAGE HERO (short, editorial)
════════════════════════════ */
.page-hero {
    background: var(--navy);
    padding: 80px 40px 72px;
    position: relative;
    overflow: hidden;
    text-align: center;
}
.page-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: repeating-linear-gradient(
        45deg, transparent, transparent 40px,
        rgba(201,168,76,0.03) 40px, rgba(201,168,76,0.03) 41px
    );
    pointer-events: none;
}
.page-hero-cross {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    font-size: 400px;
    color: rgba(200,151,58,0.04);
    pointer-events: none;
    user-select: none;
    font-family: serif;
    line-height: 1;
}
.page-hero-inner { position: relative; z-index: 1; max-width: 700px; margin: 0 auto; }
.page-hero h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(52px, 8vw, 88px);
    font-weight: 600;
    color: #fff;
    line-height: 0.95;
    letter-spacing: -0.01em;
    margin: 14px 0 20px;
}
.page-hero h1 em { font-style: italic; color: var(--gold2); font-weight: 300; }
.page-hero p {
    font-size: 14px;
    font-weight: 300;
    color: rgba(255,255,255,0.5);
    line-height: 1.8;
    max-width: 520px;
    margin: 0 auto 10px;
}
.page-hero .verse {
    font-family: 'Cormorant Garamond', serif;
    font-size: 15px;
    font-style: italic;
    color: rgba(255,255,255,0.35);
    margin-top: 24px;
}

/* ════════════════════════════
   SERVICES GRID
════════════════════════════ */
.services-section {
    padding: 88px 0;
    background: var(--white);
}
.section-inner { max-width: 1200px; margin: 0 auto; padding: 0 40px; }

.section-header { text-align: center; margin-bottom: 60px; }
.section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(34px, 5vw, 52px);
    font-weight: 600;
    color: var(--navy);
    line-height: 1.1;
    margin: 12px 0 16px;
}
.section-desc { font-size: 14px; color: var(--muted); max-width: 500px; margin: 0 auto; line-height: 1.75; font-weight: 300; }

/* Service cards */
.services-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}
.service-card {
    background: var(--cream);
    border: 1px solid var(--border);
    border-radius: 2px;
    padding: 32px 24px 28px;
    text-align: center;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}
.service-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--gold), var(--gold2));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.35s ease;
}
.service-card::after {
    content: '';
    position: absolute;
    bottom: -20px; right: -10px;
    font-size: 90px;
    opacity: 0.04;
    pointer-events: none;
    transition: opacity 0.3s;
}
.service-card:hover {
    background: var(--white);
    box-shadow: 0 16px 48px rgba(12,27,58,0.09);
    transform: translateY(-3px);
    border-color: transparent;
}
.service-card:hover::before { transform: scaleX(1); }
.service-card:hover::after  { opacity: 0.07; }

.service-icon-wrap {
    width: 56px; height: 56px;
    margin: 0 auto 20px;
    background: var(--navy);
    border-radius: 2px;
    display: flex; align-items: center; justify-content: center;
}
.service-icon-wrap svg { width: 26px; height: 26px; color: var(--gold2); }

.service-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 21px;
    font-weight: 600;
    color: var(--navy);
    margin-bottom: 10px;
    line-height: 1.2;
}
.service-desc {
    font-size: 13px;
    color: var(--muted);
    line-height: 1.75;
    font-weight: 300;
    margin-bottom: 20px;
}
.service-badge-free {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 16px;
    background: rgba(26,122,74,0.08);
    border: 1px solid rgba(26,122,74,0.2);
    color: var(--green);
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.16em;
    text-transform: uppercase;
}
.service-fee-wrap {
    border-top: 1px solid var(--border);
    padding-top: 16px;
}
.service-fee-label {
    font-size: 9px;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: 4px;
    display: block;
}
.service-fee-amount {
    font-family: 'Cormorant Garamond', serif;
    font-size: 32px;
    font-weight: 700;
    color: var(--navy);
    line-height: 1;
}
.service-schedule {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 12px;
    font-size: 11px;
    color: var(--muted);
    font-weight: 400;
}

/* ════════════════════════════
   REGISTRATION SPLIT SECTION
════════════════════════════ */
.register-section {
    padding: 88px 0;
    background: var(--cream);
}
.register-grid {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 40px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    align-items: center;
}

/* Left: copy */
.register-copy { }
.register-copy p {
    font-size: 14px;
    font-weight: 300;
    color: #4a4f5e;
    line-height: 1.85;
    margin-bottom: 14px;
}
.register-copy .verse {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    font-size: 15px;
    color: var(--gold);
    margin-top: 24px;
    padding-left: 16px;
    border-left: 2px solid var(--gold);
    line-height: 1.65;
}

/* Right: form card */
.register-card {
    background: var(--navy);
    border-radius: 2px;
    overflow: hidden;
    box-shadow: 0 24px 64px rgba(12,27,58,0.18);
    position: relative;
}
.register-card::after {
    content: '✝';
    position: absolute;
    right: -12px; bottom: -28px;
    font-size: 160px;
    color: rgba(200,151,58,0.05);
    pointer-events: none;
}
.register-card-top {
    padding: 28px 32px 22px;
    border-bottom: 1px solid rgba(200,151,58,0.15);
}
.register-card-top h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 24px;
    font-weight: 600;
    color: #fff;
    margin-bottom: 4px;
}
.register-card-top p {
    font-size: 12px;
    color: rgba(255,255,255,0.4);
    font-weight: 300;
}
.register-card-body { padding: 28px 32px 32px; position: relative; z-index: 1; }

/* Auth info box */
.auth-info-box {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 18px;
    background: rgba(200,151,58,0.1);
    border: 1px solid rgba(200,151,58,0.2);
    margin-bottom: 20px;
}
.auth-info-box .material-symbols-outlined { font-size: 18px; color: var(--gold); flex-shrink: 0; }
.auth-info-box span { font-size: 13px; color: rgba(255,255,255,0.7); font-weight: 300; }
.auth-info-box strong { color: var(--gold2); font-weight: 500; }

/* Select field (dark) */
.field-select-dark {
    width: 100%;
    padding: 14px 18px;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.12);
    color: rgba(255,255,255,0.85);
    font-family: 'Jost', sans-serif;
    font-size: 14px;
    border-radius: 0;
    outline: none;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='rgba(200,151,58,0.7)'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 18px center;
    transition: border-color 0.2s;
}
.field-select-dark:focus { border-color: var(--gold); }
.field-select-dark option { background: var(--navy2); color: #fff; }

/* Submit button */
.btn-submit-dark {
    width: 100%;
    margin-top: 18px;
    padding: 16px 32px;
    background: var(--gold);
    color: var(--navy);
    font-family: 'Jost', sans-serif;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    border: none;
    cursor: pointer;
    transition: background 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    position: relative;
    overflow: hidden;
}
.btn-submit-dark::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--gold2);
    transform: translateX(-100%);
    transition: transform 0.3s ease;
}
.btn-submit-dark:hover::before { transform: translateX(0); }
.btn-submit-dark span { position: relative; z-index: 1; }

/* Login prompt (not authed) */
.login-prompt {
    padding: 20px 24px;
    background: rgba(200,151,58,0.07);
    border: 1px solid rgba(200,151,58,0.18);
}
.login-prompt p {
    font-size: 13px;
    color: rgba(255,255,255,0.6);
    font-weight: 300;
    margin-bottom: 16px;
}
.login-prompt-btns { display: flex; gap: 12px; }
.btn-lp-solid {
    flex: 1;
    padding: 12px;
    background: var(--gold);
    color: var(--navy);
    font-family: 'Jost', sans-serif;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    border: none;
    cursor: pointer;
    transition: background 0.2s;
    text-decoration: none;
    text-align: center;
    display: flex; align-items: center; justify-content: center;
}
.btn-lp-solid:hover { background: var(--gold2); }
.btn-lp-outline {
    flex: 1;
    padding: 12px;
    background: transparent;
    color: rgba(255,255,255,0.6);
    border: 1px solid rgba(255,255,255,0.18);
    font-family: 'Jost', sans-serif;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    text-align: center;
    display: flex; align-items: center; justify-content: center;
}
.btn-lp-outline:hover { border-color: var(--gold); color: var(--gold2); }

/* ════════════════════════════
   PAYMENT MODAL
════════════════════════════ */
.modal-overlay {
    position: fixed; inset: 0; z-index: 999;
    background: rgba(12,27,58,0.72);
    backdrop-filter: blur(4px);
    display: none;
    align-items: center; justify-content: center;
    padding: 20px; overflow-y: auto;
}
.modal-overlay.open { display: flex; }

.modal-box {
    position: relative;
    background: var(--white);
    width: 100%; max-width: 640px;
    border-radius: 2px;
    overflow: hidden;
    box-shadow: 0 32px 100px rgba(0,0,0,0.3);
    animation: fadeUp 0.35s ease both;
}
.modal-close {
    position: absolute; top: 18px; right: 20px;
    width: 36px; height: 36px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: rgba(255,255,255,0.7); font-size: 20px;
    transition: all 0.2s; z-index: 10;
}
.modal-close:hover { background: rgba(255,255,255,0.2); color: #fff; }

.modal-header {
    background: var(--navy);
    padding: 40px 44px 32px;
    position: relative; overflow: hidden;
}
.modal-header::after {
    content: '✝';
    position: absolute; right: 20px; bottom: -30px;
    font-size: 140px; color: rgba(200,151,58,0.06);
    pointer-events: none;
}
.modal-header h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 32px; font-weight: 600; color: #fff; margin: 10px 0 6px;
}
.modal-header p { font-size: 13px; color: rgba(255,255,255,0.45); font-weight: 300; }

.modal-body { padding: 36px 44px; max-height: 70vh; overflow-y: auto; }

/* Service detail strip */
.service-detail-strip {
    background: var(--sand);
    border: 1px solid var(--border);
    padding: 18px 20px;
    margin-bottom: 28px;
    display: flex; gap: 24px;
}
.sd-item { }
.sd-label { font-size: 9px; letter-spacing: 0.18em; text-transform: uppercase; color: var(--muted); display: block; margin-bottom: 3px; }
.sd-value { font-family: 'Cormorant Garamond', serif; font-size: 17px; font-weight: 600; color: var(--navy); }
.sd-value.fee { color: var(--gold); }
.sd-value.ref { font-family: 'Jost', monospace; font-size: 13px; font-weight: 500; }

/* Payment method tabs */
.pay-methods { display: flex; flex-direction: column; gap: 10px; margin-bottom: 28px; }
.pay-method {
    border: 1px solid var(--border);
    padding: 16px 18px;
    display: flex; align-items: flex-start; gap: 14px;
    transition: border-color 0.2s;
}
.pay-method:hover { border-color: var(--gold); }
.pay-method-icon { font-size: 22px; flex-shrink: 0; margin-top: 1px; }
.pay-method-title { font-size: 13px; font-weight: 600; color: var(--navy); margin-bottom: 4px; }
.pay-method-detail { font-size: 12px; color: var(--muted); font-weight: 300; line-height: 1.55; }

/* Form divider */
.form-divider {
    display: flex; align-items: center; gap: 14px;
    margin: 24px 0; color: var(--muted); font-size: 11px;
    letter-spacing: 0.12em; text-transform: uppercase;
}
.form-divider::before, .form-divider::after {
    content: ''; flex: 1; height: 1px; background: var(--border);
}

/* Form fields (light modal) */
.field-label-sm { display: block; font-size: 10px; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; color: var(--navy); margin-bottom: 8px; }
.field-input-sm {
    width: 100%; padding: 12px 16px;
    background: var(--cream); border: 1px solid var(--border);
    font-family: 'Jost', sans-serif; font-size: 14px; color: var(--text);
    transition: all 0.2s; outline: none; border-radius: 0;
}
.field-input-sm:focus { background: var(--white); border-color: var(--gold); box-shadow: 0 0 0 3px rgba(200,151,58,0.1); }
.field-hint { font-size: 11px; color: var(--muted); margin-top: 5px; font-weight: 300; }

select.field-input-sm {
    appearance: none; cursor: pointer;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%236b7080'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 16px center;
}
textarea.field-input-sm { resize: none; }

.modal-actions { display: flex; gap: 14px; margin-top: 24px; }
.btn-modal-submit {
    flex: 1; padding: 15px;
    background: var(--navy); color: var(--gold2);
    font-family: 'Jost', sans-serif; font-size: 12px; font-weight: 600;
    letter-spacing: 0.18em; text-transform: uppercase;
    border: none; cursor: pointer; transition: background 0.2s;
}
.btn-modal-submit:hover { background: var(--navy2); }
.btn-modal-cancel {
    padding: 15px 28px;
    background: transparent; color: var(--muted);
    border: 1px solid var(--border);
    font-family: 'Jost', sans-serif; font-size: 12px; font-weight: 500;
    letter-spacing: 0.12em; text-transform: uppercase;
    cursor: pointer; transition: all 0.2s;
}
.btn-modal-cancel:hover { border-color: var(--navy); color: var(--navy); }

.modal-note {
    margin-top: 20px; padding: 14px 18px;
    background: var(--sand); border-left: 3px solid var(--gold);
    font-size: 12px; color: var(--muted); line-height: 1.6; font-weight: 300;
}
.modal-note strong { color: var(--navy); font-weight: 600; }

/* ── RESPONSIVE ── */
@media (max-width: 1024px) {
    .services-grid { grid-template-columns: repeat(2, 1fr); }
    .register-grid { grid-template-columns: 1fr; gap: 40px; }
}
@media (max-width: 640px) {
    .services-grid { grid-template-columns: 1fr; }
    .section-inner, .register-grid { padding: 0 20px; }
    .page-hero { padding: 60px 20px 52px; }
    .modal-header { padding: 28px 24px 22px; }
    .modal-body { padding: 24px; }
    .service-detail-strip { flex-wrap: wrap; gap: 14px; }
}
</style>
</head>

<body>
@include('partials.navbar')
@include('partials.announcement')

{{-- Flash messages --}}
@if ($message = Session::get('success'))
    <div class="flash success" role="alert">
        <span class="material-symbols-outlined" style="font-size:18px; flex-shrink:0; color:var(--green);">check_circle</span>
        <div><div class="flash-title">Success</div>{{ $message }}</div>
    </div>
@endif
@if ($message = Session::get('error'))
    <div class="flash error" role="alert">
        <span class="material-symbols-outlined" style="font-size:18px; flex-shrink:0; color:var(--red);">error</span>
        <div><div class="flash-title">Error</div>{{ $message }}</div>
    </div>
@endif

{{-- ═══════════════ PAGE HERO ═══════════════ --}}
<section class="page-hero">
    <div class="page-hero-cross">✝</div>
    <div class="page-hero-inner">
        <p class="eyebrow fade-up fade-up-1" style="justify-content:center; color:var(--gold);">Worship · Sacraments · Community</p>
        <h1 class="fade-up fade-up-2">Our<br><em>Services</em></h1>
        <p class="fade-up fade-up-2">
            Every service is an invitation to encounter the living God. From the beauty of the Holy Eucharist to the comfort of reconciliation — we walk with you in every season.
        </p>
        <p class="verse fade-up fade-up-3">"Come to me, all you who are weary and burdened, and I will give you rest." — Matthew 11:28</p>
    </div>
</section>

{{-- ═══════════════ SERVICES GRID ═══════════════ --}}
<section class="services-section">
    <div class="section-inner">
        <div class="section-header">
            <p class="eyebrow" style="justify-content:center; margin-bottom:14px;">Sacraments & Spiritual Care</p>
            <h2 class="section-title">What We Offer</h2>
            <p class="section-desc">Sacred moments — celebrated with reverence, warmth, and the full community of faith.</p>
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
            $scheduleIcons = ['📅','⛪','🕊️','🙏','✝️','🎵'];
        @endphp

        <div class="services-grid">
            @forelse($services as $index => $service)
                <div class="service-card fade-up" style="animation-delay:{{ $index * 0.07 }}s;">
                    <div class="service-icon-wrap">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $svgPaths[$index % count($svgPaths)] }}" />
                        </svg>
                    </div>

                    <div class="service-name">{{ $service->name }}</div>
                    <p class="service-desc">{{ $service->description }}</p>

                    @if($service->isFree())
                        <div class="service-badge-free">
                            <span class="material-symbols-outlined" style="font-size:13px;">check_circle</span>
                            No Fee
                        </div>
                    @else
                        <div class="service-fee-wrap">
                            <span class="service-fee-label">Registration Fee</span>
                            <div class="service-fee-amount">{{ $service->formatted_fee }}</div>
                        </div>
                    @endif

                    @if($service->schedule)
                        <div class="service-schedule">
                            <span class="material-symbols-outlined" style="font-size:13px; color:var(--gold);">calendar_month</span>
                            {{ $service->schedule }}
                        </div>
                    @endif
                </div>
            @empty
                <div style="grid-column:1/-1; text-align:center; padding:64px 0;">
                    <div style="font-size:48px; margin-bottom:16px; opacity:.3;">⛪</div>
                    <p style="font-family:'Cormorant Garamond',serif; font-size:22px; color:var(--muted);">No services listed yet</p>
                    <p style="font-size:13px; color:#bbb; margin-top:6px;">Please check back soon.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ═══════════════ REGISTRATION SECTION ═══════════════ --}}
<section class="register-section">
    <div class="register-grid">

        {{-- Left: copy --}}
        <div class="register-copy fade-up">
            <p class="eyebrow" style="margin-bottom:16px;">You Are Welcome Here</p>
            <h2 class="section-title" style="text-align:left; margin-bottom:24px;">
                Register for a<br><em style="font-family:'Cormorant Garamond',serif; font-style:italic; color:var(--gold);">Church Service</em>
            </h2>
            <p>We are overjoyed that you're considering joining us at <strong>St. John's Parish Church Entebbe</strong>. Every service is a sacred moment we are honoured to share with you.</p>
            <p>Whether it's baptism, confirmation, holy matrimony, or spiritual counseling — we are here to walk beside you every step of the way.</p>
            <div class="verse">"Where two or three are gathered in my name, there am I among them." — Matthew 18:20</div>

            {{-- Values mini-list --}}
            <div style="margin-top:40px; display:flex; flex-direction:column; gap:16px;">
                @foreach(['Warm, prayerful atmosphere in every service','Trained clergy & counselors to guide you','Discreet, confidential pastoral care'] as $item)
                <div style="display:flex; align-items:center; gap:14px;">
                    <div style="width:8px; height:8px; background:var(--gold); border-radius:50%; flex-shrink:0;"></div>
                    <span style="font-size:13.5px; color:#4a4f5e; font-weight:300;">{{ $item }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Right: form card --}}
        <div class="register-card fade-up fade-up-2">
            <div class="register-card-top">
                <p class="eyebrow" style="color:var(--gold); margin-bottom:10px;">Service Registration</p>
                <h3>Let Us Know<br>You're Coming</h3>
                <p>Complete the form and our team will confirm your booking.</p>
            </div>
            <div class="register-card-body">
                <form action="{{ route('service.register') }}" method="POST">
                    @csrf
                    @auth
                        <div class="auth-info-box">
                            <span class="material-symbols-outlined">person</span>
                            <span>Registering as <strong>{{ Auth::user()->member->full_name ?? Auth::user()->name }}</strong></span>
                        </div>

                        <label class="field-label-sm" style="color:rgba(255,255,255,0.45); margin-bottom:8px;">Select a Service</label>
                        <select name="service_id" required class="field-select-dark">
                            <option value="" disabled selected>Choose a service…</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}{{ !$service->isFree() ? '  ·  ' . $service->formatted_fee : '  ·  Free' }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn-submit-dark">
                            <span>Register for Service</span>
                            <span class="material-symbols-outlined" style="font-size:18px; position:relative; z-index:1;">arrow_forward</span>
                        </button>

                        <p style="font-size:11px; color:rgba(255,255,255,0.25); text-align:center; margin-top:16px; font-weight:300;">
                            Our team will reach out to confirm your registration within 24hrs.
                        </p>
                    @else
                        <div class="login-prompt">
                            <p>Please log in to register for a service. Don't have an account? Create one in seconds.</p>
                            <div class="login-prompt-btns">
                                <a href="{{ route('login') }}" class="btn-lp-solid">Log In</a>
                                <a href="#" onclick="showQuickAccountModal(); return false;" class="btn-lp-outline">Create Account</a>
                            </div>
                        </div>
                    @endauth
                </form>
            </div>
        </div>

    </div>
</section>

{{-- ═══════════════ PAYMENT MODAL ═══════════════ --}}
<div id="paymentModal" class="modal-overlay">
    <div class="modal-box">
        <button onclick="closePaymentModal()" class="modal-close">×</button>

        <div class="modal-header">
            <p class="eyebrow" style="color:var(--gold);">Payment</p>
            <h3>Complete Your<br>Registration</h3>
            <p>Submit payment proof to confirm your booking.</p>
        </div>

        <div class="modal-body">
            {{-- Service detail strip --}}
            <div class="service-detail-strip">
                <div class="sd-item">
                    <span class="sd-label">Service</span>
                    <span class="sd-value" id="modal-service-name">—</span>
                </div>
                <div class="sd-item">
                    <span class="sd-label">Fee</span>
                    <span class="sd-value fee" id="modal-service-fee">—</span>
                </div>
                <div class="sd-item">
                    <span class="sd-label">Registration</span>
                    <span class="sd-value ref" id="modal-registration-id">—</span>
                </div>
            </div>

            {{-- Payment methods --}}
            <label class="field-label-sm" style="margin-bottom:14px;">How to Pay</label>
            <div class="pay-methods">
                <div class="pay-method">
                    <div class="pay-method-icon">📱</div>
                    <div>
                        <div class="pay-method-title">Mobile Money</div>
                        <div class="pay-method-detail">
                            MTN: <strong>0772-567-789</strong> (St. John's Church)<br>
                            Airtel: <strong>0752-666-024</strong> (St. John's Church)
                        </div>
                    </div>
                </div>
                <div class="pay-method">
                    <div class="pay-method-icon">🏦</div>
                    <div>
                        <div class="pay-method-title">Bank Transfer</div>
                        <div class="pay-method-detail">
                            Stanbic Bank Uganda<br>
                            A/C Name: <strong>St. John's Parish Church Entebbe</strong><br>
                            A/C No: <strong>9030XXXXXXXX</strong>
                        </div>
                    </div>
                </div>
                <div class="pay-method">
                    <div class="pay-method-icon">💵</div>
                    <div>
                        <div class="pay-method-title">Cash at Office</div>
                        <div class="pay-method-detail">Mon–Fri, 9:00 AM – 5:00 PM · St. John's Parish, Entebbe</div>
                    </div>
                </div>
            </div>

            <div class="form-divider">Submit Proof</div>

            <form id="paymentProofForm" style="display:flex; flex-direction:column; gap:18px;">
                @csrf
                <input type="hidden" id="proof-registration-id" name="registration_id">

                <div>
                    <label class="field-label-sm">Payment Method Used <span style="color:var(--gold);">*</span></label>
                    <select name="payment_method" required class="field-input-sm">
                        <option value="">Select payment method…</option>
                        <option value="mobile_money">Mobile Money (MTN / Airtel)</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="cash">Cash</option>
                    </select>
                </div>

                <div>
                    <label class="field-label-sm">Transaction Reference <span style="color:var(--gold);">*</span></label>
                    <input type="text" name="transaction_reference" required class="field-input-sm" placeholder="e.g. MTN123456789">
                    <p class="field-hint">Enter the transaction ID from your mobile money or bank receipt.</p>
                </div>

                <div>
                    <label class="field-label-sm">Additional Notes</label>
                    <textarea name="payment_notes" rows="2" class="field-input-sm" placeholder="Any extra information…"></textarea>
                </div>

                <div class="modal-actions">
                    <button type="submit" class="btn-modal-submit">Submit Proof</button>
                    <button type="button" onclick="closePaymentModal()" class="btn-modal-cancel">Pay Later</button>
                </div>
            </form>

            <div class="modal-note">
                <strong>Note:</strong> Your registration is confirmed. Payment verification may take up to 24 hours — we'll send a confirmation once approved.
            </div>
        </div>
    </div>
</div>

@include('partials.member-modals')
@include('partials.quick-account-modal')
@include('partials.footer')

<script>
let currentRegistrationData = null;

// Auto-show modal if session says so
@if(session('show_payment_modal') && session('registration_data'))
    document.addEventListener('DOMContentLoaded', function () {
        showPaymentModal(@json(session('registration_data')));
    });
@endif

function showPaymentModal(data) {
    currentRegistrationData = data;
    document.getElementById('modal-service-name').textContent  = data.service_name;
    document.getElementById('modal-service-fee').textContent   = data.service_fee;
    document.getElementById('modal-registration-id').textContent = '#' + data.registration_id;
    document.getElementById('proof-registration-id').value      = data.registration_id;
    document.getElementById('paymentModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.remove('open');
    document.body.style.overflow = '';
    document.getElementById('paymentProofForm').reset();
}

document.getElementById('paymentModal').addEventListener('click', function (e) {
    if (e.target === this) closePaymentModal();
});

document.addEventListener('keydown', e => { if (e.key === 'Escape') closePaymentModal(); });

document.getElementById('paymentProofForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const submit = this.querySelector('.btn-modal-submit');
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
    t.style.cssText = `
        position:fixed; top:24px; right:24px; z-index:9999;
        padding:16px 22px; min-width:280px; font-family:'Jost',sans-serif;
        font-size:13px; border-radius:2px; animation: fadeUp .3s ease both;
        ${type === 'success'
            ? 'background:#0c1b3a; color:#e8b96a; border-left:3px solid #c8973a;'
            : 'background:#fff; color:#c0392b; border-left:3px solid #c0392b; box-shadow:0 8px 24px rgba(0,0,0,.12);'}
    `;
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 5000);
}
</script>
</body>
</html>