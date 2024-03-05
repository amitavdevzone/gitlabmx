<?php

use App\Models\Issue;
use App\Models\Project;
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

it('shows the project issue list page', function () {
    // Arrange
    $user = User::factory()->create();
    $project = Project::factory()->create();

    // Act
    $this->actingAs($user);

    // Assert
    get(route('issues.index', ['project' => $project]))
        ->assertOk();
});

it('shows the issue detail view', function () {
    // Arrange
    $project = Project::factory()->create();
    $issue = Issue::factory()->create(['project_id' => $project->project_id]);

    // Act & Assert
    get(route('issues.show', ['project' => $project, 'issue' => $issue]))
        ->assertOk();
});
