<?php

namespace App\Http\Controllers;

use App\Events\FetchGitlabProjectEvent;
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

        return view('projects.index')
            ->with('projects', $projects);
    }

    public function create()
    {
        return view('project.fetch');
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

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
