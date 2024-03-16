<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return Auth::check();
    }

    public function view(User $user, Project $project): bool
    {
        return Auth::check();
    }

    public function create(User $user): bool
    {
        return Auth::check();
    }

    public function update(User $user, Project $project): bool
    {
        return Auth::check();
    }

    public function delete(User $user, Project $project): bool
    {
        return Auth::check();
    }

    public function restore(User $user, Project $project): bool
    {
        return Auth::check();
    }

    public function forceDelete(User $user, Project $project): bool
    {
        return Auth::check();
    }
}
