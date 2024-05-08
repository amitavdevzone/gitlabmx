<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;
use function Pest\Laravel\patch;

uses(RefreshDatabase::class);

it('shows the name of the user', function () {
    // Arrange
    $user = User::factory()->create();

    // Act
    $this->actingAs($user);

    // Assert
    get(route('users.show', ['user' => $user]))
        ->assertOk()
        ->assertSeeText($user->name);
});

it('updates the name', function () {
    // Arrange
    $user = User::factory()->create();

    // Act
    $this->actingAs($user);

    // Assert
    patch(route('users.update', ['user' => $user]), ['name' => 'Something random']);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Something random',
    ]);
});
