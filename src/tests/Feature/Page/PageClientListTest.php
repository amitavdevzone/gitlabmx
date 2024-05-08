<?php

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows the client list', function () {
    // Arrange
    Client::factory(2)->create();
    $client = Client::factory()->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('clients.index'))
        ->assertSeeText([$client->name])
        ->assertOk();
});

it('shows paginated data', function () {
    // Arrange
    $client = Client::factory()->create(['created_at' => now()->subMinute()]);
    Client::factory(10)->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('clients.index'))
        ->assertDontSeeText([$client->name])
        ->assertOk();
});

it('shows the latest', function () {
    // Arrange
    $client = Client::factory()->create(['created_at' => now()]);
    Client::factory(10)->create(['created_at' => now()->subMinute()]);

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('clients.index'))
        ->assertSeeText([$client->name])
        ->assertOk();
});

it('shows the project count', function () {
    // Arrange
    $client = Client::factory()->create(['created_at' => now()]);
    Project::factory()->count(77)->create(['client_id' => $client->id]);

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('clients.index'))
        ->assertSeeText([
            77,
        ])
        ->assertOk();
});
