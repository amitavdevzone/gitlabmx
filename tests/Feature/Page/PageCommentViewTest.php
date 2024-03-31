<?php

use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows comments for an issue', function () {
    // Arrange
    $issue = Issue::factory()->create(['project_id' => Project::factory()->create()->project_id]);
    $comment = Comment::factory()->forIssue()->create(['noteable_id' => $issue->gitlab_id]);

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('issues.show', ['project' => $issue->project_id, 'issue' => $issue->gitlab_id]))
        ->assertSeeText([
            $issue->title,
            $comment->body,
            $comment->updated_at->diffForHumans(),
        ])
        ->assertOk();
});

it('shows recent comment on top', function () {
    // Arrange
    $user = User::factory()->create();
    $issue = Issue::factory()->create(['project_id' => Project::factory()->create()->project_id]);
    $comment = Comment::factory()->forIssue()->create(['noteable_id' => $issue->gitlab_id]);
    $commentOld = Comment::factory()
        ->forIssue()->create(['noteable_id' => $issue->gitlab_id, 'updated_at' => now()->subDays(2)]);

    // Act
    $this->actingAs($user);

    // Assert
    get(route('issues.show', ['project' => $issue->project_id, 'issue' => $issue->gitlab_id]))
        ->assertSeeTextInOrder([
            $comment->body,
            $commentOld->body,
        ])
        ->assertOk();
});

it('does not show comments when issue has no comment', function () {
    // Arrange
    $project = Project::factory()->create();
    $issue = Issue::factory()->create(['project_id' => $project->project_id]);

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('issues.show', ['project' => $project, 'issue' => $issue]))
        ->assertDontSee('Comments')
        ->assertOk();
});
