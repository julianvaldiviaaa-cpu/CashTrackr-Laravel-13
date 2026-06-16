<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

it('shows the login screen', function () {
    $response = $this->get(route('login'));
    $response->assertOk();
});

it('logs in a verified user succesfully', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('12345678'),
        'email_verified_at' => now(),
    ]);

    $response = $this->post(route('login.store'), [
        'email' => 'test@example.com',
        'password' => '12345678',
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticated();
});

it('does not log in with invalid credentials', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('12345678'),
    ]);

    $response = $this->from(route('login'))->post(route('login.store'), [
        'email' => 'test@example.com',
        'password' => '1234567890',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHas("error", "Contraseña Incorrecta.");

    $this->assertGuest();
});

it("prevents unverified user form accessing dashboard", function(){
    User::factory()->unverified()->create([
        "email" => "test@example.com",
        "password" => bcrypt("12345678"),
    ]);

    $response = $this->post(route("login.store"), [
        "email" => "test@example.com",
        "password" => "12345678",
    ]);

    $response->assertRedirect(route("dashboard"));
    $this->assertAuthenticated();

    $dashboardResponse = $this->get(route("dashboard"));
    $dashboardResponse->assertRedirect(route("verification.notice"));
});

it("does not allow access to dashboard if email is not verified", function(){
    $user = User::factory()->create([
        "email_verified_at" => null,
    ]);

    $response = $this->actingAs($user)->get(route("dashboard"));
    $response->assertRedirect(route("verification.notice")); 
});

it("allow acces to dashboard if email is verified", function(){
    $user = User::factory()->create([
        "email_verified_at" => now(),
    ]);

    $response = $this->actingAs($user)->get(route("dashboard"));
    $response->assertOk();
});

it("fails login if user does not exist", function(){
    $response = $this->from(route("login"))->post(route("login.store"),[
        "email" => "test@example.com",
        "password" => "12345678",
    ]);

    $response->assertRedirect(route("login"));
    $response->assertSessionHasErrors([
        "email" => "No encontramos una cuenta con ese correo electrónico.",
    ]);

    $this->assertGuest();
});