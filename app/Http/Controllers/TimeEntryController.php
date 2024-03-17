<?php

namespace App\Http\Controllers;

use App\Events\TimeEntry\EntryAddedEvent;
use App\Services\TimeEntryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeEntryController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
    }

    public function store(Request $request, TimeEntryService $service)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:clients,id',
            'project_id' => 'required|exists:projects,id',
            'issue_id' => 'sometimes|exists:issues,id',
            'description' => 'required|min:3',
            'time' => 'required|numeric',
        ]);

        $entry = $service->addTimeEntry($data);

        event(new EntryAddedEvent(Auth::user(), $entry));

        return redirect()->back()->with('success', 'Entry added');
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
