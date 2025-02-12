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

            ['name' => 'subadmin-view', 'label' => 'View', 'group_name' => 'subadmin'],
            ['name' => 'subadmin-add', 'label' => 'Add', 'group_name' => 'subadmin'],
            ['name' => 'subadmin-edit', 'label' => 'Edit', 'group_name' => 'subadmin'],
            ['name' => 'subadmin-delete', 'label' => 'Delete', 'group_name' => 'subadmin'],

            ['name' => 'category-view', 'label' => 'View', 'group_name' => 'category'],
            ['name' => 'category-add', 'label' => 'Add', 'group_name' => 'category'],
            ['name' => 'category-edit', 'label' => 'Edit', 'group_name' => 'category'],
            ['name' => 'category-delete', 'label' => 'Delete', 'group_name' => 'category'],

            ['name' => 'sub-category-view', 'label' => 'View', 'group_name' => 'sub-category'],
            ['name' => 'sub-category-add', 'label' => 'Add', 'group_name' => 'sub-category'],
            ['name' => 'sub-category-edit', 'label' => 'Edit', 'group_name' => 'sub-category'],
            ['name' => 'sub-category-delete', 'label' => 'Delete', 'group_name' => 'sub-category'],

            ['name' => 'role-view', 'label' => 'View', 'group_name' => 'role'],
            ['name' => 'role-add', 'label' => 'Add', 'group_name' => 'role'],
            ['name' => 'role-edit', 'label' => 'Edit', 'group_name' => 'role'],
            ['name' => 'role-delete', 'label' => 'Delete', 'group_name' => 'role'],

            ['name' => 'plan-view', 'label' => 'View', 'group_name' => 'plan'],
            ['name' => 'plan-add', 'label' => 'Add', 'group_name' => 'plan'],
            ['name' => 'plan-edit', 'label' => 'Edit', 'group_name' => 'plan'],
            ['name' => 'plan-delete', 'label' => 'Delete', 'group_name' => 'plan'],

            ['name' => 'transaction-view', 'label' => 'View', 'group_name' => 'transaction'],

            ['name' => 'cms-view', 'label' => 'View', 'group_name' => 'cms'],
            ['name' => 'cms-edit', 'label' => 'Edit', 'group_name' => 'cms'],

            ['name' => 'commission-view', 'label' => 'View', 'group_name' => 'commission'],
            ['name' => 'commission-edit', 'label' => 'Edit', 'group_name' => 'commission'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate([
                'name'  =>  $permission['name']
            ], [
                // 'label'  =>  $permission['label'],
                // 'group_name'  =>  $permission['group_name'],
                'guard_name'  =>  'web',
            ]);
        }
    }
}
