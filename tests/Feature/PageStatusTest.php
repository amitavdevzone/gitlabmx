<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\get;

uses(RefreshDatabase::class);

it('shows the home page', function () {
    get(route('home'))
        ->assertOk();
});

it('shows the project listing page', function () {
    // Act & Assert
    get(route('projects.index'))
        ->assertOk();
});
