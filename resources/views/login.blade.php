<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Login - St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body{font-family:Inter,system-ui,-apple-system,'Segoe UI',Roboto,'Helvetica Neue',Arial}</style>
</head>
<body class="min-h-screen bg-gradient-to-b from-[#f8fafc] to-white flex items-center justify-center p-6">
    <div class="w-full max-w-md">
        <div class="bg-white border border-gray-100 rounded-2xl shadow-lg overflow-hidden">
            <div class="px-8 py-10">
                <div class="flex items-center gap-3 mb-6">
                    <img src="/assets/Logo Final.png" alt="St John's Logo" class="h-12 w-auto">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Admin Portal</h1>
                        <p class="text-sm text-gray-500">Sign in to manage members, events and services</p>
                    </div>
                </div>

                {{-- Validation errors --}}
                @if ($errors->any())
                    <div class="mb-4 p-3 rounded bg-red-50 border border-red-100 text-red-700 text-sm">
                        <ul class="list-disc ml-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/login') }}" method="POST" class="space-y-4" novalidate>
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input id="email" name="email" type="email" required autofocus value="{{ old('email') }}"
                            class="w-full px-4 py-3 border rounded-lg bg-white border-gray-200 text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-indigo-200 focus:outline-none" placeholder="admin@stjohns.local">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" name="password" type="password" required
                            class="w-full px-4 py-3 border rounded-lg bg-white border-gray-200 text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-indigo-200 focus:outline-none" placeholder="••••••••">
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-indigo-600">
                            <span class="text-gray-600">Remember me</span>
                        </label>
                        <a href="#" class="text-indigo-600 hover:underline">Forgot password?</a>
                    </div>

                    <div>
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-200">
                            Sign in
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center text-sm text-gray-600">
                    <span>Back to</span>
                    <a href="{{ route('home') }}" class="text-indigo-600 hover:underline ml-1">Homepage</a>
                </div>
            </div>
        </div>

        <p class="mt-4 text-xs text-center text-gray-500">Only authorized staff may access the admin portal.</p>
    </div>
</body>
</html>
