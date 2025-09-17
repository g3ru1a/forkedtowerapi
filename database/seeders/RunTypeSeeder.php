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
                'name'      => 'FToB: Newbie Run',
                'color_hex' => '#4CAF50', // medium green for fresh start
            ],
            [
                'name'      => 'FToB: Boss2 Prog',
                'color_hex' => '#81C784', // lighter green for progression
            ],
            [
                'name'      => 'FToB: Boss2 Kill',
                'color_hex' => '#388E3C', // darker green for victory
            ],
            [
                'name'      => 'FToB: Boss3 Prog',
                'color_hex' => '#64B5F6', // lighter blue for progression
            ],
            [
                'name'      => 'FToB: Boss3 Kill',
                'color_hex' => '#1976D2', // darker blue for victory
            ],
            [
                'name'      => 'FToB: Boss4 Prog',
                'color_hex' => '#FFB74D', // lighter orange for progression
            ],
            [
                'name'      => 'FToB: Boss4 Kill',
                'color_hex' => '#F57C00', // darker orange for victory
            ],
            [
                'name'      => 'FToB: Reclears',
                'color_hex' => '#BA68C8', // light lavender purple for routine runs
            ],
            [
                'name'      => 'FToB: Marathon',
                'color_hex' => '#8E24AA', // rich purple for standout sessions
            ],
        ];

        foreach ($types as $type) {
            RunType::create($type); // creates a new row each run
        }
    }
}
