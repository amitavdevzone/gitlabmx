<?php

namespace App\Actions\Gitlab;

use App\Services\GitlabService;

class IssueWebhookHandler
{
    public function handle(array $data): void
    {
        $issue = $data['object_attributes'];

        $gitlabService = app()->make(GitlabService::class);
        $gitlabService->createOrUpdateIssue($issue);
    }
}
