<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

$dataSet = [
    'webhook-gitlabcomment.json',
    'webhook-gitlabissue.json',
];

it('gives a 200 status when data is proper', function (string $fileName) {
    // Arrange
    $sampleData = json_decode(
        file_get_contents(__DIR__. "/../Fixtures/{$fileName}"), true
    );

    // Act & Assert
    postJson(route('gitlab-webhooks'), $sampleData, [
        'X-Gitlab-Token' => config('services.gitlab.secret_token'),
    ])->assertOk();
})->with($dataSet);

it('gives a 401 error when the header is missing', function (string $fileName) {
    // Arrange
    $sampleData = json_decode(
        file_get_contents(__DIR__. "/../Fixtures/{$fileName}"), true
    );

    // Act & Assert
    postJson(route('gitlab-webhooks'), $sampleData)
        ->assertUnauthorized();
})->with($dataSet);

it('gives a 401 when the token is wrong', function (string $fileName) {
    // Arrange
    $sampleData = json_decode(
        file_get_contents(__DIR__. "/../Fixtures/{$fileName}"), true
    );

    // Act & Assert
    postJson(route('gitlab-webhooks'), $sampleData, [
        'X-Gitlab-Token' => config('services.gitlab.secret_token').'-add-random',
    ])->assertUnauthorized();
})->with($dataSet);

it('gives a 400 error when event type is not supported', function (string $fileName) {
    // Arrange
    $sampleData = json_decode(
        file_get_contents(__DIR__. "/../Fixtures/{$fileName}"), true
    );
    $sampleData['event_type'] = 'random';

    // Act & Assert
    postJson(route('gitlab-webhooks'), $sampleData, [
        'X-Gitlab-Token' => config('services.gitlab.secret_token'),
    ])->assertBadRequest();
})->with($dataSet);
