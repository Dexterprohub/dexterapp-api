<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $r1 = [
            'id' => '1',
            'role' => 'admin'
        ];

        $r2 = [
            'id' => '2',
            'role' => 'vendor'
        ];

        $r3 = [
            'id' => '3',
            'role' => 'delivery boy'
        ];
        
        $r4 = [
            'id' => '4',
            'role' => 'restaurant'
        ];

        $r5 = [
            'id' => '5',
            'role' => 'user'
        ];

        Role::create($r1);
        Role::create($r2);
        Role::create($r3);
        Role::create($r4);
        Role::create($r5);
   
    }
}
