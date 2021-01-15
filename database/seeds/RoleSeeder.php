<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new Role)
            ->setName(Role::ROLE_ADMIN)
            ->setLabel('Administrator PME BBLK Palembang')
            ->setLoginAllowed(true)
            ->setRegistrationAllowed(false)
            ->save();
        (new Role)
            ->setName(Role::ROLE_PARTICIPANT)
            ->setLabel('Personil Penghubung Laboratorium')
            ->setLoginAllowed(true)
            ->setRegistrationAllowed(true)
            ->save();
    }
}
