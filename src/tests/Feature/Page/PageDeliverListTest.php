<?php

use App\Models\Delivery;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows the list of deliveries for that project', function () {
    // Arrange
    $delivery = Delivery::factory()->create();

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('deliveries.index', ['project' => $delivery->project_id]))
        ->assertSeeText([
            $delivery->title,
        ])
        ->assertOk();
});

it('shows the recent on top', function () {
    // Arrange
    $project = Project::factory()->create();
    $delivery = Delivery::factory()->create([
        'project_id' => $project->id,
        'updated_at' => now()->subHour(),
    ]);
    $deliveryNew = Delivery::factory()->create([
        'updated_at' => now()->addMinute(),
        'project_id' => $project->id,
    ]);

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('deliveries.index', ['project' => $project]))
        ->assertSeeInOrder([
            $deliveryNew->title,
            $delivery->title,
        ])
        ->assertOk();
});

it('shows the paginated data', function () {
    // Arrange
    $project = Project::factory()->create();
    $delivery = Delivery::factory(10)->create([
        'project_id' => $project->id,
    ]);
    $deliveryOld = Delivery::factory()->create([
        'updated_at' => now()->subHour(),
        'project_id' => $project->id,
        'title' => 'Dont see delivery',
    ]);

    // Act
    $this->actingAs(User::factory()->create());

    // Assert
    get(route('deliveries.index', ['project' => $project]))
        ->assertDontSeeText([$deliveryOld->title])
        ->assertOk();
});
