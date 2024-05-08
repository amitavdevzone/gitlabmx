<?php

use App\Models\Client;
use App\Models\Delivery;
use App\Models\Estimate;
use App\Models\Issue;
use App\Models\Project;
use App\Models\TimeEntry;
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

it('returns false when the issue is not present', function () {
    // Arrange
    $timeEntry = TimeEntry::factory()->make();
    $service = app()->make(TimeEntryService::class);

    // Act & Assert
    expect($service->updateEstimateAndDelivery($timeEntry))->toBeFalse();
});

it('returns false when the time entry is not mapped to estimate', function () {
    // Arrange
    $timeEntry = TimeEntry::factory()
        ->for(Issue::factory(['estimate_id' => null]))
        ->create();
    $service = app()->make(TimeEntryService::class);

    // Act & Assert
    expect($service->updateEstimateAndDelivery($timeEntry))->toBeFalse();
});

it('returns false when delivery is not present', function () {
    $timeEntry = TimeEntry::factory()
        ->for(Issue::factory(['estimate_id' => null]))
        ->create();

    $service = app()->make(TimeEntryService::class);

    // Act & Assert
    expect($service->updateEstimateAndDelivery($timeEntry))->toBeFalse();
});

it('updates the delivery and estimate completed hours', function () {
    Event::fake();

    // Arrange
    $delivery = Delivery::factory()->create([
        'is_complete' => 0,
        'estimated_hours' => 1,
        'progress_complete' => 0,
        'completed_hours' => 0,
    ]);
    $estimate = Estimate::factory()->create([
        'estimated_hours' => 1,
        'delivery_id' => $delivery->id,
        'progress_percentage' => 0,
        'completed_hours' => 0,
    ]);
    $issue = Issue::factory()->create([
        'estimate_id' => $estimate->id,
    ]);

    $timeEntry = TimeEntry::factory()
        ->create([
            'time' => 30,
            'issue_id' => $issue->id,
        ]);

    // Act & Assert
    $service = app()->make(TimeEntryService::class);
    $service->updateEstimateAndDelivery($timeEntry);

    $this->assertDatabaseHas('estimates', [
        'id' => $estimate->id,
        'estimated_hours' => 1,
        'completed_hours' => 0.5,
    ]);

    $this->assertDatabaseHas('deliveries', [
        'id' => $delivery->id,
        'estimated_hours' => 1,
        'completed_hours' => 0.5,
    ]);
});
