<?php

namespace App\Http\Controllers;

use App\Enums\ClientStatusEnum;
use App\Events\FetchGitlabProjectEvent;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::query()
            ->with('client')
            ->latest('updated_at')
            ->paginate(10);

        return view('pages.projects.index')
            ->with('projects', $projects);
    }

    public function create()
    {
        return view('pages.projects.fetch');
    }

    public function store(Request $request)
    {
        $postData = $request->validate([
            'project_id' => 'required|integer|unique:projects,project_id',
        ]);

        event(new FetchGitlabProjectEvent(projectId: $postData['project_id']));

        return redirect()
            ->back()
            ->with('success', 'Project queued for fetch');
    }

    public function show(Project $project)
    {
        $clients = Client::query()
            ->select(['id', 'name'])
            ->where('is_active', ClientStatusEnum::ACTIVE)
            ->orderBy('name')
            ->get();

        return view('pages.projects.view')
            ->with('clients', $clients)
            ->with('project', $project);
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
        ]);

        Project::query()
            ->where('id', $id)
            ->update([
                'client_id' => $data['client_id'],
            ]);

        return redirect()
            ->route('projects.show', ['project' => $id])
            ->with('success', 'Project updated');
    }

    public function destroy($id)
    {
    }
}
