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
:root {
    --navy:    #0c1b3a;
    --navy2:   #142450;
    --gold:    #c8973a;
    --gold2:   #e8b96a;
    --cream:   #fdf8f0;
    --sand:    #f5ede0;
    --text:    #1a1a2e;
    --muted:   #6b7080;
    --border:  #e2d9cc;
    --white:   #ffffff;
    --red:     #c0392b;
    --green:   #1a7a4a;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Jost', sans-serif;
    background: var(--cream);
    color: var(--text);
    overflow-x: hidden;
}

/* ── TYPOGRAPHY ── */
.serif { font-family: 'Cormorant Garamond', serif; }

/* ── FADE IN ANIMATION ── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
}
.fade-up { animation: fadeUp 0.8s ease both; }
.fade-up-1 { animation-delay: 0.1s; }
.fade-up-2 { animation-delay: 0.25s; }
.fade-up-3 { animation-delay: 0.4s; }

/* ── EYEBROW LABEL ── */
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
.eyebrow::before {
    content: '';
    display: block;
    width: 28px;
    height: 1px;
    background: var(--gold);
}

/* ══════════════════════════════
   HERO
══════════════════════════════ */
.hero {
    position: relative;
    min-height: 92vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.hero-bg {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(to bottom, rgba(12,27,58,0.55) 0%, rgba(12,27,58,0.75) 60%, rgba(12,27,58,0.92) 100%),
        url("https://lh3.googleusercontent.com/aida-public/AB6AXuBJuBVtqw9UvSxdwxXR4HOoRKNwjmp9luc3fMocyA9NTqdPQivYkifWnUaMwnjyQq3T4squ6UlhiwnVUaXW1dGBb9iQTqAWj2ZWY0cDsr8_w0zYXf4_sbb551OYF9iq1ViLJ1oSTTDppAlvmUWZuWIo8Etdwaaf_zx3Twh1p4XfM8eHKL64rCtraA9U_aCR3AJcZ_L-6y2nwV4LQ3nNURKG3gPTol5sCwQWKy93zdr-wzJtb_VykEtdfU3XC_2Nsxabk4C2zBpbrrgU");
    background-size: cover;
    background-position: center 30%;
    transform: scale(1.03);
    transition: transform 8s ease;
}
.hero:hover .hero-bg { transform: scale(1); }

/* Cross watermark */
.hero-cross {
    position: absolute;
    right: 8%;
    top: 50%;
    transform: translateY(-50%);
    font-size: 320px;
    color: rgba(200,151,58,0.07);
    line-height: 1;
    pointer-events: none;
    font-family: serif;
    user-select: none;
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    max-width: 780px;
    padding: 0 24px;
}

.hero-parish {
    font-family: 'Jost', sans-serif;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.28em;
    text-transform: uppercase;
    color: var(--gold2);
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
}
.hero-parish::before,
.hero-parish::after {
    content: '';
    width: 40px;
    height: 1px;
    background: var(--gold);
    opacity: 0.7;
}

.hero-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(56px, 9vw, 100px);
    font-weight: 600;
    color: #fff;
    line-height: 0.95;
    letter-spacing: -0.01em;
    margin-bottom: 28px;
}
.hero-title em {
    font-style: italic;
    color: var(--gold2);
    font-weight: 300;
}

.hero-sub {
    font-size: 14px;
    font-weight: 300;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.6);
    margin-bottom: 48px;
}

.hero-verse {
    font-family: 'Cormorant Garamond', serif;
    font-size: 16px;
    font-style: italic;
    color: rgba(255,255,255,0.5);
    margin-bottom: 52px;
    line-height: 1.7;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 16px 40px;
    background: var(--gold);
    color: var(--navy);
    font-family: 'Jost', sans-serif;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    border: none;
    border-radius: 0;
    cursor: pointer;
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
    text-decoration: none;
}
.btn-primary::before {
    content: '';
    position: absolute;
    inset: 0;
    background: var(--gold2);
    transform: translateX(-100%);
    transition: transform 0.3s ease;
}
.btn-primary:hover::before { transform: translateX(0); }
.btn-primary span { position: relative; z-index: 1; }

.btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 15px 38px;
    background: transparent;
    color: #fff;
    font-family: 'Jost', sans-serif;
    font-size: 12px;
    font-weight: 500;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    border: 1px solid rgba(255,255,255,0.35);
    border-radius: 0;
    cursor: pointer;
    transition: all 0.25s ease;
    text-decoration: none;
}
.btn-outline:hover {
    border-color: var(--gold);
    color: var(--gold2);
}

