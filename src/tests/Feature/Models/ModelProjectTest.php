<?php

use App\Models\Client;
use App\Models\Delivery;
use App\Models\Issue;
use App\Models\Project;
use App\Models\TimeEntry;
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

test('project has many time entries', function () {
    $project = Project::factory()->has(TimeEntry::factory(3), 'time_entries')->create();

    expect($project->time_entries)->each->toBeInstanceOf(TimeEntry::class);
});

test('project has many deliveries', function () {
    // Arrange
    $project = Project::factory()->has(Delivery::factory(3), 'deliveries')->create();

    // Act & Assert
    expect($project->deliveries)->each->toBeInstanceOf(Delivery::class);
});
