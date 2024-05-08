<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ClientPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return Auth::check();
    }

    public function view(User $user, Client $client): bool
    {
        return Auth::check();
    }

    public function create(User $user): bool
    {
        return Auth::check();
    }

    public function update(User $user, Client $client): bool
    {
        return Auth::check();
    }

    public function delete(User $user, Client $client): bool
    {
        return Auth::check();
    }

    public function restore(User $user, Client $client): bool
    {
        return Auth::check();
    }

    public function forceDelete(User $user, Client $client): bool
    {
        return Auth::check();
    }
}
