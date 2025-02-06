<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name'=>'Administrator','guard_name'=> 'web'],
            ['name' => 'User','guard_name'=> 'web'],
        ];
        Role::insert($roles);
    }
}
