<?php

use App\Division;
use Illuminate\Database\Seeder;

class DivisionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = [
            [
                'name' => 'pathology',
                'label' => 'Patologi',
            ],
            [
                'name' => 'immunology',
                'label' => 'Imunologi',
            ],
            [
                'name' => 'microbiology',
                'label' => 'Mikrobiologi',
            ],
            [
                'name' => 'health-chemical',
                'label' => 'Kimia Kesehatan',
            ],
        ];
        foreach ($divisions as $division) {
            (new Division)->fill($division)
                ->save();
        }
    }
}
