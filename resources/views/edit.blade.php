<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Edit Member - St. John’s Parish Church Entebbe</title>

    <!-- Tailwind + Fonts -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link rel="stylesheet" href="styles.css">

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#3A5C83",
                        "secondary": "#F2C94C",
                        "background-light": "#F8F9FA",
                        "background-dark": "#101922",
                        "text-light": "#333333",
                        "text-dark": "#F8F9FA",
                        "text-muted-light": "#4c739a",
                        "text-muted-dark": "#a0aec0",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                },
            },
        }
    </script>
</head>
<body class="bg-background-light font-display text-text-light">
    <div class="flex h-screen overflow-hidden bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-800 text-white flex flex-col">
            <div class="p-6 text-2xl font-bold border-b border-blue-900">
                St. Johns Admin
            </div>
            <nav class="mt-6">
                <ul>
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 hover:bg-blue-700 rounded-r-lg transition">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-10 0h3" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('members') }}" class="flex items-center px-6 py-3 bg-blue-700 rounded-r-lg">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 0 018 0z"/>
                            </svg>
                            Members
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('service.register') }}" class="flex items-center px-6 py-3 hover:bg-blue-700 rounded-r-lg transition">
                            <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 0 018 0z"/>
                            </svg>
                            Services
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center px-6 py-3 hover:bg-blue-700 rounded-r-lg transition">
                                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="flex items-center justify-between px-6 py-4 bg-white shadow-sm">
                <h1 class="text-xl font-bold text-gray-800">Edit Member</h1>
            </header>

            <!-- Edit Form -->
            <main class="flex-1 p-6 overflow-y-auto bg-gray-50">
                <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Update Member Information</h2>

                    <form action="{{ route('members.update', $member->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-medium mb-1">Full Name</label>
                                <input type="text" name="fullname" value="{{ old('fullname', $member->full_name) }}" class="w-full p-2 border rounded @error('fullname') border-red-500 @enderror" required>
                                @error('fullname')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Date of Birth</label>
                                <input type="date" name="dateOfBirth" value="{{ old('dateOfBirth', $member->date_of_birth ? $member->date_of_birth->format('Y-m-d') : '') }}" class="w-full p-2 border rounded @error('dateOfBirth') border-red-500 @enderror" required>
                                @error('dateOfBirth')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Gender</label>
                                <select name="gender" class="w-full p-2 border rounded @error('gender') border-red-500 @enderror" required>
                                    <option value="">-- Select Gender --</option>
                                    <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Marital Status</label>
                                <select name="maritalStatus" class="w-full p-2 border rounded @error('maritalStatus') border-red-500 @enderror" required>
                                    <option value="">-- Select Status --</option>
                                    <option value="single" {{ old('maritalStatus', $member->marital_status) == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="married" {{ old('maritalStatus', $member->marital_status) == 'married' ? 'selected' : '' }}>Married</option>
                                    <option value="divorced" {{ old('maritalStatus', $member->marital_status) == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                    <option value="widowed" {{ old('maritalStatus', $member->marital_status) == 'widowed' ? 'selected' : '' }}>Widowed</option>
                                </select>
                                @error('maritalStatus')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" class="w-full p-2 border rounded @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', $member->email) }}" class="w-full p-2 border rounded @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-medium mb-1">Address</label>
                                <input type="text" name="address" value="{{ old('address', $member->address) }}" class="w-full p-2 border rounded @error('address') border-red-500 @enderror">
                                @error('address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Date Joined</label>
                                <input type="date" name="dateJoined" value="{{ old('dateJoined', $member->date_joined ? $member->date_joined->format('Y-m-d') : '') }}" class="w-full p-2 border rounded @error('dateJoined') border-red-500 @enderror" required>
                                @error('dateJoined')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Cell (Zone)</label>
                                <select name="cell" class="w-full p-2 border rounded @error('cell') border-red-500 @enderror" required>
                                    <option value="">-- Select Cell --</option>
                                    <option value="north" {{ old('cell', $member->cell) == 'north' ? 'selected' : '' }}>North</option>
                                    <option value="east" {{ old('cell', $member->cell) == 'east' ? 'selected' : '' }}>East</option>
                                    <option value="south" {{ old('cell', $member->cell) == 'south' ? 'selected' : '' }}>South</option>
                                    <option value="west" {{ old('cell', $member->cell) == 'west' ? 'selected' : '' }}>West</option>
                                </select>
                                @error('cell')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-medium mb-1">Profile Image</label>
                                
                                @if($member->hasProfileImage())
                                    <div class="mb-3 flex items-center space-x-4">
                                        <img src="{{ $member->profile_image_url }}" 
                                             alt="{{ $member->full_name }}" 
                                             class="h-16 w-16 rounded-full object-cover border-2 border-gray-300"
                                             onerror="this.onerror=null; this.src='{{ $member->default_profile_image_url }}';">
                                        <div>
                                            <p class="text-sm text-gray-600">Current profile image</p>
                                            <p class="text-xs text-gray-500">Upload a new image to replace it</p>
                                        </div>
                                    </div>
                                @endif
                                
                                <input type="file" name="profileImage" accept="image/*" id="profileImageInput" class="w-full p-2 border rounded @error('profileImage') border-red-500 @enderror">
                                <p class="text-xs text-gray-500 mt-1">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</p>
                                
                                <!-- New Image Preview -->
                                <div id="newImagePreview" class="mt-3 hidden">
                                    <p class="text-sm text-gray-600 mb-2">New image preview:</p>
                                    <img id="newPreviewImg" src="" alt="New Preview" class="h-16 w-16 rounded-full object-cover border-2 border-blue-300">
                                </div>
                                @error('profileImage')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex space-x-4">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Update</button>
                            <a href="{{ route('members') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">Cancel</a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

<script>
// Image preview functionality for edit form
document.getElementById('profileImageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('newImagePreview');
    const previewImg = document.getElementById('newPreviewImg');
    
    if (file) {
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!validTypes.includes(file.type)) {
            alert('Please select a valid image file (JPEG, PNG, JPG, or GIF)');
            event.target.value = '';
            preview.classList.add('hidden');
            return;
        }
        
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            event.target.value = '';
            preview.classList.add('hidden');
            return;
        }
        
        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
    }
});
</script>

</body>
</html>
