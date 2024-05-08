<?php

use App\Models\Delivery;
use App\Models\Estimate;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows the estimate list page', function () {
    // Arrange
    $estimate = Estimate::factory()
        ->has(Project::factory()->has(Delivery::factory()))
        ->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('estimates.index', ['project' => $estimate->project_id, 'delivery' => $estimate->delivery_id]))
        ->assertSee($estimate->title)
        ->assertOk();
});

it('shows paginated data', function () {
    // Arrange
    Estimate::factory(10)
        ->has(Project::factory()->has(Delivery::factory()))
        ->create();
    $estimate = Estimate::factory()
        ->has(Project::factory()->has(Delivery::factory()))
        ->create(['title' => 'Latest estimate']);

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('estimates.index', ['project' => $estimate->project_id, 'delivery' => $estimate->delivery_id]))
        ->assertSee($estimate->title)
        ->assertOk();
});

it('does not show completed estimate', function () {
    // Arrange
    $estimate = Estimate::factory()
        ->completed()
        ->has(Project::factory()->has(Delivery::factory()))
        ->create(['title' => 'Latest estimate']);

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('estimates.index', ['project' => $estimate->project_id, 'delivery' => $estimate->delivery_id]))
        ->assertDontSee($estimate->title)
        ->assertOk();
});
