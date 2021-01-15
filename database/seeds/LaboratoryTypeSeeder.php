<?php

use Illuminate\Database\Seeder;

class LaboratoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\LaboratoryType::create([
            'name' => 'Rumah Sakit',
        ]);

        \App\LaboratoryType::create([
            'name' => 'Puskesmas',
        ]);

        \App\LaboratoryType::create([
            'name' => 'Balai Lab Kesehatan',
        ]);

        \App\LaboratoryType::create([
            'name' => 'Lab Klinik',
        ]);

        \App\LaboratoryType::create([
            'name' => 'PMI',
        ]);
    }
}
