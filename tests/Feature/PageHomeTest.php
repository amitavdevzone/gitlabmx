<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('redirects guest to login form', function () {
    get(route('dashboard'))->assertRedirect(route('login'));
});

it('redirects logged in user to dashboard', function () {
    $this->actingAs(User::factory()->create());

    get(route('home'))->assertRedirect(route('dashboard'));
});
