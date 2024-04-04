<?php

use App\Models\Delivery;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;
use function Pest\Laravel\patch;

uses(RefreshDatabase::class);

it('shows the current delivery data', function () {
    // Arrange
    $project = Project::factory()->create();
    $delivery = Delivery::factory()->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('deliveries.edit', ['project' => $project, 'delivery' => $delivery]))
        ->assertSee([
            $delivery->title,
            $delivery->description,
            $delivery->start_date->format('Y-m-d'),
            $delivery->end_date->format('Y-m-d'),
        ])
        ->assertOk();
});

it('updates with new values', function () {
    // Arrange
    $project = Project::factory()->create();
    $delivery = Delivery::factory()->create();

    $data = [
        'title' => 'New title',
        'description' => 'New desc',
        'start_date' => now()->format('Y-m-d'),
        'end_date' => now()->addDays(5)->format('Y-m-d'),
    ];

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    patch(route('deliveries.update', ['project' => $project, 'delivery' => $delivery]), $data);

    $this->assertDatabaseHas('deliveries', [
        ...$data,
        'id' => $delivery->id,
    ]);
});

it('requires all fields', function () {
    // Arrange
    $project = Project::factory()->create();
    $delivery = Delivery::factory()->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    patch(route('deliveries.update', ['project' => $project, 'delivery' => $delivery]), [])
        ->assertSessionHasErrors(['title', 'start_date', 'end_date']);
});
