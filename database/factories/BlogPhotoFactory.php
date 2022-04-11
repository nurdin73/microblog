<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPhoto>
 */
class BlogPhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $blogs = Blog::pluck('id')->toArray();
        return [
            'blog_id' => $this->faker->randomElement($blogs),
            'src' => $this->faker->imageUrl(),
        ];
    }
}
