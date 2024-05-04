<?php

namespace App\Services;

use App\Models\Issue;
use App\Models\Project;
use Illuminate\Pagination\LengthAwarePaginator;

class IssueService
{
    public function getIssueList(string $state, Project $project): LengthAwarePaginator
    {
        return Issue::query()
            ->where('state', $state)
            ->with(['assigned', 'author'])
            ->where('project_id', $project->project_id)
            ->latest('updated_at')
            ->paginate(10);
    }
}
