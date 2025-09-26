<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Character>
 */
class CharacterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $lodestoneId = $this->faker->unique()->numberBetween(10000000, 99999999);
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;

        return [
            'id' => (string) Str::uuid(),
            'user_id' => User::factory(),
            'lodestone_id' => $lodestoneId,
            'name' => "$firstName $lastName",
            'world' => $this->faker->randomElement(['Lich', 'Zodiark', 'Phoenix', 'Twintania']),
            'datacenter' => $this->faker->randomElement(['Light', 'Chaos', 'Aether']),
            'avatar_url' => "https://img2.finalfantasyxiv.com/f/" . Str::random(64),
            'verification_code' => 'fp_' . $this->faker->unique()->numberBetween(10000000, 99999999),
            'verified' => $this->faker->boolean(80), // 80% verified
            'attempts' => $this->faker->numberBetween(0, 5),
            'expires_at' => $this->faker->dateTimeBetween('now', '+7 days'),
            'verified_at' => $this->faker->optional(0.8)->dateTimeBetween('-7 days', 'now'),
        ];
    }
}
