<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows a list of projects', function () {
    // Arrange
    $projectA = Project::factory()->create();
    $projectB = Project::factory()->create();

    $this->actingAs(User::factory()->create());

    // Act
    get(route('projects.index'))
        ->assertSeeText([
            $projectA->name,
            $projectA->visibility,
            $projectB->name,
            $projectB->visibility,
        ]);

    // Assert
});

it('shows the project with latest activity on top', function () {
    $this->actingAs(User::factory()->create());

    // Arrange
    $projectA = Project::factory()->create(['updated_at' => now()->subDay()]);
    $projectB = Project::factory()->create(['updated_at' => now()]);

    // Act & Assert
    get(route('projects.index'))
        ->assertSeeTextInOrder([
            $projectB->name,
            $projectA->name,
        ]);
});

it('shows n projects only', function () {
    // Arrange
    Project::factory()->count(10)->create();
    $projectNext = Project::factory()->create(['updated_at' => now()->subDay(), 'name' => 'Test project']);

    // Act & Assert
    get(route('projects.index'))
        ->assertDontSeeText([
            $projectNext->name,
        ]);
});
