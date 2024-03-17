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
