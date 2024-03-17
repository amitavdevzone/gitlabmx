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
    $data = [
        'user_id' => User::factory()->create()->id,
        'client_id' => Client::factory()->create()->id,
        'project_id' => Project::factory()->create()->id,
        'issue_id' => Issue::factory()->create()->id,
        'description' => 'My time entry',
        'time' => 60,
    ];

    // Act
    $this->actingAs(User::factory()->create());
    post(route('time-entry.store'), $data);

    // Assert
    $this->assertDatabaseCount('time_entries', 1);
    $this->assertDatabaseHas('time_entries', $data);
});

it('requires all necessary fields', function () {
    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    post(route('time-entry.store'), [])
        ->assertSessionHasErrors(['user_id', 'client_id', 'project_id', 'description', 'time'])
        ->assertSessionDoesntHaveErrors(['issue_id']);
});

it('requires a user to be present', function () {
    // Arrange
    $data = [
        'user_id' => 9999,
        'client_id' => Client::factory()->create()->id,
        'project_id' => Project::factory()->create()->id,
        'issue_id' => Issue::factory()->create()->id,
        'description' => 'My time entry',
        'time' => 60,
    ];

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    post(route('time-entry.store'), $data)->assertSessionHasErrors(['user_id']);
});

it('requires a client to be present', function () {
    // Arrange
    $data = [
        'user_id' => User::factory()->create()->id,
        'client_id' => 111,
        'project_id' => Project::factory()->create()->id,
        'issue_id' => Issue::factory()->create()->id,
        'description' => 'My time entry',
        'time' => 60,
    ];

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    post(route('time-entry.store'), $data)->assertSessionHasErrors(['client_id']);
});

it('requires a project to be present', function () {
    // Arrange
    $data = [
        'user_id' => User::factory()->create()->id,
        'client_id' => Client::factory()->create()->id,
        'project_id' => 111,
        'issue_id' => Issue::factory()->create()->id,
        'description' => 'My time entry',
        'time' => 60,
    ];

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    post(route('time-entry.store'), $data)->assertSessionHasErrors(['project_id']);
});
