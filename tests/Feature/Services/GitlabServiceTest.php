<?php

use App\Http\Integrations\Gitlab\Requests\GitlabFetchProjectRequest;
use App\Http\Integrations\Gitlab\Requests\GitlabFetchUser;
use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use App\Services\GitlabService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

uses(RefreshDatabase::class);

it('creates a project when the project is not present', function () {
    // Arrange
    $sampleData = json_decode(file_get_contents(__DIR__.'/../../Fixtures/gitlabproject.json'), true);

    MockClient::global([
        GitlabFetchProjectRequest::class => MockResponse::make(
            body: $sampleData,
            status: 200,
        ),
    ]);

    $gitlabService = app()->make(GitlabService::class);

    // Act
    $gitlabService->fetchGitlabProject($sampleData['id']);

    // Assert
    $this->assertDatabaseCount('projects', 1);
    $this->assertDatabaseHas('projects', [
        'project_id' => $sampleData['id'],
    ]);
});

it('updates the project if it exist and latest updated does not match', function () {
    // Arrange
    $sampleData = json_decode(file_get_contents(__DIR__.'/../../Fixtures/gitlabproject.json'), true);
    Project::factory()->create([
        'project_id' => $sampleData['id'],
        'updated_at' => now()->subYear(),
    ]);

    MockClient::global([
        GitlabFetchProjectRequest::class => MockResponse::make(
            body: $sampleData,
            status: 200,
        ),
    ]);

    $gitlabService = app()->make(GitlabService::class);

    // Act
    $gitlabService->fetchGitlabProject($sampleData['id']);

    // Assert
    $this->assertDatabaseCount('projects', 1);
    $this->assertDatabaseHas('projects', [
        'updated_at' => Carbon::parse($sampleData['last_activity_at'])->format('Y-m-d H:i:s'),
    ]);

});

it('does not do anything if there are no updates', function () {
    $sampleData = json_decode(file_get_contents(__DIR__.'/../../Fixtures/gitlabproject.json'), true);
    Project::factory()->create([
        'project_id' => $sampleData['id'],
        'updated_at' => Carbon::parse($sampleData['last_activity_at']),
    ]);

    MockClient::global([
        GitlabFetchProjectRequest::class => MockResponse::make(
            body: $sampleData,
            status: 200,
        ),
    ]);

    $gitlabService = app()->make(GitlabService::class);

    // Act
    $gitlabService->fetchGitlabProject($sampleData['id']);

    // Assert
    $this->assertDatabaseCount('projects', 1);
    $this->assertDatabaseHas('projects', [
        'updated_at' => Carbon::parse($sampleData['last_activity_at'])->format('Y-m-d H:i:s'),
    ]);
});

it('inserts an issue when not present', function () {
    // Arrange
    $sampleData = json_decode(file_get_contents(__DIR__.'/../../Fixtures/webhook-gitlabissue.json'), true);

    // Act
    app(GitlabService::class)->createOrUpdateIssue($sampleData['object_attributes']);

    // Assert
    $this->assertDatabaseCount('issues', 1);
});

it('updates the issue when already present', function () {
    // Arrange
    $sampleData = json_decode(
        file_get_contents(__DIR__.'/../../Fixtures/webhook-gitlabissue.json'), true
    )['object_attributes'];
    $sampleData['title'] = 'Some random title';
    $sampleData['updated_at'] = now();

    // Act
    app(GitlabService::class)->createOrUpdateIssue($sampleData);

    // Assert
    $this->assertDatabaseHas('issues', [
        'title' => 'Some random title',
        'gitlab_id' => $sampleData['id'],
    ]);
});

it('updates the project based on the issue time', function () {
    // Arrange
    $sampleData = json_decode(
        file_get_contents(__DIR__.'/../../Fixtures/webhook-gitlabissue.json'), true
    )['object_attributes'];
    $project = Project::factory()->create([
        'project_id' => $sampleData['project_id'], 'updated_at' => now()->subYear(),
    ]);

    // Act
    app(GitlabService::class)->createOrUpdateIssue($sampleData);

    // Assert
    expect(Issue::first()->updated_at)
        ->toEqual(Project::first()->updated_at);
});

it('adds author details', function () {
    // Arrange
    $sampleData = json_decode(
        file_get_contents(__DIR__.'/../../Fixtures/webhook-gitlabissue.json'), true
    )['object_attributes'];
    $project = Project::factory()->create([
        'project_id' => $sampleData['project_id'], 'updated_at' => now()->subYear(),
    ]);

    // Act
    app(GitlabService::class)->createOrUpdateIssue($sampleData);

    // Assert
    $this->assertDatabaseHas('issues', [
        'author_id' => $sampleData['author_id'],
        'project_id' => $sampleData['project_id'],
    ]);
});

it('creates a comment when not present', function () {
    // Arrange
    $sampleData = json_decode(
        file_get_contents(__DIR__.'/../../Fixtures/webhook-gitlabcomment.json'), true
    )['object_attributes'];

    // Act
    app(GitlabService::class)->createOrUpdateComment($sampleData);

    // Assert
    $this->assertDatabaseHas('comments', [
        'gitlab_id' => $sampleData['id'],
        'project_id' => $sampleData['project_id'],
    ]);
});

it('updates a comment when it is present', function () {
    // Arrange
    $sampleData = json_decode(
        file_get_contents(__DIR__.'/../../Fixtures/webhook-gitlabcomment.json'), true
    )['object_attributes'];

    $sampleData['note'] = 'Some random comment';

    // Act
    app(GitlabService::class)->createOrUpdateComment($sampleData);

    // Assert
    $this->assertDatabaseHas('comments', [
        'gitlab_id' => $sampleData['id'],
        'body' => 'Some random comment',
    ]);
});

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

    // Assert
    expect($service->createUserByUsername('user'))->toBeInstanceOf(User::class);
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

it('throws not found exception when empty response', function () {
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
