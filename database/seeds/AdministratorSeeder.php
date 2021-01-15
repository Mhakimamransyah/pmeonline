<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new User)
            ->setName('Administrator')
            ->setRole(Role::administrator())
            ->setLoginAllowed(true)
            ->setPassword('password')
            ->setEmail('admin@pme.bblkpalembang.com')
            ->save();
    }
}
