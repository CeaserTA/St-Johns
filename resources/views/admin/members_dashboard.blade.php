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

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Members</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_members'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Active Members</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_members'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">New This Month</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['new_this_month'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a2 2 0 100-4 2 2 0 000 4zm0 0v3m-3-3h6m-6 0H3m15 0h3" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Average Age</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['average_age'] ? round($stats['average_age']) : 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Search & Filter Members</h2>
        <form method="GET" action="{{ route('admin.members') }}" class="space-y-4">
            <!-- Search Bar -->
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Search by name, email, phone, or address..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition duration-200">
                        🔍 Search
                    </button>
                </div>
            </div>

            <!-- Filters Row -->
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <select name="gender" id="gender" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Genders</option>
                        @foreach($filterOptions['genders'] as $gender)
                            <option value="{{ $gender }}" {{ request('gender') == $gender ? 'selected' : '' }}>
                                {{ ucfirst($gender) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="marital_status" class="block text-sm font-medium text-gray-700 mb-1">Marital Status</label>
                    <select name="marital_status" id="marital_status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Statuses</option>
                        @foreach($filterOptions['marital_statuses'] as $status)
                            <option value="{{ $status }}" {{ request('marital_status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="cell" class="block text-sm font-medium text-gray-700 mb-1">Cell</label>
                    <select name="cell" id="cell" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Cells</option>
                        @foreach($filterOptions['cells'] as $cellName)
                            <option value="{{ $cellName }}" {{ request('cell') == $cellName ? 'selected' : '' }}>
                                {{ ucfirst($cellName) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="age_range" class="block text-sm font-medium text-gray-700 mb-1">Age Range</label>
                    <select name="age_range" id="age_range" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Ages</option>
                        <option value="under_18" {{ request('age_range') == 'under_18' ? 'selected' : '' }}>Under 18</option>
                        <option value="18_30" {{ request('age_range') == '18_30' ? 'selected' : '' }}>18-30</option>
                        <option value="31_50" {{ request('age_range') == '31_50' ? 'selected' : '' }}>31-50</option>
                        <option value="over_50" {{ request('age_range') == 'over_50' ? 'selected' : '' }}>Over 50</option>
                    </select>
                </div>

                <div>
                    <label for="joined_period" class="block text-sm font-medium text-gray-700 mb-1">Joined</label>
                    <select name="joined_period" id="joined_period" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Time</option>
                        <option value="this_month" {{ request('joined_period') == 'this_month' ? 'selected' : '' }}>This Month</option>
                        <option value="this_year" {{ request('joined_period') == 'this_year' ? 'selected' : '' }}>This Year</option>
                        <option value="last_year" {{ request('joined_period') == 'last_year' ? 'selected' : '' }}>Last Year</option>
                    </select>
                </div>

                <div class="flex items-end">
                    <a href="{{ route('admin.members') }}" class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-center transition duration-200">
                        Clear Filters
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Members Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-900">
                Members List 
                @if($members && request()->hasAny(['search', 'gender', 'marital_status', 'cell', 'age_range', 'joined_period']))
                    <span class="text-sm text-gray-500">({{ $members->total() }} filtered results)</span>
                @elseif($members)
                    <span class="text-sm text-gray-500">({{ $members->total() }} total)</span>
                @else
                    <span class="text-sm text-gray-500">(0 total)</span>
                @endif
            </h2>
            <button id="addMemberBtn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200">
                + Add Member
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'full_name', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                               class="flex items-center hover:text-gray-700">
                                Full Name
                                @if(request('sort_by') == 'full_name')
                                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if(request('sort_order') == 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Personal Info</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Church Info</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'date_joined', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc']) }}" 
                               class="flex items-center hover:text-gray-700">
                                Joined
                                @if(request('sort_by') == 'date_joined')
                                    <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if(request('sort_order') == 'asc')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        @endif
                                    </svg>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if($members && $members->count() > 0)
                        @foreach($members as $member)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if($member->hasProfileImage())
                                                <img class="h-10 w-10 rounded-full object-cover" 
                                                     src="{{ $member->profile_image_url }}" 
                                                     alt="{{ $member->full_name }}"
                                                     onerror="this.onerror=null; this.src='{{ $member->default_profile_image_url }}';">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-gray-700">{{ $member->full_name ? substr($member->full_name, 0, 1) : '?' }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $member->full_name ?? 'N/A' }}</div>
                                            @if($member->user)
                                                <div class="text-sm text-green-600">Has Account</div>
                                            @else
                                                <div class="text-sm text-gray-500">No Account</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>{{ $member->phone ?: 'N/A' }}</div>
                                    <div class="text-gray-500">{{ $member->email ?: 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>{{ $member->gender ? ucfirst($member->gender) : 'N/A' }}</div>
                                    <div class="text-gray-500">{{ $member->marital_status ? ucfirst($member->marital_status) : 'N/A' }}</div>
                                    @if($member->age)
                                        <div class="text-xs text-gray-400">Age: {{ $member->age }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <div class="max-w-xs truncate">{{ $member->address ?: 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>Cell: {{ $member->cell ? ucfirst($member->cell) : 'N/A' }}</div>
                                    <div class="text-gray-500">Groups: 0</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $member->formatted_date_joined }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <button onclick="viewMemberDetails({{ $member->id }})" 
                                                class="text-blue-600 hover:text-blue-900 transition duration-200 text-xs px-2 py-1 bg-blue-50 rounded">
                                            👁 View
                                        </button>
                                        <a href="{{ route('members.edit', $member->id) }}" 
                                           class="text-yellow-600 hover:text-yellow-900 transition duration-200 text-xs px-2 py-1 bg-yellow-50 rounded">
                                            ✏️ Edit
                                        </a>
                                        <form method="POST" action="{{ route('members.destroy', $member->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 transition duration-200 text-xs px-2 py-1 bg-red-50 rounded" 
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
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                @if(request()->hasAny(['search', 'gender', 'marital_status', 'cell', 'age_range', 'joined_period']))
                                    No members found matching your filters. <a href="{{ route('admin.members') }}" class="text-blue-600 hover:underline">Clear filters</a> to see all members.
                                @else
                                    No members registered yet. <button onclick="document.getElementById('addMemberBtn').click()" class="text-blue-600 hover:underline">Add the first member</button>!
                                @endif
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if($members && $members->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $members->links() }}
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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

    const content = `
        <div class="space-y-6">
            <!-- Header with Member Info -->
            <div class="flex justify-between items-start">
                <div class="flex items-center">
                    <div class="h-16 w-16 rounded-full overflow-hidden bg-gray-300 flex items-center justify-center mr-4">
                        ${member.profile_image ? 
                            `<img class="h-16 w-16 rounded-full object-cover" 
                                  src="${getProfileImageUrl(member.profile_image)}" 
                                  alt="${member.full_name}"
                                  onerror="this.onerror=null; this.parentElement.innerHTML='<span class=\\"text-xl font-bold text-gray-700\\">${member.full_name.charAt(0)}</span>';">` :
                            `<span class="text-xl font-bold text-gray-700">${member.full_name.charAt(0)}</span>`
                        }
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">${member.full_name}</h2>
                        <p class="text-gray-600">${member.user ? 'Has User Account' : 'No User Account'}</p>
                        ${stats.age ? `<p class="text-sm text-gray-500">Age: ${stats.age} years old</p>` : ''}
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

// Close modal on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('member-modal');
        if (!modal.classList.contains('hidden')) {
            closeMemberModal();
        }
    }
});

// Close modal when clicking outside
document.getElementById('member-modal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeMemberModal();
    }
});

// Add Member functionality (placeholder)
document.getElementById('addMemberBtn').addEventListener('click', function() {
    alert('Add Member functionality would redirect to the member creation form.');
});
</script>

<!-- Add CSRF token to head for AJAX requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="supabase-url" content="{{ config('filesystems.disks.supabase.url') }}">
<meta name="supabase-bucket" content="{{ config('filesystems.disks.supabase.bucket') }}">
@endsection
