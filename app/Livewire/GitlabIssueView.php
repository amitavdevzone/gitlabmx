<?php

namespace App\Livewire;

use App\Models\Estimate;
use App\Models\Issue;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class GitlabIssueView extends Component
{
    public $project;

    public $issue;

    public Collection $estimates;

    public $estimateId;

    public function mount($project, $issue): void
    {
        $this->project = $project;
        $this->issue = $issue;
        $this->estimateId = $this->issue->estimate_id ?? null;
        $this->estimates = Estimate::query()
            ->select(['id', 'title'])
            ->where('project_id', $project->id)
            ->get();
    }

    #[On('echo:gitlab,IssueUpdatedEvent')]
    public function refresh(): void
    {
        $this->project = Project::find($this->project->id);
        $this->issue = Issue::query()->where('internal_id', $this->issue->internal_id)->first();
    }

    public function updating($attribute, $value): void
    {
        if ($attribute == 'estimateId') {
            Issue::where('id', $this->issue->id)
                ->update([
                    'estimate_id' => $value,
                ]);
        }
    }

    public function render(): View
    {
        return view('livewire.gitlab-issue-view');
    }
}
