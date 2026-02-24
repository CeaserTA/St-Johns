<?php

use App\Services\MailerLiteService;
use Illuminate\Support\Facades\Log;

beforeEach(function () {
    // Prevent actual logging during tests - mock the channel method
    Log::shouldReceive('channel')->with('mailerlite')->andReturnSelf();
    Log::shouldReceive('info')->andReturn(null);
    Log::shouldReceive('error')->andReturn(null);
    Log::shouldReceive('warning')->andReturn(null);
    Log::shouldReceive('critical')->andReturn(null);
});

describe('SubscriptionController - Request Validation', function () {
    test('subscribe validates email is required', function () {
        $this->postJson('/subscribe', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    });

    test('subscribe validates email format', function () {
        $this->postJson('/subscribe', [
            'email' => 'invalid-email',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    });

    test('subscribe validates email max length', function () {
        $longEmail = str_repeat('a', 250) . '@example.com';
        
        $this->postJson('/subscribe', [
            'email' => $longEmail,
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    });

    test('unsubscribe validates email is required', function () {
        $this->post('/unsubscribe', [])
            ->assertStatus(302)
            ->assertSessionHasErrors(['email']);
    });

    test('unsubscribe validates email format', function () {
        $this->post('/unsubscribe', [
            'email' => 'not-an-email',
        ])
            ->assertStatus(302)
            ->assertSessionHasErrors(['email']);
    });
});

describe('SubscriptionController - Response Formatting', function () {
    test('subscribe returns JSON success response for new subscription', function () {
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('getSubscriber')
            ->once()
            ->andReturn(null);
        $mailerLite->shouldReceive('subscribe')
            ->once()
            ->andReturn(true);

        $this->app->instance(MailerLiteService::class, $mailerLite);

        $response = $this->postJson('/subscribe', [
            'email' => 'new@example.com',
        ]);
        
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
        
        $this->assertStringContainsString('Thank you for subscribing', $response->json('message'));
    });

    test('subscribe returns JSON response for duplicate subscription', function () {
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('getSubscriber')
            ->once()
            ->andReturn(['id' => 1, 'email' => 'existing@example.com']);

        $this->app->instance(MailerLiteService::class, $mailerLite);

        $response = $this->postJson('/subscribe', [
            'email' => 'existing@example.com',
        ]);
        
        $response->assertStatus(200)
            ->assertJson([
                'success' => false,
            ]);
        
        $this->assertStringContainsString('already subscribed', $response->json('message'));
    });

    test('subscribe returns JSON error response on exception', function () {
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('getSubscriber')
            ->once()
            ->andReturn(null);
        $mailerLite->shouldReceive('subscribe')
            ->once()
            ->andThrow(new \Exception('API error'));

        $this->app->instance(MailerLiteService::class, $mailerLite);

        $this->postJson('/subscribe', [
            'email' => 'error@example.com',
        ])
            ->assertStatus(500)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonStructure(['success', 'message']);
    });

    test('unsubscribe returns redirect response on success', function () {
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('unsubscribe')
            ->once()
            ->andReturn(true);

        $this->app->instance(MailerLiteService::class, $mailerLite);

        $this->post('/unsubscribe', [
            'email' => 'test@example.com',
        ])
            ->assertStatus(302)
            ->assertRedirect();
    });

    test('unsubscribe returns redirect back on error', function () {
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('unsubscribe')
            ->once()
            ->andThrow(new \Exception('API error'));

        $this->app->instance(MailerLiteService::class, $mailerLite);

        $this->from('/some-page')
            ->post('/unsubscribe', [
                'email' => 'error@example.com',
            ])
            ->assertStatus(302)
            ->assertRedirect('/some-page');
    });
});

describe('SubscriptionController - Error Message Display', function () {
    test('displays authentication error message', function () {
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('getSubscriber')
            ->once()
            ->andReturn(null);
        $mailerLite->shouldReceive('subscribe')
            ->once()
            ->andThrow(new \Exception('API key authentication failed'));

        $this->app->instance(MailerLiteService::class, $mailerLite);

        $response = $this->postJson('/subscribe', [
            'email' => 'test@example.com',
        ]);
        
        $response->assertStatus(500);
        $message = $response->json('message');
        $this->assertStringContainsString('Email service configuration error', $message);
        $this->assertStringContainsString('contact support', $message);
    });

    test('displays rate limit error message', function () {
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('getSubscriber')
            ->once()
            ->andReturn(null);
        $mailerLite->shouldReceive('subscribe')
            ->once()
            ->andThrow(new \Exception('Service is busy due to rate limit'));

        $this->app->instance(MailerLiteService::class, $mailerLite);

        $response = $this->postJson('/subscribe', [
            'email' => 'test@example.com',
        ]);
        
        $response->assertStatus(500);
        $this->assertStringContainsString('Service is busy', $response->json('message'));
    });

    test('displays connection error message', function () {
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('getSubscriber')
            ->once()
            ->andReturn(null);
        $mailerLite->shouldReceive('subscribe')
            ->once()
            ->andThrow(new \Exception('Unable to connect to server'));

        $this->app->instance(MailerLiteService::class, $mailerLite);

        $response = $this->postJson('/subscribe', [
            'email' => 'test@example.com',
        ]);
        
        $response->assertStatus(500);
        $this->assertStringContainsString('Unable to connect to email service', $response->json('message'));
    });

    test('displays validation error message', function () {
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('getSubscriber')
            ->once()
            ->andReturn(null);
        $mailerLite->shouldReceive('subscribe')
            ->once()
            ->andThrow(new \Exception('Invalid email validation failed'));

        $this->app->instance(MailerLiteService::class, $mailerLite);

        $response = $this->postJson('/subscribe', [
            'email' => 'test@example.com',
        ]);
        
        $response->assertStatus(500);
        $this->assertStringContainsString('check your email address', $response->json('message'));
    });

    test('displays default error message for unknown errors', function () {
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('getSubscriber')
            ->once()
            ->andReturn(null);
        $mailerLite->shouldReceive('subscribe')
            ->once()
            ->andThrow(new \Exception('Some unexpected error'));

        $this->app->instance(MailerLiteService::class, $mailerLite);

        $response = $this->postJson('/subscribe', [
            'email' => 'test@example.com',
        ]);
        
        $response->assertStatus(500);
        $this->assertStringContainsString('Unable to process your subscription', $response->json('message'));
    });
});

describe('SubscriptionController - Service Isolation', function () {
    test('subscribe calls getSubscriber to check for duplicates', function () {
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('getSubscriber')
            ->once()
            ->with('test@example.com')
            ->andReturn(null);
        $mailerLite->shouldReceive('subscribe')
            ->once()
            ->with('test@example.com')
            ->andReturn(true);

        $this->app->instance(MailerLiteService::class, $mailerLite);

        $this->postJson('/subscribe', [
            'email' => 'test@example.com',
        ]);
    });

    test('subscribe does not call subscribe method when duplicate exists', function () {
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('getSubscriber')
            ->once()
            ->with('existing@example.com')
            ->andReturn(['id' => 1, 'email' => 'existing@example.com']);
        $mailerLite->shouldNotReceive('subscribe');

        $this->app->instance(MailerLiteService::class, $mailerLite);

        $this->postJson('/subscribe', [
            'email' => 'existing@example.com',
        ]);
    });

    test('unsubscribe calls service unsubscribe method', function () {
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('unsubscribe')
            ->once()
            ->with('test@example.com')
            ->andReturn(true);

        $this->app->instance(MailerLiteService::class, $mailerLite);

        $this->post('/unsubscribe', [
            'email' => 'test@example.com',
        ]);
    });

    test('subscribe passes email to service methods', function () {
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('getSubscriber')
            ->once()
            ->with('specific@example.com')
            ->andReturn(null);
        $mailerLite->shouldReceive('subscribe')
            ->once()
            ->with('specific@example.com')
            ->andReturn(true);

        $this->app->instance(MailerLiteService::class, $mailerLite);

        $this->postJson('/subscribe', [
            'email' => 'specific@example.com',
        ]);
    });
});

afterEach(function () {
    Mockery::close();
});

describe('SubscriptionController - Rate Limiting', function () {
    test('subscribe endpoint enforces rate limit of 5 attempts per minute', function () {
        // Mock Log facade
        Log::shouldReceive('channel')->andReturnSelf();
        Log::shouldReceive('info')->andReturn(null);
        
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('getSubscriber')
            ->andReturn(null);
        $mailerLite->shouldReceive('subscribe')
            ->andReturn(true);

        $this->app->instance(MailerLiteService::class, $mailerLite);

        // Make 5 successful requests
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/subscribe', [
                'email' => "test{$i}@gmail.com",
            ])->assertStatus(200);
        }

        // 6th request should be rate limited
        $response = $this->postJson('/subscribe', [
            'email' => 'test6@gmail.com',
        ]);

        $response->assertStatus(429)
            ->assertJson([
                'success' => false,
                'message' => 'Too many attempts. Please try again in a few moments.',
            ]);
    });

    test('unsubscribe endpoint enforces rate limit of 5 attempts per minute', function () {
        // Mock Log facade
        Log::shouldReceive('channel')->andReturnSelf();
        Log::shouldReceive('info')->andReturn(null);
        
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('unsubscribe')
            ->andReturn(true);

        $this->app->instance(MailerLiteService::class, $mailerLite);

        // Make 5 successful requests
        for ($i = 0; $i < 5; $i++) {
            $this->post('/unsubscribe', [
                'email' => "test{$i}@gmail.com",
            ])->assertStatus(302);
        }

        // 6th request should be rate limited (Laravel redirects back with error for non-JSON)
        $response = $this->from('/some-page')->post('/unsubscribe', [
            'email' => 'test6@gmail.com',
        ]);

        // For non-JSON requests, Laravel redirects back with errors
        $response->assertStatus(302)
            ->assertRedirect('/some-page');
    });

    test('rate limit is per IP address', function () {
        // Mock Log facade
        Log::shouldReceive('channel')->andReturnSelf();
        Log::shouldReceive('info')->andReturn(null);
        
        $mailerLite = Mockery::mock(MailerLiteService::class);
        $mailerLite->shouldReceive('getSubscriber')
            ->andReturn(null);
        $mailerLite->shouldReceive('subscribe')
            ->andReturn(true);

        $this->app->instance(MailerLiteService::class, $mailerLite);

        // Make 5 requests from first IP
        for ($i = 0; $i < 5; $i++) {
            $this->postJson('/subscribe', [
                'email' => "test{$i}@gmail.com",
            ])->assertStatus(200);
        }

        // 6th request from same IP should be rate limited
        $this->postJson('/subscribe', [
            'email' => 'test6@gmail.com',
        ])->assertStatus(429);

        // Request from different IP should succeed
        $this->postJson('/subscribe', [
            'email' => 'different@gmail.com',
        ], ['REMOTE_ADDR' => '192.168.1.100'])
            ->assertStatus(200);
    });
});


