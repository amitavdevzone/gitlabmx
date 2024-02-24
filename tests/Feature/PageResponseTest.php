<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows the home page', function () {
    get(route('home'))
        ->assertOk();
});

it('shows the project listing page', function () {
    // Act & Assert
    get(route('projects.index'))
        ->assertOk();
});

it('shows the project fetch page', function () {
    // Arrange
    $user = User::factory()->create();

    // Act
    $this->actingAs($user);

    // Assert
    get(route('projects.create'))->assertOk();
});
