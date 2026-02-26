<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Give / Tithe — St. John's Parish Church Entebbe</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

@keyframes fadeUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
.fade-up   { animation:fadeUp .75s ease both }
.fade-up-1 { animation-delay:.1s }
.fade-up-2 { animation-delay:.2s }
.fade-up-3 { animation-delay:.32s }

/* Field focus */
.field {
    width:100%;padding:12px 16px;
    background:var(--cream);border:1px solid var(--border);
    font-family:'Jost',sans-serif;font-size:14px;color:var(--text);
    transition:all .2s;outline:none;
}
.field:focus { background:#fff;border-color:var(--gold);box-shadow:0 0 0 3px rgba(200,151,58,.1); }
.field::placeholder { color:#b5b9c4; }

/* Giving type pills */
.giving-pill input[type="radio"] { display:none; }
.giving-pill label {
    display:block;padding:12px 16px;
    border:1px solid var(--border);cursor:pointer;
    font-size:11px;font-weight:600;letter-spacing:.12em;text-transform:uppercase;
    color:var(--muted);transition:all .2s;text-align:center;
    font-family:'Jost',sans-serif;
}
.giving-pill input[type="radio"]:checked + label {
    background:var(--navy);color:var(--gold2);border-color:var(--navy);
}
.giving-pill label:hover { border-color:var(--navy);color:var(--navy); }

/* Amount quick-select pills */
.amount-pill input[type="radio"] { display:none; }
.amount-pill label {
    display:block;padding:10px 14px;
    border:1px solid var(--border);cursor:pointer;
    font-size:13px;font-weight:600;color:var(--muted);
    transition:all .2s;text-align:center;
    font-family:'Jost',sans-serif;
}
.amount-pill input[type="radio"]:checked + label {
    background:var(--gold);color:var(--navy);border-color:var(--gold);
}
.amount-pill label:hover { border-color:var(--gold);color:var(--navy); }

/* Payment method tabs */
.pay-tab input[type="radio"] { display:none; }
.pay-tab label {
    display:flex;flex-direction:column;align-items:center;gap:6px;
    padding:14px 10px;border:1px solid var(--border);cursor:pointer;
    font-size:10px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;
    color:var(--muted);transition:all .2s;font-family:'Jost',sans-serif;
}
.pay-tab input[type="radio"]:checked + label {
    background:var(--navy);color:var(--gold2);border-color:var(--navy);
}
.pay-tab label:hover { border-color:var(--navy);color:var(--navy); }
.pay-tab label .material-symbols-outlined { font-size:22px; }

/* Info box */
.info-box { padding:16px 20px;border-left:3px solid var(--gold);background:rgba(200,151,58,.06);font-size:13px;line-height:1.7; }
.info-box strong { color:var(--navy);font-weight:600; }

/* Submit button shimmer */
.btn-submit { position:relative;overflow:hidden; }
.btn-submit::before { content:'';position:absolute;inset:0;background:var(--navy2);transform:translateX(-101%);transition:transform .3s ease; }
.btn-submit:hover::before { transform:translateX(0); }
.btn-submit > * { position:relative;z-index:1; }

@media(max-width:640px){
    .giving-grid { grid-template-columns:repeat(2,1fr)!important; }
    .pay-grid { grid-template-columns:repeat(2,1fr)!important; }
}
</style>
</head>

<body style="font-family:'Jost',sans-serif;background:var(--cream);color:var(--text);">

@include('partials.navbar')
@include('partials.login-modal')


{{-- ══════════════════════════════════════
     PAGE HERO
══════════════════════════════════════ --}}
<section class="relative overflow-hidden text-center px-10 py-[72px]"
         style="background:var(--navy);background-image:repeating-linear-gradient(45deg,transparent,transparent 40px,rgba(201,168,76,.03) 40px,rgba(201,168,76,.03) 41px);">
    <span class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none select-none leading-none"
          style="font-size:420px;color:rgba(200,151,58,.04);font-family:serif;">✝</span>
    <div class="relative z-10 max-w-[680px] mx-auto">
        <p class="fade-up inline-flex items-center gap-2.5 justify-center mb-3.5 text-[10px] font-semibold tracking-[.22em] uppercase"
           style="color:var(--gold);">
            <span style="display:block;width:28px;height:1px;background:var(--gold);"></span>
            Stewardship · Generosity · Faith
        </p>
        <h1 class="fade-up fade-up-1 font-semibold leading-[.95] tracking-[-0.01em] mt-3.5 mb-5"
            style="font-family:'Cormorant Garamond',serif;font-size:clamp(48px,8vw,84px);color:#fff;">
            Give with a<br><em style="font-style:italic;color:var(--gold2);font-weight:300;">Cheerful Heart</em>
        </h1>
        <p class="fade-up fade-up-2 text-[13px] font-light leading-[1.85] max-w-[480px] mx-auto" style="color:rgba(255,255,255,.5);">
            Your generosity is an act of worship. Every gift — great or small — helps us serve our community, support ministry, and spread the love of Christ.
        </p>
        <p class="fade-up fade-up-3 text-[15px] italic mt-5" style="color:rgba(255,255,255,.3);font-family:'Cormorant Garamond',serif;">
            "God loves a cheerful giver." — 2 Corinthians 9:7
        </p>
    </div>
</section>


{{-- ══════════════════════════════════════
     MAIN CONTENT — 2-col: Form + Sidebar
══════════════════════════════════════ --}}
<div class="max-w-[1200px] mx-auto px-10 py-14 max-sm:px-5"
     style="display:grid;grid-template-columns:1fr 320px;gap:48px;align-items:start;">

    {{-- ════════════════════════
         LEFT — GIVING FORM
    ════════════════════════ --}}
    <div>

        {{-- Messages --}}
        <div id="message-container" class="mb-6 hidden">
            <div id="success-message" class="hidden flex items-start gap-3 px-5 py-4 border-l-[3px]"
                 style="background:#edf7f2;border-color:var(--green);color:#155d38;">
                <span class="material-symbols-outlined shrink-0" style="font-size:18px;">check_circle</span>
                <div><div class="font-semibold mb-0.5">Thank you!</div><span id="success-text"></span></div>
            </div>
            <div id="error-message" class="hidden flex items-start gap-3 px-5 py-4 border-l-[3px]"
                 style="background:#fdf2f0;border-color:var(--red);color:#8b2020;">
                <span class="material-symbols-outlined shrink-0" style="font-size:18px;">error</span>
                <div><div class="font-semibold mb-0.5">Error</div><span id="error-text"></span></div>
            </div>
        </div>

        <form id="giving-form">
            @csrf

            {{-- ── Auth welcome banner ── --}}
            @auth
                @if(auth()->user()->member)
                <div class="flex items-center gap-3 px-5 py-3 mb-6 text-sm"
                     style="background:rgba(26,122,74,.07);border-left:3px solid var(--green);color:#155d38;">
                    <span class="material-symbols-outlined" style="font-size:16px;">verified_user</span>
                    Welcome back, <strong>{{ auth()->user()->member->full_name }}</strong>! Your giving will be linked to your account.
                </div>
                @else
                <div class="flex items-center gap-3 px-5 py-3 mb-6 text-sm"
                     style="background:rgba(200,151,58,.08);border-left:3px solid var(--gold);color:var(--navy);">
                    <span class="material-symbols-outlined" style="font-size:16px;">person</span>
                    Welcome, {{ auth()->user()->name }}! Please fill in your details below.
                </div>
                @endif
            @endauth

            {{-- ── SECTION 1: Your Information (guests only) ── --}}
            @if(!auth()->check() || !auth()->user()->member)
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-5">
                    <span style="display:inline-block;width:24px;height:1px;background:var(--gold);"></span>
                    <span style="font-size:10px;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);">Your Information</span>
                    <div style="flex:1;height:1px;background:var(--border);"></div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4 max-sm:grid-cols-1">
                    <div>
                        <label class="block mb-2" style="font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--navy);">
                            Full Name <span style="color:var(--gold);">*</span>
                        </label>
                        <input type="text" name="guest_name" required class="field" placeholder="Your full name">
                    </div>
                    <div>
                        <label class="block mb-2" style="font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--navy);">Email</label>
                        <input type="email" name="guest_email" class="field" placeholder="For receipt & confirmation">
                    </div>
                </div>
                <div>
                    <label class="block mb-2" style="font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--navy);">Phone Number</label>
                    <input type="tel" name="guest_phone" class="field" placeholder="For mobile money / updates">
                </div>
            </div>
            @endif


            {{-- ── SECTION 2: Type of Giving ── --}}
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-5">
                    <span style="display:inline-block;width:24px;height:1px;background:var(--gold);"></span>
                    <span style="font-size:10px;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);">Type of Giving</span>
                    <div style="flex:1;height:1px;background:var(--border);"></div>
                </div>

                {{-- Giving type pills --}}
                <div class="giving-grid grid gap-3 mb-5" style="grid-template-columns:repeat(4,1fr);">
                    <div class="giving-pill">
                        <input type="radio" name="giving_type" id="gt_tithe" value="tithe" required>
                        <label for="gt_tithe">
                            <span class="material-symbols-outlined block mx-auto mb-1" style="font-size:20px;">percent</span>
                            Tithe
                        </label>
                    </div>
                    <div class="giving-pill">
                        <input type="radio" name="giving_type" id="gt_offering" value="offering">
                        <label for="gt_offering">
                            <span class="material-symbols-outlined block mx-auto mb-1" style="font-size:20px;">volunteer_activism</span>
                            Offering
                        </label>
                    </div>
                    <div class="giving-pill">
                        <input type="radio" name="giving_type" id="gt_donation" value="donation">
                        <label for="gt_donation">
                            <span class="material-symbols-outlined block mx-auto mb-1" style="font-size:20px;">favorite</span>
                            Donation
                        </label>
                    </div>
                    <div class="giving-pill">
                        <input type="radio" name="giving_type" id="gt_special" value="special_offering">
                        <label for="gt_special">
                            <span class="material-symbols-outlined block mx-auto mb-1" style="font-size:20px;">stars</span>
                            Special
                        </label>
                    </div>
                </div>
            </div>


            {{-- ── SECTION 3: Amount ── --}}
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-5">
                    <span style="display:inline-block;width:24px;height:1px;background:var(--gold);"></span>
                    <span style="font-size:10px;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);">Amount (UGX)</span>
                    <div style="flex:1;height:1px;background:var(--border);"></div>
                </div>

                {{-- Quick-select amounts --}}
                <div class="grid grid-cols-4 gap-2 mb-4 max-sm:grid-cols-2">
                    <div class="amount-pill"><input type="radio" name="amount_preset" id="amt1" value="10000"><label for="amt1">10,000</label></div>
                    <div class="amount-pill"><input type="radio" name="amount_preset" id="amt2" value="25000"><label for="amt2">25,000</label></div>
                    <div class="amount-pill"><input type="radio" name="amount_preset" id="amt3" value="50000"><label for="amt3">50,000</label></div>
                    <div class="amount-pill"><input type="radio" name="amount_preset" id="amt4" value="100000"><label for="amt4">100,000</label></div>
                    <div class="amount-pill"><input type="radio" name="amount_preset" id="amt5" value="250000"><label for="amt5">250,000</label></div>
                    <div class="amount-pill"><input type="radio" name="amount_preset" id="amt6" value="500000"><label for="amt6">500,000</label></div>
                    <div class="amount-pill col-span-2"><input type="radio" name="amount_preset" id="amt_other" value="other"><label for="amt_other">Other Amount</label></div>
                </div>

                {{-- Custom amount input --}}
                <div>
                    <label class="block mb-2" style="font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--navy);">
                        Enter Amount <span style="color:var(--gold);">*</span>
                    </label>
                    <div class="flex">
                        <span class="flex items-center px-4 text-[13px] font-semibold shrink-0"
                              style="background:var(--sand);border:1px solid var(--border);border-right:none;color:var(--muted);">UGX</span>
                        <input type="number" name="amount" id="amount_input" required min="1000" step="100"
                               class="field flex-1" style="border-left:none;" placeholder="e.g. 50,000">
                        <input type="hidden" name="currency" value="UGX">
                    </div>
                </div>
            </div>


            {{-- ── SECTION 4: Purpose & Notes ── --}}
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-5">
                    <span style="display:inline-block;width:24px;height:1px;background:var(--gold);"></span>
                    <span style="font-size:10px;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);">Details</span>
                    <div style="flex:1;height:1px;background:var(--border);"></div>
                </div>

                <div class="mb-4">
                    <label class="block mb-2" style="font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--navy);">Purpose / Designation</label>
                    <input type="text" name="purpose" class="field"
                           placeholder="e.g. Building Fund, Missions, Youth Ministry">
                </div>
                <div>
                    <label class="block mb-2" style="font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--navy);">
                        Personal Message / Prayer Request
                    </label>
                    <textarea name="notes" rows="3" class="field resize-none"
                              placeholder="Share your heart or prayer request (optional)"></textarea>
                </div>
            </div>


            {{-- ── SECTION 5: Payment Method ── --}}
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-5">
                    <span style="display:inline-block;width:24px;height:1px;background:var(--gold);"></span>
                    <span style="font-size:10px;font-weight:700;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);">Payment Method</span>
                    <div style="flex:1;height:1px;background:var(--border);"></div>
                </div>

                {{-- Payment method tab pills --}}
                <div class="pay-grid grid gap-3 mb-6" style="grid-template-columns:repeat(4,1fr);">
                    <div class="pay-tab">
                        <input type="radio" name="payment_method" id="pm_cash" value="cash" required>
                        <label for="pm_cash">
                            <span class="material-symbols-outlined">payments</span>Cash
                        </label>
                    </div>
                    <div class="pay-tab">
                        <input type="radio" name="payment_method" id="pm_mobile" value="mobile_money">
                        <label for="pm_mobile">
                            <span class="material-symbols-outlined">smartphone</span>Mobile Money
                        </label>
                    </div>
                    <div class="pay-tab">
                        <input type="radio" name="payment_method" id="pm_bank" value="bank_transfer">
                        <label for="pm_bank">
                            <span class="material-symbols-outlined">account_balance</span>Bank Transfer
                        </label>
                    </div>
                    <div class="pay-tab">
                        <input type="radio" name="payment_method" id="pm_card" value="card">
                        <label for="pm_card">
                            <span class="material-symbols-outlined">credit_card</span>Card
                        </label>
                    </div>
                </div>

                {{-- Cash details --}}
                <div id="cash-details" class="hidden">
                    <div class="info-box mb-4">
                        <strong>Cash Giving</strong><br>
                        Please bring your cash offering to the church during service or office hours. Your giving will be confirmed immediately upon submission.
                    </div>
                </div>

                {{-- Mobile Money details --}}
                <div id="mobile-money-details" class="hidden">
                    <div class="info-box mb-4">
                        <strong>Mobile Money Instructions</strong><br>
                        Send money to: <strong>0700-123-456</strong> (Church Account)<br>
                        Then enter your transaction reference below.
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4 max-sm:grid-cols-1">
                        <div>
                            <label class="block mb-2" style="font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--navy);">Provider</label>
                            <select id="payment_provider" name="payment_provider" class="field" disabled>
                                <option value="">Select provider</option>
                                <option value="MTN">MTN Mobile Money</option>
                                <option value="Airtel">Airtel Money</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2" style="font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--navy);">Your Phone Number</label>
                            <input type="tel" id="payment_account" name="payment_account" class="field" disabled placeholder="0700-000-000">
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2" style="font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--navy);">
                            Transaction Reference <span style="color:var(--gold);">*</span>
                        </label>
                        <input type="text" id="transaction_reference" name="transaction_reference" class="field" disabled placeholder="Enter transaction ID from SMS">
                    </div>
                </div>

                {{-- Bank Transfer details --}}
                <div id="bank-transfer-details" class="hidden">
                    <div class="info-box mb-4">
                        <strong>Bank Transfer Details</strong><br>
                        Bank: Stanbic Bank Uganda<br>
                        Account Name: St. John's Church Entebbe<br>
                        Account Number: <strong>9030012345678</strong><br>
                        Branch: Kampala Main Branch
                    </div>
                    <div>
                        <label class="block mb-2" style="font-size:10px;font-weight:600;letter-spacing:.14em;text-transform:uppercase;color:var(--navy);">
                            Transaction Reference <span style="color:var(--gold);">*</span>
                        </label>
                        <input type="text" id="transaction_reference_bank" name="transaction_reference" class="field" disabled placeholder="Bank transaction reference">
                    </div>
                </div>

                {{-- Card details --}}
                <div id="card-details" class="hidden">
                    <div class="info-box">
                        <strong>Card Payment</strong><br>
                        You will be redirected to our secure payment gateway to complete your card transaction.
                    </div>
                </div>
            </div>


            {{-- ── SUBMIT ── --}}
            <button type="submit" id="submit-btn"
                    class="btn-submit w-full flex items-center justify-center gap-3 border-none cursor-pointer transition-all duration-300"
                    style="padding:17px;background:var(--navy);color:var(--gold2);font-family:'Jost',sans-serif;font-size:12px;font-weight:600;letter-spacing:.22em;text-transform:uppercase;">
                <span id="submit-text">Submit My Giving</span>
                <span id="submit-loading" class="hidden">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
                <span class="material-symbols-outlined" style="font-size:18px;">arrow_forward</span>
            </button>

            <p class="text-center mt-4 text-[11px] font-light" style="color:var(--muted);">
                Your giving is secure and confidential. A receipt will be sent to your email.
            </p>
        </form>
    </div>


    {{-- ════════════════════════
         RIGHT — SIDEBAR
    ════════════════════════ --}}
    <div style="position:sticky;top:24px;">

        {{-- Scripture card --}}
        <div class="mb-5 relative overflow-hidden" style="background:var(--navy);padding:32px 28px;">
            <span class="absolute right-3 bottom-[-20px] pointer-events-none leading-none" style="font-size:120px;color:rgba(200,151,58,.06);font-family:serif;">✝</span>
            <p class="relative z-10 text-[9px] font-bold tracking-[.22em] uppercase mb-3" style="color:var(--gold);">Scripture</p>
            <blockquote class="relative z-10 font-light italic leading-[1.8] mb-3" style="font-family:'Cormorant Garamond',serif;font-size:18px;color:rgba(255,255,255,.85);">
                "Each of you should give what you have decided in your heart to give, not reluctantly or under compulsion, for God loves a cheerful giver."
            </blockquote>
            <cite class="relative z-10 text-[11px] font-semibold tracking-[.1em] not-italic" style="color:var(--gold);">— 2 Corinthians 9:7</cite>
        </div>

        {{-- Secure & Transparent --}}
        <div class="mb-4" style="background:#fff;border:1px solid var(--border);padding:24px;">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center justify-center w-9 h-9 shrink-0" style="background:var(--navy);">
                    <span class="material-symbols-outlined" style="font-size:18px;color:var(--gold2);">lock</span>
                </div>
                <h3 class="font-semibold" style="font-family:'Cormorant Garamond',serif;font-size:20px;color:var(--navy);">Secure &amp; Transparent</h3>
            </div>
            <div class="flex flex-col gap-2.5">
                @foreach(['All transactions encrypted & secure','Instant digital receipt sent to you','Full financial transparency reports'] as $item)
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined shrink-0 mt-0.5" style="font-size:15px;color:var(--green);">check_circle</span>
                    <span style="font-size:13px;color:var(--muted);font-weight:300;line-height:1.5;">{{ $item }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Your Impact --}}
        <div class="mb-4" style="background:#fff;border:1px solid var(--border);padding:24px;">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex items-center justify-center w-9 h-9 shrink-0" style="background:var(--navy);">
                    <span class="material-symbols-outlined" style="font-size:18px;color:var(--gold2);">volunteer_activism</span>
                </div>
                <h3 class="font-semibold" style="font-family:'Cormorant Garamond',serif;font-size:20px;color:var(--navy);">Your Impact</h3>
            </div>
            <div class="flex flex-col gap-2.5">
                @foreach(['Local community outreach & food programs','Youth, children & education support','Church maintenance & missions'] as $item)
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined shrink-0 mt-0.5" style="font-size:15px;color:var(--gold);">favorite</span>
                    <span style="font-size:13px;color:var(--muted);font-weight:300;line-height:1.5;">{{ $item }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Contact --}}
        <div style="background:var(--sand);border:1px solid var(--border);padding:20px;">
            <p class="text-[9px] font-bold tracking-[.22em] uppercase mb-3" style="color:var(--gold);">Questions?</p>
            <a href="mailto:giving@stjohnsentebbe.org"
               class="flex items-center gap-2 mb-2 transition-colors duration-200"
               style="font-size:13px;color:var(--navy);font-weight:500;"
               onmouseover="this.style.color='var(--gold)';" onmouseout="this.style.color='var(--navy)';">
                <span class="material-symbols-outlined" style="font-size:16px;">mail</span>
                giving@stjohnsentebbe.org
            </a>
            <a href="tel:+256700123456"
               class="flex items-center gap-2 transition-colors duration-200"
               style="font-size:13px;color:var(--navy);font-weight:500;"
               onmouseover="this.style.color='var(--gold)';" onmouseout="this.style.color='var(--navy)';">
                <span class="material-symbols-outlined" style="font-size:16px;">phone</span>
                +256 700 123 456
            </a>
        </div>

    </div>{{-- end sidebar --}}

