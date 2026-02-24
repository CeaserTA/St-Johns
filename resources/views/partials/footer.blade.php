{{-- ═══════════════════════════════════════════════
     resources/views/partials/footer.blade.php
     St. John's Parish Church · Entebbe
═══════════════════════════════════════════════ --}}

<footer class="relative bg-primary overflow-hidden">

  {{-- Decorative cross watermark --}}
  <div class="absolute right-[3%] bottom-0 text-[18rem] leading-none text-accent/[0.035] pointer-events-none select-none font-serif" aria-hidden="true">✝</div>

  {{-- Top gold bar --}}
  <div class="h-px bg-gradient-to-r from-transparent via-accent/50 to-transparent"></div>

  {{-- Main content --}}
  <div class="relative z-10 max-w-6xl mx-auto px-4 pt-10 pb-6">

    {{-- 4-column grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

      {{-- ── Col 1: Brand ── --}}
      <div class="lg:col-span-1">

        <a href="{{ route('home') }}" class="flex items-center gap-3 mb-4 group">
          <img src="{{ asset('assets/Logo Final.png') }}"
               alt="St. John's Parish Church Logo"
               class="h-10 w-auto object-contain opacity-90 group-hover:opacity-100 transition-opacity">
          <div>
            <h2 class="font-sans text-sm font-bold text-white leading-tight">St. John's Parish Church</h2>
            <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-accent mt-0.5">Entebbe</p>
          </div>
        </a>

        <p class="text-xs text-white/50 leading-relaxed font-light mb-4">
          A welcoming community rooted in faith, service, and the love of Christ. All are welcome here.
        </p>

        {{-- Service time badge --}}
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white/5 border border-white/10">
          <span class="w-1.5 h-1.5 rounded-full bg-success animate-pulse"></span>
          <span class="text-xs font-medium text-white/65">Sunday Service · 9:00 AM</span>
        </div>
      </div>

      {{-- ── Col 2: Quick Links ── --}}
      <div>
        <h3 class="text-[10px] font-bold uppercase tracking-[0.18em] text-accent mb-4">Quick Links</h3>
        <ul class="space-y-2">
          <li>
            <a href="{{ route('home') }}" class="group flex items-center gap-2.5 text-xs text-white/55 hover:text-white transition-colors duration-200">
              <span class="inline-block w-3 h-px bg-accent/40 group-hover:w-5 group-hover:bg-accent transition-all duration-200 rounded-full flex-shrink-0"></span>
              Home
            </a>
          </li>
          <li>
            <a href="{{ route('services') }}" class="group flex items-center gap-2.5 text-xs text-white/55 hover:text-white transition-colors duration-200">
              <span class="inline-block w-3 h-px bg-accent/40 group-hover:w-5 group-hover:bg-accent transition-all duration-200 rounded-full flex-shrink-0"></span>
              Services
            </a>
          </li>
          <li>
            <a href="{{ route('updates') }}" class="group flex items-center gap-2.5 text-xs text-white/55 hover:text-white transition-colors duration-200">
              <span class="inline-block w-3 h-px bg-accent/40 group-hover:w-5 group-hover:bg-accent transition-all duration-200 rounded-full flex-shrink-0"></span>
              Announcements
            </a>
          </li>
          <li>
            <a href="{{ route('giving.index') }}" class="group flex items-center gap-2.5 text-xs text-white/55 hover:text-white transition-colors duration-200">
              <span class="inline-block w-3 h-px bg-accent/40 group-hover:w-5 group-hover:bg-accent transition-all duration-200 rounded-full flex-shrink-0"></span>
              Give Online
            </a>
          </li>
          <li>
            <a href="#" class="group flex items-center gap-2.5 text-xs text-white/55 hover:text-white transition-colors duration-200">
              <span class="inline-block w-3 h-px bg-accent/40 group-hover:w-5 group-hover:bg-accent transition-all duration-200 rounded-full flex-shrink-0"></span>
              About Us
            </a>
          </li>
          <li>
            <a href="#" class="group flex items-center gap-2.5 text-xs text-white/55 hover:text-white transition-colors duration-200">
              <span class="inline-block w-3 h-px bg-accent/40 group-hover:w-5 group-hover:bg-accent transition-all duration-200 rounded-full flex-shrink-0"></span>
              Ministries
            </a>
          </li>
        </ul>
      </div>

      {{-- ── Col 3: Contact ── --}}
      <div>
        <h3 class="text-[10px] font-bold uppercase tracking-[0.18em] text-accent mb-4">Contact Us</h3>
        <ul class="space-y-3">

          <li class="flex items-start gap-2.5">
            <svg class="w-3.5 h-3.5 text-accent/60 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="text-xs text-white/50 leading-relaxed">Entebbe Municipality,<br>Central Region, Uganda</span>
          </li>

          <li class="flex items-center gap-2.5">
            <svg class="w-3.5 h-3.5 text-accent/60 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
            </svg>
            <a href="tel:+256000000000" class="text-xs text-white/50 hover:text-white transition-colors">+256 000 000 000</a>
          </li>

          <li class="flex items-center gap-2.5">
            <svg class="w-3.5 h-3.5 text-accent/60 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <a href="mailto:info@stjohnsentebbe.org" class="text-xs text-white/50 hover:text-white transition-colors">info@stjohnsentebbe.org</a>
          </li>

          <li class="flex items-start gap-2.5">
            <svg class="w-3.5 h-3.5 text-accent/60 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="text-xs text-white/50 leading-relaxed">
              <span class="block">Sun: 9:00 AM – 12:00 PM</span>
              <span class="block">Wed: Prayer Night 6:30 PM</span>
            </div>
          </li>

        </ul>
      </div>

      {{-- ── Col 4: Newsletter + Social ── --}}
      <div>
        <h3 class="text-[10px] font-bold uppercase tracking-[0.18em] text-accent mb-4">Stay Connected</h3>

        <p class="text-xs text-white/45 mb-3 leading-relaxed">
          Get our weekly bulletin and parish announcements delivered to you.
        </p>
        <p class="text-xs text-white/80 mb-3">Receive weekly updates & sermons</p>
          <form id="newsletter-form" class="flex flex-col gap-2">
            @csrf
            <input type="email" 
                   id="newsletter-email" 
                   name="email" 
                   placeholder="Your email address" 
                   required
                   class="px-4 py-2 rounded-lg text-primary placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent transition text-sm">
            <button type="submit"
                    id="newsletter-submit"
                    class="px-4 py-2 bg-accent text-primary font-bold rounded-lg hover:bg-accent/90 transition shadow-md text-sm disabled:opacity-50 disabled:cursor-not-allowed">
              <span id="newsletter-button-text">Subscribe</span>
              <span id="newsletter-loading" class="hidden">
                <svg class="animate-spin h-4 w-4 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Subscribing...
              </span>
            </button>
            <div id="newsletter-message" class="hidden text-xs mt-1"></div>
          </form>

        {{-- Social --}}
        <div class="mt-5">
          <div class="flex items-center gap-2 mb-3">
            <span class="text-[10px] font-semibold uppercase tracking-wider text-white/25">Follow Us</span>
            <div class="flex-1 h-px bg-white/[0.08]"></div>
          </div>
          <div class="flex items-center gap-2">

            {{-- Facebook --}}
            <a href="#" aria-label="Facebook"
               class="w-8 h-8 rounded-full flex items-center justify-center bg-white/[0.07] border border-white/10 text-white/45 hover:-translate-y-1 hover:bg-accent/20 hover:text-accent-light hover:border-accent/35 transition-all duration-200">
              <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
              </svg>
            </a>

            {{-- WhatsApp --}}
            <a href="#" aria-label="WhatsApp"
               class="w-8 h-8 rounded-full flex items-center justify-center bg-white/[0.07] border border-white/10 text-white/45 hover:-translate-y-1 hover:bg-accent/20 hover:text-accent-light hover:border-accent/35 transition-all duration-200">
              <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347zM12 0C5.373 0 0 5.373 0 12c0 2.123.554 4.116 1.523 5.845L0 24l6.335-1.494A11.95 11.95 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.652-.516-5.163-1.415L3 21.5l.943-3.73A9.956 9.956 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
              </svg>
            </a>

            {{-- YouTube --}}
            <a href="#" aria-label="YouTube"
               class="w-8 h-8 rounded-full flex items-center justify-center bg-white/[0.07] border border-white/10 text-white/45 hover:-translate-y-1 hover:bg-accent/20 hover:text-accent-light hover:border-accent/35 transition-all duration-200">
              <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
              </svg>
            </a>

          <!-- Instagram -->
          <a href="https://instagram.com/stjohnsentebbe" target="_blank"
            class="text-white hover:text-accent transition-all duration-300 transform hover:scale-125"
            aria-label="Follow us on Instagram">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z" />
            </svg>
          </a>
        </div>

        <!-- Newsletter – Below Social Icons -->
        <div class="pt-4">
          


          </div>
        </div>
      </div>

    </div>{{-- /grid --}}

    {{-- Gold divider --}}
    <div class="my-6 h-px bg-gradient-to-r from-transparent via-accent/60 to-transparent"></div>

    {{-- Bottom bar --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">

      <p class="text-[11px] text-white/30 font-light">
        © {{ date('Y') }} St. John's Parish Church, Entebbe. All rights reserved.
      </p>

      <div class="flex items-center gap-1.5 text-[11px] text-white/20">
        <svg class="w-3 h-3 text-secondary/50" fill="currentColor" viewBox="0 0 24 24">
          <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
        </svg>
        <span>Crafted for the Parish Community</span>
      </div>

      <div class="flex items-center gap-3">
        <a href="#" class="text-[11px] text-white/30 hover:text-white/60 transition-colors">Privacy Policy</a>
        <span class="text-white/15">·</span>
        <a href="#" class="text-[11px] text-white/30 hover:text-white/60 transition-colors">Terms of Use</a>
      </div>

    </div>

  </div>
</footer>

<!-- Newsletter Subscription Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('newsletter-form');
    const emailInput = document.getElementById('newsletter-email');
    const submitButton = document.getElementById('newsletter-submit');
    const buttonText = document.getElementById('newsletter-button-text');
    const loadingSpinner = document.getElementById('newsletter-loading');
    const messageDiv = document.getElementById('newsletter-message');
    
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous messages
        messageDiv.classList.add('hidden');
        messageDiv.textContent = '';
        
        // Validate email
        const email = emailInput.value.trim();
        if (!email) {
            showMessage('Please enter your email address', 'error');
            return;
        }
        
        // Basic email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showMessage('Please enter a valid email address', 'error');
            return;
        }
        
        // Show loading state
        setLoadingState(true);
        
        // Get CSRF token
        const csrfToken = document.querySelector('input[name="_token"]').value;
        
        // Submit via AJAX
        fetch('/subscribe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ email: email })
        })
        .then(response => response.json())
        .then(data => {
            setLoadingState(false);
            
            if (data.success) {
                showMessage(data.message || 'Successfully subscribed to our newsletter!', 'success');
                emailInput.value = ''; // Clear the input
            } else {
                showMessage(data.message || 'Failed to subscribe. Please try again.', 'error');
            }
        })
        .catch(error => {
            setLoadingState(false);
            console.error('Newsletter subscription error:', error);
            showMessage('An error occurred. Please try again later.', 'error');
        });
    });
    
    function setLoadingState(isLoading) {
        if (isLoading) {
            submitButton.disabled = true;
            buttonText.classList.add('hidden');
            loadingSpinner.classList.remove('hidden');
        } else {
            submitButton.disabled = false;
            buttonText.classList.remove('hidden');
            loadingSpinner.classList.add('hidden');
        }
    }
    
    function showMessage(message, type) {
        messageDiv.textContent = message;
        messageDiv.classList.remove('hidden');
        
        if (type === 'success') {
            messageDiv.classList.remove('text-red-300');
            messageDiv.classList.add('text-green-300');
        } else {
            messageDiv.classList.remove('text-green-300');
            messageDiv.classList.add('text-red-300');
        }
        
        // Auto-hide success messages after 5 seconds
        if (type === 'success') {
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 5000);
        }
    }
});
</script>

