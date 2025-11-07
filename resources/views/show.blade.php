<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Details - St. Johns Parish Church</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    </style>
</head>
<body>
    <div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded-lg shadow">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Member Details</h1>
        <p><strong>Name:</strong> {{ $member->first_name }} {{ $member->last_name }}</p>
        <p><strong>Gender:</strong> {{ $member->gender }}</p>
        <p><strong>Phone:</strong> {{ $member->phone ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ $member->email ?? 'N/A' }}</p>
        <p><strong>Address:</strong> {{ $member->address ?? 'N/A' }}</p>
        <div class="mt-4 flex space-x-4">
            <a href="{{ route('members') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Back to Members</a>
            <a href="{{ route('members.edit', $member->id) }}" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Edit</a>
        </div>
    </div>
</body>
</html>