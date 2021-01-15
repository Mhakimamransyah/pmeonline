<?php

use App\Role;
use Illuminate\Database\Seeder;

class DivisionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'label' => 'Instalasi Imunologi',
                'name' => Role::ROLE_DIVISION_IMMUNOLOGY,
            ],
            [
                'label' => 'Instalasi Patologi',
                'name' => Role::ROLE_DIVISION_PATHOLOGY,
            ],
            [
                'label' => 'Instalasi Mikrobiologi',
                'name' => Role::ROLE_DIVISION_MICROBIOLOGY,
            ],
            [
                'label' => 'Instalasi Kimia Kesehatan',
                'name' => Role::ROLE_DIVISION_HEALTH_CHEMICAL,
            ],
        ];

        foreach ($roles as $role) {
            (new Role)
                ->setLabel($role['label'])
                ->setName($role['name'])
                ->setLoginAllowed(true)
                ->setRegistrationAllowed(false)
                ->save();
        }
    }
}
