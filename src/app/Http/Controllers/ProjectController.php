<?php

namespace App\Http\Controllers;

use App\Events\FetchGitlabProjectEvent;
use App\Models\Project;
use App\Services\ClientService;
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

    public function show(Project $project, ClientService $clientService)
    {
        $clients = $clientService->getClientDropdown();

        return view('pages.projects.show')
            ->with('clients', $clients)
            ->with('project', $project);
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
}
