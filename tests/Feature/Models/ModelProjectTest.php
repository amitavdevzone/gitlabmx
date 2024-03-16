<?php

use App\Models\Client;
use App\Models\Issue;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('project has issues', function () {
    // Arrange
    $project = Project::factory()
        ->has(Issue::factory()->count(3))
        ->create();

    // Act & Assert
    expect($project->issues)->each->toBeInstanceOf(Issue::class);
});

test('project belongs to a client', function () {
    // Arrange
    $client = Client::factory()->create();
    $project = Project::factory()->create(['client_id' => $client->id]);

    // Act & Assert
    expect($project->client)->toBeInstanceOf(Client::class);
});
