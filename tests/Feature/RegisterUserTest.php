<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
use App\Models\User;
use App\Notifications\verifyEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

it('shows the registration screen', function () {
    $response = $this->get(route('register'));
    $response->assertStatus(200);
});

it('registers a new user as unverified and dispatches the registered event', function () {
    Event::fake();

    $response = $this->post(route('register.store'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ]);

    $response->assertRedirect(route('verification.notice'));

    $user = User::where('email', 'test@example.com')->first();

    expect($user)->not()->toBeNull();
    expect($user->name)->toBe('Test User');
    expect($user->email)->toBe('test@example.com');
    expect($user->hasVerifiedEmail())->toBeFalse();

    Event::assertDispatched(Registered::class);
});

it('should validate required fields when the request body is empty', function () {
    $response = $this->post(route('register.store'), []);

    $response->assertSessionHasErrors(['name', 'email', 'password']);
});

it('prevents duplicate email addresses', function () {
    User::factory()->create([
        'email' => 'test@example.com',
    ]);

    $response = $this->post(route('register.store'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ]);

    $response->assertRedirect();

    $response->assertSessionHasErrors([
        'email' => 'El E-mail ya está en uso',
    ]);
});

it('sends the verification email notification after registration', function () {
    Notification::fake();

    $response = $this->post(route('register.store'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
    ]);

    $user = User::where('email', 'test@example.com')->first();

    Notification::assertSentTo($user, verifyEmail::class);
});

it('verifies the user email from a signed verification link', function () {
    $user = User::factory()->unverified()->create();

    $verificationUrl = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
        'id' => $user->id,
        'hash' => sha1($user->email),
    ]);

    $response = $this->actingAs($user)->get($verificationUrl);
    $response->assertRedirect(route('dashboard')); 

    expect($user->hasVerifiedEmail())->toBeTrue();
});

it("does not allow an unverified user to access the dashboard", function(){
    $user = User::factory()->unverified()->create();

    $response = $this->actingAs($user)->get(route('dashboard'));
    $response->assertRedirect(route('verification.notice'));
});

it("allows a verified user to access the dashboard", function(){
    $user = User::factory()->create([
        "email_verified_at" => now(),
    ]);

    $response = $this->actingAs($user)->get(route('dashboard'));
    $response->assertOK();
});