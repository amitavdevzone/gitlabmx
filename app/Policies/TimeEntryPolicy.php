<?php

namespace App\Policies;

use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class TimeEntryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return Auth::check();
    }

    public function view(User $user, TimeEntry $timeEntry): bool
    {
        return Auth::check();
    }

    public function create(User $user): bool
    {
        return Auth::check();
    }

    public function update(User $user, TimeEntry $timeEntry): bool
    {
        return Auth::check();
    }

    public function delete(User $user, TimeEntry $timeEntry): bool
    {
        return Auth::check();
    }

    public function restore(User $user, TimeEntry $timeEntry): bool
    {
        return Auth::check();
    }

    public function forceDelete(User $user, TimeEntry $timeEntry): bool
    {
        return Auth::check();
    }
}
