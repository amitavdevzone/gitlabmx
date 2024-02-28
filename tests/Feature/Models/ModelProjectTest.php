<?php

use App\Models\Issue;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('project has issues', function () {
    // Arrange
    $project = Project::factory()
        ->has(Issue::factory()->count(3))
        ->create();

    // Act & Assert
    expect($project->issues)->each->toBeInstanceOf(Issue::class);
});
