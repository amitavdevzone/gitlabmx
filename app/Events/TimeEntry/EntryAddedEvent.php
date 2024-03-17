<?php

namespace App\Events\TimeEntry;

use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EntryAddedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public User $user,
        public TimeEntry $entry
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('channel-name'),
        ];
    }
}
