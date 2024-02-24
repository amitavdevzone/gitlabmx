<?php

namespace App\Services;

use App\Http\Integrations\Gitlab\GitlabConnector;
use App\Http\Integrations\Gitlab\Requests\GitlabFetchProjectRequest;
use App\Models\Project;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GitlabService
{
    public function getAccessToken(): string
    {
        return config('services.gitlab.pat');
    }

    public function fetchGitlabProject(int $projectId): array
    {
        $updated = false;
        $count = Project::query()->where('project_id', $projectId)->count();

        $connector = new GitlabConnector();
        $request = $connector->send(new GitlabFetchProjectRequest($projectId));
        if (! $request->ok()) {
            throw new NotFoundHttpException();
        }
        $projectData = $request->json();

        if ($count == 0) {
            $this->createProject($projectData);
        } else {
            $updated = true;
            $this->updateProject($projectData);
        }

        return [
            'project' => $projectData,
            'updated' => $updated,
        ];
    }

    private function createProject(array $projectData): void
    {
        Project::create([
            'project_id' => $projectData['id'],
            'name' => $projectData['name'],
            'name_with_namespace' => $projectData['name_with_namespace'],
            'description' => $projectData['description'],
            'web_url' => $projectData['web_url'],
            'visibility' => $projectData['visibility'],
            'project_created_date' => Carbon::parse($projectData['created_at']),
            'updated_at' => Carbon::parse($projectData['last_activity_at']),
        ]);
    }

    private function updateProject(array $projectData): void
    {
        Project::query()
            ->where(['project_id' => $projectData['id']])
            ->update([
                'name' => $projectData['name'],
                'name_with_namespace' => $projectData['name_with_namespace'],
                'description' => $projectData['description'],
                'updated_at' => Carbon::parse($projectData['last_activity_at']),
            ]);
    }
}
