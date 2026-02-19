@extends('layouts.dashboard_layout')

@section('title', 'QR Code Generator')
@section('header_title', 'QR Code Generator')

@section('content')
<div class="space-y-6">

    <!-- QR Code Generator Header – Compact & Sacred -->
    <div class="bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 p-5 lg:p-6 mb-8 lg:mb-10">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold text-primary dark:text-text-dark flex items-center gap-3">
                    <svg class="h-8 w-8 text-accent group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 16h4.01M12 8h4.01M8 12h.01M16 8h.01M8 16h.01M8 8h.01M12 16h.01" />
                    </svg>
                    QR Code Generator
                </h1>
                <p class="text-sm text-gray-600 dark:text-text-muted-dark mt-1.5">
                    Generate QR codes for member registration, events, giving, and custom links
                </p>
            </div>

            <!-- Optional quick tip or status -->
            <div class="text-right text-xs text-gray-500 dark:text-text-muted-dark">
                <span class="inline-flex items-center gap-1.5">
                    <svg class="h-4 w-4 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Scan with phone camera
                </span>
            </div>
        </div>
    </div>

    <!-- QR Code Types – Compact, Modern & Sacred -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-6 mb-8 lg:mb-10">
        <!-- Member Registration QR -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 border-primary/50 dark:hover:border-primary/60 hover:shadow-md hover:-translate-y-1 transition-all duration-200 overflow-hidden">
            <div class="p-5 lg:p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-primary/10 dark:bg-primary/20 rounded-lg group-hover:bg-primary/20 dark:group-hover:bg-primary/30 transition-colors">
                        <svg class="h-7 w-7 text-primary dark:text-text-dark group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-primary dark:text-text-dark group-hover:text-accent transition-colors">
                        Member Registration
                    </h3>
                </div>
                <p class="text-sm text-gray-600 dark:text-text-muted-dark mb-4">New member sign-up</p>
                <button onclick="openMemberRegistrationModal()" 
                        class="w-full bg-primary hover:bg-secondary text-white px-4 py-2.5 rounded-lg font-medium transition-all duration-300 shadow-sm hover:shadow flex items-center justify-center gap-2 text-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Generate QR
                </button>
            </div>
        </div>

        <!-- Event Registration QR -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 border-accent/50 dark:hover:border-accent/60 hover:shadow-md hover:-translate-y-1 transition-all duration-200 overflow-hidden">
            <div class="p-5 lg:p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-accent/10 dark:bg-accent/20 rounded-lg group-hover:bg-accent/20 dark:group-hover:bg-accent/30 transition-colors">
                        <svg class="h-7 w-7 text-accent group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a2 2 0 100-4 2 2 0 000 4zm0 0v3m-3-3h6m-6 0H3m15 0h3" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-accent group-hover:text-primary transition-colors">
                        Event Registration
                    </h3>
                </div>
                <p class="text-sm text-gray-600 dark:text-text-muted-dark mb-4">Specific events</p>
                <button onclick="openEventRegistrationModal()" 
                        class="w-full bg-accent hover:bg-secondary text-primary hover:text-white px-4 py-2.5 rounded-lg font-medium transition-all duration-300 shadow-sm hover:shadow flex items-center justify-center gap-2 text-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Generate QR
                </button>
            </div>
        </div>

        <!-- Giving/Donations QR -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 border-secondary/50 dark:hover:border-secondary/60 hover:shadow-md hover:-translate-y-1 transition-all duration-200 overflow-hidden">
            <div class="p-5 lg:p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-secondary/10 dark:bg-secondary/20 rounded-lg group-hover:bg-secondary/20 dark:group-hover:bg-secondary/30 transition-colors">
                        <svg class="h-7 w-7 text-secondary group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-secondary group-hover:text-primary transition-colors">
                        Giving & Donations
                    </h3>
                </div>
                <p class="text-sm text-gray-600 dark:text-text-muted-dark mb-4">Tithes & offerings</p>
                <button onclick="openGivingModal()" 
                        class="w-full bg-secondary hover:bg-accent text-white px-4 py-2.5 rounded-lg font-medium transition-all duration-300 shadow-sm hover:shadow flex items-center justify-center gap-2 text-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                    </svg>
                    Generate QR
                </button>
            </div>
        </div>

        <!-- Custom URL QR -->
        <div class="group bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 hover:border-accent/50 dark:hover:border-accent/60 hover:shadow-md hover:-translate-y-1 transition-all duration-200 overflow-hidden">
            <div class="p-5 lg:p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="p-3 bg-accent/10 dark:bg-accent/20 rounded-lg group-hover:bg-accent/20 dark:group-hover:bg-accent/30 transition-colors">
                        <svg class="h-7 w-7 text-accent group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-accent group-hover:text-primary transition-colors">
                        Custom URL
                    </h3>
                </div>
                <p class="text-sm text-gray-600 dark:text-text-muted-dark mb-4">Any custom link</p>
                <button onclick="openCustomModal()" 
                        class="w-full bg-accent hover:bg-secondary text-primary hover:text-white px-4 py-2.5 rounded-lg font-medium transition-all duration-300 shadow-sm hover:shadow flex items-center justify-center gap-2 text-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                    Generate QR
                </button>
            </div>
        </div>
    </div>

    <!-- Recent QR Codes – Compact & Modern -->
    <div class="bg-white dark:bg-background-dark rounded-xl shadow border border-gray-200/70 dark:border-gray-700 p-5 lg:p-6 mb-8 lg:mb-10 overflow-hidden">
        <h2 class="text-lg font-semibold text-primary dark:text-text-dark mb-4 flex items-center gap-2">
            <svg class="h-5 w-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 16h4.01M12 8h4.01M8 12h.01M16 8h.01M8 16h.01M8 8h.01M12 16h.01" />
            </svg>
            Recent QR Codes
        </h2>

        <div id="recent-qr-codes" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-5">
            <div class="group text-center text-gray-500 dark:text-text-muted-dark py-8 bg-gray-50/50 dark:bg-gray-800/30 rounded-lg border border-gray-200/70 dark:border-gray-700 hover:border-accent/50 dark:hover:border-accent/60 hover:shadow-md hover:-translate-y-1 transition-all duration-200">
                <svg class="h-10 w-10 mx-auto mb-4 text-gray-300 dark:text-gray-600 group-hover:text-accent transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 16h4.01M12 8h4.01M8 12h.01M16 8h.01M8 16h.01M8 8h.01M12 16h.01" />
                </svg>
                <p class="font-medium mb-1">No QR codes generated yet</p>
                <p class="text-sm">Start by using one of the options above</p>
            </div>
            <!-- Generated QR cards will be appended here via JS -->
        </div>
    </div>
    
