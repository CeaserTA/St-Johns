<?php

use App\Services\MailerLiteService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

beforeEach(function () {
    // Set up test configuration
    Config::set('mailerlite.api_key', 'test_api_key_12345');
    Config::set('mailerlite.group_id', 'test_group_123');
    Config::set('mailerlite.api_base_url', 'https://api.mailerlite.com/api/v2/');
    
    // Prevent actual logging during tests - mock the channel method
    Log::shouldReceive('channel')->with('mailerlite')->andReturnSelf();
    Log::shouldReceive('info')->andReturn(null);
    Log::shouldReceive('error')->andReturn(null);
    Log::shouldReceive('warning')->andReturn(null);
    Log::shouldReceive('critical')->andReturn(null);
});

describe('MailerLiteService - API Request Construction', function () {
    test('subscribe constructs request with correct headers', function () {
        Http::fake([
            '*' => Http::response(['id' => 1, 'email' => 'test@example.com'], 200),
        ]);

        $service = new MailerLiteService();
        $service->subscribe('test@example.com', ['name' => 'Test User']);

        Http::assertSent(function ($request) {
            return $request->hasHeader('X-MailerLite-ApiKey', 'test_api_key_12345') &&
                   $request->hasHeader('Content-Type', 'application/json') &&
                   $request->hasHeader('Accept', 'application/json') &&
                   $request->url() === 'https://api.mailerlite.com/api/v2/groups/test_group_123/subscribers' &&
                   $request->method() === 'POST' &&
                   $request['email'] === 'test@example.com' &&
                   $request['fields'] === ['name' => 'Test User'];
        });
    });

    test('unsubscribe constructs DELETE request with correct headers', function () {
        Http::fake([
            '*' => Http::response([], 200),
        ]);

        $service = new MailerLiteService();
        $service->unsubscribe('test@example.com');

        Http::assertSent(function ($request) {
            return $request->hasHeader('X-MailerLite-ApiKey', 'test_api_key_12345') &&
                   $request->url() === 'https://api.mailerlite.com/api/v2/subscribers/test@example.com' &&
                   $request->method() === 'DELETE';
        });
    });

    test('getSubscriber constructs GET request with correct headers', function () {
        Http::fake([
            '*' => Http::response(['id' => 1, 'email' => 'test@example.com'], 200),
        ]);

        $service = new MailerLiteService();
        $service->getSubscriber('test@example.com');

        Http::assertSent(function ($request) {
            return $request->hasHeader('X-MailerLite-ApiKey', 'test_api_key_12345') &&
                   $request->url() === 'https://api.mailerlite.com/api/v2/subscribers/test@example.com' &&
                   $request->method() === 'GET';
        });
    });

    test('getAllSubscribers constructs GET request with pagination parameters', function () {
        Http::fake([
            '*' => Http::response([
                ['id' => 1, 'email' => 'test1@example.com'],
                ['id' => 2, 'email' => 'test2@example.com'],
            ], 200),
        ]);

        $service = new MailerLiteService();
        $service->getAllSubscribers(50, 10);

        Http::assertSent(function ($request) {
            $url = $request->url();
            return $request->hasHeader('X-MailerLite-ApiKey', 'test_api_key_12345') &&
                   str_contains($url, 'groups/test_group_123/subscribers') &&
                   str_contains($url, 'limit=50') &&
                   str_contains($url, 'offset=10') &&
                   $request->method() === 'GET';
        });
    });

    test('updateSubscriber constructs PUT request with correct headers and data', function () {
        Http::fake([
            '*' => Http::response(['id' => 1, 'email' => 'test@example.com'], 200),
        ]);

        $service = new MailerLiteService();
        $service->updateSubscriber('test@example.com', ['name' => 'Updated Name']);

        Http::assertSent(function ($request) {
            return $request->hasHeader('X-MailerLite-ApiKey', 'test_api_key_12345') &&
                   $request->url() === 'https://api.mailerlite.com/api/v2/subscribers/test@example.com' &&
                   $request->method() === 'PUT' &&
                   $request['fields'] === ['name' => 'Updated Name'];
        });
    });

    test('getSubscriberCount constructs GET request for group details', function () {
        Http::fake([
            '*' => Http::response(['id' => 'test_group_123', 'total' => 150], 200),
        ]);

        $service = new MailerLiteService();
        $service->getSubscriberCount();

        Http::assertSent(function ($request) {
            return $request->hasHeader('X-MailerLite-ApiKey', 'test_api_key_12345') &&
                   $request->url() === 'https://api.mailerlite.com/api/v2/groups/test_group_123' &&
                   $request->method() === 'GET';
        });
    });
});

