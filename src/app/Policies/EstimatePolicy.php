<?php

namespace App\Policies;

use App\Models\Estimate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class EstimatePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return Auth::check();
    }

    public function view(User $user, Estimate $estimate): bool
    {
        return Auth::check();
    }

    public function create(User $user): bool
    {
        return Auth::check();
    }

    public function update(User $user, Estimate $estimate): bool
    {
        return Auth::check();
    }

    public function delete(User $user, Estimate $estimate): bool
    {
        return Auth::check();
    }

    public function restore(User $user, Estimate $estimate): bool
    {
        return Auth::check();
    }

    public function forceDelete(User $user, Estimate $estimate): bool
    {
        return Auth::check();
    }
}
