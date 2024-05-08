<?php

use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('gives client id and name for dropdown', function () {
    // Arrange
    $client = Client::factory()->create();

    // Act & Assert
    $service = app()->make(ClientService::class);
    $result = $service->getClientDropdown();

    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(1);

    $record = $result->first();
    expect($record->id)->toEqual($client->id)
        ->and($record->name)->toEqual($client->name);
});

it('gives only active clients', function () {
    // Arrange
    $client = Client::factory(3)->create();
    $inactiveClient = Client::factory()->inactive()->create();

    // Act & Assert
    $service = app()->make(ClientService::class);
    $result = $service->getClientDropdown();

    expect($result)
        ->toBeInstanceOf(Collection::class)
        ->toHaveCount(3);
});
