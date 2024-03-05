<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

it('gives a 200 status when data is proper', function () {
    // Arrange
    $sampleData = json_decode(
        file_get_contents(__DIR__.'/../Fixtures/webhook-gitlabissue.json'), true
    );

    // Act & Assert
    postJson(route('gitlab-webhooks'), $sampleData, [
        'X-Gitlab-Token' => config('services.gitlab.secret_token'),
    ])->assertOk();
});

it('gives a 401 error when the header is missing', function () {
    // Arrange
    $sampleData = json_decode(
        file_get_contents(__DIR__.'/../Fixtures/webhook-gitlabissue.json'), true
    );

    // Act & Assert
    postJson(route('gitlab-webhooks'), $sampleData)
        ->assertUnauthorized();
});

it('gives a 401 when the token is wrong', function () {
    // Arrange
    $sampleData = json_decode(
        file_get_contents(__DIR__.'/../Fixtures/webhook-gitlabissue.json'), true
    );

    // Act & Assert
    postJson(route('gitlab-webhooks'), $sampleData, [
        'X-Gitlab-Token' => config('services.gitlab.secret_token').'-add-random',
    ])->assertUnauthorized();
});

it('gives a 400 error when event type is not supported', function () {
    // Arrange
    $sampleData = json_decode(
        file_get_contents(__DIR__.'/../Fixtures/webhook-gitlabissue.json'), true
    );
    $sampleData['event_type'] = 'random';

    // Act & Assert
    postJson(route('gitlab-webhooks'), $sampleData, [
        'X-Gitlab-Token' => config('services.gitlab.secret_token'),
    ])->assertBadRequest();
});
