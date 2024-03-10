<?php

use App\Models\Client;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has a project', function () {
    // Arrange
    $client = Client::factory()->create();
    Project::factory()->create(['client_id' => $client->id]);

    // Act & Assert
    expect($client->projects)->each->toBeInstanceOf(Project::class);
});
