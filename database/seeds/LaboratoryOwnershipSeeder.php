<?php

use Illuminate\Database\Seeder;

class LaboratoryOwnershipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\LaboratoryOwnership::create([
            'name' => 'Pemerintah',
        ]);

        \App\LaboratoryOwnership::create([
            'name' => 'Swasta',
        ]);
    }
}
