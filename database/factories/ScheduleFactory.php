<?php

namespace Database\Factories;

use App\Models\Character;
use App\Models\Fight;
use App\Models\Group;
use App\Models\RunType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['planned', 'scheduled', 'recruiting', 'ongoing', 'finished', 'cancelled'];

        return [
            'id' => (string) Str::uuid(),
            'group_id' => Group::inRandomOrder()->value('id'),
            'host_id' => Character::factory(),
            'type_id' => RunType::inRandomOrder()->value('id'),
            'public' => $this->faker->boolean(30),
            'date' => $this->faker->dateTimeBetween('-1 months', '+1 months')->format('Y-m-d'),
            'time' => $this->faker->time('H:i:s'),
            'description' => $this->faker->optional()->paragraph,
            'require_registration' => $this->faker->boolean,
            'duration_hours' => $this->faker->numberBetween(1, 6),
            'status' => $this->faker->randomElement($statuses),
            'fight_id' => Fight::inRandomOrder()->value('id'),
            'seat_count' => 48,
        ];
    }
}
