<?php

use App\Models\Delivery;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('adds an estimate with proper data', function () {
    // Arrange
    $project = Project::factory()->create();
    $delivery = Delivery::factory()->create();

    $data = [
        'title' => 'Estimate title',
        'description' => 'Estimate description',
        'estimated_hours' => 30,
    ];

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    post(route('estimates.store', ['project' => $project, 'delivery' => $delivery]), $data)
        ->assertRedirectToRoute('estimates.index', ['project' => $project, 'delivery' => $delivery]);

    $this->assertDatabaseCount('estimates', 1);
    $this->assertDatabaseHas('estimates', [
        ...$data,
        'project_id' => $project->id,
        'delivery_id' => $delivery->id,
    ]);
});

it('ensures all necessary fields are required', function () {
    // Arrange
    $project = Project::factory()->create();
    $delivery = Delivery::factory()->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    post(route('estimates.store', ['project' => $project, 'delivery' => $delivery]), [])
        ->assertSessionHasErrors(['title', 'estimated_hours']);
});

it('estimated hours should be number', function () {
    // Arrange
    $project = Project::factory()->create();
    $delivery = Delivery::factory()->create();

    $data = [
        'title' => 'Estimate title',
        'description' => 'Estimate description',
        'estimated_hours' => 'asd',
    ];

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    post(route('estimates.store', ['project' => $project, 'delivery' => $delivery]), $data)
        ->assertSessionHasErrors(['estimated_hours']);
});
