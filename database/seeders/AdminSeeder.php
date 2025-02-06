<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $checkUserExists  = User::where("email","admin@gmail.com")->first();
        if(is_null($checkUserExists)){
            $user = User::create([
                "name"=>"admin",
                "email"=>"admin@gmail.com",
                "password"=>Hash::make("Shine@123"),
                "email_verified_at"=>date("Y-m-d H:i:s"),
                
            ]);
            // Ensure the role exists before assigning
            $role = Role::firstOrCreate(['name' => 'Administrator']);

            // Assign role to user
            $user->assignRole($role);
        }
    }
}
