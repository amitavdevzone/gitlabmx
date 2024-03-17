<?php

use App\Models\Client;
use App\Models\Project;
use App\Models\TimeEntry;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has a project', function () {
    // Arrange
    $client = Client::factory()->create();
    Project::factory()->create(['client_id' => $client->id]);

    // Act & Assert
    expect($client->projects)->each->toBeInstanceOf(Project::class);
});

test('client has many time entries', function () {
    $client = Client::factory()
        ->has(TimeEntry::factory()->count(3), 'time_entries')
        ->create();

    expect($client->time_entries)->each->toBeInstanceOf(TimeEntry::class);
});
