<?php

namespace Database\Factories;

use App\Models\Delivery;
use App\Models\Estimate;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EstimateFactory extends Factory
{
    protected $model = Estimate::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'project_id' => Project::factory(),
            'delivery_id' => Delivery::factory(),
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'is_complete' => $this->faker->boolean(),
            'progress_percentage' => rand(0, 100),
            'estimated_hours' => $this->faker->randomNumber(),
            'completed_hours' => $this->faker->randomNumber(),
        ];
    }
}
