<?php

use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Member Newsletter Methods', function () {
    test('subscribeToNewsletter updates newsletter_subscribed to true', function () {
        $member = Member::factory()->create([
            'newsletter_subscribed' => false,
            'newsletter_subscribed_at' => null,
        ]);

        $member->subscribeToNewsletter();

        expect($member->fresh()->newsletter_subscribed)->toBeTrue();
    });

    test('subscribeToNewsletter updates newsletter_subscribed_at timestamp', function () {
        $member = Member::factory()->create([
            'newsletter_subscribed' => false,
            'newsletter_subscribed_at' => null,
        ]);

        $member->subscribeToNewsletter();

        $subscribedAt = $member->fresh()->newsletter_subscribed_at;
        
        expect($subscribedAt)->not->toBeNull();
        expect($subscribedAt)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
        // Verify the timestamp is recent (within last 5 seconds)
        expect($subscribedAt->diffInSeconds(now()))->toBeLessThanOrEqual(5);
    });

    test('unsubscribeFromNewsletter updates newsletter_subscribed to false', function () {
        $member = Member::factory()->create([
            'newsletter_subscribed' => true,
            'newsletter_subscribed_at' => now(),
        ]);

        $member->unsubscribeFromNewsletter();

        expect($member->fresh()->newsletter_subscribed)->toBeFalse();
    });

    test('unsubscribeFromNewsletter clears newsletter_subscribed_at timestamp', function () {
        $member = Member::factory()->create([
            'newsletter_subscribed' => true,
            'newsletter_subscribed_at' => now(),
        ]);

        $member->unsubscribeFromNewsletter();

        expect($member->fresh()->newsletter_subscribed_at)->toBeNull();
    });

    test('isSubscribedToNewsletter returns true when subscribed', function () {
        $member = Member::factory()->create([
            'newsletter_subscribed' => true,
            'newsletter_subscribed_at' => now(),
        ]);

        expect($member->isSubscribedToNewsletter())->toBeTrue();
    });

    test('isSubscribedToNewsletter returns false when not subscribed', function () {
        $member = Member::factory()->create([
            'newsletter_subscribed' => false,
            'newsletter_subscribed_at' => null,
        ]);

        expect($member->isSubscribedToNewsletter())->toBeFalse();
    });

    test('timestamp updates correctly on subscription state changes', function () {
        $member = Member::factory()->create([
            'newsletter_subscribed' => false,
            'newsletter_subscribed_at' => null,
        ]);

        // Subscribe
        $member->subscribeToNewsletter();
        $firstSubscribedAt = $member->fresh()->newsletter_subscribed_at;
        expect($firstSubscribedAt)->not->toBeNull();

        // Unsubscribe
        $member->unsubscribeFromNewsletter();
        expect($member->fresh()->newsletter_subscribed_at)->toBeNull();

        // Subscribe again
        sleep(1); // Ensure timestamp difference
        $member->subscribeToNewsletter();
        $secondSubscribedAt = $member->fresh()->newsletter_subscribed_at;
        
        expect($secondSubscribedAt)->not->toBeNull();
        expect($secondSubscribedAt->greaterThan($firstSubscribedAt))->toBeTrue();
    });
});
