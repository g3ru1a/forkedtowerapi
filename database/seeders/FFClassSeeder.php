<?php

namespace Database\Seeders;

use App\Models\FFClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FFClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            [
                'name' => 'Gladiator',
                'icon_url' => 'ffxiv/classes/icons/Gladiator_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Gladiator_Icon_8.png',
                'type' => 'Tank',
            ],
            [
                'name' => 'Marauder',
                'icon_url' => 'ffxiv/classes/icons/Marauder_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Marauder_Icon_8.png',
                'type' => 'Tank',
            ],
            [
                'name' => 'Paladin',
                'icon_url' => 'ffxiv/classes/icons/Paladin_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Paladin_Icon_8.png',
                'type' => 'Tank',
            ],
            [
                'name' => 'Warrior',
                'icon_url' => 'ffxiv/classes/icons/Warrior_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Warrior_Icon_8.png',
                'type' => 'Tank',
            ],
            [
                'name' => 'Dark Knight',
                'icon_url' => 'ffxiv/classes/icons/Dark_Knight_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Dark_Knight_Icon_8.png',
                'type' => 'Tank',
            ],
            [
                'name' => 'Gunbreaker',
                'icon_url' => 'ffxiv/classes/icons/Gunbreaker_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Gunbreaker_Icon_8.png',
                'type' => 'Tank',
            ],
            [
                'name' => 'Conjurer',
                'icon_url' => 'ffxiv/classes/icons/Conjurer_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Conjurer_Icon_8.png',
                'type' => 'Healer',
            ],
            [
                'name' => 'White Mage',
                'icon_url' => 'ffxiv/classes/icons/White_Mage_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-White_Mage_Icon_8.png',
                'type' => 'Healer',
            ],
            [
                'name' => 'Scholar',
                'icon_url' => 'ffxiv/classes/icons/Scholar_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Scholar_Icon_8.png',
                'type' => 'Healer',
            ],
            [
                'name' => 'Astrologian',
                'icon_url' => 'ffxiv/classes/icons/Astrologian_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Astrologian_Icon_8.png',
                'type' => 'Healer',
            ],
            [
                'name' => 'Sage',
                'icon_url' => 'ffxiv/classes/icons/Sage_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Sage_Icon_8.png',
                'type' => 'Healer',
            ],
            [
                'name' => 'Lancer',
                'icon_url' => 'ffxiv/classes/icons/Lancer_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Lancer_Icon_8.png',
                'type' => 'Melee DPS',
            ],
            [
                'name' => 'Dragoon',
                'icon_url' => 'ffxiv/classes/icons/Dragoon_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Dragoon_Icon_8.png',
                'type' => 'Melee DPS',
            ],
            [
                'name' => 'Pugilist',
                'icon_url' => 'ffxiv/classes/icons/Pugilist_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Pugilist_Icon_8.png',
                'type' => 'Melee DPS',
            ],
            [
                'name' => 'Monk',
                'icon_url' => 'ffxiv/classes/icons/Monk_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Monk_Icon_8.png',
                'type' => 'Melee DPS',
            ],
            [
                'name' => 'Rogue',
                'icon_url' => 'ffxiv/classes/icons/Rogue_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Rogue_Icon_8.png',
                'type' => 'Melee DPS',
            ],
            [
                'name' => 'Ninja',
                'icon_url' => 'ffxiv/classes/icons/Ninja_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Ninja_Icon_8.png',
                'type' => 'Melee DPS',
            ],
            [
                'name' => 'Samurai',
                'icon_url' => 'ffxiv/classes/icons/Samurai_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Samurai_Icon_8.png',
                'type' => 'Melee DPS',
            ],
            [
                'name' => 'Reaper',
                'icon_url' => 'ffxiv/classes/icons/Reaper_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Reaper_Icon_8.png',
                'type' => 'Melee DPS',
            ],
            [
                'name' => 'Viper',
                'icon_url' => 'ffxiv/classes/icons/Viper_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Viper_Icon_8.png',
                'type' => 'Melee DPS',
            ],
            [
                'name' => 'Archer',
                'icon_url' => 'ffxiv/classes/icons/Archer_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Archer_Icon_8.png',
                'type' => 'Physical Ranged DPS',
            ],
            [
                'name' => 'Bard',
                'icon_url' => 'ffxiv/classes/icons/Bard_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Bard_Icon_8.png',
                'type' => 'Physical Ranged DPS',
            ],
            [
                'name' => 'Machinist',
                'icon_url' => 'ffxiv/classes/icons/Machinist_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Machinist_Icon_8.png',
                'type' => 'Physical Ranged DPS',
            ],
            [
                'name' => 'Dancer',
                'icon_url' => 'ffxiv/classes/icons/Dancer_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Dancer_Icon_8.png',
                'type' => 'Physical Ranged DPS',
            ],
            [
                'name' => 'Arcanist',
                'icon_url' => 'ffxiv/classes/icons/Arcanist_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Arcanist_Icon_8.png',
                'type' => 'Magical Ranged DPS',
            ],
            [
                'name' => 'Black Mage',
                'icon_url' => 'ffxiv/classes/icons/Black_Mage_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Black_Mage_Icon_8.png',
                'type' => 'Magical Ranged DPS',
            ],
            [
                'name' => 'Summoner',
                'icon_url' => 'ffxiv/classes/icons/Summoner_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Summoner_Icon_8.png',
                'type' => 'Magical Ranged DPS',
            ],
            [
                'name' => 'Red Mage',
                'icon_url' => 'ffxiv/classes/icons/Red_Mage_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Red_Mage_Icon_8.png',
                'type' => 'Magical Ranged DPS',
            ],
            [
                'name' => 'Pictomancer',
                'icon_url' => 'ffxiv/classes/icons/Pictomancer_Icon_3.png',
                'flat_icon_url' => 'ffxiv/classes/flat_icons/80px-Pictomancer_Icon_8.png',
                'type' => 'Magical Ranged DPS',
            ],
        ];
        // Empty Class List
        FFClass::all()->each(function ($class) {
            $class->delete();
        });
        //
        foreach ($classes as $c) {
            FFClass::create($c); // creates a new row each run
        }

    }
}
