<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'priority' => fake()->numberBetween(1, 10),
            'project_id' => fake()->boolean(70) ? Project::factory() : null,
        ];
    }
}