.hero-ctas {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    flex-wrap: wrap;
}

/* Scroll indicator */
.scroll-hint {
    position: absolute;
    bottom: 32px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    color: rgba(255,255,255,0.35);
    font-size: 9px;
    letter-spacing: 0.2em;
    text-transform: uppercase;
}
@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(6px); }
}
.scroll-arrow {
    width: 18px;
    height: 18px;
    border-right: 1.5px solid rgba(255,255,255,0.3);
    border-bottom: 1.5px solid rgba(255,255,255,0.3);
    transform: rotate(45deg);
    animation: bounce 2s infinite;
}

/* ══════════════════════════════
   FLASH MESSAGES
══════════════════════════════ */
.flash {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px 24px;
    margin: 16px 24px;
    border-radius: 4px;
    font-size: 14px;
}
.flash.success { background: #edf7f2; border-left: 3px solid var(--green); color: #155d38; }
.flash.error   { background: #fdf2f0; border-left: 3px solid var(--red); color: #8b2020; }
.flash-title   { font-weight: 600; margin-bottom: 2px; }

/* ══════════════════════════════
   SECTION COMMONS
══════════════════════════════ */
.section-header {
    text-align: center;
    margin-bottom: 64px;
}
.section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: clamp(36px, 5vw, 54px);
    font-weight: 600;
    color: var(--navy);
    line-height: 1.1;
    margin: 12px 0 16px;
}
.section-desc {
    font-size: 15px;
    font-weight: 300;
    color: var(--muted);
    max-width: 520px;
    margin: 0 auto;
    line-height: 1.7;
}

/* ══════════════════════════════
   ABOUT / INTRO SECTION
══════════════════════════════ */
.about-section {
    background: var(--white);
    padding: 100px 0;
    position: relative;
}

/* Diagonal accent top */
.about-section::before {
    content: '';
    position: absolute;
    top: -1px; left: 0; right: 0;
    height: 80px;
    background: var(--navy);
    clip-path: polygon(0 0, 100% 0, 100% 30%, 0 100%);
}

.about-grid {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 32px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 40px;
}

.about-intro p {
    font-size: 15px;
    line-height: 1.85;
    color: #4a4f5e;
    margin-bottom: 16px;
    font-weight: 300;
}

.heartbeat-card {
    background: var(--navy);
    border-radius: 2px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(12,27,58,0.18);
    position: relative;
}
.heartbeat-card::after {
    content: '✝';
    position: absolute;
    right: -10px;
    bottom: -20px;
    font-size: 120px;
    color: rgba(200,151,58,0.06);
    pointer-events: none;
}
.heartbeat-top {
    padding: 28px 28px 20px;
    border-bottom: 1px solid rgba(200,151,58,0.2);
}
.heartbeat-top h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 26px;
    font-weight: 600;
    color: #fff;
    margin-bottom: 4px;
}
.heartbeat-top p {
    font-size: 11px;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--gold);
    font-weight: 500;
}

.heartbeat-body { padding: 24px 28px; }
.heartbeat-item { margin-bottom: 20px; }
.heartbeat-item h4 {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    color: var(--gold);
    margin-bottom: 6px;
}
.heartbeat-item p {
    font-size: 13.5px;
    line-height: 1.7;
    color: rgba(255,255,255,0.65);
    font-weight: 300;
}

.heartbeat-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    border-top: 1px solid rgba(200,151,58,0.15);
}
.stat-cell {
    padding: 20px 28px;
    text-align: center;
}
.stat-cell:first-child { border-right: 1px solid rgba(200,151,58,0.15); }
.stat-num {
    font-family: 'Cormorant Garamond', serif;
    font-size: 38px;
    font-weight: 600;
    color: var(--gold2);
    line-height: 1;
    display: block;
}
.stat-lbl {
    font-size: 9px;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.4);
    margin-top: 4px;
    display: block;
}

.connect-cards { display: flex; flex-direction: column; gap: 20px; }
.connect-card {
    background: var(--sand);
    border: 1px solid var(--border);
    border-radius: 2px;
    padding: 24px 26px;
    position: relative;
    transition: all 0.25s;
}
.connect-card:hover {
    border-color: var(--gold);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(200,151,58,0.1);
}
.connect-card::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: var(--gold);
    transform: scaleY(0);
    transform-origin: bottom;
    transition: transform 0.25s;
}
.connect-card:hover::before { transform: scaleY(1); }
.connect-card h3 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 20px;
    font-weight: 600;
    color: var(--navy);
    margin-bottom: 8px;
}
.connect-card p {
    font-size: 13.5px;
    color: var(--muted);
    line-height: 1.7;
    font-weight: 300;
}

