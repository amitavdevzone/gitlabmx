<?php

use App\Events\FetchGitlabProjectEvent;
use App\Listeners\FetchGitlabProjectListener;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;
use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('shows a form with field to add project id', function () {
    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('projects.create'))
        ->assertSeeText([
            'Fetch Project from Gitlab',
            'Enter the project ID so that we can fetch the information from Gitlab',
        ])
        ->assertOk();
});

it('raises an event when project is requested', function () {
    // Arrange
    Event::fake();

    // Act
    post(route('projects.store'), ['project_id' => 123]);

    // Assert
    Event::assertListening(
        expectedEvent: FetchGitlabProjectEvent::class,
        expectedListener: FetchGitlabProjectListener::class
    );
});

it('shows error if project already exist', function () {
    // Arrange
    $project = Project::factory()->create();
    $this->actingAs(User::factory()->create());

    // Act & Assert
    post(route('projects.store'), ['project_id' => $project->project_id])
        ->assertSessionHasErrors(keys: ['project_id']);
});
