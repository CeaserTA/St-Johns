<?php

use App\Models\User;
use App\Models\Member;
use App\Services\MailerLiteService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Mock MailerLiteService to avoid actual API calls
    $this->mock(MailerLiteService::class, function ($mock) {
        $mock->shouldReceive('subscribe')->andReturn(true);
        $mock->shouldReceive('unsubscribe')->andReturn(true);
    });
});

test('member can subscribe to newsletter via profile', function () {
    // Create a user with a member profile
    $user = User::factory()->create();
    $member = Member::factory()->create([
        'user_id' => $user->id,
        'email' => 'test@example.com',
        'newsletter_subscribed' => false,
    ]);

    // Subscribe to newsletter
    $response = $this
        ->actingAs($user)
        ->patch('/profile/newsletter', [
            'newsletter_subscribe' => true,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile')
        ->assertSessionHas('newsletter-success');

    // Verify member is subscribed
    $member->refresh();
    expect($member->newsletter_subscribed)->toBeTrue();
    expect($member->newsletter_subscribed_at)->not->toBeNull();
});

test('member can unsubscribe from newsletter via profile', function () {
    // Create a user with a member profile that is subscribed
    $user = User::factory()->create();
    $member = Member::factory()->create([
        'user_id' => $user->id,
        'email' => 'test@example.com',
        'newsletter_subscribed' => true,
        'newsletter_subscribed_at' => now(),
    ]);

    // Unsubscribe from newsletter
    $response = $this
        ->actingAs($user)
        ->patch('/profile/newsletter', [
            'newsletter_subscribe' => false,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/profile')
        ->assertSessionHas('newsletter-success');

    // Verify member is unsubscribed
    $member->refresh();
    expect($member->newsletter_subscribed)->toBeFalse();
    expect($member->newsletter_subscribed_at)->toBeNull();
});

test('user without member profile cannot toggle newsletter', function () {
    // Create a user without a member profile
    $user = User::factory()->create();

    // Attempt to subscribe to newsletter
    $response = $this
        ->actingAs($user)
        ->patch('/profile/newsletter', [
            'newsletter_subscribe' => true,
        ]);

    $response
        ->assertRedirect('/profile')
        ->assertSessionHas('newsletter-error');
});

test('member without email cannot subscribe to newsletter', function () {
    // Create a user with a member profile but no email
    $user = User::factory()->create();
    $member = Member::factory()->create([
        'user_id' => $user->id,
        'email' => '', // Empty string instead of null
    ]);

    // Attempt to subscribe to newsletter
    $response = $this
        ->actingAs($user)
        ->patch('/profile/newsletter', [
            'newsletter_subscribe' => true,
        ]);

    $response
        ->assertRedirect('/profile')
        ->assertSessionHas('newsletter-error');
});

test('newsletter subscription status is displayed on profile page', function () {
    // Create a user with a subscribed member profile
    $user = User::factory()->create();
    $member = Member::factory()->create([
        'user_id' => $user->id,
        'email' => 'test@example.com',
        'newsletter_subscribed' => true,
        'newsletter_subscribed_at' => now(),
    ]);

    // Visit profile page
    $response = $this
        ->actingAs($user)
        ->get('/profile');

    $response
        ->assertOk()
        ->assertSee('Newsletter Subscription')
        ->assertSee('You are currently subscribed');
});

test('subscription toggle updates member record correctly', function () {
    // Create a user with an unsubscribed member profile
    $user = User::factory()->create();
    $member = Member::factory()->create([
        'user_id' => $user->id,
        'email' => 'test@example.com',
        'newsletter_subscribed' => false,
        'newsletter_subscribed_at' => null,
    ]);

    // Subscribe
    $this
        ->actingAs($user)
        ->patch('/profile/newsletter', [
            'newsletter_subscribe' => true,
        ]);

    // Verify member record was updated
    $member->refresh();
    expect($member->newsletter_subscribed)->toBeTrue();
    expect($member->newsletter_subscribed_at)->not->toBeNull();
    expect($member->newsletter_subscribed_at)->toBeInstanceOf(\Illuminate\Support\Carbon::class);

    // Unsubscribe
    $this
        ->actingAs($user)
        ->patch('/profile/newsletter', [
            'newsletter_subscribe' => false,
        ]);

    // Verify member record was updated
    $member->refresh();
    expect($member->newsletter_subscribed)->toBeFalse();
    expect($member->newsletter_subscribed_at)->toBeNull();
});

test('API sync is called on subscription changes', function () {
    // Create a user with a member profile
    $user = User::factory()->create();
    $member = Member::factory()->create([
        'user_id' => $user->id,
        'email' => 'test@example.com',
        'newsletter_subscribed' => false,
    ]);

    // Mock MailerLiteService and verify subscribe is called with correct parameters
    $mock = $this->mock(MailerLiteService::class);
    $mock->shouldReceive('subscribe')
        ->once()
        ->with($member->email, [
            'name' => $member->full_name,
            'member_status' => 'active',
        ])
        ->andReturn(true);

    // Subscribe
    $this
        ->actingAs($user)
        ->patch('/profile/newsletter', [
            'newsletter_subscribe' => true,
        ]);

    // Mock MailerLiteService and verify unsubscribe is called
    $mock = $this->mock(MailerLiteService::class);
    $mock->shouldReceive('unsubscribe')
        ->once()
        ->with($member->email)
        ->andReturn(true);

    // Unsubscribe
    $this
        ->actingAs($user)
        ->patch('/profile/newsletter', [
            'newsletter_subscribe' => false,
        ]);
});

test('error handling for failed API calls during subscription', function () {
    // Create a user with a member profile
    $user = User::factory()->create();
    $member = Member::factory()->create([
        'user_id' => $user->id,
        'email' => 'test@example.com',
        'newsletter_subscribed' => false,
    ]);

    // Mock MailerLiteService to throw an exception
    $mock = $this->mock(MailerLiteService::class);
    $mock->shouldReceive('subscribe')
        ->once()
        ->andThrow(new \Exception('API connection failed'));

    // Attempt to subscribe
    $response = $this
        ->actingAs($user)
        ->patch('/profile/newsletter', [
            'newsletter_subscribe' => true,
        ]);

    // Verify error message is displayed
    $response
        ->assertRedirect('/profile')
        ->assertSessionHas('newsletter-error', 'Failed to update newsletter subscription. Please try again later.');

    // Verify member record was NOT updated
    $member->refresh();
    expect($member->newsletter_subscribed)->toBeFalse();
    expect($member->newsletter_subscribed_at)->toBeNull();
});

test('error handling for failed API calls during unsubscription', function () {
    // Create a user with a subscribed member profile
    $user = User::factory()->create();
    $member = Member::factory()->create([
        'user_id' => $user->id,
        'email' => 'test@example.com',
        'newsletter_subscribed' => true,
        'newsletter_subscribed_at' => now(),
    ]);

    // Mock MailerLiteService to throw an exception
    $mock = $this->mock(MailerLiteService::class);
    $mock->shouldReceive('unsubscribe')
        ->once()
        ->andThrow(new \Exception('API connection failed'));

    // Attempt to unsubscribe
    $response = $this
        ->actingAs($user)
        ->patch('/profile/newsletter', [
            'newsletter_subscribe' => false,
        ]);

    // Verify error message is displayed
    $response
        ->assertRedirect('/profile')
        ->assertSessionHas('newsletter-error', 'Failed to update newsletter subscription. Please try again later.');

    // Verify member record was NOT updated (still subscribed)
    $member->refresh();
    expect($member->newsletter_subscribed)->toBeTrue();
    expect($member->newsletter_subscribed_at)->not->toBeNull();
});
