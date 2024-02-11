<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'project_id' => $this->faker->randomNumber(),
            'name_with_namespace' => $this->faker->name(),
            'web_url' => $this->faker->url(),
            'visibility' => $this->faker->word(),
        ];
    }
}
