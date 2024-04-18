<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Database\Eloquent\Collection;

class ClientService
{
    public function getClientDropdown(): Collection
    {
        return Client::query()
            ->select(['id', 'name'])
            ->active()
            ->orderBy('name')
            ->get();
    }
}
