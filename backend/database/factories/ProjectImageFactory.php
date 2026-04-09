<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectImageFactory extends Factory
{
    protected $model = ProjectImage::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'path' => 'projects/1/test.jpg',
            'thumbnail' => 'projects/1/thumbs/test.jpg',
            'alt_text' => fake()->sentence(3),
            'sort_order' => 0,
        ];
    }
}