</div>

<!-- Member Registration Modal -->
<div id="member-registration-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Generate Member Registration QR Code</h3>
                <button onclick="closeMemberRegistrationModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="member-registration-form" class="p-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                        <input type="text" name="title" value="Join Our Church" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="2" placeholder="Scan to register as a member"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Size (px)</label>
                            <input type="number" name="size" value="300" min="100" max="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Format</label>
                            <select name="format" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="svg">SVG (Recommended)</option>
                                <option value="png">PNG</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeMemberRegistrationModal()" 
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Generate QR Code
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Event Registration Modal -->
<div id="event-registration-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Generate Event Registration QR Code</h3>
                <button onclick="closeEventRegistrationModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="event-registration-form" class="p-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Event *</label>
                        <select name="event_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Select an event</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}">{{ $event->title }} - {{ $event->date->format('M d, Y') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" placeholder="Will auto-fill based on event"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="2" placeholder="Scan to register for this event"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Size (px)</label>
                            <input type="number" name="size" value="300" min="100" max="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Format</label>
                            <select name="format" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="svg">SVG (Recommended)</option>
                                <option value="png">PNG</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeEventRegistrationModal()" 
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        Cancel
                    </button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                        Generate QR Code
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Giving Modal -->
<div id="giving-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Generate Giving QR Code</h3>
                <button onclick="closeGivingModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="giving-form" class="p-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                        <input type="text" name="title" value="Give to Our Church" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="2" placeholder="Scan to make a donation or tithe"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Size (px)</label>
                            <input type="number" name="size" value="300" min="100" max="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Format</label>
                            <select name="format" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="svg">SVG (Recommended)</option>
                                <option value="png">PNG</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeGivingModal()" 
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        Cancel
                    </button>
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md">
                        Generate QR Code
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Custom URL Modal -->
<div id="custom-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Generate Custom QR Code</h3>
                <button onclick="closeCustomModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="custom-form" class="p-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">URL *</label>
                        <input type="url" name="url" required placeholder="https://example.com"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                        <input type="text" name="title" required placeholder="Custom Link"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="2" placeholder="Scan to visit this link"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Size (px)</label>
                            <input type="number" name="size" value="300" min="100" max="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Format</label>
                            <select name="format" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500">
                                <option value="svg">SVG (Recommended)</option>
                                <option value="png">PNG</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeCustomModal()" 
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        Cancel
                    </button>
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md">
                        Generate QR Code
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- QR Code Preview Modal -->
<div id="qr-preview-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">QR Code Generated</h3>
                <button onclick="closeQRPreviewModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 text-center">
                <div id="qr-preview-content">
                    <!-- QR code will be inserted here -->
                </div>
                <div id="qr-info" class="mt-4 text-sm text-gray-600">
                    <!-- QR code info will be inserted here -->
                </div>
                <div class="mt-6 flex justify-center space-x-3">
                    <button id="download-qr-btn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Download QR Code
                    </button>
                    <button onclick="closeQRPreviewModal()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Modal functions
function openMemberRegistrationModal() {
    document.getElementById('member-registration-modal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeMemberRegistrationModal() {
    document.getElementById('member-registration-modal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

function openEventRegistrationModal() {
    document.getElementById('event-registration-modal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeEventRegistrationModal() {
    document.getElementById('event-registration-modal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

function openGivingModal() {
    document.getElementById('giving-modal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeGivingModal() {
    document.getElementById('giving-modal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

function openCustomModal() {
    document.getElementById('custom-modal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeCustomModal() {
    document.getElementById('custom-modal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

function closeQRPreviewModal() {
    document.getElementById('qr-preview-modal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

// Auto-fill event title when event is selected
document.querySelector('select[name="event_id"]').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const titleInput = document.querySelector('#event-registration-form input[name="title"]');
    
    if (selectedOption.value) {
        const eventTitle = selectedOption.text.split(' - ')[0];
        titleInput.value = `Register for ${eventTitle}`;
    } else {
        titleInput.value = '';
    }
});

// Form submission handlers
document.getElementById('member-registration-form').addEventListener('submit', function(e) {
    e.preventDefault();
    generateQRCode('member-registration', new FormData(this));
});

document.getElementById('event-registration-form').addEventListener('submit', function(e) {
    e.preventDefault();
    generateQRCode('event-registration', new FormData(this));
});

document.getElementById('giving-form').addEventListener('submit', function(e) {
    e.preventDefault();
    generateQRCode('giving', new FormData(this));
});

document.getElementById('custom-form').addEventListener('submit', function(e) {
    e.preventDefault();
    generateQRCode('custom', new FormData(this));
});

// Generate QR Code function
function generateQRCode(type, formData) {
    const endpoints = {
        'member-registration': '{{ route("qr-codes.generate.member") }}',
        'event-registration': '{{ route("qr-codes.generate.event") }}',
        'giving': '{{ route("qr-codes.generate.giving") }}',
        'custom': '{{ route("qr-codes.generate.custom") }}'
    };

    // Show loading state
    showLoadingState();

    fetch(endpoints[type], {
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
        if (data.success) {
            console.log('QR Code generated successfully:', data); // Debug log
            showQRCodePreview(data);
            closeAllModals();
            addToRecentQRCodes(data);
        } else {
            showErrorNotification(data.message || 'Failed to generate QR code');
        }
    })
    .catch(error => {
        console.error('Error generating QR code:', error);
        showErrorNotification(error.message || 'Failed to generate QR code');
    })
    .finally(() => {
        hideLoadingState();
    });
}

function showQRCodePreview(data) {
    const modal = document.getElementById('qr-preview-modal');
    const content = document.getElementById('qr-preview-content');
    const info = document.getElementById('qr-info');
    const downloadBtn = document.getElementById('download-qr-btn');

    // Always use the preview_url for display - this works for both SVG and PNG
    content.innerHTML = `<img src="${data.preview_url}" alt="QR Code" class="mx-auto max-w-xs border-2 border-gray-200 rounded-lg p-4 bg-white">`;

    // Display info
    info.innerHTML = `
        <div class="bg-gray-50 rounded-lg p-4 text-left">
            <h4 class="font-semibold text-gray-900 mb-2">${data.title}</h4>
            ${data.description ? `<p class="text-gray-600 mb-2">${data.description}</p>` : ''}
            <p class="text-sm text-gray-500">Target URL: <a href="${data.target_url}" target="_blank" class="text-blue-600 hover:underline">${data.target_url}</a></p>
            <p class="text-sm text-gray-500">Size: ${data.size}px | Format: ${data.format.toUpperCase()}</p>
        </div>
    `;

    // Set download link
    downloadBtn.onclick = () => window.open(data.download_url, '_blank');

    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function addToRecentQRCodes(data) {
    const container = document.getElementById('recent-qr-codes');
    
    // Remove "no QR codes" message if it exists
    if (container.querySelector('.text-gray-500')) {
        container.innerHTML = '';
    }

    const qrItem = document.createElement('div');
    qrItem.className = 'bg-gray-50 rounded-lg p-4 border';
    
    qrItem.innerHTML = `
        <div class="text-center">
            <div class="mb-3">
                <img src="${data.preview_url}" alt="QR Code" class="w-20 h-20 mx-auto border border-gray-300 rounded bg-white p-1">
            </div>
            <h4 class="font-semibold text-gray-900 text-sm mb-1">${data.title}</h4>
            <p class="text-xs text-gray-500 mb-2">${data.format.toUpperCase()} | ${data.size}px</p>
            <button onclick="window.open('${data.download_url}', '_blank')" 
                    class="text-xs bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded">
                Download
            </button>
        </div>
    `;

    // Add to beginning of container
    container.insertBefore(qrItem, container.firstChild);

    // Keep only last 6 items
    while (container.children.length > 6) {
        container.removeChild(container.lastChild);
    }
}

function closeAllModals() {
    closeMemberRegistrationModal();
    closeEventRegistrationModal();
    closeGivingModal();
    closeCustomModal();
}

function showLoadingState() {
    // You can implement a loading overlay here
}

function hideLoadingState() {
    // Hide loading overlay
}

function showErrorNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 z-50 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded max-w-sm';
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="h-5 w-5 text-red-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 19.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
            <span class="text-sm">${message}</span>
            <button onclick="this.parentNode.parentNode.remove()" class="ml-2 text-red-400 hover:text-red-600">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 5000);
}

// Close modals on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeAllModals();
        closeQRPreviewModal();
    }
});

// Close modals when clicking outside
document.querySelectorAll('[id$="-modal"]').forEach(modal => {
    modal.addEventListener('click', function(event) {
        if (event.target === this) {
            this.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });
});
</script>

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection