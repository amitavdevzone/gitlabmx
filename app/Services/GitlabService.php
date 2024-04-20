<?php

namespace App\Services;

use App\Http\Integrations\Gitlab\GitlabConnector;
use App\Http\Integrations\Gitlab\Requests\GitlabFetchProjectRequest;
use App\Http\Integrations\Gitlab\Requests\GitlabFetchUser;
use App\Models\Comment;
use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
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

    public function createOrUpdateIssue(array $gitlabIssueData): void
    {
        Issue::updateOrInsert(
            ['gitlab_id' => $gitlabIssueData['id'], 'project_id' => $gitlabIssueData['project_id']],
            [
                'gitlab_id' => $gitlabIssueData['id'],
                'internal_id' => $gitlabIssueData['iid'],
                'project_id' => $gitlabIssueData['project_id'],
                'author_id' => $gitlabIssueData['author_id'] ?? null,
                'assigned_to' => $gitlabIssueData['assignee_id'] ?? null,
                'title' => $gitlabIssueData['title'],
                'description' => $gitlabIssueData['description'] ?? '',
                'state' => $gitlabIssueData['state'],
                'closed_at' => Carbon::parse($gitlabIssueData['closed_at']) ?? null,
                'closed_by' => $gitlabIssueData['closed_by']['id'] ?? null,
                'labels' => json_encode($gitlabIssueData['labels']) ?? null,
                'assignees' => json_encode($gitlabIssueData['assignees'] ?? []),
                'created_at' => Carbon::parse($gitlabIssueData['created_at']),
                'updated_at' => Carbon::parse($gitlabIssueData['updated_at']),
            ]
        );

        Project::query()
            ->where('project_id', $gitlabIssueData['project_id'])
            ->update(['updated_at' => Carbon::parse($gitlabIssueData['updated_at'])]);
    }

    public function createOrUpdateComment(array $gitlabCommentData): void
    {
        Comment::updateOrCreate(
            ['gitlab_id' => $gitlabCommentData['id']],
            [
                'gitlab_id' => $gitlabCommentData['id'],
                'author_id' => $gitlabCommentData['author_id'],
                'noteable_id' => $gitlabCommentData['noteable_id'],
                'project_id' => $gitlabCommentData['project_id'],
                'system' => $gitlabCommentData['system'],
                'noteable_type' => $gitlabCommentData['noteable_type'],
                'body' => $gitlabCommentData['note'],
            ]
        );
    }

    public function createUserByUsername(string $username): User
    {
        $connector = new GitlabConnector();
        $request = new GitlabFetchUser();
        $request->query()->add('username', $username);

        $result = $connector->send($request);

        if (! $result->successful()) {
            throw new BadRequestException('The data provided was not correct');
        }

        if (empty($result->array())) {
            throw new NotFoundHttpException('User not found with given username on Gitlab');
        }

        $data = collect($result->array())->first();

        return User::create([
            'name' => $data['name'] ?? '',
            'gitlab_id' => $data['id'],
            'gitlab_username' => $data['username'],
            'email' => $data['username'].'@work.in',
            'password' => 'Password@123',
            'gitlab_data' => $data,
        ]);
    }
}
