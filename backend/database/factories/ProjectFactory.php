<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'title' => fake()->unique()->words(3, true),
            'description' => fake()->paragraph(),
            'location' => fake()->city(),
            'client_name' => fake()->name(),
            'cover_image' => null,
            'is_featured' => false,
            'is_active' => true,
            'sort_order' => 0,
            'completed_at' => fake()->date(),
        ];
    }

    public function featured(): static
    {
        return $this->state(['is_featured' => true]);
    }
}
