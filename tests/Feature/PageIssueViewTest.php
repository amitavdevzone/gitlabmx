<?php

use App\Models\Issue;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows ticket information', function () {
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

it('shows 404 when the ticket does not exist', function () {
    // Arrange
    $user = User::factory()->create();
    $project = Project::factory()->create();

    // Act
    $this->actingAs($user);

    // Assert
    get(route('issues.show', ['project' => $project, 'issue' => 99]))
        ->assertNotFound();
});

it('shows the correct state of the ticket', function () {
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

it('shows the time entry link', function () {
    // Arrange
    $user = User::factory()->create();
    $project = Project::factory()->create();
    $issue = Issue::factory()->create(['project_id' => $project->project_id]);

    // Act
    $this->actingAs($user);

    // Assert
    get(route('issues.show', ['project' => $project, 'issue' => $issue]))
        ->assertSee(route('time-entries.create', ['issue_id' => $issue->id]))
        ->assertOk();
});

it('shows the total time spent', function () {
    // Arrange
    $user = User::factory()->create();
    $project = Project::factory()->create();
    $issue = Issue::factory()->create(['project_id' => $project->project_id]);
    TimeEntry::factory(2)->create(['issue_id' => $issue->id, 'time' => 60]);

    // Act
    $this->actingAs($user);

    // Assert
    get(route('issues.show', ['project' => $project, 'issue' => $issue]))
        ->assertSee(['Total time spent:', '2 hours'])
        ->assertOk();
});
