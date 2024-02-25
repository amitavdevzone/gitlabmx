<?php

namespace Database\Factories;

use App\Enums\IssueStateEnum;
use App\Models\Issue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class IssueFactory extends Factory
{
    protected $model = Issue::class;

    public function definition(): array
    {
        return [
            'gitlab_id' => $this->faker->randomNumber(),
            'internal_id' => $this->faker->randomNumber(),
            'project_id' => $this->faker->randomNumber(),
            'assigned_to' => $this->faker->randomNumber(),
            'title' => $this->faker->unique()->word(),
            'description' => $this->faker->text(),
            'state' => IssueStateEnum::OPENED,
            'closed_at' => Carbon::now(),
            'closed_by' => $this->faker->randomNumber(),
            'labels' => $this->faker->words(),
            'assignees' => $this->faker->words(),
            'due_date' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    /**
     * Indicate that the issue should be closed
     */
    public function closed(): static
    {
        return $this->state(fn (array $attributes) => [
            'state' => IssueStateEnum::CLOSED,
        ]);
    }
}
