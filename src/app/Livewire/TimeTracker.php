<?php

namespace App\Livewire;

use App\Models\TimeEntry;
use App\Services\TimeEntryService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class TimeTracker extends Component
{
    public ?string $id;

    public bool $started;

    public ?TimeEntry $entry;

    public string $elapsedTime;

    private $service;

    public function mount(): void
    {
        $service = app()->make(TimeEntryService::class);

        $this->started = false;

        if (! Route::current()->parameter('issue')->id) {
            return;
        }

        $this->id = Route::current()->parameter('issue')->id;

        $this->initTrackerWithEntry($service);
    }

    #[On('toggle-tracking')]
    public function toggleTracker($id): void
    {
        $service = app()->make(TimeEntryService::class);

        $timeEntry = TimeEntry::query()
            ->where('issue_id', $id)
            ->whereNull('ended_at')
            ->first();

        if (! $timeEntry) {
            $service->startTimeEntryForIssue($id);
            $this->started = true;
            $this->initTrackerWithEntry($service);
        } else {
            $service->endTimeEntryForIssue($id);
            $this->elapsedTime = '';
            $this->entry = null;
            $this->started = false;
        }
    }

    public function updateToggle(): bool
    {
        if (! $this->started) {
            return false;
        }

        $this->elapsedTime = Carbon::parse($this->entry->started_at)
            ->diff(now())->format('%H:%I:%S');

        return true;
    }

    private function initTrackerWithEntry(TimeEntryService $service): void
    {
        if ($entry = $service->userHasActiveEntry(auth()->user()->id)) {
            $this->started = true;
            $this->entry = $entry;
            $this->elapsedTime = Carbon::parse($entry->started_at)
                ->diff(now())->format('%H:%I:%S');
        }
    }

    public function render(): View
    {
        return view('livewire.time-tracker');
    }
}
