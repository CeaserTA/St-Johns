<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Service Registrations - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Service Registrations</h1>
            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('service.registrations') }}" class="flex items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email"
                           class="px-3 py-2 border rounded" />
                    <select name="service" class="px-3 py-2 border rounded">
                        <option value="">All services</option>
                        <option value="Counseling" {{ request('service') == 'Counseling' ? 'selected' : '' }}>Counseling</option>
                        <option value="Baptism" {{ request('service') == 'Baptism' ? 'selected' : '' }}>Baptism</option>
                        <option value="Youth Retreat" {{ request('service') == 'Youth Retreat' ? 'selected' : '' }}>Youth Retreat</option>
                    </select>
                    <input type="date" name="from" value="{{ request('from') }}" class="px-3 py-2 border rounded" />
                    <input type="date" name="to" value="{{ request('to') }}" class="px-3 py-2 border rounded" />
                    <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded">Filter</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        <div class="bg-white shadow rounded overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="px-4 py-3 text-sm font-medium">#</th>
                        <th class="px-4 py-3 text-sm font-medium">Name</th>
                        <th class="px-4 py-3 text-sm font-medium">Email</th>
                        <th class="px-4 py-3 text-sm font-medium">Phone</th>
                        <th class="px-4 py-3 text-sm font-medium">Service</th>
                            <td class="px-4 py-3 text-sm">{{ $reg->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-3 text-sm">{{ $reg->id }}</td>
                        <td class="px-4 py-3 text-sm">{{ $reg->full_name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $reg->email ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm">{{ $reg->phone_number ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm">{{ $reg->service }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex gap-2">
                                <button data-id="{{ $reg->id }}" class="view-btn px-2 py-1 bg-blue-600 text-white rounded text-sm">View</button>
                                <button data-id="{{ $reg->id }}" class="edit-btn px-2 py-1 bg-yellow-500 text-white rounded text-sm">Edit</button>
                                <button data-id="{{ $reg->id }}" class="delete-btn px-2 py-1 bg-red-600 text-white rounded text-sm">Delete</button>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $reg->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-6 text-center" colspan="6">No registrations found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <div class="p-4">
                {{ $registrations->links() }}
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg w-11/12 md:w-2/3 lg:w-1/2 p-6">
            <h3 class="text-lg font-bold mb-4">Registration Details</h3>
            <div id="viewContent" class="space-y-2 text-sm text-gray-800"></div>
            <div class="mt-4 text-right">
                <button id="closeView" class="px-4 py-2 bg-gray-300 rounded">Close</button>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 hidden items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg w-11/12 md:w-2/3 lg:w-1/2 p-6">
            <h3 class="text-lg font-bold mb-4">Edit Registration</h3>
            <form id="editForm" class="space-y-3">
                <input type="hidden" name="id" id="edit_id">
                <div>
                    <label class="block text-sm">Full name</label>
                    <input id="edit_full_name" name="full_name" class="w-full border px-3 py-2 rounded" />
                </div>
                <div>
                    <label class="block text-sm">Email</label>
                    <input id="edit_email" name="email" class="w-full border px-3 py-2 rounded" />
                </div>
                <div>
                    <label class="block text-sm">Phone</label>
                    <input id="edit_phone_number" name="phone_number" class="w-full border px-3 py-2 rounded" />
                </div>
                <div>
                    <label class="block text-sm">Address</label>
                    <input id="edit_address" name="address" class="w-full border px-3 py-2 rounded" />
                </div>
                <div>
                    <label class="block text-sm">Service</label>
                    <select id="edit_service" name="service" class="w-full border px-3 py-2 rounded">
                        <option value="Counseling">Counseling</option>
                        <option value="Baptism">Baptism</option>
                        <option value="Youth Retreat">Youth Retreat</option>
                    </select>
                </div>

                <div class="mt-4 text-right">
                    <button type="button" id="cancelEdit" class="px-4 py-2 bg-gray-300 rounded mr-2">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

        </div>
    </body>
    </html>
    </div>
</body>
</html>
