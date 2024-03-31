<?php

namespace App\Policies;

use App\Models\Delivery;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class DeliveryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return Auth::check();
    }

    public function view(User $user, Delivery $delivery): bool
    {
        return Auth::check();
    }

    public function create(User $user): bool
    {
        return Auth::check();
    }

    public function update(User $user, Delivery $delivery): bool
    {
        return Auth::check();
    }

    public function delete(User $user, Delivery $delivery): bool
    {
        return Auth::check();
    }

    public function restore(User $user, Delivery $delivery): bool
    {
        return Auth::check();
    }

    public function forceDelete(User $user, Delivery $delivery): bool
    {
        return Auth::check();
    }
}
