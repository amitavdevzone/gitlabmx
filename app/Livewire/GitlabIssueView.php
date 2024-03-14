<?php

namespace App\Livewire;

use App\Models\Issue;
use App\Models\Project;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class GitlabIssueView extends Component
{
    public $project;

    public $issue;

    public function mount($project, $issue): void
    {
        $this->project = $project;
        $this->issue = $issue;
    }

    #[On('echo:gitlab,IssueUpdatedEvent')]
    public function refresh(): void
    {
        $this->project = Project::find($this->project->id);
        $this->issue = Issue::query()->where('internal_id', $this->issue->internal_id)->first();
    }

    public function render(): View
    {
        return view('livewire.gitlab-issue-view');
    }
}
