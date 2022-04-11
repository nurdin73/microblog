<?php

namespace Database\Factories;

use App\Models\QuoteFunfact;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuoteFunfactTag>
 */
class QuoteFunfactTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $quote_funfacts = QuoteFunfact::pluck('id')->toArray();
        $tags = Tag::pluck('id')->toArray();
        return [
            'quote_funfact_id' => $this->faker->randomElement($quote_funfacts),
            'tag_id' => $this->faker->randomElement($tags),
        ];
    }
}
