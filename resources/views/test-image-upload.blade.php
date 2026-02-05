<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Image Upload</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-6">Test Image Upload & Supabase Connection</h1>
        
        <!-- Supabase Connection Test -->
        <div class="mb-8 p-4 bg-blue-50 rounded-lg">
            <h2 class="text-lg font-semibold mb-4">Supabase Connection Test</h2>
            <button id="testSupabase" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Test Supabase Connection
            </button>
            <div id="supabaseResult" class="mt-4"></div>
        </div>

        <!-- Image Upload Test -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4">Test Image Upload</h2>
            <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Full Name</label>
                    <input type="text" name="fullname" value="Test User {{ time() }}" class="w-full p-2 border rounded" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Date of Birth</label>
                    <input type="date" name="dateOfBirth" value="1990-01-01" class="w-full p-2 border rounded" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Gender</label>
                    <select name="gender" class="w-full p-2 border rounded" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Marital Status</label>
                    <select name="maritalStatus" class="w-full p-2 border rounded" required>
                        <option value="single">Single</option>
                        <option value="married">Married</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Phone</label>
                    <input type="text" name="phone" value="+256700000000" class="w-full p-2 border rounded">
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" name="email" value="test{{ time() }}@example.com" class="w-full p-2 border rounded">
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Address</label>
                    <input type="text" name="address" value="Test Address" class="w-full p-2 border rounded">
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Date Joined</label>
                    <input type="date" name="dateJoined" value="{{ date('Y-m-d') }}" class="w-full p-2 border rounded" required>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Cell</label>
                    <select name="cell" class="w-full p-2 border rounded" required>
                        <option value="north">North</option>
                        <option value="east">East</option>
                        <option value="south">South</option>
                        <option value="west">West</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Profile Image</label>
                    <input type="file" name="profileImage" accept="image/*" id="profileImageInput" class="w-full p-2 border rounded">
                    <p class="text-xs text-gray-500 mt-1">Supported formats: JPEG, PNG, JPG, GIF. Max size: 2MB</p>
                    
                    <!-- Image Preview -->
                    <div id="imagePreview" class="mt-3 hidden">
                        <p class="text-sm text-gray-600 mb-2">Preview:</p>
                        <img id="previewImg" src="" alt="Preview" class="h-20 w-20 rounded-full object-cover border-2 border-gray-300">
                    </div>
                </div>
                
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    Create Test Member
                </button>
            </form>
        </div>

        <!-- Recent Members -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4">Recent Members (Last 5)</h2>
            <div id="recentMembers">
                <button id="loadMembers" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                    Load Recent Members
                </button>
                <div id="membersResult" class="mt-4"></div>
            </div>
        </div>
    </div>

    <script>
        // Test Supabase Connection
        document.getElementById('testSupabase').addEventListener('click', function() {
            const resultDiv = document.getElementById('supabaseResult');
            resultDiv.innerHTML = '<div class="text-blue-600">Testing connection...</div>';
            
            fetch('/test-supabase')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        resultDiv.innerHTML = `
                            <div class="text-green-600 font-semibold">✅ Connection Successful!</div>
                            <div class="text-sm text-gray-600 mt-2">
                                <p>Files in bucket: ${data.files_count}</p>
                                <p>Endpoint: ${data.config.endpoint}</p>
                                <p>Bucket: ${data.config.bucket}</p>
                                <p>Public URL: ${data.config.url}</p>
                            </div>
                        `;
                    } else {
                        resultDiv.innerHTML = `
                            <div class="text-red-600 font-semibold">❌ Connection Failed!</div>
                            <div class="text-sm text-gray-600 mt-2">
                                <p>Error: ${data.message}</p>
                                <p>Endpoint: ${data.config.endpoint}</p>
                                <p>Bucket: ${data.config.bucket}</p>
                                <p>Public URL: ${data.config.url}</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    resultDiv.innerHTML = `<div class="text-red-600">Error: ${error.message}</div>`;
                });
        });

        // Load Recent Members
        document.getElementById('loadMembers').addEventListener('click', function() {
            const resultDiv = document.getElementById('membersResult');
            resultDiv.innerHTML = '<div class="text-blue-600">Loading members...</div>';
            
            // Simple fetch to get recent members
            fetch('/api/recent-members')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        let html = '<div class="space-y-2">';
                        data.members.forEach(member => {
                            html += `
                                <div class="flex items-center space-x-3 p-2 bg-gray-50 rounded">
                                    <div class="h-10 w-10 rounded-full overflow-hidden bg-gray-300">
                                        ${member.profile_image ? 
                                            `<img src="${member.profile_image_url}" alt="${member.full_name}" class="h-10 w-10 object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                             <div class="h-10 w-10 bg-gray-300 flex items-center justify-center text-sm font-medium text-gray-700" style="display:none;">${member.full_name.charAt(0)}</div>` :
                                            `<div class="h-10 w-10 bg-gray-300 flex items-center justify-center text-sm font-medium text-gray-700">${member.full_name.charAt(0)}</div>`
                                        }
                                    </div>
                                    <div>
                                        <div class="font-medium">${member.full_name}</div>
                                        <div class="text-sm text-gray-500">${member.email || 'No email'}</div>
                                        <div class="text-xs text-gray-400">Image: ${member.profile_image || 'None'}</div>
                                    </div>
                                </div>
                            `;
                        });
                        html += '</div>';
                        resultDiv.innerHTML = html;
                    } else {
                        resultDiv.innerHTML = `<div class="text-red-600">Error: ${data.message}</div>`;
                    }
                })
                .catch(error => {
                    resultDiv.innerHTML = `<div class="text-red-600">Error: ${error.message}</div>`;
                });
        });

        // Image preview functionality
        document.getElementById('profileImageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            
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