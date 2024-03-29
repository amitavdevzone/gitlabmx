<?php

use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('it shows ticket information', function () {
    // Arrange
    $user = User::factory()->create();
    $project = Project::factory()->create();
    $issue = Issue::factory()->create(['project_id' => $project->project_id]);

    // Act
    $this->actingAs($user);

    // Assert
    get(route('issues.show', ['project' => $project, 'issue' => $issue]))
        ->assertOk()
        ->assertSeeText([
            $issue->title,
            $issue->description,
            $issue->state,
        ]);
});

it('it shows 404 when the ticket does not exist', function () {
    // Arrange
    $user = User::factory()->create();
    $project = Project::factory()->create();

    // Act
    $this->actingAs($user);

    // Assert
    get(route('issues.show', ['project' => $project, 'issue' => 99]))
        ->assertNotFound();
});

it('it shows the correct state of the ticket', function () {
    // Arrange
    $user = User::factory()->create();
    $project = Project::factory()->create();
    $issue = Issue::factory()->create(['project_id' => $project->project_id]);

    // Act
    $this->actingAs($user);

    // Assert
    get(route('issues.show', ['project' => $project, 'issue' => $issue]))
        ->assertSeeText([
            $issue->state,
            $issue->title,
        ])
        ->assertOk();
});
