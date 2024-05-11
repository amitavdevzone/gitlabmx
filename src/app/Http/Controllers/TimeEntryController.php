<?php

namespace App\Http\Controllers;

use App\Events\TimeEntry\EntryAddedEvent;
use App\Models\Issue;
use App\Models\Project;
use App\Services\TimeEntryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeEntryController extends Controller
{
    public function create(Request $request)
    {
        if (! $request->has('issue_id')) {
            abort(400, 'Issue not specified.');
        }

        $issue = Issue::findOrFail($request->input('issue_id'));

        return view('pages.time-entries.create')
            ->with('issue', $issue);
    }

    public function store(Request $request, TimeEntryService $service)
    {
        $data = $request->validate([
            'issue_id' => 'sometimes|exists:issues,id',
            'description' => 'required|min:3',
            'time' => 'required|numeric',
        ]);

        $issue = Issue::find($data['issue_id']);
        $project = Project::where('project_id', $issue->project_id)->first();

        $data['user_id'] = Auth::user()->id;
        $data['client_id'] = $project->client_id;
        $data['project_id'] = $project->id;
        $data['started_at'] = now()->subMinutes($data['time']);
        $data['ended_at'] = now();

        $entry = $service->addTimeEntry($data);

        event(new EntryAddedEvent(Auth::user(), $entry));

        return redirect()->route('time-entries.create', ['issue_id' => $issue->id])->with('success', 'Entry added');
    }
}
