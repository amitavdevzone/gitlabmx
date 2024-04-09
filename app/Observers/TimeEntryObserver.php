<?php

namespace App\Observers;

use App\Jobs\TimeEntryUpdateJob;
use App\Models\TimeEntry;

class TimeEntryObserver
{
    public function created(TimeEntry $entry): void
    {
        TimeEntryUpdateJob::dispatch($entry);
    }

    public function updated(TimeEntry $entry): void
    {
        TimeEntryUpdateJob::dispatch($entry);
    }
}