/* ══════════════════════════════
   GROUPS SECTION
══════════════════════════════ */
.groups-section {
    background: var(--cream);
    padding: 100px 0;
}

.groups-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 40px;
}

.group-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: 2px;
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
}
.group-card::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--gold), var(--gold2));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.35s ease;
}
.group-card:hover {
    box-shadow: 0 16px 48px rgba(12,27,58,0.1);
    transform: translateY(-3px);
    border-color: transparent;
}
.group-card:hover::after { transform: scaleX(1); }

.group-card-top {
    padding: 28px 28px 0;
    display: flex;
    align-items: flex-start;
    gap: 18px;
}
.group-icon-wrap {
    width: 48px; height: 48px;
    border-radius: 2px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    font-size: 22px;
}
.group-icon-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    border-radius: 2px;
}

.group-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 20px;
    font-weight: 600;
    color: var(--navy);
    line-height: 1.2;
    margin-bottom: 4px;
}
.group-meta {
    font-size: 11px;
    color: var(--muted);
    display: flex;
    align-items: center;
    gap: 6px;
}
.group-meta::before {
    content: '';
    width: 3px; height: 3px;
    background: var(--gold);
    border-radius: 50%;
    display: none;
}

.group-card-body { padding: 16px 28px 28px; }
.group-desc {
    font-size: 13.5px;
    color: var(--muted);
    line-height: 1.75;
    font-weight: 300;
    margin-bottom: 24px;
}

/* Buttons inside cards */
.group-btn-join {
    width: 100%;
    padding: 12px 20px;
    background: var(--navy);
    color: var(--gold2);
    font-family: 'Jost', sans-serif;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.16em;
    text-transform: uppercase;
    border: none;
    border-radius: 0;
    cursor: pointer;
    transition: all 0.22s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.group-btn-join:hover { background: var(--navy2); }

.group-btn-member {
    width: 100%;
    padding: 12px 20px;
    background: transparent;
    color: var(--green);
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    border: 1px solid rgba(26,122,74,0.3);
    border-radius: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.group-btn-login {
    width: 100%;
    padding: 12px 20px;
    background: transparent;
    color: var(--navy);
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    border: 1px solid var(--border);
    border-radius: 0;
    cursor: pointer;
    transition: all 0.22s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
}
.group-btn-login:hover { border-color: var(--navy); }

.group-btn-disabled {
    width: 100%;
    padding: 12px 20px;
    background: var(--sand);
    color: var(--muted);
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    border: 1px solid var(--border);
    border-radius: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

/* ══════════════════════════════
   MODAL SHARED
══════════════════════════════ */
.modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 999;
    background: rgba(12,27,58,0.7);
    backdrop-filter: blur(4px);
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    overflow-y: auto;
}
.modal-overlay.open { display: flex; }

.modal-box {
    position: relative;
    background: var(--white);
    width: 100%;
    max-width: 680px;
    border-radius: 2px;
    overflow: hidden;
    box-shadow: 0 32px 100px rgba(0,0,0,0.3);
    animation: fadeUp 0.35s ease both;
}

.modal-close {
    position: absolute;
    top: 18px; right: 20px;
    width: 36px; height: 36px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    color: rgba(255,255,255,0.7);
    font-size: 20px;
    transition: all 0.2s;
    z-index: 10;
}
.modal-close:hover { background: rgba(255,255,255,0.2); color: #fff; }

.modal-header {
    background: var(--navy);
    padding: 44px 48px 36px;
    position: relative;
    overflow: hidden;
}
.modal-header::after {
    content: '✝';
    position: absolute;
    right: 20px; bottom: -30px;
    font-size: 140px;
    color: rgba(200,151,58,0.07);
    pointer-events: none;
}
.modal-header .eyebrow { margin-bottom: 10px; }
.modal-header h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 38px;
    font-weight: 600;
    color: #fff;
    line-height: 1.1;
    margin-bottom: 8px;
}
.modal-header p {
    font-size: 13px;
    color: rgba(255,255,255,0.5);
    font-weight: 300;
}

.modal-body {
    padding: 40px 48px;
    max-height: 70vh;
    overflow-y: auto;
}

/* Form styles */
.form-section { margin-bottom: 36px; }
.form-section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-family: 'Cormorant Garamond', serif;
    font-size: 20px;
    font-weight: 600;
    color: var(--navy);
    padding-bottom: 12px;
    border-bottom: 1px solid var(--border);
    margin-bottom: 24px;
}
.form-section-title .material-symbols-outlined {
    font-size: 20px;
    color: var(--gold);
}

.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
.form-grid.full { grid-template-columns: 1fr; }

.field-label {
    display: block;
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--navy);
    margin-bottom: 8px;
}
.field-required { color: var(--gold); margin-left: 2px; }

