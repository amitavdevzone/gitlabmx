<?php

namespace Database\Factories;

use App\Models\Delivery;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DeliveryFactory extends Factory
{
    protected $model = Delivery::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'project_id' => Project::factory(),
            'owner_id' => User::factory(),
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays($this->faker->numberBetween(5, 20)),
            'is_complete' => $this->faker->boolean(),
            'progress_complete' => $this->faker->randomNumber(),
            'estimated_hours' => $this->faker->randomNumber(),
            'completed_hours' => $this->faker->randomNumber(),
        ];
    }
}
