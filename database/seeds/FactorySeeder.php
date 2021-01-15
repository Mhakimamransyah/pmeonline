<?php

use Illuminate\Database\Seeder;

class FactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generate 100 users
        $faker = Faker\Factory::create();
        foreach (range(1, 200) as $index) {
            \App\User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
            ]);
        }

        foreach (range(1, 200) as $index) {
            DB::table('role_user')->insert([
                'user_id' => $index,
                'role_id' => rand(1, 4),
            ]);
        }

        foreach (range(1, 400) as $index) {
            \App\Phone::create([
                'number' => $faker->unique()->phoneNumber,
                'phone_type_id' => rand(1, 2),
            ]);
        }
    }
}
