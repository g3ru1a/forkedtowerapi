<?php

namespace Database\Seeders;

use App\Models\RunType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RunTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name'      => 'Newbie Run',
                'color_hex' => '#4CAF50', // medium green for fresh start
            ],
            [
                'name'      => 'Boss2 Prog',
                'color_hex' => '#81C784', // lighter green for progression
            ],
            [
                'name'      => 'Boss2 Kill',
                'color_hex' => '#388E3C', // darker green for victory
            ],
            [
                'name'      => 'Boss3 Prog',
                'color_hex' => '#64B5F6', // lighter blue for progression
            ],
            [
                'name'      => 'Boss3 Kill',
                'color_hex' => '#1976D2', // darker blue for victory
            ],
            [
                'name'      => 'Boss4 Prog',
                'color_hex' => '#FFB74D', // lighter orange for progression
            ],
            [
                'name'      => 'Boss4 Kill',
                'color_hex' => '#F57C00', // darker orange for victory
            ],
            [
                'name'      => 'Reclears',
                'color_hex' => '#BA68C8', // light lavender purple for routine runs
            ],
            [
                'name'      => 'Marathon',
                'color_hex' => '#8E24AA', // rich purple for standout sessions
            ],
        ];

        foreach ($types as $type) {
            RunType::create($type); // creates a new row each run
        }
    }
}
