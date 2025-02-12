<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::beginTransaction();

        try {
            $checkUserExists = User::where('email', 'admin@gmail.com')->first();

            if (!$checkUserExists) {
                $user = User::create([
                    "name" => "admin",
                    "email" => "admin@gmail.com",
                    "password" => Hash::make("Shine@123"),
                    'status' => 'ACTIVE',
                    "email_verified_at" => now(),
                ]);

                $permissions = Permission::all();

                foreach ($permissions as $permission) {
                    $user->givePermissionTo($permission);
                }

                $role = Role::where('name', 'Administrator')->first();
                if ($role) {
                    $user->assignRole($role);
                }
                $role->syncPermissions(Permission::all());
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
