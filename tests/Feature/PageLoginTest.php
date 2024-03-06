<?php

use App\Events\UserLoggedInEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('shows the login form', function () {
    // Act & Assert
    get(route('login'))
        ->assertSeeText([
            'Please login',
            'Enter your email address',
            'Enter your password',
        ]);
});

it('shows error if email and password is not added', function () {
    // Act & Assert
    post(route('login.handle'), [])
        ->assertSessionHasErrors(['email', 'password']);
});

it('shows error if password is wrong', function () {
    // Arrange
    $user = User::factory()->create(['password' => 'safepass']);

    // Act & Assert
    $credentials = ['email' => $user->email, 'password' => 'wrongpass'];
    post(route('login.handle'), $credentials)
        ->assertSessionHasErrors(['password']);
});

it('redirects to home if login is successful', function () {
    // Arrange
    $password = 'safepass';
    $user = User::factory()->create(['password' => $password]);

    // Act & Assert
    $credentials = ['email' => $user->email, 'password' => $password];
    post(route('login.handle'), $credentials)
        ->assertRedirectToRoute('dashboard')
        ->assertSessionHas('success');
});

it('remembers login if checked', function () {
    // Arrange
    $password = 'safepass';
    $user = User::factory()->create(['password' => $password]);

    // Act & Assert
    $credentials = ['email' => $user->email, 'password' => $password];
    post(route('login.handle'), $credentials)
        ->assertRedirect(route('dashboard')); // TODO: Amitav to check how we can assert remember me cookie
});

it('raises an event when user logs in', function () {
    // Arrange
    Event::fake();
    $password = 'safepass';
    $user = User::factory()->create(['password' => $password]);

    // Act
    $credentials = ['email' => $user->email, 'password' => $password];
    post(route('login.handle'), $credentials);

    // Assert
    Event::assertDispatched(UserLoggedInEvent::class);
});
