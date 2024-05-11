<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryRequest;
use App\Models\Delivery;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DeliveryController extends Controller
{
    public function index(Project $project): View
    {
        $deliveries = Delivery::query()
            ->where('project_id', $project->id)
            ->orderByDesc('updated_at')
            ->paginate(10);

        return view('pages.deliveries.index')
            ->with('deliveries', $deliveries)
            ->with('project', $project);
    }

    public function create(Project $project): View
    {
        $delivery = new Delivery;

        return view('pages.deliveries.create')
            ->with('delivery', $delivery)
            ->with('project', $project);
    }

    public function store(DeliveryRequest $request, Project $project): RedirectResponse
    {
        $data = $request->validated();

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

    public function edit(Project $project, Delivery $delivery)
    {
        return view('pages.deliveries.edit')
            ->with('project', $project)
            ->with('delivery', $delivery);
    }

    public function update(DeliveryRequest $request, Project $project, Delivery $delivery)
    {
        $data = $request->validated();

        Delivery::where('id', $delivery->id)
            ->update($data);

        return redirect()
            ->route('deliveries.edit', ['project' => $project, 'delivery' => $delivery])
            ->with('success', 'Delivery edited');
    }
}
