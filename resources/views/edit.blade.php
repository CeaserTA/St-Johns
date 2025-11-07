<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member - St. Johns Parish Church</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    </style>
</head>
<body>
    <div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded-lg shadow">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Member</h1>
        <form action="{{ route('members.update', $member->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $member->first_name) }}" class="w-full p-2 border rounded @error('first_name') border-red-500 @enderror" required>
                @error('first_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $member->last_name) }}" class="w-full p-2 border rounded @error('last_name') border-red-500 @enderror" required>
                @error('last_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Gender</label>
                <select name="gender" class="w-full p-2 border rounded @error('gender') border-red-500 @enderror" required>
                    <option value="Male" {{ old('gender', $member->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $member->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('gender', $member->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('gender')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Phone</label>
                <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" class="w-full p-2 border rounded @error('phone') border-red-500 @enderror">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $member->email) }}" class="w-full p-2 border rounded @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Address</label>
                <input type="text" name="address" value="{{ old('address', $member->address) }}" class="w-full p-2 border rounded @error('address') border-red-500 @enderror">
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
                <a href="{{ route('members') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>