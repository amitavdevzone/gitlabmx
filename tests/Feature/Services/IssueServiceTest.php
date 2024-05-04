<?php

use App\Enums\IssueStateEnum;
use App\Models\Issue;
use App\Models\Project;
use App\Services\IssueService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;

uses(RefreshDatabase::class);

it('gives issues based on state passed', function (string $state) {
    // Arrange
    $project = Project::factory()->create();
    Issue::factory()->create([
        'title' => 'Active issue title',
        'project_id' => $project->project_id,
    ]);
    Issue::factory()->closed()->create([
        'title' => 'Inactive issue title',
        'project_id' => $project->project_id,
    ]);

    // Act & Assert
    $service = app()->make(IssueService::class);
    $issues = $service->getIssueList(
        state: IssueStateEnum::OPENED->value,
        project: $project,
    );

    expect($issues)->toBeInstanceOf(LengthAwarePaginator::class)
        ->and($issues)->each->toHaveKeys(['assigned', 'author'])
        ->and($issues->count())
        ->toEqual(1);

})->with([
    IssueStateEnum::OPENED->value,
    IssueStateEnum::CLOSED->value,
]);
