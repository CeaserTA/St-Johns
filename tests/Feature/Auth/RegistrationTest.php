<?php

use App\Models\Member;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register when member record exists', function () {
    // Create a member record first
    $member = Member::factory()->create([
        'email' => 'test@example.com',
        'full_name' => 'Test User',
        'user_id' => null, // No linked account yet
    ]);

    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('services'));
    
    // Verify the member is now linked to the user
    $member->refresh();
    expect($member->user_id)->not->toBeNull();
});

test('guests without member record are redirected to member registration', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'nonmember@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertRedirect();
    $response->assertSessionHas('error', 'You must register as a church member before creating an account.');
    $response->assertSessionHas('show_member_registration', true);
});

test('members with existing accounts cannot create duplicate accounts', function () {
    // Create a member with an existing linked account
    $user = \App\Models\User::factory()->create([
        'email' => 'existing@example.com',
    ]);
    
    $member = Member::factory()->create([
        'email' => 'existing@example.com',
        'user_id' => $user->id,
    ]);

    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'existing@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertSessionHasErrors('email');
});
