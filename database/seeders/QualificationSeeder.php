<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Qualification;
class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $qualifications = [
            [
                'name' => 'Secondary School Cert'
            ],
            [
                'name' => 'Bachelor of Honor'
            ],
            [
                'name' => 'Masters\' Degree'
            ],
            [
                'name' => 'Ph.D'
            ],
        ];

        Qualification::insert($qualifications);
    }
}