.field-input {
    width: 100%;
    padding: 13px 16px;
    background: var(--cream);
    border: 1px solid var(--border);
    border-radius: 0;
    font-family: 'Jost', sans-serif;
    font-size: 14px;
    color: var(--text);
    transition: all 0.2s;
    outline: none;
}
.field-input:focus {
    background: var(--white);
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(200,151,58,0.1);
}
.field-input::placeholder { color: #b0b5c0; }

select.field-input { appearance: none; cursor: pointer; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%236b7080'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 16px center; }

/* Account toggle area */
.account-toggle {
    background: var(--sand);
    border: 1px solid var(--border);
    padding: 24px;
    margin-bottom: 28px;
}
.account-toggle-label {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    cursor: pointer;
}
.account-toggle input[type=checkbox] {
    width: 18px; height: 18px;
    margin-top: 2px;
    flex-shrink: 0;
    accent-color: var(--navy);
    cursor: pointer;
}
.account-toggle h4 {
    font-size: 14px;
    font-weight: 600;
    color: var(--navy);
    margin-bottom: 3px;
}
.account-toggle p {
    font-size: 12px;
    color: var(--muted);
    font-weight: 300;
    line-height: 1.5;
}
.account-fields {
    display: none;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid var(--border);
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}
.account-fields.visible { display: grid; }

.file-input-wrap {
    border: 1.5px dashed var(--border);
    padding: 20px;
    text-align: center;
    transition: border-color 0.2s;
    cursor: pointer;
}
.file-input-wrap:hover { border-color: var(--gold); }
.file-input-wrap input { display: none; }
.file-input-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}
.file-icon {
    width: 40px; height: 40px;
    background: var(--sand);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    color: var(--gold);
}
.file-input-label span {
    font-size: 12px;
    color: var(--muted);
}
.file-input-label strong {
    font-size: 13px;
    color: var(--navy);
    font-weight: 600;
}

.form-notice {
    display: none;
    padding: 16px 20px;
    background: #edf7f2;
    border-left: 3px solid var(--green);
    color: #155d38;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 20px;
}

.btn-submit {
    width: 100%;
    padding: 17px 32px;
    background: var(--navy);
    color: var(--gold2);
    font-family: 'Jost', sans-serif;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    border: none;
    cursor: pointer;
    transition: all 0.25s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.btn-submit:hover { background: var(--navy2); }

/* ══════════════════════════════
   JOIN GROUP MODAL
══════════════════════════════ */
.join-modal-box {
    max-width: 440px;
}
.join-modal-body { padding: 32px 40px 36px; }
.join-modal-body p {
    font-size: 14px;
    color: var(--muted);
    margin-bottom: 28px;
    font-weight: 300;
    line-height: 1.6;
}
.join-modal-actions { display: flex; gap: 14px; }
.btn-cancel {
    flex: 1;
    padding: 14px;
    background: transparent;
    border: 1px solid var(--border);
    color: var(--muted);
    font-family: 'Jost', sans-serif;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-cancel:hover { border-color: var(--navy); color: var(--navy); }
.btn-confirm {
    flex: 1;
    padding: 14px;
    background: var(--navy);
    border: none;
    color: var(--gold2);
    font-family: 'Jost', sans-serif;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-confirm:hover { background: var(--navy2); }

/* ══════════════════════════════
   MY GROUPS MODAL
══════════════════════════════ */
.my-groups-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 0;
    border-bottom: 1px solid var(--border);
}
.my-groups-item:last-child { border-bottom: none; }
.my-groups-icon {
    width: 44px; height: 44px;
    border-radius: 2px;
    overflow: hidden;
    flex-shrink: 0;
    background: var(--sand);
    display: flex; align-items: center; justify-content: center;
}
.my-groups-icon img { width: 100%; height: 100%; object-fit: cover; }
.my-groups-name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 18px;
    font-weight: 600;
    color: var(--navy);
}
.my-groups-meta { font-size: 12px; color: var(--muted); }
.my-groups-leave {
    margin-left: auto;
    padding: 7px 16px;
    background: transparent;
    border: 1px solid rgba(192,57,43,0.25);
    color: var(--red);
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.2s;
    flex-shrink: 0;
}
.my-groups-leave:hover { background: #fdf2f0; border-color: var(--red); }

/* Notification toast */
.toast {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 9999;
    padding: 16px 20px;
    min-width: 280px;
    font-size: 14px;
    font-weight: 500;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    animation: fadeUp 0.3s ease both;
    border-radius: 2px;
}
.toast.success { background: var(--navy); color: var(--gold2); border-left: 3px solid var(--gold); }
.toast.error   { background: #fff; color: var(--red); border-left: 3px solid var(--red); box-shadow: 0 8px 24px rgba(0,0,0,0.12); }

/* Empty state */
.empty-state {
    text-align: center;
    padding: 64px 32px;
}
.empty-state-icon {
    font-size: 48px;
    color: var(--border);
    margin-bottom: 16px;
}
.empty-state p {
    font-family: 'Cormorant Garamond', serif;
    font-size: 20px;
    color: var(--muted);
}
.empty-state small {
    font-size: 13px;
    color: #bbb;
}

/* ══════════════════════════════
   RESPONSIVE
══════════════════════════════ */
@media (max-width: 1024px) {
    .about-grid, .groups-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 768px) {
    .about-grid, .groups-grid { grid-template-columns: 1fr; }
    .about-grid, .groups-grid { padding: 0 20px; }
    .modal-header { padding: 32px 28px 24px; }
    .modal-body { padding: 28px; }
    .form-grid { grid-template-columns: 1fr; }
    .hero-title { font-size: 52px; }
}
</style>
</head>

<body>
<div class="relative flex h-auto min-h-screen w-full flex-col overflow-x-hidden">
<div class="flex h-full grow flex-col">

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

    <main class="flex-grow w-full">

        {{-- ═══════════════ HERO ═══════════════ --}}
        <section class="hero">
            <div class="hero-bg"></div>
            <div class="hero-cross">✝</div>

            <div class="hero-content">
                <div class="hero-parish fade-up fade-up-1">
                    St. John's Parish Church · Entebbe
                </div>
                <h1 class="hero-title fade-up fade-up-2">
                    Welcome<br><em>Home</em>
                </h1>
                <p class="hero-sub fade-up fade-up-2">Growing in Faith Together</p>
                <p class="hero-verse fade-up fade-up-3">
                    "Let us not grow weary in doing good,<br>for in due season we will reap." — Gal. 6:9
                </p>
                <div class="hero-ctas fade-up fade-up-3">
                    <button id="joinBtn" class="btn-primary"><span>Join Our Church</span></button>
                    <a href="#groups" class="btn-outline">Explore Groups</a>
                </div>
            </div>

            <div class="scroll-hint">
                <div class="scroll-arrow"></div>
                <span>Scroll</span>
            </div>
        </section>

        {{-- ═══════════════ ABOUT ═══════════════ --}}
        <section class="about-section" id="about">
            <div class="about-grid">

                {{-- Col 1: Intro --}}
                <div class="about-intro fade-up">
                    <p class="eyebrow" style="margin-bottom:16px;">Who We Are</p>
                    <h2 class="section-title" style="text-align:left; font-size:36px; margin-bottom:24px;">
                        A welcoming parish for every stage of faith
                    </h2>
                    <p>St. John's Parish Church Entebbe is more than a Sunday gathering — we are a home for seekers, families, students, and long-time believers.</p>
                    <p>Whether you're visiting for the first time or looking for a place to belong, you'll find warmth and meaning here.</p>
                    <div style="margin-top:28px; display:flex; flex-direction:column; gap:14px;">
                        <div class="connect-card">
                            <h3>What to Expect</h3>
                            <p>Friendly greeters, uplifting worship, and practical biblical teaching. Come as you are — we'll save you a seat.</p>
                        </div>
                        <div class="connect-card">
                            <h3>Ways to Connect</h3>
                            <p>Small groups, outreach teams, youth & adult programs — there's a meaningful place for you here.</p>
                        </div>
                    </div>
                </div>

                {{-- Col 2: Heartbeat --}}
                <div class="heartbeat-card fade-up fade-up-1">
                    <div class="heartbeat-top">
                        <h3>Our Heartbeat</h3>
                        <p>Mission & Vision</p>
                    </div>
                    <div class="heartbeat-body">
                        <div class="heartbeat-item">
                            <h4>Mission</h4>
                            <p>To proclaim Christ, nurture believers, and serve our community with compassion and grace.</p>
                        </div>
                        <div class="heartbeat-item">
                            <h4>Vision</h4>
                            <p>To be a lighthouse of hope in Entebbe — equipping disciples and reaching new generations for Christ.</p>
                        </div>
                    </div>
                    <div class="heartbeat-stats">
                        <div class="stat-cell">
                            <span class="stat-num">1948</span>
                            <span class="stat-lbl">Founded</span>
                        </div>
                        <div class="stat-cell">
                            <span class="stat-num">600+</span>
                            <span class="stat-lbl">Members</span>
                        </div>
                    </div>
                </div>

                {{-- Col 3: Values --}}
                <div class="fade-up fade-up-2" style="display:flex; flex-direction:column; gap:0;">
                    <p class="eyebrow" style="margin-bottom:20px;">Core Values</p>
                    @foreach([
                        ['✝', 'Worship', 'We gather to exalt God through song, prayer, and the Word.'],
                        ['🤝', 'Community', 'We believe life is richer when lived in authentic relationship.'],
                        ['🌍', 'Mission', 'We actively serve Entebbe and beyond with love in action.'],
                        ['📖', 'Discipleship', 'We grow together through scripture, mentorship, and accountability.'],
                    ] as $val)
                    <div style="display:flex; gap:16px; padding:20px 0; border-bottom:1px solid var(--border);">
                        <span style="font-size:22px; flex-shrink:0; margin-top:2px;">{{ $val[0] }}</span>
                        <div>
                            <div style="font-family:'Cormorant Garamond',serif; font-size:17px; font-weight:600; color:var(--navy); margin-bottom:4px;">{{ $val[1] }}</div>
                            <div style="font-size:13px; color:var(--muted); line-height:1.65; font-weight:300;">{{ $val[2] }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        </section>

        {{-- ═══════════════ GROUPS ═══════════════ --}}
        <section class="groups-section" id="groups">
            <div style="max-width:1200px; margin:0 auto; padding:0 40px;">
                <div class="section-header">
                    <p class="eyebrow" style="justify-content:center; margin-bottom:14px;">Find Your Place</p>
                    <h2 class="section-title">Church Groups & Ministries</h2>
                    <p class="section-desc">Every person belongs somewhere. Discover a community where your gifts are welcomed and your faith grows.</p>
                </div>
            </div>

            <div class="groups-grid">
                @php
                    $groupStyles = [
                        ['icon' => 'group',                'bg' => 'background:var(--navy); color:var(--gold2);'],
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
                    <div class="group-card">
                        <div class="group-card-top">
                            <div class="group-icon-wrap" style="{{ $style['bg'] }}">
                                @if($group->image_url)
                                    <img src="{{ $group->image_url }}" alt="{{ $group->name }}">
                                @else
                                    <span class="material-symbols-outlined" style="font-size:22px;">{{ $displayIcon }}</span>
                                @endif
                            </div>
                            <div>
                                <div class="group-name">{{ $group->name }}</div>
                                @if($group->meeting_day || $group->location)
                                    <div class="group-meta">
                                        {{ $group->meeting_day }}{{ $group->meeting_day && $group->location ? ' · ' : '' }}{{ $group->location }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="group-card-body">
                            <p class="group-desc">{{ $group->description ?: 'Join this group to grow in faith and fellowship with fellow believers.' }}</p>

                            @if($alreadyMember)
                                <div class="group-btn-member">
                                    <span class="material-symbols-outlined" style="font-size:16px;">check_circle</span>
                                    Member
                                </div>
                            @elseif($canJoin)
                                <button class="group-btn-join joinGroupBtn" data-group="{{ $group->name }}">
                                    <span>Join Group</span>
                                    <span class="material-symbols-outlined" style="font-size:16px;">arrow_forward</span>
                                </button>
                            @elseif(auth()->check() && !auth()->user()->member)
                                <div class="group-btn-disabled">Complete registration to join</div>
                            @else
                                <a href="{{ route('login') }}" class="group-btn-login">
                                    <span class="material-symbols-outlined" style="font-size:16px;">lock</span>
                                    Log in to join
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="grid-column:1/-1;">
                        <div class="empty-state">
                            <div class="empty-state-icon">⛪</div>
                            <p>No groups available yet</p>
                            <small>Check back soon — something wonderful is coming.</small>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

    </main>

    @include('partials.member-modals')
    @include('partials.footer')
</div>
</div>

{{-- ═══════════════ REGISTRATION MODAL ═══════════════ --}}
<div id="registrationModal" class="modal-overlay">
    <div class="modal-box" style="max-width:720px;">
        <button type="button" data-modal-close class="modal-close">×</button>
        <div class="modal-header">
            <div class="eyebrow">St. John's Parish · Entebbe</div>
            <h2>Member<br>Registration</h2>
            <p>Become part of the St. John's family today</p>
        </div>
        <div class="modal-body">
            <form id="memberForm" method="POST" action="{{ route('members.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Personal Info --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">person</span>
                        Personal Information
                    </div>
                    <div class="form-grid">
                        <div>
                            <label class="field-label">Full Name<span class="field-required">*</span></label>
                            <input type="text" name="fullname" required class="field-input" placeholder="Your full name">
                        </div>
                        <div>
                            <label class="field-label">Date of Birth<span class="field-required">*</span></label>
                            <input type="date" name="dateOfBirth" required max="2024-12-31" min="1900-01-01" class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Gender<span class="field-required">*</span></label>
                            <select name="gender" required class="field-input">
                                <option value="">Select gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="field-label">Marital Status<span class="field-required">*</span></label>
                            <select name="maritalStatus" required class="field-input">
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
                <div class="form-section">
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">contact_phone</span>
                        Contact Information
                    </div>
                    <div class="form-grid">
                        <div>
                            <label class="field-label">Phone Number<span class="field-required">*</span></label>
                            <input type="tel" name="phone" required class="field-input" placeholder="+256 ...">
                        </div>
                        <div>
                            <label class="field-label">Email Address</label>
                            <input type="email" name="email" class="field-input" placeholder="you@example.com">
                        </div>
                        <div class="form-grid full" style="grid-column:1/-1;">
                            <label class="field-label">Residential Address</label>
                            <textarea name="address" rows="2" class="field-input" style="resize:none;" placeholder="Village & Zone"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Church Info --}}
                <div class="form-section">
                    <div class="form-section-title">
                        <span class="material-symbols-outlined">church</span>
                        Church Information
                    </div>
                    <div class="form-grid">
                        <div>
                            <label class="field-label">Date Joined<span class="field-required">*</span></label>
                            <input type="date" name="dateJoined" required class="field-input">
                        </div>
                        <div>
                            <label class="field-label">Cell (Zone)<span class="field-required">*</span></label>
                            <select name="cell" required class="field-input">
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
                <div class="form-section">
                    <label class="field-label" style="margin-bottom:12px;">Profile Photo <span style="font-weight:300; text-transform:none; letter-spacing:0; color:var(--muted);">(Optional)</span></label>
                    <div class="file-input-wrap">
                        <label class="file-input-label">
                            <div class="file-icon">📷</div>
                            <strong>Click to upload photo</strong>
                            <span>PNG, JPG up to 5MB</span>
                            <input type="file" name="profileImage" accept="image/*">
                        </label>
                    </div>
                </div>

                {{-- Account creation --}}
                <div class="account-toggle">
                    <label class="account-toggle-label">
                        <input type="checkbox" id="createAccount" name="create_account" value="1">
                        <div>
                            <h4>Create an online account</h4>
                            <p>Access services, join groups, and track your giving online.</p>
                        </div>
                    </label>
                    <div class="account-fields" id="accountFields">
                        <div>
                            <label class="field-label">Password<span class="field-required">*</span></label>
                            <input type="password" name="password" id="password" class="field-input" placeholder="Minimum 8 characters">
                        </div>
                        <div>
                            <label class="field-label">Confirm Password<span class="field-required">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="field-input" placeholder="Re-enter password">
                        </div>
                    </div>
                </div>

                <div class="form-notice" id="formNotice">
                    ✓ Registration submitted — redirecting…
                </div>

                <button type="submit" class="btn-submit">
                    <span>Complete Registration</span>
                    <span class="material-symbols-outlined" style="font-size:18px;">arrow_forward</span>
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ═══════════════ JOIN GROUP MODAL ═══════════════ --}}
<div id="joinGroupModal" class="modal-overlay">
    <div class="modal-box join-modal-box">
        <button type="button" id="closeJoinModal" class="modal-close">×</button>
        <div class="modal-header">
            <div class="eyebrow">Ministry</div>
            <h2 id="modalGroupName">Join Group</h2>
            <p>We're so glad to have you!</p>
        </div>
        <form id="joinGroupForm" action="{{ route('groups.join') }}" method="POST">
            @csrf
            <input type="hidden" name="group" id="groupInput">
            <div class="join-modal-body">
                <p>You're about to join this ministry group. Confirm your choice and start growing in community.</p>
                <div class="join-modal-actions">
                    <button type="button" class="btn-cancel" id="cancelJoinBtn">Cancel</button>
                    <button type="submit" class="btn-confirm">Confirm & Join</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════ MY GROUPS MODAL ═══════════════ --}}
<div id="myGroupsModal" class="modal-overlay">
    <div class="modal-box" style="max-width:520px;">
        <button type="button" onclick="closeMyGroupsModal()" class="modal-close">×</button>
        <div class="modal-header">
            <div class="eyebrow">Your Ministry</div>
            <h2>My Groups</h2>
            <p>Groups you currently belong to</p>
        </div>
        <div id="myGroupsContent" class="modal-body">
            <div class="empty-state">
                <div class="empty-state-icon">⏳</div>
                <p>Loading…</p>
            </div>
        </div>
    </div>
</div>

{{-- ═══════════════ SCRIPTS ═══════════════ --}}
<script>
(function () {
    // ── Registration Modal ──
    const regModal  = document.getElementById('registrationModal');
    const joinBtn   = document.getElementById('joinBtn');
    const regClose  = regModal?.querySelector('[data-modal-close]');

    function openReg()  { if (regModal) { regModal.classList.add('open'); document.body.style.overflow = 'hidden'; } }
    function closeReg() { if (regModal) { regModal.classList.remove('open'); document.body.style.overflow = ''; } }

    joinBtn?.addEventListener('click', openReg);
    regClose?.addEventListener('click', closeReg);
    regModal?.addEventListener('click', e => { if (e.target === regModal) closeReg(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeReg(); closeJoinGroup(); closeMyGroupsModal(); } });

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

    // Form submit
    const memberForm = document.getElementById('memberForm');
    memberForm?.addEventListener('submit', function () {
        const notice = document.getElementById('formNotice');
        if (notice) notice.style.display = 'block';
    });

    // ── Join Group Modal ──
    const joinModal = document.getElementById('joinGroupModal');
    const joinClose = document.getElementById('closeJoinModal');
    const cancelJoinBtn = document.getElementById('cancelJoinBtn');

    function openJoinGroup(name) {
        if (!joinModal) return;
        document.getElementById('modalGroupName').textContent = name;
        document.getElementById('groupInput').value = name;
        joinModal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeJoinGroup() {
        if (!joinModal) return;
        joinModal.classList.remove('open');
        document.body.style.overflow = '';
    }
    joinClose?.addEventListener('click', closeJoinGroup);
    cancelJoinBtn?.addEventListener('click', closeJoinGroup);
    joinModal?.addEventListener('click', e => { if (e.target === joinModal) closeJoinGroup(); });

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
                    this.outerHTML = `<div class="group-btn-member"><span class="material-symbols-outlined" style="font-size:16px;">check_circle</span>Member</div>`;
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

    // Toast
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
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';

    fetch('/api/my-groups', {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    })
    .then(r => r.json())
    .then(data => {
        const groups = (data.groups || []).filter(g => g.status !== 'rejected');
        if (groups.length > 0) {
            content.innerHTML = `<div style="padding:0 4px;">` + groups.map(g => `
                <div class="my-groups-item">
                    <div class="my-groups-icon">
                        ${g.image_url ? `<img src="${g.image_url}" alt="${g.name}">` : `<span class="material-symbols-outlined" style="color:var(--gold); font-size:22px;">group</span>`}
                    </div>
                    <div>
                        <div class="my-groups-name">${g.name}</div>
                        <div class="my-groups-meta">${g.meeting_day || ''}${g.meeting_day && g.location ? ' · ' : ''}${g.location || ''}</div>
                    </div>
                    <button class="my-groups-leave" onclick="leaveGroup(${g.id}, '${g.name}')">Leave</button>
                </div>
            `).join('') + `</div>`;
        } else {
            content.innerHTML = `<div class="empty-state"><div class="empty-state-icon">⛪</div><p>No groups yet</p><small>Join a group to start connecting!</small></div>`;
        }
    })
    .catch(() => {
        content.innerHTML = `<div class="empty-state"><div class="empty-state-icon">⚠️</div><p>Could not load groups</p></div>`;
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
    document.getElementById('myGroupsModal').classList.remove('open');
    document.body.style.overflow = '';
}

// Body scroll safety
document.addEventListener('DOMContentLoaded', function () {
    document.documentElement.style.overflowY = 'auto';
    document.body.style.overflowY = 'auto';
});
</script>

<script src="script.js"></script>
</body>
</html>