<?php

use App\Http\Integrations\Gitlab\Requests\GitlabFetchProjectRequest;
use App\Models\Issue;
use App\Models\Project;
use App\Services\GitlabService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

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
