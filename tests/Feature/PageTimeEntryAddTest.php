<?php

use App\Models\Client;
use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('adds a time entry when data is proper', function () {
    // Arrange
    $project = Project::factory()->create(['client_id' => 1]);
    $issue = Issue::factory()->create(['project_id' => $project->project_id]);
    $data = [
        'issue_id' => $issue->id,
        'description' => 'My time entry',
        'time' => 60,
    ];

    // Act
    $this->actingAs(User::factory()->create());
    post(route('time-entries.store'), $data);

    // Assert
    $this->assertDatabaseCount('time_entries', 1);
    $this->assertDatabaseHas('time_entries', $data);
});

it('requires all necessary fields', function () {
    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    post(route('time-entries.store'), [])
        ->assertSessionHasErrors(['description', 'time'])
        ->assertSessionDoesntHaveErrors(['issue_id']);
});

it('adds the current logged in user', function () {
    // Arrange
    $user = User::factory()->create();
    $issue = Issue::factory()->create([
        'project_id' => Project::factory()->create(['client_id' => 1])->project_id,
    ]);

    $data = [
        'issue_id' => $issue->id,
        'description' => 'My time entry',
        'time' => 60,
    ];

    // Act
    $this->actingAs($user);

    // Assert
    post(route('time-entries.store'), $data);

    $this->assertDatabaseHas('time_entries', [
        'user_id' => $user->id,
    ]);
});

it('assigns the client based on the project', function () {
    // Arrange
    $user = User::factory()->create();
    $client = Client::factory()->create();
    $project = Project::factory()->create(['client_id' => $client->id]);
    $issue = Issue::factory()->create(['project_id' => $project->project_id]);

    $data = [
        'issue_id' => $issue->id,
        'description' => 'My time entry',
        'time' => 60,
    ];

    // Act
    $this->actingAs($user);

    // Assert
    post(route('time-entries.store'), $data);

    $this->assertDatabaseHas('time_entries', [
        'client_id' => $client->id,
    ]);
});

it('requires a project to be present', function () {
    // Arrange
    $user = User::factory()->create();
    $client = Client::factory()->create();
    $project = Project::factory()->create(['client_id' => $client->id]);
    $issue = Issue::factory()->create(['project_id' => $project->project_id]);

    $data = [
        'issue_id' => $issue->id,
        'description' => 'My time entry',
        'time' => 60,
    ];

    // Act
    $this->actingAs($user);

    // Assert
    post(route('time-entries.store'), $data);

    $this->assertDatabaseHas('time_entries', [
        'project_id' => $project->id,
    ]);
});
