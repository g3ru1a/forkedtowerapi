<?php

namespace Database\Factories;

use App\Models\{
    Registration,
    Schedule,
    User,
    Character,
    FFClass,
    PhantomJob
};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RegistrationFactory extends Factory
{
    protected $model = Registration::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'schedule_id' => Schedule::inRandomOrder()->value('id') ?? Schedule::factory(),
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'character_id' => Character::inRandomOrder()->value('id') ?? Character::factory(),
            'preferred_class_id' => FFClass::inRandomOrder()->value('id') ?? FFClass::factory(),
            'preferred_job_id' => PhantomJob::inRandomOrder()->value('id') ?? PhantomJob::factory(),
            'can_solo_heal' => $this->faker->boolean,
            'can_english' => $this->faker->boolean,
            'can_markers' => $this->faker->boolean,
            'notes' => $this->faker->optional()->paragraph,
            'status' => 'pending',
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Registration $registration) {
            // Attach 1–3 random flex_classes
            $flexClassIds = FFClass::inRandomOrder()->limit(rand(1, 3))->pluck('id');
            $registration->flex_classes()->attach($flexClassIds);

            // Attach 1–3 random flex_jobs
            $flexJobIds = PhantomJob::inRandomOrder()->limit(rand(1, 3))->pluck('id');
            $registration->flex_jobs()->attach($flexJobIds);
        });
    }
}

