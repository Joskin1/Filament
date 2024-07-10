<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'image' => $this->faker->imageUrl(),
            'category_id' => Category::factory(),
            'body' => $this->faker->paragraph(10),
            'publish_at' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
        ];
    }
}
