<?php

use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows a list of tickets on that project', function () {
    // Arrange
    $project = Project::factory()->create();
    $issue = Issue::factory()->create(['project_id' => $project->project_id]);

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('issues.index', ['project' => $project]))
        ->assertSeeText([
            $issue->title,
        ])
        ->assertOk();
});

it('shows a list of open tickets only', function () {
    // Arrange
    $project = Project::factory()->create();
    $issue = Issue::factory()->create([
        'title' => 'Open ticket title',
        'project_id' => $project->project_id,
    ]);
    $closed = Issue::factory()->closed()->create([
        'title' => 'Closed ticket title',
        'project_id' => $project->project_id,
    ]);

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('issues.index', ['project' => $project]))
        ->assertSeeText([
            $issue->title,
        ])
        ->assertDontSeeText([
            $closed->title,
        ])
        ->assertOk();
});

it('shows the recently updated ticket on top', function () {
    // Arrange
    $project = Project::factory()->create();
    $issueOlder = Issue::factory()->create(['project_id' => $project->project_id, 'updated_at' => now()->subDays(2)]);
    $issueOld = Issue::factory()->create(['project_id' => $project->project_id, 'updated_at' => now()->subDays(1)]);
    $issueNew = Issue::factory()->create(['project_id' => $project->project_id, 'updated_at' => now()]);

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('issues.index', ['project' => $project]))
        ->assertSeeInOrder([
            $issueNew->title,
            $issueOld->title,
            $issueOlder->title,
        ])
        ->assertOk();
});

it('shows few critical information of a ticket', function () {
    // Arrange
    $user = User::factory()->create();
    $project = Project::factory()->create();
    $issue = Issue::factory()->create(['project_id' => $project->project_id]);

    // Act
    $this->actingAs($user);

    // Assert
    get(route('issues.index', ['project' => $project]))
        ->assertSee([
            $issue->title,
            $issue->state,
        ])
        ->assertOk();
});

it('shows tickets n tickets on the listing page', function () {
    // Arrange
    $project = Project::factory()->create();
    $latest = Issue::factory()->create(['project_id' => $project->project_id]);
    Project::factory()->count(10)
        ->create(['project_id' => $project->project_id, 'updated_at' => now()->subDay()]);

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('issues.index', ['project' => $project]))
        ->assertSee([
            $latest->title,
        ])
        ->assertOk();
});

it('shows assigned to user when assigned', function () {
    // Arrange
    $user = User::factory()->create();
    $project = Project::factory()->create();
    $issue = Issue::factory()->create(['assigned_to' => $user->gitlab_id, 'project_id' => $project->project_id]);

    // Act
    $this->actingAs($user);

    // Assert
    get(route('issues.index', ['project' => $project]))
        ->assertSeeText([
            'Assigned to '.$user->name,
        ])
        ->assertOk();
});

it('does not show assigned to when issue not assigned', function () {
    $user = User::factory()->create(['name' => 'Mr. Xavier Troller']);
    $project = Project::factory()->create();
    Issue::factory()->create(['assigned_to' => 99, 'project_id' => $project->project_id]);

    // Act
    $this->actingAs($user);

    // Assert
    get(route('issues.index', ['project' => $project]))
        ->assertDontSeeText([
            'Assigned to '.$user->name,
        ])
        ->assertOk();
});

it('shows the issue author name', function () {
    // Arrange
    $user = User::factory()->create(['name' => 'Mr. Xavier Troller']);
    $project = Project::factory()->create();
    Issue::factory()->create(['author_id' => $user->gitlab_id, 'project_id' => $project->project_id]);

    // Act
    $this->actingAs($user);

    // Assert
    get(route('issues.index', ['project' => $project]))
        ->assertDontSeeText([
            'Author '.$user->name,
        ])
        ->assertOk();
});
