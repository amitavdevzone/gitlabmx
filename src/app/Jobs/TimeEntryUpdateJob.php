<?php

namespace App\Jobs;

use App\Models\TimeEntry;
use App\Services\TimeEntryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TimeEntryUpdateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly TimeEntry $timeEntry
    ) {
    }

    public function handle(TimeEntryService $timeEntryService): void
    {
        $timeEntryService->updateEstimateAndDelivery($this->timeEntry);
    }
}
