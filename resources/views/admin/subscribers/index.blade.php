@extends('layouts.dashboard_layout')

@section('title', 'Newsletter Subscribers')
@section('header_title', 'Newsletter Subscribers')

@section('content')
<div class="space-y-6">
    <!-- Summary Metrics -->
    <div class="bg-white dark:bg-background-dark rounded-2xl shadow-md border border-primary/30 dark:border-primary/40 hover:border-primary/50 transition-all duration-300 p-4 lg:p-5 mb-8 lg:mb-10 overflow-hidden">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6">
            <!-- Total Subscribers -->
            <div class="group relative bg-white/90 dark:bg-background-dark/90 rounded-xl border border-gray-200/70 dark:border-gray-700 p-4 lg:p-5 hover:border-accent/40 hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                <div class="flex items-center gap-3.5">
                    <div class="p-3 bg-primary/10 dark:bg-primary/20 rounded-lg group-hover:bg-primary/20 transition-colors">
                        <svg class="h-6 w-6 lg:h-7 lg:w-7 text-primary dark:text-text-dark group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">Total Subscribers</p>
                        <p class="text-3xl lg:text-4xl font-black text-primary dark:text-text-dark mt-0.5">{{ $subscriberCount ?? 0 }}</p>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-text-muted-dark mt-2.5">Active newsletter subscribers</p>
            </div>

            <!-- Member Subscribers -->
            <div class="group relative bg-white/90 dark:bg-background-dark/90 rounded-xl border border-gray-200/70 dark:border-gray-700 p-4 lg:p-5 hover:border-accent/40 hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                <div class="flex items-center gap-3.5">
                    <div class="p-3 bg-accent/10 dark:bg-accent/20 rounded-lg group-hover:bg-accent/20 transition-colors">
                        <svg class="h-6 w-6 lg:h-7 lg:w-7 text-accent group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">Members</p>
                        <p class="text-3xl lg:text-4xl font-black text-accent mt-0.5">{{ $memberCount ?? 0 }}</p>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-text-muted-dark mt-2.5">Registered members</p>
            </div>

            <!-- Visitor Subscribers -->
            <div class="group relative bg-white/90 dark:bg-background-dark/90 rounded-xl border border-gray-200/70 dark:border-gray-700 p-4 lg:p-5 hover:border-accent/40 hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                <div class="flex items-center gap-3.5">
                    <div class="p-3 bg-secondary/10 dark:bg-secondary/20 rounded-lg group-hover:bg-secondary/20 transition-colors">
                        <svg class="h-6 w-6 lg:h-7 lg:w-7 text-secondary group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">Visitors</p>
                        <p class="text-3xl lg:text-4xl font-black text-secondary mt-0.5">{{ $visitorCount ?? 0 }}</p>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-text-muted-dark mt-2.5">Non-member subscribers</p>
            </div>
        </div>
    </div>

    <!-- Search & Actions -->
    <div class="bg-white dark:bg-background-dark rounded-xl shadow-sm border border-gray-200/60 dark:border-gray-700 p-4 lg:p-5 mb-6 lg:mb-8">
        <h2 class="text-base lg:text-lg font-semibold text-primary dark:text-text-dark mb-3.5 flex items-center gap-2">
            <svg class="h-5 w-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            Search & Actions
        </h2>

        <form method="GET" action="{{ route('admin.subscribers.index') }}" class="space-y-3">
            <!-- Main Search -->
            <div class="flex flex-col md:flex-row gap-3">
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        id="search" 
                        value="{{ request('search') }}"
                        placeholder="Search by email..." 
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-background-dark text-sm transition-all duration-200 focus:border-primary focus:ring-2 focus:ring-primary/20 hover:border-gray-400 dark:hover:border-gray-500"
                    />
                </div>
                <button type="submit"
                        class="bg-primary hover:bg-secondary text-white px-6 py-2 rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-primary/30 text-sm flex items-center justify-center gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Search
                </button>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3">
                <button type="button" id="addSubscriberBtn"
                        class="bg-secondary hover:bg-accent text-white px-5 py-2.5 rounded-xl font-medium transition-all duration-300 shadow-sm hover:shadow flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-accent/30 text-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Subscriber
                </button>

                <a href="{{ route('admin.subscribers.export') }}"
                   class="bg-accent hover:bg-secondary text-primary hover:text-white px-5 py-2.5 rounded-xl font-medium transition-all duration-300 shadow-sm hover:shadow flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-accent/30 text-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export CSV
                </a>

                @if(request('search'))
                    <a href="{{ route('admin.subscribers.index') }}"
                       class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-text-muted-dark px-5 py-2.5 rounded-xl font-medium transition-all duration-300 shadow-sm hover:shadow flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-accent/30 text-sm">
                        Clear Search
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Subscribers Table -->
    <div class="bg-white dark:bg-background-dark rounded-2xl shadow-md border border-primary/30 dark:border-primary/40 overflow-hidden">
        <!-- Table Header -->
        <div class="px-5 py-3.5 border-b border-gray-200/80 dark:border-gray-700/80 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-lg lg:text-xl font-bold text-primary dark:text-text-dark flex items-center gap-3">
                <svg class="h-6 w-6 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Subscribers List
                @if(isset($paginationData) && request('search'))
                    <span class="text-sm font-medium text-gray-500 dark:text-text-muted-dark">({{ $paginationData['total'] }} filtered)</span>
                @elseif(isset($paginationData))
                    <span class="text-sm font-medium text-gray-500 dark:text-text-muted-dark">({{ $paginationData['total'] }} total)</span>
                @else
                    <span class="text-sm font-medium text-gray-500 dark:text-text-muted-dark">(0 total)</span>
                @endif
            </h2>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200/60 dark:divide-gray-700/50">
                <thead class="bg-gray-50/80 dark:bg-gray-800/40 border-b border-primary/30 dark:border-primary/40">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-primary dark:text-text-muted-dark uppercase tracking-wider border-r border-gray-200/50 dark:border-gray-700/40">
                            Email
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-primary dark:text-text-muted-dark uppercase tracking-wider border-r border-gray-200/50 dark:border-gray-700/40">
                            Type
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-primary dark:text-text-muted-dark uppercase tracking-wider border-r border-gray-200/50 dark:border-gray-700/40">
                            Status
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-primary dark:text-text-muted-dark uppercase tracking-wider border-r border-gray-200/50 dark:border-gray-700/40">
                            Subscribed Date
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-primary dark:text-text-muted-dark uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/70 dark:divide-gray-700/50">
                    @if($subscribers && count($subscribers) > 0)
                        @foreach($subscribers as $subscriber)
                            <tr class="group hover:bg-primary/5 dark:hover:bg-primary/10 hover:shadow-sm hover:-translate-y-[1px] transition-all duration-200">
                                <td class="px-5 py-3.5 whitespace-nowrap border-r border-gray-100/50 dark:border-gray-700/40">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-9 w-9">
                                            <div class="h-9 w-9 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center ring-1 ring-accent/30">
                                                <span class="text-xs font-medium text-primary dark:text-text-dark">
                                                    {{ strtoupper(substr($subscriber['email'] ?? 'U', 0, 1)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-text-dark group-hover:text-primary transition-colors">
                                                {{ $subscriber['email'] ?? 'N/A' }}
                                            </div>
                                            @if(isset($subscriber['fields']['name']) && !empty($subscriber['fields']['name']))
                                                <div class="text-xs text-gray-500 dark:text-text-muted-dark">
                                                    {{ $subscriber['fields']['name'] }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-sm border-r border-gray-100/50 dark:border-gray-700/40">
                                    @if(isset($subscriber['fields']['member_status']) && $subscriber['fields']['member_status'] === 'member')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300">
                                            Member
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-text-muted-dark">
                                            Visitor
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap border-r border-gray-100/50 dark:border-gray-700/40">
                                    @if(isset($subscriber['status']) && $subscriber['status'] === 'active')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300">
                                            Active
                                        </span>
                                    @elseif(isset($subscriber['type']) && $subscriber['type'] === 'active')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300">
                                            Active
                                        </span>
                                    @elseif(isset($subscriber['status']))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-text-muted-dark">
                                            {{ ucfirst($subscriber['status']) }}
                                        </span>
                                    @elseif(isset($subscriber['type']))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-text-muted-dark">
                                            {{ ucfirst($subscriber['type']) }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300">
                                            Active
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-sm text-gray-500 dark:text-text-muted-dark border-r border-gray-100/50 dark:border-gray-700/40">
                                    {{ isset($subscriber['date_subscribe']) ? \Carbon\Carbon::parse($subscriber['date_subscribe'])->format('M d, Y') : (isset($subscriber['date_created']) ? \Carbon\Carbon::parse($subscriber['date_created'])->format('M d, Y') : 'N/A') }}
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-sm font-medium">
                                    <form method="POST" action="{{ route('admin.subscribers.destroy', $subscriber['email'] ?? '') }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 hover:bg-red-100 dark:hover:bg-red-800/50 rounded-lg transition duration-200 text-xs flex items-center gap-1 border border-red-200/50 dark:border-red-700/40 hover:border-red-300 dark:hover:border-red-600/60"
                                                onclick="return confirm('Are you sure you want to remove this subscriber?')"
                                                {{ empty($subscriber['email']) ? 'disabled' : '' }}>
                                            🗑 Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-text-muted-dark text-sm">
                                @if(request('search'))
                                    No subscribers match your search. 
                                    <a href="{{ route('admin.subscribers.index') }}" class="text-primary hover:underline font-medium">Clear search</a>
                                @else
                                    No subscribers yet. 
                                    <button onclick="document.getElementById('addSubscriberBtn').click()" 
                                            class="text-primary hover:underline font-medium">
                                        Add the first subscriber
                                    </button>!
                                @endif
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($paginationData) && $paginationData['last_page'] > 1)
            <div class="px-5 py-3.5 border-t border-gray-200/80 dark:border-gray-700/80">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700 dark:text-text-muted-dark">
                        Showing <span class="font-medium">{{ $paginationData['from'] }}</span> to <span class="font-medium">{{ $paginationData['to'] }}</span> of <span class="font-medium">{{ $paginationData['total'] }}</span> results
                    </div>
                    <div class="flex gap-2">
                        @if($paginationData['current_page'] > 1)
                            <a href="{{ request()->fullUrlWithQuery(['page' => $paginationData['current_page'] - 1]) }}" 
                               class="px-3 py-2 text-sm font-medium text-gray-700 dark:text-text-muted-dark bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                                Previous
                            </a>
                        @endif
                        
                        @for($i = 1; $i <= $paginationData['last_page']; $i++)
                            @if($i == $paginationData['current_page'])
                                <span class="px-3 py-2 text-sm font-medium text-white bg-primary border border-primary rounded-md">
                                    {{ $i }}
                                </span>
                            @elseif($i == 1 || $i == $paginationData['last_page'] || abs($i - $paginationData['current_page']) <= 2)
                                <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}" 
                                   class="px-3 py-2 text-sm font-medium text-gray-700 dark:text-text-muted-dark bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                                    {{ $i }}
                                </a>
                            @elseif($i == 2 || $i == $paginationData['last_page'] - 1)
                                <span class="px-3 py-2 text-sm font-medium text-gray-700 dark:text-text-muted-dark">...</span>
                            @endif
                        @endfor
                        
                        @if($paginationData['current_page'] < $paginationData['last_page'])
                            <a href="{{ request()->fullUrlWithQuery(['page' => $paginationData['current_page'] + 1]) }}" 
                               class="px-3 py-2 text-sm font-medium text-gray-700 dark:text-text-muted-dark bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">
                                Next
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Add Subscriber Modal -->
<div id="addSubscriberModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-background-dark rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-text-dark">Add Subscriber</h3>
                <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form method="POST" action="{{ route('admin.subscribers.store') }}">
                @csrf
                <div class="p-6 space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-text-muted-dark mb-1">
                            Email Address *
                        </label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary bg-white dark:bg-background-dark text-gray-900 dark:text-text-dark"
                               placeholder="subscriber@example.com">
                    </div>
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-text-muted-dark mb-1">
                            Name (optional)
                        </label>
                        <input type="text" id="name" name="name"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-primary bg-white dark:bg-background-dark text-gray-900 dark:text-text-dark"
                               placeholder="John Doe">
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-end space-x-3">
                    <button type="button" onclick="closeAddModal()" 
                            class="px-4 py-2 text-gray-600 dark:text-text-muted-dark hover:text-gray-800 dark:hover:text-text-dark">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-primary hover:bg-secondary text-white rounded-md transition-colors">
                        Add Subscriber
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Add Subscriber Modal
    const addSubscriberBtn = document.getElementById('addSubscriberBtn');
    const addSubscriberModal = document.getElementById('addSubscriberModal');

    addSubscriberBtn.addEventListener('click', () => {
        addSubscriberModal.classList.remove('hidden');
    });

    function closeAddModal() {
        addSubscriberModal.classList.add('hidden');
        document.getElementById('email').value = '';
        document.getElementById('name').value = '';
    }

    // Close modal on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !addSubscriberModal.classList.contains('hidden')) {
            closeAddModal();
        }
    });

    // Close modal on background click
    addSubscriberModal.addEventListener('click', (e) => {
        if (e.target === addSubscriberModal) {
            closeAddModal();
        }
    });
</script>
@endsection
