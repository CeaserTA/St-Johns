@extends('layouts.dashboard_layout')

@section('title', 'Members Management')
@section('header_title', 'Members Management')

@section('content')
    <div class="space-y-6">
        <!-- Error Message Display -->
        @if(isset($error))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Error:</strong> {{ $error }}
            </div>
        @endif

        <!-- Members Dashboard – Summary Cards (First Section) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8 mb-10 lg:mb-12">
            <!-- Total Members -->
            <div class="group bg-white dark:bg-background-dark rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100/80 dark:border-gray-700 hover:border-accent/30 dark:hover:border-accent/50 hover:-translate-y-1">
                <div class="p-6 lg:p-8">
                    <div class="flex items-center gap-5 mb-6">
                        <div class="p-4 bg-primary/10 dark:bg-primary/20 rounded-xl group-hover:bg-primary/20 dark:group-hover:bg-primary/30 transition-colors">
                            <svg class="h-8 w-8 text-primary dark:text-text-dark" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">Total Members</p>
                            <p class="text-4xl lg:text-5xl font-black text-primary dark:text-text-dark mt-1">{{ $stats['total_members'] ?? 0 }}</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-text-muted-dark">All registered members</p>
                </div>
            </div>

            <!-- Active Members -->
            <div class="group bg-white dark:bg-background-dark rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100/80 dark:border-gray-700 hover:border-accent/30 dark:hover:border-accent/50 hover:-translate-y-1">
                <div class="p-6 lg:p-8">
                    <div class="flex items-center gap-5 mb-6">
                        <div class="p-4 bg-accent/10 dark:bg-accent/20 rounded-xl group-hover:bg-accent/20 dark:group-hover:bg-accent/30 transition-colors">
                            <svg class="h-8 w-8 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">Active Members</p>
                            <p class="text-4xl lg:text-5xl font-black text-accent mt-1">{{ $stats['active_members'] ?? 0 }}</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-text-muted-dark">Currently engaged</p>
                </div>
            </div>

            <!-- New This Month -->
            <div class="group bg-white dark:bg-background-dark rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100/80 dark:border-gray-700 hover:border-secondary/30 dark:hover:border-secondary/50 hover:-translate-y-1">
                <div class="p-6 lg:p-8">
                    <div class="flex items-center gap-5 mb-6">
                        <div class="p-4 bg-secondary/10 dark:bg-secondary/20 rounded-xl group-hover:bg-secondary/20 dark:group-hover:bg-secondary/30 transition-colors">
                            <svg class="h-8 w-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">New This Month</p>
                            <p class="text-4xl lg:text-5xl font-black text-secondary mt-1">{{ $stats['new_this_month'] ?? 0 }}</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-text-muted-dark">Recent additions</p>
                </div>
            </div>

            <!-- Average Age -->
            <div class="group bg-white dark:bg-background-dark rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100/80 dark:border-gray-700 hover:border-accent/30 dark:hover:border-accent/50 hover:-translate-y-1">
                <div class="p-6 lg:p-8">
                    <div class="flex items-center gap-5 mb-6">
                        <div class="p-4 bg-accent/10 dark:bg-accent/20 rounded-xl group-hover:bg-accent/20 dark:group-hover:bg-accent/30 transition-colors">
                            <svg class="h-8 w-8 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a2 2 0 100-4 2 2 0 000 4zm0 0v3m-3-3h6m-6 0H3m15 0h3" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-text-muted-dark uppercase tracking-wide">Average Age</p>
                            <p class="text-4xl lg:text-5xl font-black text-accent mt-1">{{ $stats['average_age'] ? round($stats['average_age']) : 'N/A' }}</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-text-muted-dark">Across all members</p>
                </div>
            </div>
        </div>

        <!-- Search & Filters – Compact & Intuitive -->
        <div class="bg-white dark:bg-background-dark rounded-xl shadow p-5 lg:p-6 mb-8 lg:mb-10 border border-gray-100/80 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-primary dark:text-text-dark mb-4">Search & Filter</h2>

            <form method="GET" action="{{ route('admin.members') }}" class="space-y-4">
                <!-- Main Search -->
                <div class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="search" 
                            id="search" 
                            value="{{ request('search') }}"
                            placeholder="Name, email, phone..." 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 focus:border-accent focus:ring-2 focus:ring-accent/30 bg-white dark:bg-background-dark text-sm transition-all duration-200"
                        />
                    </div>
                    <button type="submit"
                            class="bg-accent hover:bg-secondary text-primary hover:text-white px-6 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow">
                        Search
                    </button>
                </div>

                <!-- Filters – Tighter Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                    <!-- Gender -->
                    <select name="gender" id="gender"
                            class="px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 focus:border-accent focus:ring-2 focus:ring-accent/30 bg-white dark:bg-background-dark text-sm transition-all duration-200">
                        <option value="all">Gender</option>
                        @foreach($filterOptions['genders'] as $gender)
                            <option value="{{ $gender }}" {{ request('gender') == $gender ? 'selected' : '' }}>
                                {{ ucfirst($gender) }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Marital Status -->
                    <select name="marital_status" id="marital_status"
                            class="px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 focus:border-accent focus:ring-2 focus:ring-accent/30 bg-white dark:bg-background-dark text-sm transition-all duration-200">
                        <option value="all">Marital</option>
                        @foreach($filterOptions['marital_statuses'] as $status)
                            <option value="{{ $status }}" {{ request('marital_status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Cell -->
                    <select name="cell" id="cell"
                            class="px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 focus:border-accent focus:ring-2 focus:ring-accent/30 bg-white dark:bg-background-dark text-sm transition-all duration-200">
                        <option value="all">Cell</option>
                        @foreach($filterOptions['cells'] as $cellName)
                            <option value="{{ $cellName }}" {{ request('cell') == $cellName ? 'selected' : '' }}>
                                {{ ucfirst($cellName) }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Age Range -->
                    <select name="age_range" id="age_range"
                            class="px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 focus:border-accent focus:ring-2 focus:ring-accent/30 bg-white dark:bg-background-dark text-sm transition-all duration-200">
                        <option value="all">Age</option>
                        <option value="under_18" {{ request('age_range') == 'under_18' ? 'selected' : '' }}>Under 18</option>
                        <option value="18_30" {{ request('age_range') == '18_30' ? 'selected' : '' }}>18–30</option>
                        <option value="31_50" {{ request('age_range') == '31_50' ? 'selected' : '' }}>31–50</option>
                        <option value="over_50" {{ request('age_range') == 'over_50' ? 'selected' : '' }}>Over 50</option>
                    </select>

                    <!-- Joined Period -->
                    <select name="joined_period" id="joined_period"
                            class="px-3 py-2.5 rounded-lg border border-gray-200 dark:border-gray-600 focus:border-accent focus:ring-2 focus:ring-accent/30 bg-white dark:bg-background-dark text-sm transition-all duration-200">
                        <option value="all">Joined</option>
                        <option value="this_month" {{ request('joined_period') == 'this_month' ? 'selected' : '' }}>This Month</option>
                        <option value="this_year" {{ request('joined_period') == 'this_year' ? 'selected' : '' }}>This Year</option>
                        <option value="last_year" {{ request('joined_period') == 'last_year' ? 'selected' : '' }}>Last Year</option>
                    </select>

                    <!-- Clear -->
                    <div class="flex items-end">
                        <a href="{{ route('admin.members') }}"
                        class="w-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-text-muted-dark px-4 py-2.5 rounded-lg text-center text-sm transition-all duration-200">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

<!-- Members Table – Clean, Modern & Intuitive -->
<div class="bg-white dark:bg-background-dark rounded-2xl shadow-lg border border-gray-100/80 dark:border-gray-700 overflow-hidden">
    <!-- Table Header -->
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-xl font-bold text-primary dark:text-text-dark flex items-center gap-3">
            <span class="text-accent text-2xl">👥</span>
            Members List
            @if($members && request()->hasAny(['search', 'gender', 'marital_status', 'cell', 'age_range', 'joined_period']))
                <span class="text-sm font-medium text-gray-500 dark:text-text-muted-dark">({{ $members->total() }} filtered)</span>
            @elseif($members)
                <span class="text-sm font-medium text-gray-500 dark:text-text-muted-dark">({{ $members->total() }} total)</span>
            @else
                <span class="text-sm font-medium text-gray-500 dark:text-text-muted-dark">(0 total)</span>
            @endif
        </h2>

        <button id="addMemberBtn"
                class="bg-secondary hover:bg-accent text-white px-5 py-2.5 rounded-xl font-medium transition-all duration-300 shadow-md hover:shadow-lg flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-accent/30">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Member
        </button>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800/50">
                <tr>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 dark:text-text-muted-dark uppercase tracking-wider">
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'full_name', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}"
                           class="flex items-center hover:text-accent transition-colors">
                            Full Name
                            @if(request('sort_by') == 'full_name')
                                <svg class="ml-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    @if(request('sort_order') == 'asc')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    @endif
                                </svg>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 dark:text-text-muted-dark uppercase tracking-wider">Contact</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 dark:text-text-muted-dark uppercase tracking-wider">Personal Info</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 dark:text-text-muted-dark uppercase tracking-wider">Address</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 dark:text-text-muted-dark uppercase tracking-wider">Church Info</th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 dark:text-text-muted-dark uppercase tracking-wider">
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'date_joined', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}"
                           class="flex items-center hover:text-accent transition-colors">
                            Joined
                            @if(request('sort_by') == 'date_joined')
                                <svg class="ml-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    @if(request('sort_order') == 'asc')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    @endif
                                </svg>
                            @endif
                        </a>
                    </th>
                    <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-600 dark:text-text-muted-dark uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-background-dark divide-y divide-gray-200 dark:divide-gray-700">
                @if($members && $members->count() > 0)
                    @foreach($members as $member)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($member->hasProfileImage())
                                            <img class="h-10 w-10 rounded-full object-cover ring-2 ring-accent/30" 
                                                 src="{{ $member->profile_image_url }}" 
                                                 alt="{{ $member->full_name }}"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center ring-2 ring-accent/30" style="display:none;">
                                                <span class="text-sm font-medium text-primary dark:text-text-dark">
                                                    {{ $member->full_name ? substr($member->full_name, 0, 1) : '?' }}
                                                </span>
                                            </div>
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center ring-2 ring-accent/30">
                                                <span class="text-sm font-medium text-primary dark:text-text-dark">
                                                    {{ $member->full_name ? substr($member->full_name, 0, 1) : '?' }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-text-dark">{{ $member->full_name ?? 'N/A' }}</div>
                                        @if($member->user)
                                            <span class="text-xs text-green-600 dark:text-green-400">Has Account</span>
                                        @else
                                            <span class="text-xs text-gray-500 dark:text-text-muted-dark">No Account</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-text-dark">
                                <div>{{ $member->phone ?: 'N/A' }}</div>
                                <div class="text-gray-500 dark:text-text-muted-dark">{{ $member->email ?: 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-text-dark">
                                <div>{{ $member->gender ? ucfirst($member->gender) : 'N/A' }}</div>
                                <div class="text-gray-500 dark:text-text-muted-dark">
                                    {{ $member->marital_status ? ucfirst($member->marital_status) : 'N/A' }}
                                </div>
                                @if($member->date_of_birth)
                                    <div class="text-xs text-gray-500 dark:text-text-muted-dark">
                                        DOB: {{ \Carbon\Carbon::parse($member->date_of_birth)->format('M d, Y') }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-text-dark">
                                <div class="max-w-xs truncate">{{ $member->address ?: 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-text-dark">
                                <div>Cell: {{ $member->cell ? ucfirst($member->cell) : 'N/A' }}</div>
                                <div class="text-gray-500 dark:text-text-muted-dark">Groups: 0</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-text-muted-dark">
                                {{ $member->formatted_date_joined }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex flex-wrap gap-2">
                                    <button onclick="viewMemberDetails({{ $member->id }})"
                                            class="px-3 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-800/50 rounded-lg transition duration-200 text-xs">
                                        👁 View
                                    </button>
                                    <button onclick="openEditMemberModal({{ $member->id }})"
                                            class="px-3 py-1.5 bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300 hover:bg-yellow-100 dark:hover:bg-yellow-800/50 rounded-lg transition duration-200 text-xs">
                                        ✏️ Edit
                                    </button>
                                    <form method="POST" action="{{ route('members.destroy', $member->id) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 hover:bg-red-100 dark:hover:bg-red-800/50 rounded-lg transition duration-200 text-xs"
                                                onclick="return confirm('Are you sure you want to delete this member?')">
                                            🗑 Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-text-muted-dark">
                            @if(request()->hasAny(['search', 'gender', 'marital_status', 'cell', 'age_range', 'joined_period']))
                                No members match your filters. 
                                <a href="{{ route('admin.members') }}" class="text-accent hover:underline font-medium">Clear filters</a>
                            @else
                                No members registered yet. 
                                <button onclick="document.getElementById('addMemberBtn').click()" 
                                        class="text-accent hover:underline font-medium">
                                    Add the first member
                                </button>!
                            @endif
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($members && $members->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex justify-center">
            {{ $members->links('pagination::tailwind') }}
        </div>
    @endif
</div>

    </div>

    <!-- Member Details Modal -->
    <div id="member-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full modal-enter">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Member Details</h3>
                    <button onclick="closeMemberModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div id="member-modal-content" class="member-modal-content p-6">
                    <div class="flex justify-center items-center py-8">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                        <span class="ml-2 text-gray-600">Loading member details...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Lightbox Modal -->
    <div id="image-lightbox" class="fixed inset-0 bg-black bg-opacity-90 hidden z-60 flex items-center justify-center">
        <div class="relative max-w-4xl max-h-full p-4">
            <!-- Close button -->
            <button onclick="closeImageLightbox()"
                class="absolute top-2 right-2 text-white hover:text-gray-300 transition-colors z-10 bg-black bg-opacity-50 rounded-full p-2">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Image container -->
            <div class="bg-white rounded-lg p-4 shadow-2xl">
                <div class="text-center mb-4">
                    <h3 id="lightbox-title" class="text-lg font-semibold text-gray-900"></h3>
                </div>
                <img id="lightbox-image" src="" alt="" class="max-w-full max-h-96 mx-auto rounded-lg shadow-lg">
                <div class="mt-4 text-center">
                    <button onclick="closeImageLightbox()"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm">
                        Close
                    </button>
                    <button onclick="downloadImage()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm ml-2">
                        Download Image
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Member Modal -->
    <div id="add-member-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full modal-enter">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Add New Member</h3>
                    <button onclick="closeAddMemberModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 max-h-96 overflow-y-auto">
                    <!-- Add Member Form -->
                    <form id="add-member-form" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Full Name -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-medium mb-1">Full Name *</label>
                                <input type="text" name="fullname" required
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="text-red-500 text-sm mt-1 hidden" id="error-fullname"></div>
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Date of Birth *</label>
                                <input type="date" name="dateOfBirth" required
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="text-red-500 text-sm mt-1 hidden" id="error-dateOfBirth"></div>
                            </div>

                            <!-- Gender -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Gender *</label>
                                <select name="gender" required
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Select Gender --</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <div class="text-red-500 text-sm mt-1 hidden" id="error-gender"></div>
                            </div>

                            <!-- Marital Status -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Marital Status *</label>
                                <select name="maritalStatus" required
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Select Status --</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="widowed">Widowed</option>
                                </select>
                                <div class="text-red-500 text-sm mt-1 hidden" id="error-maritalStatus"></div>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Phone</label>
                                <input type="text" name="phone" placeholder="+256700000000"
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="text-red-500 text-sm mt-1 hidden" id="error-phone"></div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Email</label>
                                <input type="email" name="email" placeholder="member@example.com"
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="text-red-500 text-sm mt-1 hidden" id="error-email"></div>
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-medium mb-1">Address</label>
                                <input type="text" name="address" placeholder="Enter full address"
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="text-red-500 text-sm mt-1 hidden" id="error-address"></div>
                            </div>

                            <!-- Date Joined -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Date Joined *</label>
                                <input type="date" name="dateJoined" value="{{ date('Y-m-d') }}" required
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="text-red-500 text-sm mt-1 hidden" id="error-dateJoined"></div>
                            </div>

                            <!-- Cell -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Cell (Zone) *</label>
                                <select name="cell" required
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Select Cell --</option>
                                    <option value="north">North</option>
                                    <option value="east">East</option>
                                    <option value="south">South</option>
                                    <option value="west">West</option>
                                </select>
                                <div class="text-red-500 text-sm mt-1 hidden" id="error-cell"></div>
                            </div>

                            <!-- Profile Image -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-medium mb-1">Profile Image</label>
                                <input type="file" name="profileImage" accept="image/*" id="modalProfileImageInput"
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Supported formats: JPEG, PNG, JPG, GIF. Max size: 5MB
                                </p>

                                <!-- Image Preview -->
                                <div id="modalImagePreview" class="mt-3 hidden">
                                    <p class="text-sm text-gray-600 mb-2">Preview:</p>
                                    <img id="modalPreviewImg" src="" alt="Preview"
                                        class="h-20 w-20 rounded-lg object-cover border-2 border-gray-300">
                                </div>

                                <div class="text-red-500 text-sm mt-1 hidden" id="error-profileImage"></div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-6 flex justify-end space-x-3 pt-4 border-t">
                            <button type="button" onclick="closeAddMemberModal()"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm">
                                Cancel
                            </button>
                            <button type="submit" id="submitMemberBtn"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm">
                                <span id="submitBtnText">Add Member</span>
                                <svg id="submitBtnSpinner" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white hidden"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Member Modal -->
    <div id="edit-member-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full modal-enter">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Edit Member</h3>
                    <button onclick="closeEditMemberModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="p-6 max-h-96 overflow-y-auto">
                    <!-- Edit Member Form -->
                    <form id="edit-member-form" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" id="edit-member-id" name="member_id">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Full Name -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-medium mb-1">Full Name *</label>
                                <input type="text" name="fullname" id="edit-fullname" required
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="text-red-500 text-sm mt-1 hidden" id="edit-error-fullname"></div>
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Date of Birth *</label>
                                <input type="date" name="dateOfBirth" id="edit-dateOfBirth" required
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="text-red-500 text-sm mt-1 hidden" id="edit-error-dateOfBirth"></div>
                            </div>

                            <!-- Gender -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Gender *</label>
                                <select name="gender" id="edit-gender" required
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Select Gender --</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <div class="text-red-500 text-sm mt-1 hidden" id="edit-error-gender"></div>
                            </div>

                            <!-- Marital Status -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Marital Status *</label>
                                <select name="maritalStatus" id="edit-maritalStatus" required
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Select Status --</option>
                                    <option value="single">Single</option>
                                    <option value="married">Married</option>
                                    <option value="divorced">Divorced</option>
                                    <option value="widowed">Widowed</option>
                                </select>
                                <div class="text-red-500 text-sm mt-1 hidden" id="edit-error-maritalStatus"></div>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Phone</label>
                                <input type="text" name="phone" id="edit-phone" placeholder="+256700000000"
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="text-red-500 text-sm mt-1 hidden" id="edit-error-phone"></div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Email</label>
                                <input type="email" name="email" id="edit-email" placeholder="member@example.com"
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="text-red-500 text-sm mt-1 hidden" id="edit-error-email"></div>
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-medium mb-1">Address</label>
                                <input type="text" name="address" id="edit-address" placeholder="Enter full address"
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="text-red-500 text-sm mt-1 hidden" id="edit-error-address"></div>
                            </div>

                            <!-- Date Joined -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Date Joined *</label>
                                <input type="date" name="dateJoined" id="edit-dateJoined" required
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <div class="text-red-500 text-sm mt-1 hidden" id="edit-error-dateJoined"></div>
                            </div>

                            <!-- Cell -->
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Cell (Zone) *</label>
                                <select name="cell" id="edit-cell" required
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">-- Select Cell --</option>
                                    <option value="north">North</option>
                                    <option value="east">East</option>
                                    <option value="south">South</option>
                                    <option value="west">West</option>
                                </select>
                                <div class="text-red-500 text-sm mt-1 hidden" id="edit-error-cell"></div>
                            </div>

                            <!-- Current Profile Image -->
                            <div class="md:col-span-2" id="edit-current-image-container">
                                <label class="block text-gray-700 font-medium mb-1">Current Profile Image</label>
                                <img id="edit-current-image" src="" alt="Current profile"
                                    class="h-20 w-20 rounded-lg object-cover border-2 border-gray-300">
                            </div>

                            <!-- Profile Image -->
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-medium mb-1">Change Profile Image</label>
                                <input type="file" name="profileImage" accept="image/*" id="editModalProfileImageInput"
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Supported formats: JPEG, PNG, JPG, GIF. Max size: 5MB
                                </p>

                                <!-- Image Preview -->
                                <div id="editModalImagePreview" class="mt-3 hidden">
                                    <p class="text-sm text-gray-600 mb-2">New Image Preview:</p>
                                    <img id="editModalPreviewImg" src="" alt="Preview"
                                        class="h-20 w-20 rounded-lg object-cover border-2 border-gray-300">
                                </div>

                                <div class="text-red-500 text-sm mt-1 hidden" id="edit-error-profileImage"></div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-6 flex justify-end space-x-3 pt-4 border-t">
                            <button type="button" onclick="closeEditMemberModal()"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm">
                                Cancel
                            </button>
                            <button type="submit" id="submitEditMemberBtn"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm">
                                <span id="submitEditBtnText">Update Member</span>
                                <svg id="submitEditBtnSpinner" class="animate-spin -ml-1 mr-3 h-4 w-4 text-white hidden"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom styles for the member details modal */
        .member-modal-content {
            max-height: 80vh;
            overflow-y: auto;
        }

        .member-modal-content::-webkit-scrollbar {
            width: 6px;
        }

        .member-modal-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .member-modal-content::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .member-modal-content::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Animation for modal */
        .modal-enter {
            animation: modalEnter 0.3s ease-out;
        }

        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Image lightbox styles */
        #image-lightbox {
            z-index: 9999;
        }

        #image-lightbox img {
            max-height: 70vh;
            max-width: 90vw;
            object-fit: contain;
        }

        /* Hover effects for image container */
        .group:hover .group-hover\:bg-opacity-30 {
            background-opacity: 0.3;
        }

        .group:hover .group-hover\:opacity-100 {
            opacity: 1;
        }
    </style>

    <script>
        function viewMemberDetails(memberId) {
            // Show modal with loading state
            document.getElementById('member-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            document.getElementById('member-modal-content').innerHTML = `
            <div class="flex justify-center items-center py-8">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <span class="ml-2 text-gray-600">Loading member details...</span>
            </div>
        `;

            // Fetch detailed member information
            fetch(`/admin/members/${memberId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        displayMemberDetails(data);
                    } else {
                        throw new Error(data.message || 'Failed to load member details');
                    }
                })
                .catch(error => {
                    console.error('Error loading member details:', error);
                    document.getElementById('member-modal-content').innerHTML = `
                <div class="text-center py-8">
                    <div class="text-red-600 mb-4">
                        <svg class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 19.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Error Loading Details</h3>
                    <p class="text-gray-600 mb-4">${error.message}</p>
                    <div class="space-x-3">
                        <button onclick="viewMemberDetails(${memberId})" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                            Try Again
                        </button>
                        <button onclick="closeMemberModal()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                            Close
                        </button>
                    </div>
                </div>
            `;
                });
        }

        function displayMemberDetails(data) {
            const member = data.member;
            const stats = data.stats;

            // Debug: Log the member data to console
            console.log('=== MEMBER MODAL DEBUG ===');
            console.log('Member data received:', member);
            console.log('Profile image path:', member.profile_image);
            console.log('Profile image URL:', member.profile_image_url);
            console.log('Has profile image:', member.has_profile_image);
            console.log('Member name:', member.full_name);
            console.log('==========================');

            const content = `
            <div class="space-y-6">
                <!-- Header with Member Info -->
                <div class="flex justify-between items-start">
                    <div class="flex items-center">
                        <div class="h-20 w-20 rounded-lg bg-gray-300 flex items-center justify-center mr-4 relative group" id="memberImageContainer-${member.id}">
                            <!-- Image will be inserted here by JavaScript -->
                            <!-- Click overlay for image viewing -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 rounded-lg transition-all duration-200 flex items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer" onclick="viewFullImage('${member.profile_image_url}', '${member.full_name}')" id="imageOverlay-${member.id}" style="display: none;">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">${member.full_name}</h2>
                            <p class="text-gray-600">${member.user ? 'Has User Account' : 'No User Account'}</p>
                            ${stats.age ? `<p class="text-sm text-gray-500">Age: ${stats.age} years old</p>` : ''}
                            <p class="text-xs text-blue-600 mt-1" id="imageClickHint-${member.id}" style="display: none;">
                                <svg class="inline h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Click image to view full size
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Active Member
                        </span>
                        ${stats.member_since_days ? `<p class="text-sm text-gray-500 mt-1">Member for ${stats.member_since_days} days</p>` : ''}
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-green-50 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-green-800">Total Givings</h3>
                        <p class="text-2xl font-bold text-green-600">${formatCurrency(stats.total_givings)} UGX</p>
                        <p class="text-xs text-green-600">${stats.giving_count} transactions</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-blue-800">Events Attended</h3>
                        <p class="text-2xl font-bold text-blue-600">${stats.events_attended}</p>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-purple-800">Services Attended</h3>
                        <p class="text-2xl font-bold text-purple-600">${stats.services_attended}</p>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-yellow-800">Groups</h3>
                        <p class="text-2xl font-bold text-yellow-600">${stats.groups_count}</p>
                    </div>
                </div>

                <!-- Main Details Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Personal Information</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Full Name:</span>
                                <span class="font-medium">${member.full_name}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Gender:</span>
                                <span class="font-medium">${member.gender ? member.gender.charAt(0).toUpperCase() + member.gender.slice(1) : 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date of Birth:</span>
                                <span class="font-medium">${member.date_of_birth ? formatDate(member.date_of_birth) : 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Marital Status:</span>
                                <span class="font-medium">${member.marital_status ? member.marital_status.charAt(0).toUpperCase() + member.marital_status.slice(1) : 'N/A'}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Contact Information</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Phone:</span>
                                <span class="font-medium">${member.phone || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <span class="font-medium">${member.email || 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Address:</span>
                                <span class="font-medium text-right max-w-xs">${member.address || 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Church Information -->
                <div class="bg-white border rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Church Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Cell:</span>
                                <span class="font-medium">${member.cell ? member.cell.charAt(0).toUpperCase() + member.cell.slice(1) : 'N/A'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date Joined:</span>
                                <span class="font-medium">${member.date_joined ? formatDate(member.date_joined) : 'N/A'}</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Groups:</span>
                                <span class="font-medium">${member.groups ? member.groups.length : 0} groups</span>
                            </div>
                            ${member.groups && member.groups.length > 0 ? `
                            <div class="mt-2">
                                <span class="text-gray-600 text-sm">Group Names:</span>
                                <div class="mt-1">
                                    ${member.groups.map(group => `<span class="inline-block bg-gray-200 rounded-full px-2 py-1 text-xs text-gray-700 mr-1 mb-1">${group.name}</span>`).join('')}
                                </div>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                </div>

                <!-- Giving Summary -->
                ${stats.total_givings > 0 ? `
                <div class="bg-white border rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Giving Summary (This Year)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Tithes</p>
                            <p class="text-xl font-bold text-purple-600">${formatCurrency(stats.total_tithes)} UGX</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Offerings</p>
                            <p class="text-xl font-bold text-blue-600">${formatCurrency(stats.total_offerings)} UGX</p>
                        </div>
                        <div class="text-center">
                            <p class="text-sm text-gray-600">Donations</p>
                            <p class="text-xl font-bold text-green-600">${formatCurrency(stats.total_donations)} UGX</p>
                        </div>
                    </div>
                </div>
                ` : ''}

                <!-- Recent Activity -->
                ${member.givings && member.givings.length > 0 ? `
                <div class="bg-white border rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Recent Givings</h3>
                    <div class="space-y-2">
                        ${member.givings.slice(0, 5).map(giving => `
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                                <div>
                                    <span class="font-medium">${giving.giving_type.charAt(0).toUpperCase() + giving.giving_type.slice(1)}</span>
                                    <span class="text-sm text-gray-500 ml-2">${formatDate(giving.created_at)}</span>
                                </div>
                                <div class="text-right">
                                    <span class="font-bold">${formatCurrency(giving.amount)} ${giving.currency}</span>
                                    <div class="text-xs ${giving.status === 'completed' ? 'text-green-600' : 'text-yellow-600'}">${giving.status}</div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
                ` : ''}

                <!-- Actions -->
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <a href="/members/${member.id}/edit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md text-sm">
                        ✏️ Edit Member
                    </a>
                    <button onclick="closeMemberModal()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm">
                        Close
                    </button>
                </div>
            </div>
        `;

            document.getElementById('member-modal-content').innerHTML = content;

            // Handle member image display after content is inserted
            const imageContainer = document.getElementById(`memberImageContainer-${member.id}`);
            const imageOverlay = document.getElementById(`imageOverlay-${member.id}`);
            const clickHint = document.getElementById(`imageClickHint-${member.id}`);

            if (member.profile_image_url && member.has_profile_image) {
                console.log('Loading image:', member.profile_image_url);

                // Create image element
                const img = document.createElement('img');
                img.className = 'h-20 w-20 rounded-lg object-cover cursor-pointer';
                img.alt = member.full_name;
                img.src = member.profile_image_url;
                img.onclick = () => viewFullImage(member.profile_image_url, member.full_name);

                img.onload = function () {
                    console.log('✅ Image loaded successfully');
                    imageContainer.innerHTML = '';
                    imageContainer.appendChild(img);

                    // Show the hover overlay and click hint
                    if (imageOverlay) imageOverlay.style.display = 'flex';
                    if (clickHint) clickHint.style.display = 'block';
                };

                img.onerror = function () {
                    console.error('❌ Image failed to load:', member.profile_image_url);
                    showFallbackInitial();
                };

                // Set a timeout fallback
                setTimeout(() => {
                    if (!img.complete) {
                        console.warn('⏰ Image loading timeout');
                        showFallbackInitial();
                    }
                }, 3000);

            } else {
                console.log('No image URL, showing initial');
                showFallbackInitial();
            }

            function showFallbackInitial() {
                imageContainer.innerHTML = `<span class="text-2xl font-bold text-gray-700">${member.full_name.charAt(0)}</span>`;
                // Hide overlay and hint for fallback
                if (imageOverlay) imageOverlay.style.display = 'none';
                if (clickHint) clickHint.style.display = 'none';
            }
        }

        function closeMemberModal() {
            document.getElementById('member-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat().format(amount || 0);
        }

        function getProfileImageUrl(profileImagePath) {
            if (!profileImagePath) {
                return null;
            }

            // Since we're using local storage for now, construct the local URL
            // The profileImagePath should be something like "members/filename.jpg"
            if (profileImagePath.startsWith('members/')) {
                return `{{ config('app.url') }}/storage/${profileImagePath}`;
            }

            // Fallback for other paths
            return `{{ config('app.url') }}/storage/${profileImagePath}`;
        }

        function getDefaultProfileImageUrl(fullName) {
            const initials = fullName ? fullName.charAt(0) : '?';
            return `https://ui-avatars.com/api/?name=${encodeURIComponent(initials)}&background=3B82F6&color=ffffff&size=200`;
        }

        // Image lightbox functions
        function viewFullImage(imageUrl, memberName) {
            if (!imageUrl) return;

            const lightbox = document.getElementById('image-lightbox');
            const lightboxImage = document.getElementById('lightbox-image');
            const lightboxTitle = document.getElementById('lightbox-title');

            lightboxTitle.textContent = `${memberName}'s Profile Photo`;
            lightboxImage.src = imageUrl;
            lightboxImage.alt = `${memberName}'s profile photo`;

            // Store current image URL for download
            lightbox.dataset.currentImageUrl = imageUrl;
            lightbox.dataset.currentMemberName = memberName;

            lightbox.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeImageLightbox() {
            const lightbox = document.getElementById('image-lightbox');
            lightbox.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function downloadImage() {
            const lightbox = document.getElementById('image-lightbox');
            const imageUrl = lightbox.dataset.currentImageUrl;
            const memberName = lightbox.dataset.currentMemberName;

            if (imageUrl) {
                const link = document.createElement('a');
                link.href = imageUrl;
                link.download = `${memberName.replace(/\s+/g, '_')}_profile_photo.jpg`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                const addMemberModal = document.getElementById('add-member-modal');
                const editMemberModal = document.getElementById('edit-member-modal');
                const memberModal = document.getElementById('member-modal');
                const imageLightbox = document.getElementById('image-lightbox');

                if (!addMemberModal.classList.contains('hidden')) {
                    closeAddMemberModal();
                } else if (!editMemberModal.classList.contains('hidden')) {
                    closeEditMemberModal();
                } else if (!imageLightbox.classList.contains('hidden')) {
                    closeImageLightbox();
                } else if (!memberModal.classList.contains('hidden')) {
                    closeMemberModal();
                }
            }
        });

        // Close modals when clicking outside
        document.getElementById('member-modal').addEventListener('click', function (event) {
            if (event.target === this) {
                closeMemberModal();
            }
        });

        document.getElementById('image-lightbox').addEventListener('click', function (event) {
            if (event.target === this) {
                closeImageLightbox();
            }
        });

        // Add Member Modal Functions
        function openAddMemberModal() {
            document.getElementById('add-member-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // Reset form
            document.getElementById('add-member-form').reset();
            clearFormErrors();
            hideImagePreview();

            // Set default date to today
            document.querySelector('input[name="dateJoined"]').value = new Date().toISOString().split('T')[0];
        }

        function closeAddMemberModal() {
            document.getElementById('add-member-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            // Reset form and clear any errors
            document.getElementById('add-member-form').reset();
            clearFormErrors();
            hideImagePreview();
        }

        // Edit Member Modal Functions
        function openEditMemberModal(memberId) {
            // Show modal with loading state
            document.getElementById('edit-member-modal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // Fetch member data
            fetch(`/admin/members/${memberId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        populateEditForm(data.member);
                    } else {
                        alert('Error loading member data: ' + (data.message || 'Unknown error'));
                        closeEditMemberModal();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading member data: ' + error.message);
                    closeEditMemberModal();
                });
        }

        function populateEditForm(member) {
            // Set member ID
            document.getElementById('edit-member-id').value = member.id;

            // Populate form fields
            document.getElementById('edit-fullname').value = member.full_name || '';
            document.getElementById('edit-dateOfBirth').value = member.date_of_birth || '';
            document.getElementById('edit-gender').value = member.gender || '';
            document.getElementById('edit-maritalStatus').value = member.marital_status || '';
            document.getElementById('edit-phone').value = member.phone || '';
            document.getElementById('edit-email').value = member.email || '';
            document.getElementById('edit-address').value = member.address || '';
            document.getElementById('edit-dateJoined').value = member.date_joined || '';
            document.getElementById('edit-cell').value = member.cell || '';

            // Show current profile image if exists
            const currentImageContainer = document.getElementById('edit-current-image-container');
            const currentImage = document.getElementById('edit-current-image');

            if (member.profile_image_url && member.has_profile_image) {
                currentImage.src = member.profile_image_url;
                currentImageContainer.classList.remove('hidden');
            } else {
                currentImageContainer.classList.add('hidden');
            }

            // Clear any previous errors
            clearEditFormErrors();
        }

        function closeEditMemberModal() {
            document.getElementById('edit-member-modal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            // Reset form and clear any errors
            document.getElementById('edit-member-form').reset();
            clearEditFormErrors();
            hideEditImagePreview();
        }

        function clearEditFormErrors() {
            // Hide all error messages
            const errorElements = document.querySelectorAll('[id^="edit-error-"]');
            errorElements.forEach(element => {
                element.classList.add('hidden');
                element.textContent = '';
            });

            // Remove error styling from inputs
            const inputs = document.querySelectorAll('#edit-member-form input, #edit-member-form select');
            inputs.forEach(input => {
                input.classList.remove('border-red-500');
            });
        }

        function showEditFormError(fieldName, message) {
            const errorElement = document.getElementById(`edit-error-${fieldName}`);
            const inputElement = document.querySelector(`#edit-member-form [name="${fieldName}"]`);

            if (errorElement) {
                errorElement.textContent = message;
                errorElement.classList.remove('hidden');
            }

            if (inputElement) {
                inputElement.classList.add('border-red-500');
            }
        }

        function hideEditImagePreview() {
            document.getElementById('editModalImagePreview').classList.add('hidden');
        }

        // Edit image preview functionality
        document.getElementById('editModalProfileImageInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPEG, PNG, JPG, or GIF)');
                    this.value = '';
                    return;
                }

                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB');
                    this.value = '';
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('editModalPreviewImg').src = e.target.result;
                    document.getElementById('editModalImagePreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                hideEditImagePreview();
            }
        });

        // Handle edit form submission
        document.getElementById('edit-member-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const memberId = document.getElementById('edit-member-id').value;
            const submitBtn = document.getElementById('submitEditMemberBtn');
            const submitBtnText = document.getElementById('submitEditBtnText');
            const submitBtnSpinner = document.getElementById('submitEditBtnSpinner');

            // Disable submit button and show spinner
            submitBtn.disabled = true;
            submitBtnText.textContent = 'Updating...';
            submitBtnSpinner.classList.remove('hidden');

            // Clear previous errors
            clearEditFormErrors();

            // Create FormData object
            const formData = new FormData(this);

            // Send AJAX request
            fetch(`/members/${memberId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => response.json())
                .then(data => {
                    // Success
                    closeEditMemberModal();

                    // Show success message
                    alert('Member updated successfully!');

                    // Reload the page to show updated data
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);

                    // Handle validation errors
                    if (error.errors) {
                        Object.keys(error.errors).forEach(fieldName => {
                            const messages = error.errors[fieldName];
                            if (messages && messages.length > 0) {
                                showEditFormError(fieldName, messages[0]);
                            }
                        });
                    } else {
                        alert('An error occurred while updating the member. Please try again.');
                    }
                })
                .finally(() => {
                    // Re-enable submit button and hide spinner
                    submitBtn.disabled = false;
                    submitBtnText.textContent = 'Update Member';
                    submitBtnSpinner.classList.add('hidden');
                });
        });

        function clearFormErrors() {
            // Hide all error messages
            const errorElements = document.querySelectorAll('[id^="error-"]');
            errorElements.forEach(element => {
                element.classList.add('hidden');
                element.textContent = '';
            });

            // Remove error styling from inputs
            const inputs = document.querySelectorAll('#add-member-form input, #add-member-form select');
            inputs.forEach(input => {
                input.classList.remove('border-red-500');
            });
        }

        function showFormError(fieldName, message) {
            const errorElement = document.getElementById(`error-${fieldName}`);
            const inputElement = document.querySelector(`[name="${fieldName}"]`);

            if (errorElement) {
                errorElement.textContent = message;
                errorElement.classList.remove('hidden');
            }

            if (inputElement) {
                inputElement.classList.add('border-red-500');
            }
        }

        // Image preview functionality
        document.getElementById('modalProfileImageInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    showFormError('profileImage', 'Please select a valid image file (JPEG, PNG, JPG, GIF)');
                    e.target.value = '';
                    hideImagePreview();
                    return;
                }

                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    showFormError('profileImage', 'Image size must be less than 5MB');
                    e.target.value = '';
                    hideImagePreview();
                    return;
                }

                // Clear any previous errors
                document.getElementById('error-profileImage').classList.add('hidden');
                document.querySelector('[name="profileImage"]').classList.remove('border-red-500');

                // Show preview
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('modalPreviewImg').src = e.target.result;
                    document.getElementById('modalImagePreview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                hideImagePreview();
            }
        });

        function hideImagePreview() {
            document.getElementById('modalImagePreview').classList.add('hidden');
            document.getElementById('modalPreviewImg').src = '';
        }

        // Form submission handler
        document.getElementById('add-member-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitMemberBtn');
            const submitBtnText = document.getElementById('submitBtnText');
            const submitBtnSpinner = document.getElementById('submitBtnSpinner');

            // Clear previous errors
            clearFormErrors();

            // Show loading state
            submitBtn.disabled = true;
            submitBtnText.textContent = 'Adding Member...';
            submitBtnSpinner.classList.remove('hidden');

            // Prepare form data
            const formData = new FormData(this);

            // Submit form via AJAX
            fetch('{{ route("members.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => Promise.reject(data));
                    }
                    return response.json();
                })
                .then(data => {
                    // Success
                    closeAddMemberModal();

                    // Show success message
                    showSuccessNotification('Member added successfully!');

                    // Refresh the page to show the new member
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                })
                .catch(error => {
                    console.error('Error adding member:', error);

                    // Handle validation errors
                    if (error.errors) {
                        Object.keys(error.errors).forEach(fieldName => {
                            const messages = error.errors[fieldName];
                            if (messages && messages.length > 0) {
                                showFormError(fieldName, messages[0]);
                            }
                        });
                    } else {
                        // Show general error
                        showErrorNotification(error.message || 'Failed to add member. Please try again.');
                    }
                })
                .finally(() => {
                    // Reset button state
                    submitBtn.disabled = false;
                    submitBtnText.textContent = 'Add Member';
                    submitBtnSpinner.classList.add('hidden');
                });
        });

        // Notification functions
        function showSuccessNotification(message) {
            const notification = createNotification(message, 'success');
            document.body.appendChild(notification);

            // Auto remove after 3 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 3000);
        }

        function showErrorNotification(message) {
            const notification = createNotification(message, 'error');
            document.body.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 5000);
        }

        function createNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm ${type === 'success'
                    ? 'bg-green-100 border border-green-400 text-green-700'
                    : 'bg-red-100 border border-red-400 text-red-700'
                }`;

            notification.innerHTML = `
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    ${type === 'success'
                    ? '<svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>'
                    : '<svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 19.5c-.77.833.192 2.5 1.732 2.5z" /></svg>'
                }
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="this.parentNode.parentNode.parentNode.remove()" class="inline-flex text-gray-400 hover:text-gray-600">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        `;

            return notification;
        }

        // Close Add Member modal when clicking outside
        document.getElementById('add-member-modal').addEventListener('click', function (event) {
            if (event.target === this) {
                closeAddMemberModal();
            }
        });

        // Close Edit Member modal when clicking outside
        document.getElementById('edit-member-modal').addEventListener('click', function (event) {
            if (event.target === this) {
                closeEditMemberModal();
            }
        });
    </script>

    <!-- Add CSRF token to head for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="supabase-url" content="{{ config('filesystems.disks.supabase.url') }}">
    <meta name="supabase-bucket" content="{{ config('filesystems.disks.supabase.bucket') }}">
@endsection