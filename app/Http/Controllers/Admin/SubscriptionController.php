<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MailerLiteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function __construct(private MailerLiteService $mailerLite)
    {
    }

    /**
     * Display all subscribers from MailerLite with search and pagination
     */
    public function index(Request $request)
    {
        try {
            // Get pagination parameters
            $perPage = 20;
            $page = $request->get('page', 1);
            $offset = ($page - 1) * $perPage;

            // Get search query
            $search = $request->get('search', '');

            // Fetch subscribers from MailerLite
            $allSubscribers = $this->mailerLite->getAllSubscribers(1000, 0);
            
            // Log the structure of the first subscriber for debugging
            if (!empty($allSubscribers)) {
                Log::info('MailerLite subscriber structure', [
                    'first_subscriber' => $allSubscribers[0],
                    'available_keys' => array_keys($allSubscribers[0]),
                ]);
            }
            
            // Get total count from the actual subscribers array
            $totalCount = count($allSubscribers);

            // Filter by search if provided
            if (!empty($search)) {
                $allSubscribers = array_filter($allSubscribers, function($subscriber) use ($search) {
                    return stripos($subscriber['email'] ?? '', $search) !== false;
                });
                $totalCount = count($allSubscribers);
            }

            // Apply pagination manually
            $subscribers = array_slice($allSubscribers, $offset, $perPage);

            // Calculate stats for dashboard
            $subscriberCount = $totalCount;
            $memberCount = 0;
            $visitorCount = 0;
            
            foreach ($allSubscribers as $subscriber) {
                if (isset($subscriber['fields']['member_status']) && $subscriber['fields']['member_status'] === 'member') {
                    $memberCount++;
                } else {
                    $visitorCount++;
                }
            }

            // Calculate pagination data
            $lastPage = ceil($totalCount / $perPage);
            $from = $offset + 1;
            $to = min($offset + $perPage, $totalCount);

            // Create pagination object-like array
            $paginationData = [
                'current_page' => $page,
                'last_page' => $lastPage,
                'per_page' => $perPage,
                'total' => $totalCount,
                'from' => $from,
                'to' => $to,
            ];

            return view('admin.subscribers.index', compact('subscribers', 'paginationData', 'search', 'totalCount', 'subscriberCount', 'memberCount', 'visitorCount'));

        } catch (\Exception $e) {
            Log::error('Error loading subscribers', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('admin.subscribers.index', [
                'subscribers' => [],
                'paginationData' => [
                    'current_page' => 1,
                    'last_page' => 1,
                    'per_page' => 20,
                    'total' => 0,
                    'from' => 0,
                    'to' => 0,
                ],
                'search' => '',
                'totalCount' => 0,
                'subscriberCount' => 0,
                'memberCount' => 0,
                'visitorCount' => 0,
            ])->with('error', 'Error loading subscribers: ' . $e->getMessage());
        }
    }

    /**
     * Manually add a subscriber
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::channel('mailerlite')->warning('Admin add subscriber - validation failed', [
                'email' => $request->email,
                'errors' => $validator->errors()->toArray(),
                'admin_user_id' => auth()->id(),
            ]);

            return redirect()->route('admin.subscribers.index')
                ->with('error', 'Invalid email address provided.');
        }

        try {
            $fields = [];
            if ($request->filled('name')) {
                $fields['name'] = $request->name;
            }

            Log::channel('mailerlite')->info('Admin add subscriber operation started', [
                'email' => $this->redactEmail($request->email),
                'has_name' => $request->filled('name'),
                'admin_user_id' => auth()->id(),
            ]);

            $this->mailerLite->subscribe($request->email, $fields);

            Log::channel('mailerlite')->info('Admin add subscriber operation successful', [
                'email' => $this->redactEmail($request->email),
                'admin_user_id' => auth()->id(),
            ]);

            return redirect()->route('admin.subscribers.index')
                ->with('success', 'Subscriber added successfully.');

        } catch (\Exception $e) {
            Log::channel('mailerlite')->error('Admin add subscriber operation failed', [
                'email' => $this->redactEmail($request->email),
                'error' => $e->getMessage(),
                'exception_class' => get_class($e),
                'admin_user_id' => auth()->id(),
            ]);

            return redirect()->route('admin.subscribers.index')
                ->with('error', 'Failed to add subscriber: ' . $e->getMessage());
        }
    }

    /**
     * Remove a subscriber
     */
    public function destroy(string $email)
    {
        try {
            Log::channel('mailerlite')->info('Admin remove subscriber operation started', [
                'email' => $this->redactEmail($email),
                'admin_user_id' => auth()->id(),
            ]);

            $this->mailerLite->unsubscribe($email);

            Log::channel('mailerlite')->info('Admin remove subscriber operation successful', [
                'email' => $this->redactEmail($email),
                'admin_user_id' => auth()->id(),
            ]);

            return redirect()->route('admin.subscribers.index')
                ->with('success', 'Subscriber removed successfully.');

        } catch (\Exception $e) {
            Log::channel('mailerlite')->error('Admin remove subscriber operation failed', [
                'email' => $this->redactEmail($email),
                'error' => $e->getMessage(),
                'exception_class' => get_class($e),
                'admin_user_id' => auth()->id(),
            ]);

            return redirect()->route('admin.subscribers.index')
                ->with('error', 'Failed to remove subscriber: ' . $e->getMessage());
        }
    }

    /**
     * Export subscribers to CSV
     */
    public function export()
    {
        try {
            Log::channel('mailerlite')->info('Admin export subscribers operation started', [
                'admin_user_id' => auth()->id(),
            ]);

            // Fetch all subscribers
            $subscribers = $this->mailerLite->getAllSubscribers(1000, 0);

            // Create CSV content
            $csvContent = "Email,Name,Status,Subscription Date,Type\n";

            foreach ($subscribers as $subscriber) {
                $email = $subscriber['email'] ?? '';
                $name = $subscriber['fields']['name'] ?? '';
                $status = $subscriber['type'] ?? 'active';
                $date = $subscriber['date_subscribe'] ?? '';
                $type = isset($subscriber['fields']['member_status']) ? 'member' : 'visitor';

                // Escape CSV fields
                $csvContent .= sprintf(
                    '"%s","%s","%s","%s","%s"' . "\n",
                    str_replace('"', '""', $email),
                    str_replace('"', '""', $name),
                    str_replace('"', '""', $status),
                    str_replace('"', '""', $date),
                    str_replace('"', '""', $type)
                );
            }

            // Generate filename with timestamp
            $filename = 'subscribers_' . date('Y-m-d_His') . '.csv';

            Log::channel('mailerlite')->info('Admin export subscribers operation successful', [
                'admin_user_id' => auth()->id(),
                'subscriber_count' => count($subscribers),
                'filename' => $filename,
            ]);

            // Return CSV download response
            return response($csvContent)
                ->header('Content-Type', 'text/csv')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

        } catch (\Exception $e) {
            Log::channel('mailerlite')->error('Admin export subscribers operation failed', [
                'error' => $e->getMessage(),
                'exception_class' => get_class($e),
                'admin_user_id' => auth()->id(),
            ]);

            return redirect()->route('admin.subscribers.index')
                ->with('error', 'Failed to export subscribers: ' . $e->getMessage());
        }
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
