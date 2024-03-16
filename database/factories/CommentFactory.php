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
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'gitlab_id' => $this->faker->randomNumber(),
            'author_id' => $this->faker->word(),
            'noteable_id' => $this->faker->word(),
            'project_id' => $this->faker->word(),
            'system' => $this->faker->boolean(),
            'noteable_type' => $this->faker->word(),
            'body' => $this->faker->word(),
        ];
    }
}
