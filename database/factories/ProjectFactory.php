<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        return [
            'project_id' => fake()->numberBetween(111, 999),
            'client_id' => Client::factory(),
            'name' => fake()->word(),
            'name_with_namespace' => fake()->word(),
            'description' => fake()->sentence(),
            'web_url' => fake()->url(),
            'visibility' => 'private',
            'project_created_date' => now(),
        ];
    }
}
