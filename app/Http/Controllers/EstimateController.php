<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstimateRequest;
use App\Models\Delivery;
use App\Models\Estimate;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EstimateController extends Controller
{
    public function index()
    {

    }

    public function create(Project $project, Delivery $delivery): View
    {
        $estimate = new Estimate;

        return view('pages.estimates.create')
            ->with('estimate', $estimate)
            ->with('project', $project)
            ->with('delivery', $delivery);
    }

    public function store(EstimateRequest $request, Project $project, Delivery $delivery): RedirectResponse
    {
        Estimate::create([
            ...$request->validated(),
            'project_id' => $project->id,
            'delivery_id' => $delivery->id,
        ]);

        return redirect()
            ->route('estimates.index', ['project' => $project, 'delivery' => $delivery])
            ->with('success', 'Estimate created successfully');
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
