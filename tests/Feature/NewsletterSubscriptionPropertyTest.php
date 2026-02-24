<?php

namespace Tests\Feature;

use App\Services\MailerLiteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Eris\TestTrait;

class NewsletterSubscriptionPropertyTest extends TestCase
{
    use RefreshDatabase;
    use TestTrait;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Mock Log facade to prevent actual logging during tests
        \Illuminate\Support\Facades\Log::shouldReceive('channel')->with('mailerlite')->andReturnSelf();
        \Illuminate\Support\Facades\Log::shouldReceive('info')->andReturn(null);
        \Illuminate\Support\Facades\Log::shouldReceive('error')->andReturn(null);
        \Illuminate\Support\Facades\Log::shouldReceive('warning')->andReturn(null);
        \Illuminate\Support\Facades\Log::shouldReceive('critical')->andReturn(null);
    }

    /**
     * **Feature: newsletter-subscription, Property 1: Email validation correctness**
     * 
     * For any string input, the email validation should accept valid email formats 
     * and reject invalid formats according to RFC 5322 standards.
     * 
     * **Validates: Requirements 1.1**
     */
    public function test_property_email_validation_correctness(): void
    {
        // Set up test configuration
        config(['mailerlite.api_key' => 'test_api_key_12345']);
        config(['mailerlite.group_id' => 'test_group_123']);
        
        // Test valid emails are accepted (using RFC validation without DNS check for testing)
        $this->forAll(
            \Eris\Generator\elements([
                'user@example.com',
                'test.user@example.com',
                'user+tag@example.co.uk',
                'user_name@example-domain.com',
                'user123@test.org',
                'a@b.co',
                'test@subdomain.example.com',
                'user.name+tag@example.com',
                'x@example.com',
                '123@example.com',
                'user@example-domain.com',
                'user@example.co.uk',
                'test_user@example.com',
                'user-name@example.com',
                'user.name@example.com',
            ])
        )->then(function (string $validEmail) {
            // Create a validator instance to test email validation
            // Using 'email:rfc' for testing to avoid DNS lookup issues in test environment
            $validator = \Illuminate\Support\Facades\Validator::make(
                ['email' => $validEmail],
                ['email' => ['required', 'email:rfc', 'max:255']]
            );
            
            // Valid emails should pass validation
            $this->assertFalse(
                $validator->fails(),
                "Expected '{$validEmail}' to be valid, but validation failed with errors: " . 
                json_encode($validator->errors()->toArray())
            );
        });
        
        // Test clearly invalid emails are rejected
        $this->forAll(
            \Eris\Generator\elements([
                'notanemail',
                '@example.com',
                'user@',
                'user@.com',
                '',
                'user@@example.com',
                'user@example..com',
                '.user@example.com',
                'user.@example.com',
                '@',
                'user',
                'user@.example.com',
                'plaintext',
                'double@@at.com',
                'no-domain@',
                '@no-local.com',
                'invalid..dots@example.com',
                'trailing.dot.@example.com',
            ])
        )->then(function (string $invalidEmail) {
            // Create a validator instance to test email validation
            $validator = \Illuminate\Support\Facades\Validator::make(
                ['email' => $invalidEmail],
                ['email' => ['required', 'email:rfc', 'max:255']]
            );
            
            // Invalid emails should fail validation
            $this->assertTrue(
                $validator->fails(),
                "Expected '{$invalidEmail}' to be invalid, but validation passed"
            );
            
            // Should have email validation error
            $this->assertTrue(
                $validator->errors()->has('email'),
                "Expected email validation error for '{$invalidEmail}'"
            );
        });
    }

    /**
     * **Feature: newsletter-subscription, Property 2: Duplicate subscription idempotency**
     * 
     * For any email address, attempting to subscribe twice should be handled 
     * gracefully without errors and inform the user appropriately.
     * 
     * **Validates: Requirements 1.3**
     */
    public function test_property_duplicate_subscription_idempotency(): void
    {
        // Set up test configuration
        config(['mailerlite.api_key' => 'test_api_key_12345']);
        config(['mailerlite.group_id' => 'test_group_123']);
        config(['mailerlite.api_base_url' => 'https://api.mailerlite.com/api/v2/']);
        
        // Track call counts outside the closure
        $getSubscriberCallCounts = [];
        
        // Use real domains that have valid DNS records for testing
        // Limit to 3 emails to stay within rate limit (5 per minute, 2 requests per email = 6 total)
        $this->forAll(
            \Eris\Generator\elements([
                'test@gmail.com',
                'user@yahoo.com',
                'subscriber@outlook.com',
            ])
        )->then(function (string $email) use (&$getSubscriberCallCounts) {
            // Reset call count for this email
            $getSubscriberCallCounts[$email] = 0;
            
            // Set up HTTP fakes for both subscription attempts
            // Use wildcard matching to catch all MailerLite API calls
            Http::fake([
                // Match all MailerLite API calls
                'https://api.mailerlite.com/*' => function ($request) use ($email, &$getSubscriberCallCounts) {
                    $url = $request->url();
                    
                    // Check if this is a getSubscriber call (GET /subscribers/{email})
                    if (str_contains($url, "/subscribers/" . $email) && $request->method() === 'GET') {
                        $getSubscriberCallCounts[$email]++;
                        
                        if ($getSubscriberCallCounts[$email] === 1) {
                            // First call: not found
                            return Http::response(null, 404);
                        } else {
                            // Second call: exists
                            return Http::response(['id' => 123, 'email' => $email, 'status' => 'active'], 200);
                        }
                    }
                    
                    // Subscribe call - POST to /groups/{groupId}/subscribers
                    if (str_contains($url, '/groups/') && str_contains($url, '/subscribers') && $request->method() === 'POST') {
                        return Http::response([
                            'id' => 123,
                            'email' => $email,
                            'status' => 'active',
                        ], 200);
                    }
                    
                    // Default response
                    return Http::response(['error' => 'Not found'], 404);
                },
            ]);
            
            // First subscription should succeed
            $response1 = $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class)
                ->postJson('/subscribe', ['email' => $email]);
            
            // Should return success
            $response1->assertStatus(200);
            $response1->assertJson([
                'success' => true,
            ]);
            
            // Message should indicate successful subscription
            $this->assertStringContainsString(
                'Thank you for subscribing',
                $response1->json('message'),
                "First subscription should return success message"
            );
            
            // Second subscription attempt - subscriber already exists
            $response2 = $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class)
                ->postJson('/subscribe', ['email' => $email]);
            
            // Should return 200 (not an error)
            $response2->assertStatus(200);
            
            // Should indicate already subscribed
            $response2->assertJson([
                'success' => false,
            ]);
            
            // Message should inform user they're already subscribed
            $this->assertStringContainsString(
                'already subscribed',
                $response2->json('message'),
                "Second subscription should inform user they're already subscribed"
            );
            
            // Should not throw an exception or return 500 error
            $this->assertNotEquals(500, $response2->status(), 
                "Duplicate subscription should not cause server error");
        });
    }

    /**
     * **Feature: newsletter-subscription, Property 8: API authentication**
     * 
     * For any API request to MailerLite, the request should include the 
     * configured API key in the authorization header.
     * 
     * **Validates: Requirements 9.3**
     */
    public function test_property_api_authentication(): void
    {
        // Set up test API key
        config(['mailerlite.api_key' => 'test_api_key_12345']);
        config(['mailerlite.group_id' => 'test_group_123']);
        
        $this->forAll(
            \Eris\Generator\elements([
                'subscribe',
                'unsubscribe',
                'getSubscriber',
                'getAllSubscribers',
                'getSubscriberCount',
                'updateSubscriber'
            ])
        )->then(function (string $method) {
            // Fake HTTP requests to capture what's being sent
            Http::fake([
                '*' => Http::response([
                    'id' => 123,
                    'email' => 'test@example.com',
                    'total' => 10,
                ], 200)
            ]);
            
            $service = new MailerLiteService();
            
            // Call different methods based on the generated method name
            try {
                switch ($method) {
                    case 'subscribe':
                        $service->subscribe('test@example.com', ['name' => 'Test User']);
                        break;
                    case 'unsubscribe':
                        $service->unsubscribe('test@example.com');
                        break;
                    case 'getSubscriber':
                        $service->getSubscriber('test@example.com');
                        break;
                    case 'getAllSubscribers':
                        $service->getAllSubscribers(10, 0);
                        break;
                    case 'getSubscriberCount':
                        $service->getSubscriberCount();
                        break;
                    case 'updateSubscriber':
                        $service->updateSubscriber('test@example.com', ['name' => 'Updated Name']);
                        break;
                }
            } catch (\Exception $e) {
                // Some methods might throw exceptions, but we still want to check the request
            }
            
            // Assert that the request was made with the correct authentication header
            Http::assertSent(function ($request) {
                // Check that X-MailerLite-ApiKey header is present
                $hasApiKeyHeader = $request->hasHeader('X-MailerLite-ApiKey');
                
                if (!$hasApiKeyHeader) {
                    return false;
                }
                
                // Check that the API key matches the configured value
                $apiKey = $request->header('X-MailerLite-ApiKey');
                $expectedApiKey = config('mailerlite.api_key');
                
                return is_array($apiKey) 
                    ? in_array($expectedApiKey, $apiKey)
                    : $apiKey === $expectedApiKey;
            });
        });
    }

    /**
     * **Feature: newsletter-subscription, Property 3: Member metadata sync**
     * 
     * For any member with a name and email, when subscribed to MailerLite, 
     * the API request should include their name and member status as custom fields.
     * 
     * **Validates: Requirements 2.4**
     */
    public function test_property_member_metadata_sync(): void
    {
        // Set up test configuration
        config(['mailerlite.api_key' => 'test_api_key_12345']);
        config(['mailerlite.group_id' => 'test_group_123']);
        config(['mailerlite.api_base_url' => 'https://api.mailerlite.com/api/v2/']);
        
        $this->forAll(
            \Eris\Generator\tuple(
                \Eris\Generator\elements([
                    'John Doe',
                    'Jane Smith',
                    'Michael Johnson',
                    'Sarah Williams',
                    'David Brown',
                    'Emily Davis',
                    'James Wilson',
                    'Mary Taylor',
                    'Robert Anderson',
                    'Jennifer Thomas',
                    'William Martinez',
                    'Linda Garcia',
                    'Richard Rodriguez',
                    'Patricia Lee',
                    'Charles White',
                ]),
                \Eris\Generator\elements([
                    'john.doe@gmail.com',
                    'jane.smith@yahoo.com',
                    'michael.j@outlook.com',
                    'sarah.w@hotmail.com',
                    'david.brown@live.com',
                    'emily.davis@gmail.com',
                    'james.wilson@yahoo.com',
                    'mary.taylor@outlook.com',
                    'robert.a@hotmail.com',
                    'jennifer.t@live.com',
                    'william.m@gmail.com',
                    'linda.garcia@yahoo.com',
                    'richard.r@outlook.com',
                    'patricia.lee@hotmail.com',
                    'charles.white@live.com',
                ])
            )
        )->then(function ($tuple) {
            [$memberName, $memberEmail] = $tuple;
            
            // Make email unique for each test iteration
            $uniqueEmail = time() . '_' . uniqid() . '_' . $memberEmail;
            
            // Fake HTTP requests to capture what's being sent
            Http::fake([
                'https://api.mailerlite.com/api/v2/groups/test_group_123/subscribers' => Http::response([
                    'id' => 123,
                    'email' => $uniqueEmail,
                    'status' => 'active',
                    'fields' => [
                        ['key' => 'name', 'value' => $memberName],
                        ['key' => 'member_status', 'value' => 'active'],
                    ],
                ], 200),
            ]);
            
            // Create a member with the generated name and unique email
            $member = \App\Models\Member::factory()->create([
                'full_name' => $memberName,
                'email' => $uniqueEmail,
                'newsletter_subscribed' => false,
            ]);
            
            // Subscribe the member to newsletter (this should trigger the sync)
            $mailerLite = app(MailerLiteService::class);
            $mailerLite->subscribe($member->email, [
                'name' => $member->full_name,
                'member_status' => 'active',
            ]);
            
            // Assert that the request was made with the correct metadata
            Http::assertSent(function ($request) use ($memberName, $uniqueEmail) {
                // Check that it's a POST request to the subscribers endpoint
                if ($request->method() !== 'POST') {
                    return false;
                }
                
                if (!str_contains($request->url(), 'subscribers')) {
                    return false;
                }
                
                // Get the request body
                $body = $request->data();
                
                // Check that email is present
                if (!isset($body['email']) || $body['email'] !== $uniqueEmail) {
                    return false;
                }
                
                // Check that fields are present
                if (!isset($body['fields'])) {
                    return false;
                }
                
                $fields = $body['fields'];
                
                // Check that name field is present and matches
                if (!isset($fields['name']) || $fields['name'] !== $memberName) {
                    return false;
                }
                
                // Check that member_status field is present and set to 'active'
                if (!isset($fields['member_status']) || $fields['member_status'] !== 'active') {
                    return false;
                }
                
                return true;
            });
            
            // Clean up
            $member->delete();
        });
    }

    /**
     * **Feature: newsletter-subscription, Property 4: Subscription state consistency**
     * 
     * For any member, when their subscription preference changes (subscribe or unsubscribe), 
     * both the member database record and MailerLite should reflect the same subscription status.
     * 
     * **Validates: Requirements 3.2, 5.2, 5.4, 8.2**
     */
    public function test_property_subscription_state_consistency(): void
    {
        // Set up test configuration
        config(['mailerlite.api_key' => 'test_api_key_12345']);
        config(['mailerlite.group_id' => 'test_group_123']);
        config(['mailerlite.api_base_url' => 'https://api.mailerlite.com/api/v2/']);
        
        $this->forAll(
            \Eris\Generator\tuple(
                \Eris\Generator\elements([
                    'Alice Johnson',
                    'Bob Smith',
                    'Carol Williams',
                    'David Brown',
                    'Eve Davis',
                    'Frank Wilson',
                    'Grace Taylor',
                    'Henry Anderson',
                    'Iris Thomas',
                    'Jack Martinez',
                ]),
                \Eris\Generator\elements([
                    'alice@gmail.com',
                    'bob@yahoo.com',
                    'carol@outlook.com',
                    'david@hotmail.com',
                    'eve@live.com',
                    'frank@gmail.com',
                    'grace@yahoo.com',
                    'henry@outlook.com',
                    'iris@hotmail.com',
                    'jack@live.com',
                ]),
                \Eris\Generator\bool() // Random initial subscription state
            )
        )->then(function ($tuple) {
            [$memberName, $memberEmail, $initialSubscriptionState] = $tuple;
            
            // Make email unique for each test iteration
            $uniqueEmail = time() . '_' . uniqid() . '_' . $memberEmail;
            
            // Create a member with the generated data
            $member = \App\Models\Member::factory()->create([
                'full_name' => $memberName,
                'email' => $uniqueEmail,
                'newsletter_subscribed' => $initialSubscriptionState,
                'newsletter_subscribed_at' => $initialSubscriptionState ? now() : null,
            ]);
            
            // Test subscribing (if not already subscribed)
            if (!$initialSubscriptionState) {
                // Fake HTTP requests for subscription
                Http::fake([
                    'https://api.mailerlite.com/api/v2/groups/test_group_123/subscribers' => Http::response([
                        'id' => 123,
                        'email' => $uniqueEmail,
                        'status' => 'active',
                        'fields' => [
                            ['key' => 'name', 'value' => $memberName],
                            ['key' => 'member_status', 'value' => 'active'],
                        ],
                    ], 200),
                ]);
                
                // Subscribe the member
                $mailerLite = app(MailerLiteService::class);
                $result = $mailerLite->subscribe($member->email, [
                    'name' => $member->full_name,
                    'member_status' => 'active',
                ]);
                
                // Update member record
                $member->subscribeToNewsletter();
                
                // Verify API was called
                Http::assertSent(function ($request) use ($uniqueEmail) {
                    return $request->method() === 'POST' 
                        && str_contains($request->url(), 'subscribers')
                        && $request->data()['email'] === $uniqueEmail;
                });
                
                // Verify database state matches subscription
                $member->refresh();
                $this->assertTrue(
                    $member->newsletter_subscribed,
                    "Member database record should show subscribed=true after subscription"
                );
                $this->assertNotNull(
                    $member->newsletter_subscribed_at,
                    "Member database record should have subscription timestamp after subscription"
                );
                $this->assertTrue(
                    $result,
                    "MailerLite API should return success for subscription"
                );
            }
            
            // Test unsubscribing
            // Reset HTTP fake for unsubscribe
            Http::fake([
                "https://api.mailerlite.com/api/v2/subscribers/{$uniqueEmail}" => Http::response(null, 200),
            ]);
            
            // Unsubscribe the member
            $mailerLite = app(MailerLiteService::class);
            $result = $mailerLite->unsubscribe($member->email);
            
            // Update member record
            $member->unsubscribeFromNewsletter();
            
            // Verify API was called
            Http::assertSent(function ($request) use ($uniqueEmail) {
                return $request->method() === 'DELETE' 
                    && str_contains($request->url(), "subscribers/{$uniqueEmail}");
            });
            
            // Verify database state matches unsubscription
            $member->refresh();
            $this->assertFalse(
                $member->newsletter_subscribed,
                "Member database record should show subscribed=false after unsubscription"
            );
            $this->assertNull(
                $member->newsletter_subscribed_at,
                "Member database record should have null subscription timestamp after unsubscription"
            );
            $this->assertTrue(
                $result,
                "MailerLite API should return success for unsubscription"
            );
            
            // Test re-subscribing to verify round-trip consistency
            Http::fake([
                'https://api.mailerlite.com/api/v2/groups/test_group_123/subscribers' => Http::response([
                    'id' => 123,
                    'email' => $uniqueEmail,
                    'status' => 'active',
                    'fields' => [
                        ['key' => 'name', 'value' => $memberName],
                        ['key' => 'member_status', 'value' => 'active'],
                    ],
                ], 200),
            ]);
            
            // Re-subscribe
            $mailerLite = app(MailerLiteService::class);
            $result = $mailerLite->subscribe($member->email, [
                'name' => $member->full_name,
                'member_status' => 'active',
            ]);
            
            // Update member record
            $member->subscribeToNewsletter();
            
            // Verify API was called
            Http::assertSent(function ($request) use ($uniqueEmail) {
                return $request->method() === 'POST' 
                    && str_contains($request->url(), 'subscribers')
                    && $request->data()['email'] === $uniqueEmail;
            });
            
            // Verify database state matches re-subscription
            $member->refresh();
            $this->assertTrue(
                $member->newsletter_subscribed,
                "Member database record should show subscribed=true after re-subscription"
            );
            $this->assertNotNull(
                $member->newsletter_subscribed_at,
                "Member database record should have subscription timestamp after re-subscription"
            );
            $this->assertTrue(
                $result,
                "MailerLite API should return success for re-subscription"
            );
            
            // Clean up
            $member->delete();
        });
    }
}
