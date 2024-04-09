<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\Estimate;
use App\Models\Issue;
use App\Models\Project;
use App\Models\TimeEntry;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TimeEntryService
{
    /**
     * Helper function to get the hours for minutes
     */
    public static function minutesToHours(int $minutes): float
    {
        return round($minutes / 60, 2);
    }

    public function addTimeEntry(array $data): TimeEntry
    {
        return TimeEntry::create($data);
    }

    public function startTimeEntryForIssue($id): TimeEntry
    {
        $issue = Issue::find($id);

        if (! $issue) {
            throw new HttpException(400, 'Issue not found');
        }

        $project = Project::where('project_id', $issue->project_id)->first();

        return TimeEntry::create([
            'user_id' => auth()->user()->id,
            'client_id' => $project->client_id,
            'project_id' => $project->id,
            'issue_id' => $id,
            'description' => $issue->title,
            'time' => 0,
            'started_at' => now(),
        ]);
    }

    public function endTimeEntryForIssue($id)
    {
        if (! $entry = $this->userHasActiveEntry(auth()->user()->id)) {
            return true;
        }

        $entry->update([
            'ended_at' => now(),
            'time' => Carbon::parse($entry->started_at)->diffInMinutes(now()),
        ]);
    }

    public function userHasActiveEntry(int $userId): ?TimeEntry
    {
        return TimeEntry::query()
            ->where('user_id', $userId)
            ->whereNull('ended_at')
            ->orderByDesc('id')
            ->first();
    }

    public function updateEstimateAndDelivery(TimeEntry $timeEntry): bool
    {
        $issue = Issue::find($timeEntry->issue_id);

        if (! $issue || ! $issue->estimate_id) {
            return false;
        }

        $estimate = Estimate::findOrFail($issue->estimate_id);
        $delivery = Delivery::findOrFail($estimate->delivery_id);

        if (! $estimate || ! $delivery) {
            return false;
        }

        $time = TimeEntryService::minutesToHours($timeEntry->time);

        $estimate->completed_hours = $estimate->completed_hours + $time;
        if ($estimate->estimated_hours > 0) {
            // to avoid division by zero
            $estimate->progress_percentage = round(($estimate->completed_hours / $estimate->estimated_hours) * 100, 2);
        }
        $estimate->save();

        $delivery->completed_hours = $delivery->completed_hours + $time;
        if ($delivery->estimated_hours > 0) {
            // to avoid division by zero
            $delivery->progress_complete = round(($delivery->completed_hours / $delivery->estimated_hours) * 100, 2);
        }
        $delivery->save();

        return true;
    }
}
