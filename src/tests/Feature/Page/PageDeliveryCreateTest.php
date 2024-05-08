<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('adds a delivery for the project', function () {
    // Arrange
    $project = Project::factory()->create();

    $data = [
        'title' => 'Delivery title',
        'description' => 'Delivery description',
        'start_date' => now()->format('Y-m-d'),
        'end_date' => now()->addDays(4)->format('Y-m-d'),
    ];

    // Act
    $this->actingAs(User::factory()->create());
    post(route('deliveries.store', ['project' => $project]), $data);

    // Assert
    $this->assertDatabaseHas('deliveries', $data);
});

it('redirects to listing', function () {
    // Arrange
    $project = Project::factory()->create();

    $data = [
        'title' => 'Delivery title',
        'description' => 'Delivery description',
        'start_date' => now()->format('Y-m-d'),
        'end_date' => now()->addDays(4)->format('Y-m-d'),
    ];

    // Act
    $this->actingAs(User::factory()->create());
    post(route('deliveries.store', ['project' => $project]), $data)
        ->assertRedirect(route('deliveries.index', ['project' => $project]));
});

it('requires all the fields', function () {
    // Arrange
    $project = Project::factory()->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    post(route('deliveries.store', ['project' => $project]), [])
        ->assertSessionHasErrors(['title', 'start_date', 'end_date']);
});

it('start and end dates needs to be proper format', function () {
    // Arrange
    $project = Project::factory()->create();

    $data = [
        'title' => 'Delivery title',
        'description' => 'Delivery description',
        'start_date' => now()->format('d-m-Y'),
        'end_date' => now()->addDays(4)->format('m-d-Y'),
    ];

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    post(route('deliveries.store', ['project' => $project]), $data)
        ->assertSessionHasErrors(['start_date', 'end_date']);
});
