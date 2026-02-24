<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Services\MailerLiteService;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Handle profile image upload if member exists
        if ($request->hasFile('profile_image') && $user->member) {
            $file = $request->file('profile_image');
            
            try {
                // Generate unique filename
                $filename = 'member_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                
                // Try to upload to Supabase first
                $path = $file->storeAs('members', $filename, 'supabase');
                $user->member->update(['profile_image' => $path]);
                
                \Log::info('Profile image uploaded to Supabase successfully', ['path' => $path]);
                
            } catch (\Exception $e) {
                \Log::error('Error uploading profile image to Supabase', [
                    'error' => $e->getMessage(),
                    'file' => $file->getClientOriginalName()
                ]);
                
                // Fall back to local storage if Supabase fails
                try {
                    $path = $file->store('members', 'public');
                    $user->member->update(['profile_image' => $path]);
                    \Log::info('Profile image uploaded to local storage as fallback', ['path' => $path]);
                } catch (\Exception $localError) {
                    \Log::error('Both Supabase and local storage failed', [
                        'supabase_error' => $e->getMessage(),
                        'local_error' => $localError->getMessage()
                    ]);
                }
            }
        }

        // Handle phone number update if provided and member exists
        if ($request->has('phone') && $user->member) {
            $user->member->update(['phone' => $request->phone]);
        }

        // Return JSON for AJAX requests
        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!'
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Return JSON for AJAX requests
        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Account deleted successfully.'
            ]);
        }

        return Redirect::to('/');
    }

    /**
     * Toggle newsletter subscription for the user's member profile.
     */
    public function toggleNewsletterSubscription(Request $request): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $user = $request->user();

        // Check if user has a member profile
        if (!$user->member) {
            if ($request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You need to have a member profile to manage newsletter subscriptions.'
                ], 400);
            }
            return Redirect::back()
                ->with('newsletter-error', 'You need to have a member profile to manage newsletter subscriptions.');
        }

        $member = $user->member;

        // Check if member has an email
        if (empty($member->email)) {
            if ($request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You need to have an email address to subscribe to the newsletter.'
                ], 400);
            }
            return Redirect::back()
                ->with('newsletter-error', 'You need to have an email address to subscribe to the newsletter.');
        }

        // Get the subscription preference from the request
        $subscribe = $request->boolean('newsletter_subscribe');

        try {
            $mailerLite = app(MailerLiteService::class);

            if ($subscribe) {
                // Subscribe to MailerLite
                $mailerLite->subscribe($member->email, [
                    'name' => $member->full_name,
                    'member_status' => 'member',
                ]);

                // Update member record
                $member->subscribeToNewsletter();

                Log::info('Member subscribed to newsletter via profile', [
                    'member_id' => $member->id,
                    'email' => $member->email,
                ]);

                if ($request->wantsJson() || $request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Successfully subscribed to the newsletter!'
                    ]);
                }
                return Redirect::back()
                    ->with('newsletter-success', 'Successfully subscribed to the newsletter!');
            } else {
                // Unsubscribe from MailerLite
                $mailerLite->unsubscribe($member->email);

                // Update member record
                $member->unsubscribeFromNewsletter();

                Log::info('Member unsubscribed from newsletter via profile', [
                    'member_id' => $member->id,
                    'email' => $member->email,
                ]);

                if ($request->wantsJson() || $request->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Successfully unsubscribed from the newsletter.'
                    ]);
                }
                return Redirect::back()
                    ->with('newsletter-success', 'Successfully unsubscribed from the newsletter.');
            }
        } catch (\Exception $e) {
            Log::error('Failed to toggle newsletter subscription via profile', [
                'member_id' => $member->id,
                'email' => $member->email,
                'subscribe' => $subscribe,
                'error' => $e->getMessage(),
            ]);

            if ($request->wantsJson() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update newsletter subscription. Please try again later.'
                ], 500);
            }
            return Redirect::back()
                ->with('newsletter-error', 'Failed to update newsletter subscription. Please try again later.');
        }
    }
}
