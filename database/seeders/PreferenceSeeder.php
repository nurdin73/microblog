<?php

namespace Database\Seeders;

use App\Models\Preferences;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lists = [
            'Turun BB',
            'Bebas Maag GERD',
            'Bebas PCOS',
            'Kolesterol turun',
            'Mens teratur & gak sakit',
            'Bebas autoimun',
            'Tidur nyenyak',
            'Persiapan hamil',
            'Mengecilkan kista',
            'Bebas Jerawat',
            'Lebih sehat aja'
        ];
        foreach ($lists as $l) {
            Preferences::create(['name' => $l]);
        }
    }
}
