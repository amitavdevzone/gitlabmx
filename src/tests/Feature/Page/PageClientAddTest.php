<?php

use App\Enums\ClientStatusEnum;
use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('shows the add client form', function () {
    // Arrange
    $user = User::factory()->create();

    // Act
    $this->actingAs($user);

    // Assert
    get(route('clients.create'))
        ->assertSee([
            'Client name',
        ])
        ->assertOk();
});

it('needs all the required fields to create a client', function () {
    // Arrange
    $user = User::factory()->create();

    // Act
    $this->actingAs($user);

    // Assert
    post(route('clients.store'), [])
        ->assertSessionHasErrors(keys: ['name']);
});

it('saves the client to db', function () {
    // Arrange
    $user = User::factory()->create();

    // Act
    $this->actingAs($user);

    // Assert
    $matchName = 'My first client';
    post(route('clients.store'), ['name' => $matchName]);

    $this->assertDatabaseCount('clients', 1);
    $this->assertDatabaseHas('clients', ['name' => $matchName]);
});

it('does not save a duplicate client', function () {
    // Arrange
    $user = User::factory()->create();
    $client = Client::factory()->create();

    // Act
    $this->actingAs($user);

    // Assert
    post(route('clients.store'), ['name' => $client->name])
        ->assertSessionHasErrors(keys: ['name']);
});

it('makes new client active', function () {
    // Arrange
    $user = User::factory()->create();

    // Act
    $this->actingAs($user);

    // Assert
    $clientMatch = 'My first client';
    post(route('clients.store'), ['name' => $clientMatch]);

    $this->assertDatabaseCount('clients', 1);
    $this->assertDatabaseHas('clients', ['name' => $clientMatch, 'is_active' => ClientStatusEnum::ACTIVE]);
});

it('redirects back after client is saved', function () {
    // Arrange
    $user = User::factory()->create();

    // Act
    $this->actingAs($user);

    // Assert
    post(route('clients.store'), ['name' => 'My first client'])
        ->assertRedirect(route('clients.index'));
});
