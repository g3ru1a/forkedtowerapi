<?php

namespace Database\Seeders;

use App\Models\PhantomJob;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhantomJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Source list (Icon + Name only; other fields intentionally ignored)
        $jobs = [
            ['name' => 'Phantom Knight',     'icon_url' => 'https://lds-img.finalfantasyxiv.com/h/s/A3-SG0tFwZO9pVR75gUloJoSQ0.png'],
            ['name' => 'Phantom Monk',       'icon_url' => 'https://lds-img.finalfantasyxiv.com/h/7/dn7C191l0vq3TtiRFR944Fb-Hc.png'],
            ['name' => 'Phantom Thief',      'icon_url' => 'https://lds-img.finalfantasyxiv.com/h/E/Yfd8jLT0bCygTbggkpZQy4ggqY.png'],
            ['name' => 'Phantom Samurai',    'icon_url' => 'https://lds-img.finalfantasyxiv.com/h/K/3-EIjmHiXIAXjta5tOD8w3FqGE.png'],
            ['name' => 'Phantom Berserker',  'icon_url' => 'https://lds-img.finalfantasyxiv.com/h/X/rLD12b3ctDWjOOIGjyCLiaxFDw.png'],
            ['name' => 'Phantom Ranger',     'icon_url' => 'https://lds-img.finalfantasyxiv.com/h/0/RdMuMVdDWzqguuOkhku6s6n80s.png'],
            ['name' => 'Phantom Time Mage',  'icon_url' => 'https://lds-img.finalfantasyxiv.com/h/n/ZIdqqxYvR36UyoNSD-LGQ4zyX0.png'],
            ['name' => 'Phantom Chemist',    'icon_url' => 'https://lds-img.finalfantasyxiv.com/h/U/6IadmelelH4pbxErgBY5Fh5rMw.png'],
            ['name' => 'Phantom Geomancer',  'icon_url' => 'https://lds-img.finalfantasyxiv.com/h/6/LU5ckrWlmoWTkGvVftNfpPtufQ.png'],
            ['name' => 'Phantom Bard',       'icon_url' => 'https://lds-img.finalfantasyxiv.com/h/R/dbBP-BFbJnDjyZqHrA3i3b-Nb0.png'],
            ['name' => 'Phantom Oracle',     'icon_url' => 'https://lds-img.finalfantasyxiv.com/h/g/M3CgKEMRjbXYLXx4wfcuJ64ong.png'],
            ['name' => 'Phantom Cannoneer',  'icon_url' => 'https://lds-img.finalfantasyxiv.com/h/S/G0meGtQ8_WR4Oz8YRpui6LYBqA.png'],
            ['name' => 'Phantom Freelancer', 'icon_url' => 'https://lds-img.finalfantasyxiv.com/h/Z/BPP6fZ59aZG1vWV0FN_-DNtK9c.png'],
        ];

        foreach ($jobs as $job) {
            PhantomJob::create($job); // creates a new row each run
        }
    }
}