<!-- My Groups Modal -->
<div id="myGroupsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl w-full max-w-lg shadow-2xl max-h-[80vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 p-4 flex items-center justify-between">
            <h3 class="text-xl font-bold text-gray-900">My Groups</h3>
            <button onclick="closeMyGroupsModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="myGroupsContent" class="p-4">
            <div class="text-center py-6">
                <svg class="w-10 h-10 text-gray-400 mx-auto mb-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <p class="text-sm text-gray-500">Loading...</p>
            </div>
        </div>
    </div>
</div>

<script>
    function showMyGroupsModal() {
        const modal = document.getElementById('myGroupsModal');
        const content = document.getElementById('myGroupsContent');
        
        if (!modal || !content) {
            console.error('Modal elements not found');
            return;
        }
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Fetch member's groups
        fetch('/api/my-groups', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            // Filter to hide rejected groups
            const userGroups = data.groups ? data.groups.filter(g => g.status !== 'rejected') : [];
            
            if (userGroups.length > 0) {
                content.innerHTML = `
                    <div class="space-y-3">
                        ${userGroups.map(group => `
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                                ${group.image_url ? 
                                    `<img src="${group.image_url}" alt="${group.name}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0">` :
                                    `<div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>`
                                }
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900 text-sm truncate">${group.name}</h4>
                                    ${group.meeting_day ? `<p class="text-xs text-gray-500">${group.meeting_day}${group.location ? ' • ' + group.location : ''}</p>` : ''}
                                </div>
                                <button onclick="leaveGroup(${group.id}, '${group.name}')" 
                                        class="px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50 rounded-lg transition flex-shrink-0"
                                        title="Leave group">
                                    Leave
                                </button>
                            </div>
                        `).join('')}
                    </div>
                `;
            } else {
                content.innerHTML = `
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="text-gray-500 font-medium">You're not in any groups yet</p>
                        <p class="text-gray-400 text-sm mt-1">Join a group to connect!</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading groups:', error);
            content.innerHTML = `
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-red-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-red-500 text-sm">Error loading groups</p>
                </div>
            `;
        });
    }
    
    function leaveGroup(groupId, groupName) {
        if (!confirm(`Are you sure you want to leave "${groupName}"?`)) {
            return;
        }
        
        fetch(`/api/groups/${groupId}/leave`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Refresh the modal
                showMyGroupsModal();
            } else {
                alert(data.message || 'Failed to leave group');
            }
        })
        .catch(error => {
            console.error('Error leaving group:', error);
            alert('Failed to leave group');
        });
    }
    
    function closeMyGroupsModal() {
        const modal = document.getElementById('myGroupsModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
    
    // Close modal when clicking outside
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('myGroupsModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeMyGroupsModal();
                }
            });
        }
    });
</script>
