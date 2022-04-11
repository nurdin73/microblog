<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogTag>
 */
class BlogTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $blogs = Blog::pluck('id')->toArray();
        $tags = Tag::pluck('id')->toArray();
        return [
            'blog_id' => $this->faker->randomElement($blogs),
            'tag_id' => $this->faker->randomElement($tags),
        ];
    }
}
