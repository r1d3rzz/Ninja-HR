<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $permissions = [
            'view_employees', 'create_employee', 'edit_employee', 'delete_employee',
            'view_departments', 'create_department', 'edit_department', 'delete_department',
            'view_roles', 'create_role', 'edit_role', 'delete_role',
            'view_permissions', 'create_permission', 'edit_permission', 'delete_permission',
            'view_profile', 'create_profile', 'edit_profile', 'delete_profile',
            'view_company_setting', 'create_company_setting', 'edit_company_setting', 'delete_company_setting',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
            ]);
        }

        Role::create([
            'name' => 'HR',
        ]);
    }
}
