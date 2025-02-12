<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'user-view', 'label' => 'View', 'group_name' => 'user'],
            ['name' => 'user-add', 'label' => 'Add', 'group_name' => 'user'],
            ['name' => 'user-edit', 'label' => 'Edit', 'group_name' => 'user'],
            ['name' => 'user-delete', 'label' => 'Delete', 'group_name' => 'user'],

            ['name' => 'form-view', 'label' => 'View', 'group_name' => 'form'],
            ['name' => 'form-add', 'label' => 'Add', 'group_name' => 'form'],
            ['name' => 'form-edit', 'label' => 'Edit', 'group_name' => 'form'],
            ['name' => 'form-delete', 'label' => 'Delete', 'group_name' => 'form'],

            ['name' => 'role-view', 'label' => 'View', 'group_name' => 'role'],
            ['name' => 'role-add', 'label' => 'Add', 'group_name' => 'role'],
            ['name' => 'role-edit', 'label' => 'Edit', 'group_name' => 'role'],
            ['name' => 'role-delete', 'label' => 'Delete', 'group_name' => 'role'],

        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate([
                'name'  =>  $permission['name']
            ], [
                'label'  =>  $permission['label'],
                'group_name'  =>  $permission['group_name'],
                'guard_name'  =>  'web',
            ]);
        }
    }
}
