<?php

namespace Database\Factories;

use App\Models\ShortLink;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ShortLink>
 */
class ShortLinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'url' => $this->faker->url,
            'code' => $this->faker->unique()->regexify('[A-Za-z0-9]{6}'),
            'clicks' => $this->faker->numberBetween(0, 100),
            'user_id' => UserFactory::new(),
        ];
    }
}
