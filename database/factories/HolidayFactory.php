<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Holiday>
 */
class HolidayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'start_date' => $this->faker->dateTime,
            'end_date' => $this->faker->randomElement([$this->faker->dateTime, null]),
            'status' => $this->faker->randomElement(['LIBUR', 'CUTI'])
        ];
    }
}
