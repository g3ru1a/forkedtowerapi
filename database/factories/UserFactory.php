<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $discordId = $this->faker->unique()->numerify('18###############');

        return [
            'id' => (string) Str::uuid(),
            'discord_id' => $discordId,
            'discord_username' => $this->faker->userName,
            'discord_nickname' => $this->faker->optional()->firstName,
            'discord_avatar_url' => "https://cdn.discordapp.com/avatars/{$discordId}/" . Str::random(32) . ".png",
            'email' => $this->faker->unique()->safeEmail,
            'bot_notifications' => $this->faker->boolean,
            'linked_at' => $this->faker->optional()->dateTime,
            'is_admin' => $this->faker->boolean(10), // 10% chance of admin
        ];
    }

}
