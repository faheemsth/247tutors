<?php

use Database\Seeders\PermissionSeeder;

use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CustomerSeeder;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Subject;
use Database\Seeders\SubjectSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {


      /*
        $this->call([
           SubjectSeeder::class
        ]);
        */

        //Subject::factory()->count(2)->create();

        $this->call([

            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            RolePermissionSeeder::class,
            SubjectSeeder::class
        ]);

    }
}
