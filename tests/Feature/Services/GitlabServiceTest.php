<?php

use App\Http\Integrations\Gitlab\Requests\GitlabFetchProjectRequest;
use App\Models\Project;
use App\Services\GitlabService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

uses(RefreshDatabase::class);

it('creates a project when the project is not present', function () {
    // Arrange
    $sampleData = json_decode(file_get_contents(__DIR__ . '/../../Fixtures/gitlabproject.json'), true);

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
