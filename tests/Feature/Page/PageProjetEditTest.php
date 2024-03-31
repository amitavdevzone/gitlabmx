<?php

use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;
use function Pest\Laravel\patch;

uses(RefreshDatabase::class);

it('shows the project name', function () {
    // Arrange
    $project = Project::factory()->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('projects.show', ['project' => $project]))
        ->assertOk()
        ->assertSeeText($project->name);
});

it('updates the client id when sent', function () {
    // Arrange
    $client = Client::factory()->create();
    $project = Project::factory()->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    patch(route('projects.show', ['project' => $project]), ['client_id' => $client->id]);

    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'client_id' => $client->id,
    ]);
});

it('needs the client id', function () {
    // Arrange
    $project = Project::factory()->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    patch(route('projects.show', ['project' => $project]), [])
        ->assertSessionHasErrors(['client_id']);
});

it('needs the client to be present', function () {
    // Arrange
    $project = Project::factory()->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    patch(route('projects.show', ['project' => $project]), ['client_id' => 99])
        ->assertSessionHasErrors(['client_id']);
});