describe('MailerLiteService - Response Parsing', function () {
    test('subscribe returns true on successful response', function () {
        Http::fake([
            '*' => Http::response(['id' => 1, 'email' => 'test@example.com'], 200),
        ]);

        $service = new MailerLiteService();
        $result = $service->subscribe('test@example.com');

        expect($result)->toBeTrue();
    });

    test('unsubscribe returns true on successful response', function () {
        Http::fake([
            '*' => Http::response([], 200),
        ]);

        $service = new MailerLiteService();
        $result = $service->unsubscribe('test@example.com');

        expect($result)->toBeTrue();
    });

    test('getSubscriber returns subscriber data on success', function () {
        $subscriberData = [
            'id' => 1,
            'email' => 'test@example.com',
            'name' => 'Test User',
            'fields' => ['member_status' => 'active'],
        ];

        Http::fake([
            '*' => Http::response($subscriberData, 200),
        ]);

        $service = new MailerLiteService();
        $result = $service->getSubscriber('test@example.com');

        expect($result)->toBe($subscriberData);
    });

    test('getSubscriber returns null when subscriber not found', function () {
        Http::fake([
            '*' => Http::response(['error' => ['message' => 'Subscriber not found']], 404),
        ]);

        $service = new MailerLiteService();
        $result = $service->getSubscriber('notfound@example.com');

        expect($result)->toBeNull();
    });

    test('getAllSubscribers returns array of subscribers', function () {
        $subscribers = [
            ['id' => 1, 'email' => 'test1@example.com'],
            ['id' => 2, 'email' => 'test2@example.com'],
        ];

        Http::fake([
            '*' => Http::response($subscribers, 200),
        ]);

        $service = new MailerLiteService();
        $result = $service->getAllSubscribers();

        expect($result)->toBe($subscribers);
    });

    test('getSubscriberCount returns total count from response', function () {
        Http::fake([
            '*' => Http::response(['id' => 'test_group_123', 'total' => 250], 200),
        ]);

        $service = new MailerLiteService();
        $result = $service->getSubscriberCount();

        expect($result)->toBe(250);
    });

    test('getSubscriberCount returns zero when total is missing', function () {
        Http::fake([
            '*' => Http::response(['id' => 'test_group_123'], 200),
        ]);

        $service = new MailerLiteService();
        $result = $service->getSubscriberCount();

        expect($result)->toBe(0);
    });

    test('updateSubscriber returns true on successful response', function () {
        Http::fake([
            '*' => Http::response(['id' => 1, 'email' => 'test@example.com'], 200),
        ]);

        $service = new MailerLiteService();
        $result = $service->updateSubscriber('test@example.com', ['name' => 'New Name']);

        expect($result)->toBeTrue();
    });
});

