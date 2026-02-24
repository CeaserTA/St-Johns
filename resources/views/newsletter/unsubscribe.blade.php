<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Unsubscribe - St. John's Parish Church Entebbe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600&family=Jost:wght@300;400;500;600&family=Material+Symbols+Outlined&display=swap" rel="stylesheet">
    @include('partials.theme-config')
</head>
<body class="font-sans antialiased bg-gray-50">
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Card -->
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <!-- Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <!-- Heading -->
                <h1 class="text-2xl font-bold text-gray-900 mb-3">
                    Successfully Unsubscribed
                </h1>

                <!-- Message -->
                <p class="text-gray-600 mb-6">
                    You have been unsubscribed from our newsletter. You will no longer receive weekly sermons and church updates.
                </p>

                <!-- Email Display (if available) -->
                @if(isset($email))
                    <p class="text-sm text-gray-500 mb-6">
                        Email: <span class="font-medium text-gray-700">{{ $email }}</span>
                    </p>
                @endif

                <!-- Divider -->
                <div class="border-t border-gray-200 my-6"></div>

                <!-- Resubscribe Section -->
                <div class="space-y-4">
                    <p class="text-sm text-gray-600">
                        Changed your mind?
                    </p>

                    <form id="resubscribe-form" class="space-y-3">
                        @csrf
                        <input type="email" 
                               id="resubscribe-email" 
                               name="email" 
                               value="{{ $email ?? '' }}"
                               placeholder="Enter your email address" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent focus:border-accent transition text-sm">
                        
                        <button type="submit"
                                id="resubscribe-button"
                                class="w-full px-6 py-3 bg-accent text-primary font-bold rounded-lg hover:bg-accent/90 transition shadow-md text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                            <span id="resubscribe-button-text">Resubscribe to Newsletter</span>
                            <span id="resubscribe-loading" class="hidden">
                                <svg class="animate-spin h-4 w-4 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Subscribing...
                            </span>
                        </button>
                    </form>

                    <div id="resubscribe-message" class="hidden text-sm mt-2"></div>
                </div>

                <!-- Back to Home -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center gap-2 text-sm font-medium text-primary hover:text-secondary transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Home
                    </a>
                </div>
            </div>

            <!-- Additional Info -->
            <p class="text-center text-xs text-gray-500 mt-6">
                If you have any questions, please contact us at 
                <a href="mailto:info@stjohnsentebbe.org" class="text-primary hover:text-secondary underline">
                    info@stjohnsentebbe.org
                </a>
            </p>
        </div>
    </main>

    @include('partials.footer')

    <!-- Resubscribe Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('resubscribe-form');
        const emailInput = document.getElementById('resubscribe-email');
        const submitButton = document.getElementById('resubscribe-button');
        const buttonText = document.getElementById('resubscribe-button-text');
        const loadingSpinner = document.getElementById('resubscribe-loading');
        const messageDiv = document.getElementById('resubscribe-message');
        
        if (!form) return;
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear previous messages
            messageDiv.classList.add('hidden');
            messageDiv.textContent = '';
            
            // Validate email
            const email = emailInput.value.trim();
            if (!email) {
                showMessage('Please enter your email address', 'error');
                return;
            }
            
            // Basic email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showMessage('Please enter a valid email address', 'error');
                return;
            }
            
            // Show loading state
            setLoadingState(true);
            
            // Get CSRF token
            const csrfToken = document.querySelector('input[name="_token"]').value;
            
            // Submit via AJAX
            fetch('/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                setLoadingState(false);
                
                if (data.success) {
                    showMessage(data.message || 'Successfully resubscribed to our newsletter!', 'success');
                    // Optionally redirect after a delay
                    setTimeout(() => {
                        window.location.href = '{{ route('home') }}';
                    }, 2000);
                } else {
                    showMessage(data.message || 'Failed to resubscribe. Please try again.', 'error');
                }
            })
            .catch(error => {
                setLoadingState(false);
                console.error('Resubscribe error:', error);
                showMessage('An error occurred. Please try again later.', 'error');
            });
        });
        
        function setLoadingState(isLoading) {
            if (isLoading) {
                submitButton.disabled = true;
                buttonText.classList.add('hidden');
                loadingSpinner.classList.remove('hidden');
            } else {
                submitButton.disabled = false;
                buttonText.classList.remove('hidden');
                loadingSpinner.classList.add('hidden');
            }
        }
        
        function showMessage(message, type) {
            messageDiv.textContent = message;
            messageDiv.classList.remove('hidden');
            
            if (type === 'success') {
                messageDiv.classList.remove('text-red-600');
                messageDiv.classList.add('text-green-600', 'font-medium');
            } else {
                messageDiv.classList.remove('text-green-600');
                messageDiv.classList.add('text-red-600', 'font-medium');
            }
        }
    });
    </script>
</body>
</html>
