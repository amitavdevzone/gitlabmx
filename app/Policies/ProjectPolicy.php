<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {

    }

    public function view(User $user, Project $project)
    {
    }

    public function create(User $user)
    {
    }

    public function update(User $user, Project $project)
    {
    }

    public function delete(User $user, Project $project)
    {
    }

    public function restore(User $user, Project $project)
    {
    }

    public function forceDelete(User $user, Project $project)
    {
    }
}
