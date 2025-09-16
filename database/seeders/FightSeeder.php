<?php

namespace Database\Seeders;

use App\Models\Fight;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fights = [
            [
                'name' => 'Forked Tower of Blood',
                'min_players' => 24,
                'max_players' => 48,
                'description' => 'A medium-difficulty encounter located in the Occult Crescent region, featuring layered mechanics and coordinated team play.',
            ],
            [
                'name' => 'Baldesion Arsenal',
                'min_players' => 24,
                'max_players' => 56,
                'description' => 'A high-difficulty dungeon deep within Eureka Hydatos, requiring coordination and special entry conditions through portals.',
            ],
            [
                'name' => 'Delubrum Reginae (Savage)',
                'min_players' => 48,
                'max_players' => 48,
                'description' => 'An extreme challenge set in the depths of the Bozjan Southern Front, requiring a full team and coordinated mechanics to conquer.',
            ],
            [
                'name' => 'Circle of Darkness (Chaotic)',
                'min_players' => 8,
                'max_players' => 24,
                'description' => 'A chaotic, higher-difficulty version of the final boss encounter from the Circle of Darkness alliance raid, with intensified mechanics and tuning.',
            ],
        ];

        foreach ($fights as $fight) {
            Fight::create($fight);
        }

    }
}
