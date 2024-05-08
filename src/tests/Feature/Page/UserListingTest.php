<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows a list of users', function () {
    // Arrange
    $user = User::factory()->create(['name' => 'Amitav']);
    User::factory(3)->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('users.index'))
        ->assertOk()
        ->assertSee('Amitav');
});

it('shows the user list sorted by name', function () {
    // Arrange
    $user = User::factory()->create(['name' => 'Amitav']);
    User::factory()->create(['name' => 'Jhon']);

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('users.index'))
        ->assertOk()
        ->assertSeeInOrder([
            'Amitav',
            'Jhon',
        ]);
});
