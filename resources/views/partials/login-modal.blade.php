{{-- Login Modal --}}
<div id="loginModal" class="modal-overlay" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(12,27,58,0.72); backdrop-filter:blur(4px); align-items:center; justify-content:center; padding:20px;">

  <div style="background:#ffffff; width:100%; max-width:400px; border-radius:2px; overflow:hidden; box-shadow:0 32px 80px rgba(12,27,58,0.3); position:relative; animation:loginModalIn .32s ease both;">

    {{-- Dark navy header (matches login page card header) --}}
    <div style="background:#0c1b3a; padding:28px 32px 22px; position:relative; overflow:hidden;">
      {{-- Cross watermark --}}
      <div style="position:absolute; right:4px; bottom:-20px; font-size:110px; line-height:1; color:rgba(200,151,58,0.06); font-family:'Cormorant Garamond',serif; pointer-events:none; user-select:none;">✝</div>

      {{-- Close button --}}
      <button onclick="closeLoginModal()"
              style="position:absolute; top:14px; right:16px; width:32px; height:32px; background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.18); border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; color:rgba(255,255,255,0.6); font-size:18px; line-height:1; z-index:10; transition:background .2s;"
              onmouseover="this.style.background='rgba(255,255,255,0.2)'"
              onmouseout="this.style.background='rgba(255,255,255,0.1)'">×</button>

      {{-- Eyebrow + title --}}
      <p style="font-family:'Jost',sans-serif; font-size:10px; font-weight:600; letter-spacing:0.2em; text-transform:uppercase; color:#c8973a; margin:0 0 8px; display:flex; align-items:center; gap:8px; position:relative; z-index:1;">
        <span style="display:block; width:20px; height:1px; background:#c8973a;"></span>Member Portal
      </p>
      <h3 style="font-family:'Cormorant Garamond',serif; font-size:32px; font-weight:600; color:#ffffff; line-height:1; margin:0 0 4px; position:relative; z-index:1;">
        Sign <em style="font-weight:300; color:#e8b96a; font-style:italic;">In</em>
      </h3>
      <p style="font-family:'Jost',sans-serif; font-size:12px; font-weight:300; color:rgba(255,255,255,0.4); margin:0; position:relative; z-index:1;">
        Welcome back — enter your details to continue.
      </p>
    </div>

    {{-- Form body --}}
    <div style="padding:28px 32px 32px; background:#ffffff;">
      <form method="POST" action="{{ route('login') }}" id="loginModalForm">
        @csrf

        {{-- Email --}}
        <div style="margin-bottom:18px;">
          <label for="modal_email"
                 style="display:block; font-family:'Jost',sans-serif; font-size:10px; font-weight:600; letter-spacing:0.16em; text-transform:uppercase; color:#0c1b3a; margin-bottom:8px;">
            Email Address <span style="color:#c8973a;">*</span>
          </label>
          <input id="modal_email" type="email" name="email" required autofocus autocomplete="username"
                 value="{{ old('email') }}"
                 placeholder="you@example.com"
                 style="width:100%; padding:12px 14px; background:#f5ede0; border:1px solid #e2d9cc; font-family:'Jost',sans-serif; font-size:13px; font-weight:300; color:#1a1a2e; outline:none; border-radius:0; transition:all .2s; box-sizing:border-box;"
                 onfocus="this.style.background='#ffffff'; this.style.borderColor='#c8973a'; this.style.boxShadow='0 0 0 3px rgba(200,151,58,0.12)';"
                 onblur="this.style.background='#f5ede0'; this.style.borderColor='#e2d9cc'; this.style.boxShadow='none';">
        </div>

        {{-- Password --}}
        <div style="margin-bottom:18px;">
          <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <label for="modal_password"
                   style="font-family:'Jost',sans-serif; font-size:10px; font-weight:600; letter-spacing:0.16em; text-transform:uppercase; color:#0c1b3a;">
              Password <span style="color:#c8973a;">*</span>
            </label>
            @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}"
                 style="font-family:'Jost',sans-serif; font-size:11px; font-weight:500; color:#c8973a; text-decoration:none;"
                 onmouseover="this.style.color='#e8b96a'"
                 onmouseout="this.style.color='#c8973a'">Forgot password?</a>
            @endif
          </div>
          <div style="position:relative;">
            <input id="modal_password" type="password" name="password" required autocomplete="current-password"
                   placeholder="••••••••"
                   style="width:100%; padding:12px 40px 12px 14px; background:#f5ede0; border:1px solid #e2d9cc; font-family:'Jost',sans-serif; font-size:13px; font-weight:300; color:#1a1a2e; outline:none; border-radius:0; transition:all .2s; box-sizing:border-box;"
                   onfocus="this.style.background='#ffffff'; this.style.borderColor='#c8973a'; this.style.boxShadow='0 0 0 3px rgba(200,151,58,0.12)';"
                   onblur="this.style.background='#f5ede0'; this.style.borderColor='#e2d9cc'; this.style.boxShadow='none';">
            <button type="button" onclick="toggleModalPw()"
                    style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#6b7080; padding:0; display:flex; align-items:center;">
              <svg id="modal-eye-on"  width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              <svg id="modal-eye-off" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none;"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
            </button>
          </div>
        </div>

        {{-- Remember me --}}
        <div style="display:flex; align-items:center; gap:8px; margin-bottom:22px;">
          <input type="checkbox" id="modal_remember" name="remember"
                 style="width:16px; height:16px; accent-color:#0c1b3a; cursor:pointer; border-radius:0; flex-shrink:0;">
          <label for="modal_remember"
                 style="font-family:'Jost',sans-serif; font-size:12px; font-weight:300; color:#6b7080; cursor:pointer; user-select:none;">
            Keep me signed in for 30 days
          </label>
        </div>

        {{-- Submit --}}
        <button type="submit" id="loginModalBtn"
                style="width:100%; padding:14px; background:#0c1b3a; color:#e8b96a; font-family:'Jost',sans-serif; font-size:11px; font-weight:600; letter-spacing:0.18em; text-transform:uppercase; border:none; cursor:pointer; transition:background .2s; display:flex; align-items:center; justify-content:center; gap:8px; border-radius:0;"
                onmouseover="this.style.background='#142450'"
                onmouseout="this.style.background='#0c1b3a'"
                onclick="loginModalLoading(this)">
          <span id="loginModalBtnContent" style="display:flex; align-items:center; gap:8px;">
            Sign In
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path d="M13 7l5 5m0 0l-5 5m5-5H6"/>
            </svg>
          </span>
        </button>

        {{-- Divider --}}
        <div style="display:flex; align-items:center; gap:12px; margin:20px 0;">
          <div style="flex:1; height:1px; background:#e2d9cc;"></div>
          <span style="font-family:'Jost',sans-serif; font-size:10px; letter-spacing:0.14em; text-transform:uppercase; color:rgba(107,112,128,0.5); font-weight:300;">or</span>
          <div style="flex:1; height:1px; background:#e2d9cc;"></div>
        </div>

        {{-- Register link --}}
        <p style="text-align:center; font-family:'Jost',sans-serif; font-size:12px; font-weight:300; color:#6b7080; margin:0;">
          New to St. John's?
          <a href="{{ route('register') ?? '#' }}"
             style="font-weight:600; color:#0c1b3a; text-decoration:none; margin-left:4px;"
             onmouseover="this.style.color='#c8973a'"
             onmouseout="this.style.color='#0c1b3a'">Create an account →</a>
        </p>

      </form>
    </div>
  </div>
