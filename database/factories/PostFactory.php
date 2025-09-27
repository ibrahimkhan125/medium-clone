<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;
        return [
            'image' => $this->faker->imageUrl(),
            'title' => $title,
            'slug' => Str::slug($title),
            'context' => $this->faker->paragraph(5),
            'category_id' => Category::inRandomOrder()->first(),
            'user_id' => 1,
            'published_at' => fake()->optional()->dateTime() 
        ];
    }
}
