<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'user_id' => User::factory(),
            'name' => $this->faker->company,
            'color' => $this->faker->hexColor,
            'badge_text' => strtoupper(Str::random(rand(2, 4))),
            'gradient' => $this->faker->optional()->hexColor,
            'discord_invite' => $this->faker->optional()->url,
            'private_path' => Str::random(10),
        ];
    }
}
