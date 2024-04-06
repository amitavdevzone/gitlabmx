<?php

use App\Livewire\GitlabIssueView;
use App\Models\Estimate;
use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('renders on the issue page', function () {
    // Arrange
    $issue = Issue::factory()->for(Project::factory())->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('issues.show', ['project' => $issue->project->project_id, 'issue' => $issue->gitlab_id]))
        ->assertSeeLivewire(GitlabIssueView::class)
        ->assertSee($issue->title)
        ->assertOk();
});

it('updates the estimate id when selected', function () {
    // Arrange
    $estimate = Estimate::factory()->create(['title' => 'Login estimate']);
    $issue = Issue::factory()->for(Project::factory())->create(['estimate_id' => $estimate->id]);

    // Act
    $this->actingAs(User::factory()->create());

    Livewire::test(GitlabIssueView::class, [
        'project' => $issue->project,
        'issue' => $issue,
        'estimateId' => $estimate->id,
    ])->set('estimateId', 2);

    $this->assertDatabaseHas('issues', [
        'id' => $issue->id,
        'estimate_id' => 2,
    ]);
});
