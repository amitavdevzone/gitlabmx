<?php

use App\Models\Delivery;
use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user has many time entries', function () {
    $user = User::factory()
        ->has(TimeEntry::factory()->count(3), 'time_entries')
        ->create();

    expect($user->time_entries)->each->toBeInstanceOf(TimeEntry::class);
});

test('user has many deliveries', function () {
    // Arrange
    $user = User::factory()
        ->has(Delivery::factory()->count(3), 'deliveries')
        ->create();

    // Act & Assert
    expect($user->deliveries)->each->toBeInstanceOf(Delivery::class);
});
