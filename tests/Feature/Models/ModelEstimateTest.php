<?php

use App\Models\Delivery;
use App\Models\Estimate;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('belongs to a project', function () {
    $estimate = Estimate::factory()->for(Project::factory())->create();

    expect($estimate->project)->toBeInstanceOf(Project::class);
});

it('belongs to a delivery', function () {
    $estimate = Estimate::factory()->for(Delivery::factory())->create();

    expect($estimate->delivery)->toBeInstanceOf(Delivery::class);
});
