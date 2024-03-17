<?php

namespace App\Services;

use App\Models\TimeEntry;

class TimeEntryService
{
    /**
     * Helper function to get the hours for minutes
     */
    public static function minutesToHours(int $minutes): int
    {
        return $minutes / 60;
    }

    public function addTimeEntry(array $data): TimeEntry
    {
        return TimeEntry::create($data);
    }

    public function startTimeEntry()
    {

    }

    public function endTimeEntry()
    {

    }
}
