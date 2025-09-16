<?php

namespace Database\Seeders;

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
    }
}
