<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'id' => 1,
                'name' => 'manage_role',
                'guard_name' => 'web',
            ],
            [
                'id' => 2,
                'name' => 'manage_permission',
                'guard_name' => 'web',
            ],
            [
                'id' => 3,
                'name' => 'manage_user',
                'guard_name' => 'web',
            ],
            [
                'id' => 4,
                'name' => 'super_admin_dashboard',
                'guard_name' => 'web',
            ],
            [
                'id' => 5,
                'name' => 'student/profile',
                'guard_name' => 'web',
            ],
            [
                'id' => 6,
                'name' => 'parent/profile',
                'guard_name' => 'web',
            ],
            [
                'id' => 7,
                'name' => 'organization/home',
                'guard_name' => 'web',
            ],
            [
                'id' => 8,
                'name' => 'tutor/home',
                'guard_name' => 'web',
            ],
        ]);
    }
}
