<!-- Footer - 4 Columns with Social & Newsletter in Column 4 -->
<footer class="bg-primary text-white py-6">
  <div class="max-w-7xl mx-auto px-5">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 text-center md:text-left">

      <!-- Column 1: Logo + Tagline -->
      <div class="space-y-3">
        <a href="{{ route('home') }}"
          class="flex items-center justify-center md:justify-start gap-4 hover:opacity-90 transition">
          <img src="assets/Logo Final.png" alt="St. John's Parish Church Logo" class="h-14 w-auto object-contain">
          <div class="leading-tight">
            <h3 class="text-xl font-bold">St. John's Parish Church</h3>
            <p class="text-xs font-semibold text-accent uppercase tracking-widest">Entebbe</p>
          </div>
        </a>
        <p class="text-sm text-white/70 max-w-xs mx-auto md:mx-0">
          Growing in faith together as a welcoming Anglican family since 1948.
        </p>
      </div>

      <!-- Column 2: Quick Links -->
      <div>
        <h4 class="text-accent font-bold text-lg mb-3">Quick Links</h4>
        <ul class="space-y-2 text-sm">
          <li><a href="{{ route('home') }}" class="hover:text-accent transition">Home</a></li>
          <li><a href="{{ route('services') }}" class="hover:text-accent transition">Services</a></li>
          <li><a href="{{ route('updates') }}" class="hover:text-accent transition">Updates</a></li>
          <li>
            <a href="#" class="hover:text-accent transition font-medium">Give / Tithe ❤️</a>
          </li>
        </ul>
      </div>

      <!-- Column 3: Contact Info -->
      <div>
        <h4 class="text-accent font-bold text-lg mb-3">Contact Info</h4>
        <ul class="space-y-2 text-sm text-white/70">
          <li class="flex items-center justify-center md:justify-start gap-3">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
            </svg>
            Church Road, Entebbe
          </li>
          <li class="flex items-center justify-center md:justify-start gap-3">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548 1.548a8.083 8.083 0 006.208 6.208l1.548-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
            </svg>
            +256 703 558 174
          </li>
          <li class="flex items-center justify-center md:justify-start gap-3">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
              <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
            </svg>
            info@stjohnsentebbe.org
          </li>
        </ul>
        <a href="{{ route('login') }}"
          class="mt-6 inline-block px-6 py-2.5 bg-secondary text-white font-bold rounded-full hover:bg-secondary/90 transition text-sm">
          Admin Portal
        </a>
      </div>

      <!-- Column 4: Stay Connected – Social Media + Newsletter -->
      <div class="space-y-3">
        <h4 class="text-accent font-bold text-lg text-center md:text-left">Stay Connected</h4>
        
        <!-- Social Media Icons Row -->
        <div class="flex justify-center md:justify-start gap-6">
          <!-- Facebook -->
          <a href="https://facebook.com/StJohnsEntebbe" target="_blank"
            class="text-white hover:text-accent transition-all duration-300 transform hover:scale-125"
            aria-label="Follow us on Facebook">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
              <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
            </svg>
          </a>

          <!-- YouTube -->
          <a href="https://youtube.com/@StJohnsEntebbe" target="_blank"
            class="text-white hover:text-accent transition-all duration-300 transform hover:scale-125"
            aria-label="Subscribe on YouTube">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
              <path d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.506 2.506 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.418-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15.194V8.806L15.194 12Z" />
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
          <p class="text-xs text-white/80 mb-3">Receive weekly updates & sermons</p>
          <form class="flex flex-col gap-2">
            <input type="email" placeholder="Your email address" required
              class="px-4 py-2 rounded-lg text-primary placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent transition text-sm">
            <button type="submit"
              class="px-4 py-2 bg-accent text-primary font-bold rounded-lg hover:bg-accent/90 transition shadow-md text-sm">
              Subscribe
            </button>
          </form>
        </div>
      </div>

    </div>

    <!-- Bottom Bar – Auto-updating year -->
    <div class="border-t border-white/10 mt-6 pt-3 text-sm text-white/60 flex flex-col md:flex-row justify-between items-center">
      <span>
        © {{ now()->year }} St. John's Parish Church Entebbe. All Rights Reserved.
      </span>
      <span class="mt-2 md:mt-0">Made with ❤️ in Uganda</span>
    </div>
  </div>
</footer>

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
