<?php

namespace App\Actions\Gitlab;

use App\Services\GitlabService;

class CommentWebhookHandler
{
    public function handle(array $data): void
    {
        $comment = $data['object_attributes'];

        $gitlabService = app()->make(GitlabService::class);
        $gitlabService->createOrUpdateComment($comment);
    }
}
