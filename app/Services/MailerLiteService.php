<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\ConnectionException;

class MailerLiteService
{
    private string $apiKey;
    private string $groupId;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('mailerlite.api_key');
        $this->groupId = config('mailerlite.group_id');
        $this->baseUrl = config('mailerlite.api_base_url');

        if (empty($this->apiKey) || empty($this->groupId)) {
            Log::error('MailerLite configuration missing', [
                'has_api_key' => !empty($this->apiKey),
                'has_group_id' => !empty($this->groupId),
            ]);
        }
    }

    /**
     * Subscribe an email address to the MailerLite group
     *
     * @param string $email
     * @param array $fields Additional custom fields (e.g., ['name' => 'John', 'member_status' => 'member'])
     * @return bool
     */
    public function subscribe(string $email, array $fields = []): bool
    {
        $operationId = uniqid('sub_', true);

        Log::channel('mailerlite')->info('Subscription operation started', [
            'operation_id' => $operationId,
            'email' => $this->redactEmail($email),
            'has_custom_fields' => !empty($fields),
            'field_keys' => array_keys($fields),
            'field_values' => $fields, // Log actual values to debug
        ]);

        try {
            $data = [
                'email' => $email,
                'fields' => $fields,
            ];

            $response = $this->makeRequest('POST', "groups/{$this->groupId}/subscribers", $data);

            Log::channel('mailerlite')->info('Subscription operation successful', [
                'operation_id' => $operationId,
                'email' => $this->redactEmail($email),
                'subscriber_id' => $response['id'] ?? null,
            ]);

            return true;
        } catch (\Exception $e) {
            Log::channel('mailerlite')->error('Subscription operation failed', [
                'operation_id' => $operationId,
                'email' => $this->redactEmail($email),
                'fields_attempted' => $fields,
                'error' => $e->getMessage(),
                'exception_class' => get_class($e),
            ]);
            throw $e;
        }
    }

    /**
     * Unsubscribe an email address from the MailerLite group
     *
     * @param string $email
     * @return bool
     */
    public function unsubscribe(string $email): bool
    {
        $operationId = uniqid('unsub_', true);

        Log::channel('mailerlite')->info('Unsubscription operation started', [
            'operation_id' => $operationId,
            'email' => $this->redactEmail($email),
        ]);

        try {
            $this->makeRequest('DELETE', "subscribers/{$email}");

            Log::channel('mailerlite')->info('Unsubscription operation successful', [
                'operation_id' => $operationId,
                'email' => $this->redactEmail($email),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::channel('mailerlite')->error('Unsubscription operation failed', [
                'operation_id' => $operationId,
                'email' => $this->redactEmail($email),
                'error' => $e->getMessage(),
                'exception_class' => get_class($e),
            ]);
            throw $e;
        }
    }

    /**
     * Get subscriber details by email
     *
     * @param string $email
     * @return array|null
     */
    public function getSubscriber(string $email): ?array
    {
        $operationId = uniqid('get_', true);

        Log::channel('mailerlite')->info('Get subscriber operation started', [
            'operation_id' => $operationId,
            'email' => $this->redactEmail($email),
        ]);

        try {
            $response = $this->makeRequest('GET', "subscribers/{$email}");

            Log::channel('mailerlite')->info('Get subscriber operation successful', [
                'operation_id' => $operationId,
                'email' => $this->redactEmail($email),
                'subscriber_found' => true,
            ]);

            return $response;
        } catch (\Exception $e) {
            // If subscriber not found (404), return null instead of throwing
            if (str_contains($e->getMessage(), '404') || str_contains($e->getMessage(), 'not found')) {
                Log::channel('mailerlite')->info('Get subscriber operation - subscriber not found', [
                    'operation_id' => $operationId,
                    'email' => $this->redactEmail($email),
                ]);
                return null;
            }
            
            Log::channel('mailerlite')->error('Get subscriber operation failed', [
                'operation_id' => $operationId,
                'email' => $this->redactEmail($email),
                'error' => $e->getMessage(),
                'exception_class' => get_class($e),
            ]);
            throw $e;
        }
    }

    /**
     * Get all subscribers from the MailerLite group with pagination
     *
     * @param int $limit Number of subscribers per page (max 1000)
     * @param int $offset Offset for pagination
     * @return array
     */
    public function getAllSubscribers(int $limit = 100, int $offset = 0): array
    {
        $operationId = uniqid('getall_', true);

        Log::channel('mailerlite')->info('Get all subscribers operation started', [
            'operation_id' => $operationId,
            'limit' => $limit,
            'offset' => $offset,
        ]);

        try {
            $response = $this->makeRequest('GET', "groups/{$this->groupId}/subscribers", [
                'limit' => min($limit, 1000), // MailerLite max is 1000
                'offset' => $offset,
            ]);

            // Transform fields array from MailerLite format to associative array
            if (is_array($response)) {
                foreach ($response as &$subscriber) {
                    if (isset($subscriber['fields']) && is_array($subscriber['fields'])) {
                        $transformedFields = [];
                        foreach ($subscriber['fields'] as $field) {
                            if (isset($field['key']) && isset($field['value'])) {
                                $transformedFields[$field['key']] = $field['value'];
                            }
                        }
                        $subscriber['fields'] = $transformedFields;
                    }
                }
                unset($subscriber); // Break reference
            }

            $subscriberCount = is_array($response) ? count($response) : 0;

            Log::channel('mailerlite')->info('Get all subscribers operation successful', [
                'operation_id' => $operationId,
                'limit' => $limit,
                'offset' => $offset,
                'subscribers_returned' => $subscriberCount,
            ]);

            return $response;
        } catch (\Exception $e) {
            Log::channel('mailerlite')->error('Get all subscribers operation failed', [
                'operation_id' => $operationId,
                'limit' => $limit,
                'offset' => $offset,
                'error' => $e->getMessage(),
                'exception_class' => get_class($e),
            ]);
            throw $e;
        }
    }

    /**
     * Get the total count of subscribers in the group
     *
     * @return int
     */
    public function getSubscriberCount(): int
    {
        $operationId = uniqid('count_', true);

        Log::channel('mailerlite')->info('Get subscriber count operation started', [
            'operation_id' => $operationId,
        ]);

        try {
            $response = $this->makeRequest('GET', "groups/{$this->groupId}");
            $count = $response['total'] ?? 0;

            Log::channel('mailerlite')->info('Get subscriber count operation successful', [
                'operation_id' => $operationId,
                'count' => $count,
            ]);

            return $count;
        } catch (\Exception $e) {
            Log::channel('mailerlite')->error('Get subscriber count operation failed', [
                'operation_id' => $operationId,
                'error' => $e->getMessage(),
                'exception_class' => get_class($e),
            ]);
            throw $e;
        }
    }

    /**
     * Update subscriber custom fields
     *
     * @param string $email
     * @param array $fields Custom fields to update
     * @return bool
     */
    public function updateSubscriber(string $email, array $fields): bool
    {
        $operationId = uniqid('update_', true);

        Log::channel('mailerlite')->info('Update subscriber operation started', [
            'operation_id' => $operationId,
            'email' => $this->redactEmail($email),
            'field_keys' => array_keys($fields),
        ]);

        try {
            $data = [
                'fields' => $fields,
            ];

            $this->makeRequest('PUT', "subscribers/{$email}", $data);

            Log::channel('mailerlite')->info('Update subscriber operation successful', [
                'operation_id' => $operationId,
                'email' => $this->redactEmail($email),
                'fields_updated' => array_keys($fields),
            ]);

            return true;
        } catch (\Exception $e) {
            Log::channel('mailerlite')->error('Update subscriber operation failed', [
                'operation_id' => $operationId,
                'email' => $this->redactEmail($email),
                'error' => $e->getMessage(),
                'exception_class' => get_class($e),
            ]);
            throw $e;
        }
    }

    /**
     * Make an HTTP request to the MailerLite API with comprehensive error handling
     *
     * @param string $method HTTP method (GET, POST, PUT, DELETE)
     * @param string $endpoint API endpoint (without base URL)
     * @param array $data Request data
     * @return array Response data
     * @throws \Exception
     */
    private function makeRequest(string $method, string $endpoint, array $data = []): array
    {
        // Validate configuration
        if (empty($this->apiKey)) {
            Log::channel('mailerlite')->critical('MailerLite API key is not configured');
            throw new \Exception('MailerLite API key is not configured');
        }

        if (empty($this->groupId) && str_contains($endpoint, '{$this->groupId}')) {
            Log::channel('mailerlite')->critical('MailerLite group ID is not configured');
            throw new \Exception('MailerLite group ID is not configured');
        }

        $url = $this->baseUrl . $endpoint;
        $requestId = uniqid('ml_', true);

        // Log API request (with sensitive data redacted)
        Log::channel('mailerlite')->info('MailerLite API request initiated', [
            'request_id' => $requestId,
            'method' => $method,
            'endpoint' => $endpoint,
            'data' => $this->redactSensitiveData($data),
        ]);

        try {
            $request = Http::withHeaders([
                'X-MailerLite-ApiKey' => $this->apiKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]);

            // Add timeout to prevent hanging requests
            $request = $request->timeout(30);

            // Make the request based on method
            $response = match (strtoupper($method)) {
                'GET' => $request->get($url, $data),
                'POST' => $request->post($url, $data),
                'PUT' => $request->put($url, $data),
                'DELETE' => $request->delete($url, $data),
                default => throw new \Exception("Unsupported HTTP method: {$method}"),
            };

            // Handle different HTTP status codes
            if ($response->successful()) {
                // Log successful API response
                Log::channel('mailerlite')->info('MailerLite API request successful', [
                    'request_id' => $requestId,
                    'method' => $method,
                    'endpoint' => $endpoint,
                    'status_code' => $response->status(),
                    'response_size' => strlen($response->body()),
                ]);

                return $response->json() ?? [];
            }

            // Handle specific error cases
            $statusCode = $response->status();
            $errorBody = $response->json();
            $errorMessage = $errorBody['error']['message'] ?? $response->body();

            // Log API error response
            Log::channel('mailerlite')->error('MailerLite API request failed', [
                'request_id' => $requestId,
                'method' => $method,
                'endpoint' => $endpoint,
                'status_code' => $statusCode,
                'error_message' => $errorMessage,
                'error_body' => $this->redactSensitiveData($errorBody),
            ]);

            switch ($statusCode) {
                case 400:
                case 422:
                    // Validation error
                    Log::channel('mailerlite')->warning('MailerLite validation error', [
                        'request_id' => $requestId,
                        'endpoint' => $endpoint,
                        'error' => $errorMessage,
                        'full_error_body' => $errorBody,
                        'request_data' => $this->redactSensitiveData($data),
                    ]);
                    throw new \Exception("Validation error: {$errorMessage}");
                
                case 401:
                    // Authentication error
                    Log::channel('mailerlite')->critical('MailerLite authentication failed', [
                        'request_id' => $requestId,
                        'api_key_prefix' => substr($this->apiKey, 0, 4) . '...',
                    ]);
                    throw new \Exception('Email service authentication failed. Please contact support.');
                
                case 404:
                    // Resource not found
                    Log::channel('mailerlite')->info('MailerLite resource not found', [
                        'request_id' => $requestId,
                        'endpoint' => $endpoint,
                    ]);
                    throw new \Exception("Resource not found: {$errorMessage}");
                
                case 429:
                    // Rate limiting
                    $retryAfter = $response->header('Retry-After') ?? 60;
                    Log::channel('mailerlite')->warning('MailerLite rate limit reached', [
                        'request_id' => $requestId,
                        'endpoint' => $endpoint,
                        'retry_after' => $retryAfter,
                    ]);
                    throw new \Exception("Service is busy. Please try again in {$retryAfter} seconds.");
                
                case 500:
                case 502:
                case 503:
                case 504:
                    // Server errors
                    Log::channel('mailerlite')->error('MailerLite server error', [
                        'request_id' => $requestId,
                        'endpoint' => $endpoint,
                        'status_code' => $statusCode,
                        'error' => $errorMessage,
                    ]);
                    throw new \Exception('Email service is temporarily unavailable. Please try again later.');
                
                default:
                    Log::channel('mailerlite')->error('MailerLite unexpected error', [
                        'request_id' => $requestId,
                        'endpoint' => $endpoint,
                        'status_code' => $statusCode,
                        'error' => $errorMessage,
                    ]);
                    throw new \Exception("API request failed with status {$statusCode}: {$errorMessage}");
            }

        } catch (ConnectionException $e) {
            // Network/connection errors
            Log::channel('mailerlite')->error('MailerLite connection error', [
                'request_id' => $requestId,
                'endpoint' => $endpoint,
                'error' => $e->getMessage(),
                'exception_class' => get_class($e),
            ]);
            throw new \Exception('Unable to connect to email service. Please try again later.');
        } catch (RequestException $e) {
            // HTTP request errors
            Log::channel('mailerlite')->error('MailerLite request error', [
                'request_id' => $requestId,
                'endpoint' => $endpoint,
                'error' => $e->getMessage(),
                'exception_class' => get_class($e),
            ]);
            throw $e;
        }
    }

    /**
     * Redact sensitive data from logs
     *
     * @param mixed $data
     * @return mixed
     */
    private function redactSensitiveData($data)
    {
        if (!is_array($data)) {
            return $data;
        }

        $redacted = $data;

        // Redact email addresses partially (keep first 3 chars and domain)
        if (isset($redacted['email'])) {
            if (is_string($redacted['email'])) {
                $redacted['email'] = $this->redactEmail($redacted['email']);
            } elseif (is_array($redacted['email'])) {
                // Handle case where email is an array (shouldn't happen but be defensive)
                $redacted['email'] = '[email_array]';
            }
        }

        // Recursively redact nested arrays
        foreach ($redacted as $key => $value) {
            if (is_array($value)) {
                $redacted[$key] = $this->redactSensitiveData($value);
            }
        }

        return $redacted;
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