</div>

<style>
@keyframes loginModalIn {
  from { opacity:0; transform:translateY(18px); }
  to   { opacity:1; transform:translateY(0); }
}
</style>

<script>
function showLoginModal() {
  const m = document.getElementById('loginModal');
  m.style.display = 'flex';
  document.body.style.overflow = 'hidden';
  setTimeout(() => { document.getElementById('modal_email').focus(); }, 100);
}
function closeLoginModal() {
  document.getElementById('loginModal').style.display = 'none';
  document.body.style.overflow = '';
}
// Close on backdrop click
document.getElementById('loginModal').addEventListener('click', function(e) {
  if (e.target === this) closeLoginModal();
});
// Close on Escape
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeLoginModal();
});
function toggleModalPw() {
  const pw  = document.getElementById('modal_password');
  const on  = document.getElementById('modal-eye-on');
  const off = document.getElementById('modal-eye-off');
  const show = pw.type === 'password';
  pw.type = show ? 'text' : 'password';
  on.style.display  = show ? 'none'  : 'block';
  off.style.display = show ? 'block' : 'none';
}
function loginModalLoading(btn) {
  setTimeout(() => {
    btn.disabled = true;
    document.getElementById('loginModalBtnContent').innerHTML =
      '<svg style="animation:spin .8s linear infinite" width="16" height="16" fill="none" viewBox="0 0 24 24"><circle style="opacity:.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path style="opacity:.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg> Signing in…';
  }, 0);
}
</script>