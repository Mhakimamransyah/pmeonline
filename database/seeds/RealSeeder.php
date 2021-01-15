<?php

use Illuminate\Database\Seeder;

class RealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProvinceSeeder::class);
        $this->call(LaboratoryTypeSeeder::class);
        $this->call(LaboratoryOwnershipSeeder::class);
        $this->call(RoleSeeder::class);
    }
}
