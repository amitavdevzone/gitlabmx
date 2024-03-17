<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Project;
use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimeEntryFactory extends Factory
{
    protected $model = TimeEntry::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'client_id' => Client::factory(),
            'project_id' => Project::factory(),
            'description' => fake()->sentence(),
            'time' => rand(5, 120),
            'started_at' => now(),
        ];
    }
}
