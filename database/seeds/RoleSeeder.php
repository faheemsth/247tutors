<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'Super Admin',
                'guard_name' => 'web',
            ],
            [
                'id' => 2,
                'name' => 'Admin',
                'guard_name' => 'web',
            ],
            [
                'id' => 3,
                'name' => 'Tutor',
                'guard_name' => 'web',
            ],
            [
                'id' => 4,
                'name' => 'Student',
                'guard_name' => 'web',
            ],
            [
                'id' => 5,
                'name' => 'Parent',
                'guard_name' => 'web',
            ],
            [
                'id' => 6,
                'name' => 'Ogranization',
                'guard_name' => 'web',
            ],
        ]);
    }
}
