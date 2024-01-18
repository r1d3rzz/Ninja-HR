<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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

        // $permissions = [
        //     'view_employees', 'create_employee', 'edit_employee', 'delete_employee',
        //     'view_departments', 'create_department', 'edit_department', 'delete_department',
        //     'view_roles', 'create_role', 'edit_role', 'delete_role',
        //     'view_permissions', 'create_permission', 'edit_permission', 'delete_permission',
        //     'view_profile', 'create_profile', 'edit_profile', 'delete_profile',
        //     'view_company_setting', 'create_company_setting', 'edit_company_setting', 'delete_company_setting',
        // ];

        // foreach ($permissions as $permission) {
        //     Permission::create([
        //         'name' => $permission,
        //     ]);
        // }

        // Role::create([
        //     'name' => 'HR',
        // ]);

        $users = User::all();
        foreach ($users as $user) {
            $periods = CarbonPeriod::create('2024-01-01', '2024-1-31');
            foreach ($periods as $period) {
                if ($period->format('D') != 'Sat' && $period->format('D') != 'Sun') {
                    $attendance = new Attendance();
                    $attendance->user_id = $user->id;
                    $attendance->date = $period->format('Y-m-d');
                    $attendance->checkin_time = Carbon::parse($period->format('Y-m-d') . ' ' . '09:00:00')->subMinute(rand(10, 55));
                    $attendance->checkout_time = Carbon::parse($period->format('Y-m-d') . ' ' . '18:00:00')->addMinute(rand(5, 55));
                    $attendance->save();
                }
            }
        }
    }
}
