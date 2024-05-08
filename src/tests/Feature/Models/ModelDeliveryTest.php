<?php

use App\Models\Delivery;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('delivery belongs to a project', function () {
    // Arrange
    $delivery = Delivery::factory()->create();

    // Act & Assert
    expect($delivery->project)->toBeInstanceOf(Project::class);
});

test('delivery belongs to an owner', function () {
    // Arrange
    $delivery = Delivery::factory()->create();

    // Act & Assert
    expect($delivery->owner)->toBeInstanceOf(User::class);
});
