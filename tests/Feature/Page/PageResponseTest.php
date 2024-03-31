<?php

use App\Models\Client;
use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows the home page', function () {
    get(route('home'))
        ->assertRedirect();
});

it('shows the project listing page', function () {
    $this->actingAs(User::factory()->create());
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

it('shows the login page', function () {
    get(route('login'))
        ->assertOk();
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

    $this->actingAs(User::factory()->create());

    // Act & Assert
    get(route('issues.show', ['project' => $project, 'issue' => $issue]))
        ->assertOk();
});

it('shows the client list page', function () {
    // Arrange
    $client = Client::factory()->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('clients.index'))->assertOk();
});

it('shows the project edit page', function () {
    // Arrange
    $project = Project::factory()->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('projects.show', ['project' => $project]))->assertOk();
});

it('shows the delivery create page', function () {
    // Arrange
    $project = Project::factory()->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('deliveries.create', ['project' => $project]))->assertOk();
});