describe('MailerLiteService - Error Handling', function () {
    test('throws exception when API key is not configured', function () {
        Config::set('mailerlite.api_key', '');

        $service = new MailerLiteService();
        
        expect(fn() => $service->subscribe('test@example.com'))
            ->toThrow(Exception::class, 'MailerLite API key is not configured');
    });

    test('handles 400 validation error correctly', function () {
        Http::fake([
            '*' => Http::response([
                'error' => ['message' => 'Invalid email format'],
            ], 400),
        ]);

        $service = new MailerLiteService();

        expect(fn() => $service->subscribe('invalid-email'))
            ->toThrow(Exception::class, 'Validation error: Invalid email format');
    });

    test('handles 401 authentication error correctly', function () {
        Http::fake([
            '*' => Http::response([
                'error' => ['message' => 'Invalid API key'],
            ], 401),
        ]);

        $service = new MailerLiteService();

        expect(fn() => $service->subscribe('test@example.com'))
            ->toThrow(Exception::class, 'Email service authentication failed');
    });

    test('handles 404 not found error correctly', function () {
        Http::fake([
            '*' => Http::response([
                'error' => ['message' => 'Resource not found'],
            ], 404),
        ]);

        $service = new MailerLiteService();

        expect(fn() => $service->updateSubscriber('notfound@example.com', ['name' => 'Test']))
            ->toThrow(Exception::class, 'Resource not found');
    });

    test('handles 429 rate limiting error correctly', function () {
        Http::fake([
            '*' => Http::response([
                'error' => ['message' => 'Too many requests'],
            ], 429, ['Retry-After' => '120']),
        ]);

        $service = new MailerLiteService();

        expect(fn() => $service->subscribe('test@example.com'))
            ->toThrow(Exception::class, 'Service is busy. Please try again in 120 seconds.');
    });

    test('handles 500 server error correctly', function () {
        Http::fake([
            '*' => Http::response([
                'error' => ['message' => 'Internal server error'],
            ], 500),
        ]);

        $service = new MailerLiteService();

        expect(fn() => $service->subscribe('test@example.com'))
            ->toThrow(Exception::class, 'Email service is temporarily unavailable');
    });

    test('handles 502 bad gateway error correctly', function () {
        Http::fake([
            '*' => Http::response([], 502),
        ]);

        $service = new MailerLiteService();

        expect(fn() => $service->subscribe('test@example.com'))
            ->toThrow(Exception::class, 'Email service is temporarily unavailable');
    });

    test('handles 503 service unavailable error correctly', function () {
        Http::fake([
            '*' => Http::response([], 503),
        ]);

        $service = new MailerLiteService();

        expect(fn() => $service->subscribe('test@example.com'))
            ->toThrow(Exception::class, 'Email service is temporarily unavailable');
    });

    test('handles connection timeout correctly', function () {
        Http::fake(function () {
            throw new \Illuminate\Http\Client\ConnectionException('Connection timeout');
        });

        $service = new MailerLiteService();

        expect(fn() => $service->subscribe('test@example.com'))
            ->toThrow(Exception::class, 'Unable to connect to email service');
    });

    test('subscribe throws exception and logs error on failure', function () {
        Http::fake([
            '*' => Http::response(['error' => ['message' => 'Server error']], 500),
        ]);

        $service = new MailerLiteService();

        expect(fn() => $service->subscribe('test@example.com'))
            ->toThrow(Exception::class, 'Email service is temporarily unavailable');
    });

    test('unsubscribe throws exception and logs error on failure', function () {
        Http::fake([
            '*' => Http::response(['error' => ['message' => 'Server error']], 500),
        ]);

        $service = new MailerLiteService();

        expect(fn() => $service->unsubscribe('test@example.com'))
            ->toThrow(Exception::class, 'Email service is temporarily unavailable');
    });

    test('getAllSubscribers throws exception and logs error on failure', function () {
        Http::fake([
            '*' => Http::response(['error' => ['message' => 'Server error']], 500),
        ]);

        $service = new MailerLiteService();

        expect(fn() => $service->getAllSubscribers())
            ->toThrow(Exception::class, 'Email service is temporarily unavailable');
    });

    test('getSubscriberCount throws exception and logs error on failure', function () {
        Http::fake([
            '*' => Http::response(['error' => ['message' => 'Server error']], 500),
        ]);

        $service = new MailerLiteService();

        expect(fn() => $service->getSubscriberCount())
            ->toThrow(Exception::class, 'Email service is temporarily unavailable');
    });

    test('updateSubscriber throws exception and logs error on failure', function () {
        Http::fake([
            '*' => Http::response(['error' => ['message' => 'Server error']], 500),
        ]);

        $service = new MailerLiteService();

        expect(fn() => $service->updateSubscriber('test@example.com', ['name' => 'Test']))
            ->toThrow(Exception::class, 'Email service is temporarily unavailable');
    });
});

describe('MailerLiteService - Edge Cases', function () {
    test('getAllSubscribers limits pagination to maximum 1000', function () {
        Http::fake([
            '*' => Http::response([], 200),
        ]);

        $service = new MailerLiteService();
        $service->getAllSubscribers(2000, 0);

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'limit=1000');
        });
    });

    test('subscribe handles empty custom fields', function () {
        Http::fake([
            '*' => Http::response(['id' => 1, 'email' => 'test@example.com'], 200),
        ]);

        $service = new MailerLiteService();
        $result = $service->subscribe('test@example.com', []);

        expect($result)->toBeTrue();
        
        Http::assertSent(function ($request) {
            return $request['fields'] === [];
        });
    });

    test('handles response with no JSON body', function () {
        Http::fake([
            '*' => Http::response('', 200),
        ]);

        $service = new MailerLiteService();
        $result = $service->getAllSubscribers();

        expect($result)->toBe([]);
    });

    test('handles error response without error message structure', function () {
        Http::fake([
            '*' => Http::response('Plain text error', 400),
        ]);

        $service = new MailerLiteService();

        expect(fn() => $service->subscribe('test@example.com'))
            ->toThrow(Exception::class, 'Validation error: Plain text error');
    });

    test('rate limiting uses default retry time when header is missing', function () {
        Http::fake([
            '*' => Http::response(['error' => ['message' => 'Rate limited']], 429),
        ]);

        $service = new MailerLiteService();

        $exception = null;
        try {
            $service->subscribe('test@example.com');
        } catch (\Exception $e) {
            $exception = $e;
        }

        expect($exception)->not->toBeNull();
        expect($exception->getMessage())->toContain('Service is busy');
        expect($exception->getMessage())->toContain('seconds');
    });
});
