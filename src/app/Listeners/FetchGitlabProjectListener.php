<?php

namespace App\Listeners;

use App\Events\FetchGitlabProjectEvent;
use App\Services\GitlabService;

class FetchGitlabProjectListener
{
    public function __construct(
        private readonly GitlabService $gitlabService
    ) {
    }

    public function handle(FetchGitlabProjectEvent $event): void
    {
        $projectId = $event->projectId;
        $this->gitlabService->fetchGitlabProject($projectId);
    }
}
