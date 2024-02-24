<?php

namespace App\Services;

class GitlabService
{
    public function getAccessToken(): string
    {
        return config('services.gitlab.pat');
    }

    public function fetchGitlabProject(int $projectId): array
    {
        return [];
    }
}
