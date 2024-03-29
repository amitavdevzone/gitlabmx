<?php

use App\Models\Client;
use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use App\Services\TimeEntryService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('it makes a time entry with time entry', function () {
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
    $service = app()->make(TimeEntryService::class);
    $service->addTimeEntry($data);

    // Assert
    $this->assertDatabaseCount('time_entries', 1);
    $this->assertDatabaseHas('time_entries', $data);
});

it('starts an entry with correct data', function () {
    // Arrange
    $user = User::factory()->create();
    $client = Client::factory()->create();
    $project = Project::factory()->create(['client_id' => $client->id]);
    $issue = Issue::factory()->create(['project_id' => $project->project_id]);
    $service = app()->make(TimeEntryService::class);

    $data = [
        'user_id' => $user->id,
        'client_id' => $project->client_id,
        'project_id' => $project->id,
        'issue_id' => $issue->id,
        'time' => 0,
        'started_at' => now(),
    ];

    // Act
    $this->actingAs($user);
    $service->startTimeEntryForIssue($issue->id);

    // Assert
    $this->assertDatabaseHas('time_entries', $data);
});

it('throws 400 error if issue is not present', function () {
    // Arrange
    $user = User::factory()->create();
    $service = app()->make(TimeEntryService::class);

    // Act
    $this->actingAs($user);
    try {
        $service->startTimeEntryForIssue(33);
    } catch (Symfony\Component\HttpKernel\Exception\HttpException $e) {
        expect($e->getStatusCode())
            ->toBe(400)
            ->and($e->getMessage())
            ->toBe('Issue not found');
    }
});
