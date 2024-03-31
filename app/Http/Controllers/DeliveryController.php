<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Project;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index()
    {

    }

    public function create(Project $project)
    {
        return view('pages.deliveries.create')
            ->with('project', $project);
    }

    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'sometimes|min:3',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
        ]);

        Delivery::create([
            'project_id' => $project->id,
            'owner_id' => $request->user()->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
        ]);

        return redirect()
            ->route('deliveries.index', ['project' => $project])
            ->with('success', 'Delivery details saved.');
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
