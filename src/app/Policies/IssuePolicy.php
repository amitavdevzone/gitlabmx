<?php

namespace App\Policies;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class IssuePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return Auth::check();
    }

    public function view(User $user, Issue $issue): bool
    {
        return Auth::check();
    }

    public function create(User $user): bool
    {
        return Auth::check();
    }

    public function update(User $user, Issue $issue): bool
    {
        return Auth::check();
    }

    public function delete(User $user, Issue $issue): bool
    {
        return Auth::check();
    }

    public function restore(User $user, Issue $issue): bool
    {
        return Auth::check();
    }

    public function forceDelete(User $user, Issue $issue): bool
    {
        return Auth::check();
    }
}
