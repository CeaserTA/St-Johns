<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Member - St. Johns Parish Church</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-blue-800 text-white flex flex-col">
        <div class="p-6 text-2xl font-bold border-b border-blue-900">
            St. Johns Admin
        </div>

        <nav class="mt-6 flex-1">
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center px-6 py-3 hover:bg-blue-700 transition {{ request()->routeIs('dashboard') ? 'bg-blue-700' : '' }}">
                        <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-10 0h3"/>
                        </svg>
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ route('members') }}"
                       class="flex items-center px-6 py-3 hover:bg-blue-700 transition {{ request()->routeIs('members*') ? 'bg-blue-700' : '' }}">
                        <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Members
                    </a>
                </li>

                <li>
                    <a href="{{ route('service.register') }}"
                       class="flex items-center px-6 py-3 hover:bg-blue-700 transition {{ request()->routeIs('service.register') ? 'bg-blue-700' : '' }}">
                        <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Services
                    </a>
                </li>
            </ul>
        </nav>

        <form method="POST" action="{{ route('logout') }}" class="p-6 border-t border-blue-900">
            @csrf
            <button type="submit"
                    class="flex items-center w-full px-4 py-2 bg-blue-700 hover:bg-blue-600 rounded transition">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </aside>


    <!-- Main Content -->
<main class="flex-1 p-8 overflow-y-auto">
    <header class="mb-8 flex items-center justify-between flex-wrap">
        <h1 class="text-2xl font-semibold">Add New Member</h1>
        <a href="{{ route('members') }}" class="text-blue-600 hover:underline text-sm mt-2 md:mt-0">
            ← Back to Members
        </a>
    </header>

    <div class="w-full max-w-4xl bg-white rounded-lg shadow p-6 mx-auto">
        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <h4 class="font-bold">Please fix the following errors:</h4>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Display success message -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(request()->query('join_group'))
                <input type="hidden" name="join_group" value="{{ request()->query('join_group') }}">
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-gray-700">Full Name</label>
                    <input type="text" name="fullname" value="{{ old('fullname') }}"
                           class="w-full p-2 border rounded @error('fullname') border-red-500 @enderror" required>
                    @error('fullname')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Date of Birth</label>
                    <input type="date" name="dateOfBirth" value="{{ old('dateOfBirth') }}"
                           class="w-full p-2 border rounded @error('dateOfBirth') border-red-500 @enderror" required>
                    @error('dateOfBirth')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Gender</label>
                    <select name="gender" class="w-full p-2 border rounded @error('gender') border-red-500 @enderror" required>
                        <option value="">-- Select Gender --</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Marital Status</label>
                    <select name="maritalStatus" class="w-full p-2 border rounded @error('maritalStatus') border-red-500 @enderror" required>
                        <option value="">-- Select Status --</option>
                        <option value="single" {{ old('maritalStatus') == 'single' ? 'selected' : '' }}>Single</option>
                        <option value="married" {{ old('maritalStatus') == 'married' ? 'selected' : '' }}>Married</option>
                        <option value="divorced" {{ old('maritalStatus') == 'divorced' ? 'selected' : '' }}>Divorced</option>
                        <option value="widowed" {{ old('maritalStatus') == 'widowed' ? 'selected' : '' }}>Widowed</option>
                    </select>
                    @error('maritalStatus')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           class="w-full p-2 border rounded @error('phone') border-red-500 @enderror" required>
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Email</label>
                          <input type="email" name="email" value="{{ old('email', request()->query('email')) }}"
                           class="w-full p-2 border rounded @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700">Address</label>
                    <input type="text" name="address" value="{{ old('address') }}"
                           class="w-full p-2 border rounded @error('address') border-red-500 @enderror">
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Date Joined</label>
                    <input type="date" name="dateJoined" value="{{ old('dateJoined', date('Y-m-d')) }}"
                           class="w-full p-2 border rounded @error('dateJoined') border-red-500 @enderror" required>
                    @error('dateJoined')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700">Cell (Zone)</label>
                    <select name="cell" class="w-full p-2 border rounded @error('cell') border-red-500 @enderror" required>
                        <option value="">-- Select Cell --</option>
                        <option value="north" {{ old('cell') == 'north' ? 'selected' : '' }}>North</option>
                        <option value="east" {{ old('cell') == 'east' ? 'selected' : '' }}>East</option>
                        <option value="south" {{ old('cell') == 'south' ? 'selected' : '' }}>South</option>
                        <option value="west" {{ old('cell') == 'west' ? 'selected' : '' }}>West</option>
                    </select>
                    @error('cell')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block text-gray-700">Profile Image</label>
                    <input type="file" name="profileImage" accept="image/*" id="profileImageInput"
                           class="w-full p-2 border rounded @error('profileImage') border-red-500 @enderror">
                    <p class="text-xs text-gray-500 mt-1">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</p>
                    
                    <!-- Image Preview -->
                    <div id="imagePreview" class="mt-3 hidden">
                        <p class="text-sm text-gray-600 mb-2">Preview:</p>
                        <img id="previewImg" src="" alt="Preview" class="h-20 w-20 rounded-full object-cover border-2 border-gray-300">
                    </div>
                    
                    @error('profileImage')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex space-x-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
                <a href="{{ route('members') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Cancel</a>
            </div>
        </form>
    </div>
</main>

<script>
// Image preview functionality
document.getElementById('profileImageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (file) {
        // More permissive file type validation
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        const fileName = file.name.toLowerCase();
        const isValidExtension = fileName.endsWith('.jpg') || fileName.endsWith('.jpeg') || 
                                fileName.endsWith('.png') || fileName.endsWith('.gif') || 
                                fileName.endsWith('.webp');
        
        if (!validTypes.includes(file.type) && !isValidExtension) {
            alert('Please select a valid image file (JPEG, PNG, JPG, GIF, or WebP)');
            event.target.value = '';
            preview.classList.add('hidden');
            return;
        }
        
        // Validate file size (5MB for testing)
        if (file.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB');
            event.target.value = '';
            preview.classList.add('hidden');
            return;
        }
        
        console.log('File selected:', {
            name: file.name,
            type: file.type,
            size: file.size,
            sizeInMB: (file.size / 1024 / 1024).toFixed(2) + ' MB'
        });
        
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

// Prevent double form submission
let formSubmitted = false;
document.querySelector('form').addEventListener('submit', function(e) {
    if (formSubmitted) {
        e.preventDefault();
        return false;
    }
    
    formSubmitted = true;
    const submitButton = this.querySelector('button[type="submit"]');
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.textContent = 'Creating Member...';
    }
    
    // Re-enable after 10 seconds in case of error
    setTimeout(() => {
        formSubmitted = false;
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.textContent = 'Save';
        }
    }, 10000);
});
</script>

</body>
</html>
