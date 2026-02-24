<?php

namespace App\Http\Controllers;

use App\Services\MailerLiteService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    public function __construct(
        private MailerLiteService $mailerLite
    ) {}

    /**
     * Handle newsletter subscription from footer form
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function subscribe(Request $request): JsonResponse
    {
        // Validate email format
        $validated = $request->validate([
            'email' => ['required', 'email:rfc', 'max:255'],
        ], [
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email address is too long.',
        ]);

        $email = $validated['email'];

        Log::channel('mailerlite')->info('Footer subscription attempt', [
            'email' => $this->redactEmail($email),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        try {
            // Check if already subscribed
            $existingSubscriber = $this->mailerLite->getSubscriber($email);
            
            if ($existingSubscriber !== null) {
                Log::channel('mailerlite')->info('Footer subscription - already subscribed', [
                    'email' => $this->redactEmail($email),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'You are already subscribed to our newsletter.',
                ], 200);
            }

            // Subscribe to MailerLite
            $this->mailerLite->subscribe($email);

            Log::channel('mailerlite')->info('Footer subscription successful', [
                'email' => $this->redactEmail($email),
                'source' => 'footer_form',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for subscribing! You will receive our weekly sermons and updates.',
            ], 200);

        } catch (\Exception $e) {
            Log::channel('mailerlite')->error('Footer subscription failed', [
                'email' => $this->redactEmail($email),
                'error' => $e->getMessage(),
                'exception_class' => get_class($e),
                'source' => 'footer_form',
            ]);

            // Return user-friendly error message
            $errorMessage = $this->getUserFriendlyErrorMessage($e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $errorMessage,
            ], 500);
        }
    }

    /**
     * Handle unsubscribe request
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function unsubscribe(Request $request): RedirectResponse
    {
        // Validate email
        $validated = $request->validate([
            'email' => ['required', 'email:rfc', 'max:255'],
        ]);

        $email = $validated['email'];

        Log::channel('mailerlite')->info('Website unsubscription attempt', [
            'email' => $this->redactEmail($email),
            'ip_address' => $request->ip(),
        ]);

        try {
            // Unsubscribe from MailerLite
            $this->mailerLite->unsubscribe($email);

            Log::channel('mailerlite')->info('Website unsubscription successful', [
                'email' => $this->redactEmail($email),
                'source' => 'website',
            ]);

            return redirect()->route('newsletter.unsubscribe.confirm', ['email' => $email])
                ->with('success', 'You have been successfully unsubscribed from our newsletter.');

        } catch (\Exception $e) {
            Log::channel('mailerlite')->error('Website unsubscription failed', [
                'email' => $this->redactEmail($email),
                'error' => $e->getMessage(),
                'exception_class' => get_class($e),
                'source' => 'website',
            ]);

            return back()->with('error', 'Unable to process your unsubscribe request. Please try again later.');
        }
    }

    /**
     * Show unsubscribe confirmation page
     * 
     * @param string $email
     * @return View
     */
    public function confirmUnsubscribe(string $email): View
    {
        return view('newsletter.unsubscribe', [
            'email' => $email,
        ]);
    }

    /**
     * Convert technical error messages to user-friendly messages
     * 
     * @param string $errorMessage
     * @return string
     */
    private function getUserFriendlyErrorMessage(string $errorMessage): string
    {
        // Check for specific error patterns
        if (str_contains($errorMessage, 'authentication') || str_contains($errorMessage, 'API key')) {
            return 'Email service configuration error. Please contact support.';
        }

        if (str_contains($errorMessage, 'rate limit') || str_contains($errorMessage, 'busy')) {
            return 'Service is busy. Please try again in a few moments.';
        }

        if (str_contains($errorMessage, 'connection') || str_contains($errorMessage, 'connect')) {
            return 'Unable to connect to email service. Please try again later.';
        }

        if (str_contains($errorMessage, 'validation') || str_contains($errorMessage, 'invalid')) {
            return 'Please check your email address and try again.';
        }

        // Default error message
        return 'Unable to process your subscription. Please try again later.';
    }

    /**
     * Redact email address for logging (keep first 3 chars and domain)
     *
     * @param string $email
     * @return string
     */
    private function redactEmail(string $email): string
    {
        if (strpos($email, '@') !== false) {
            [$local, $domain] = explode('@', $email, 2);
            return substr($local, 0, 3) . '***@' . $domain;
        }
        return substr($email, 0, 3) . '***';
    }
}