</div>{{-- end main grid --}}


{{-- Mobile responsive override --}}
<style>
@media(max-width:1024px){
    .max-w-\\[1200px\\] > div { grid-template-columns:1fr!important; }
}
</style>

@include('partials.footer')


<script>
document.addEventListener('DOMContentLoaded', function () {
    const form            = document.getElementById('giving-form');
    const submitBtn       = document.getElementById('submit-btn');
    const submitText      = document.getElementById('submit-text');
    const submitLoading   = document.getElementById('submit-loading');

    /* ── Payment method tabs ── */
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function () {
            // hide all detail panels
            ['cash-details','mobile-money-details','bank-transfer-details','card-details'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.add('hidden');
            });

            // disable all payment fields
            ['payment_provider','payment_account','transaction_reference','transaction_reference_bank'].forEach(id => {
                const el = document.getElementById(id);
                if (el) { el.disabled = true; el.value = ''; }
            });

            const method = this.value;

            if (method === 'cash') {
                document.getElementById('cash-details').classList.remove('hidden');
            } else if (method === 'mobile_money') {
                document.getElementById('mobile-money-details').classList.remove('hidden');
                ['payment_provider','payment_account','transaction_reference'].forEach(id => {
                    document.getElementById(id).disabled = false;
                });
            } else if (method === 'bank_transfer') {
                document.getElementById('bank-transfer-details').classList.remove('hidden');
                document.getElementById('transaction_reference_bank').disabled = false;
            } else if (method === 'card') {
                document.getElementById('card-details').classList.remove('hidden');
            }
        });
    });

    /* ── Quick-amount pills fill the input ── */
    document.querySelectorAll('input[name="amount_preset"]').forEach(radio => {
        radio.addEventListener('change', function () {
            const input = document.getElementById('amount_input');
            if (this.value !== 'other') {
                input.value = this.value;
            } else {
                input.value = '';
                input.focus();
            }
        });
    });

    /* ── Form submit ── */
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        submitText.classList.add('hidden');
        submitLoading.classList.remove('hidden');
        submitBtn.disabled = true;

        const formData = new FormData(form);

        fetch('{{ route("giving.store") }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') }
        })
        .then(r => r.json().then(data => ({ ok: r.ok, data })))
        .then(({ ok, data }) => {
            if (ok && data.success) {
                showMessage('success', data.message);
                if (data.next_steps) setTimeout(() => showMessage('info', data.next_steps), 2000);
                form.reset();
                ['cash-details','mobile-money-details','bank-transfer-details','card-details'].forEach(id => {
                    const el = document.getElementById(id);
                    if(el) el.classList.add('hidden');
                });
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                let msg = data.message || 'An error occurred. Please try again.';
                if (data.errors) {
                    msg = Object.entries(data.errors)
                        .map(([f, m]) => `<strong>${f.replace(/_/g,' ')}:</strong> ${Array.isArray(m)?m.join(', '):m}`)
                        .join('<br>');
                }
                showMessage('error', msg);
            }
        })
        .catch(() => showMessage('error', 'Network error. Please check your connection and try again.'))
        .finally(() => {
            submitText.classList.remove('hidden');
            submitLoading.classList.add('hidden');
            submitBtn.disabled = false;
        });
    });

    function showMessage(type, message) {
        const container    = document.getElementById('message-container');
        const successDiv   = document.getElementById('success-message');
        const errorDiv     = document.getElementById('error-message');

        successDiv.classList.add('hidden');
        errorDiv.classList.add('hidden');

        if (type === 'success' || type === 'info') {
            document.getElementById('success-text').innerHTML = message.replace(/\n/g,'<br>');
            successDiv.classList.remove('hidden');
        } else {
            document.getElementById('error-text').innerHTML = message.replace(/\n/g,'<br>');
            errorDiv.classList.remove('hidden');
        }

        container.classList.remove('hidden');
        container.scrollIntoView({ behavior:'smooth', block:'center' });
        if (type !== 'error') setTimeout(() => container.classList.add('hidden'), 8000);
    }
});
</script>
</body>
</html>