<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Group;
use App\Models\Schedule;
use App\Models\Seat;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PhantomJobSeeder::class);
        $this->call(RunTypeSeeder::class);
        $this->call(FFClassSeeder::class);
        $this->call(FightSeeder::class);

        $userId = '01998486-48b1-7032-a59f-6aee260de608';
        $characterId = '019986f8-bef2-7008-b7d3-23858ba0dd6d';
        //Create User (Gerula Discord)
        User::create([
            'id' => $userId,
            'discord_id' => '182520880277094400',
            'discord_username' => 'yenpress',
            'discord_nickname' => 'gerula',
            'discord_avatar_url' => 'https://cdn.discordapp.com/avatars/182520880277094400/253a7174a3523a566d5728ed8b9c59c4.png',
            'email' => 'egidiufarcas@maze.ws',
            'bot_notifications' => true,
            'linked_at' => '2025-09-26 06:36:57',
            'is_admin' => true,
            'created_at' => '2025-09-26 05:36:57',
            'updated_at' => '2025-09-26 05:36:57',
        ]);

        //Create Giki's Character
        Character::create([
            'id' => $characterId,
            'user_id' => $userId,
            'lodestone_id' => '47431834',
            'name' => 'Giki Chomusuke',
            'world' => 'Lich',
            'datacenter' => 'Light',
            'avatar_url' => 'https://img2.finalfantasyxiv.com/f/15cff6ad5af687333d4ae7545c7b4ec4_7206469080400ed57a5373d0a9c55c59fc0.jpg?1758904585',
            'verification_code' => 'fp_47153029',
            'verified' => true,
            'attempts' => 2,
            'expires_at' => '2025-09-27 05:01:12',
            'verified_at' => '2025-09-26 17:01:53',
            'created_at' => '2025-09-26 17:01:12',
            'updated_at' => '2025-09-26 17:01:53',
        ]);

        Group::factory()->count(3)->create([
            'user_id' => $userId,
        ]);

        Schedule::factory()->count(1000)->create([
            'host_id' => $characterId,
        ]);
//            ->each(function (Schedule $schedule) {
//            $seat_count = $schedule->getAttribute('seat_count');
//            for ($i = 0; $i < $seat_count; $i++) {
//                $seat = new Seat([
//                    'schedule_id' => $schedule->getAttribute('id'),
//                    'number' => $i
//                ]);
//                $seat->saveOrFail();
//            }
//        });

        Character::factory()->count(1000)->create();

        $this->call(RegistrationSeeder::class);
    }
}
