<?php

use App\Http\Integrations\Gitlab\Requests\GitlabFetchUser;
use App\Models\User;
use App\Services\GitlabService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

uses(RefreshDatabase::class);

it('returns a user when user is found on gitlab', function () {
    // Arrange
    $sampleData = json_decode(
        file_get_contents(__DIR__.'/../../Fixtures/gitlabuser.json'), true
    );
    MockClient::global([
        GitlabFetchUser::class => MockResponse::make(body: $sampleData, status: 200),
    ]);

    // Act
    $service = app()->make(GitlabService::class);

    expect($service->createUserByUsername('user'))->toBeInstanceOf(User::class);

    // Assert
    $this->assertDatabaseCount('users', 1);
    $this->assertDatabaseHas('users', [
        'gitlab_username' => 'amitav.roy',
    ]);
});

it('throws bad request exception when no success', function () {
    // Arrange
    MockClient::global([
        GitlabFetchUser::class => MockResponse::make(body: [], status: 400),
    ]);

    // Act
    $service = app()->make(GitlabService::class);
    $service->createUserByUsername('user');
})->throws(BadRequestException::class);

it('throws not found exception when empty array from gitlab', function () {
    // Arrange
    MockClient::global([
        GitlabFetchUser::class => MockResponse::make(body: [], status: 200),
    ]);

    // Act
    $service = app()->make(GitlabService::class);
    $service->createUserByUsername('user');
})->throws(NotFoundHttpException::class);

it('throws bad request exception if multiple users found', function () {
    // Arrange
    MockClient::global([
        GitlabFetchUser::class => MockResponse::make(body: [
            ['name' => 'A'], ['name' => 'B'],
        ], status: 200),
    ]);

    // Act
    $service = app()->make(GitlabService::class);
    $service->createUserByUsername('user');
})->throws(BadRequestException::class);
