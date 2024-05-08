<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'body' => $this->faker->paragraph(),
            'gitlab_id' => $this->faker->randomNumber(),
            'author_id' => $this->faker->randomNumber(),
            'system' => $this->faker->boolean(),
            'noteable_id' => $this->faker->randomNumber(),
            'noteable_type' => $this->faker->word(),
            'project_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    /**
     * Indicate that the comment is for an issue
     */
    public function forIssue(): static
    {
        return $this->state(fn (array $attributes) => [
            'noteable_type' => 'Issue',
        ]);
    }
}
