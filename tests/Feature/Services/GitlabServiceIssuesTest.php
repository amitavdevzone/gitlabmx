<?php

use App\Models\Issue;
use App\Models\Project;
use App\Services\GitlabService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

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

it('adds issue even if there is no assigned to', function () {
    // Arrange
    $sampleData = json_decode(
        file_get_contents(__DIR__.'/../../Fixtures/webhook-gitlabissue.json'), true
    )['object_attributes'];
    $sampleData['assigned_to'] = null;

    // Act
    app(GitlabService::class)->createOrUpdateIssue($sampleData);

    // Assert
    $this->assertDatabaseCount('issues', 1);
    $this->assertDatabaseHas('issues', [
        'project_id' => $sampleData['project_id'],
    ]);
});
