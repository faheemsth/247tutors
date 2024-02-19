<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'superadmin@gmail.com',
                'dob' => '2000-01-01',
                'phone' => '123456789',
                'password' => Hash::make(1234),
                'facebook_link' => 'https://www.google.com',
                'linkedin_link' => 'https://www.google.com',
                'twitter_link' => 'https://www.google.com',
                'role_id' => 1,
                'profile_description' => 'demo',
                'image' => 'pic.jpg',
                'address' => 'test'
            ],
            [
                'id' => 2,
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@gmail.com',
                'dob' => '2000-01-01',
                'phone' => '123456789',
                'password' => Hash::make(1234),
                'facebook_link' => 'https://www.google.com',
                'linkedin_link' => 'https://www.google.com',
                'twitter_link' => 'https://www.google.com',
                'role_id' => 2,
                'profile_description' => 'demo',
                'image' => 'pic.jpg',
                'address' => 'test'
            ],
            [
                'id' => 3,
                'first_name' => 'Tutor',
                'last_name' => 'Tutor',
                'email' => 'tutor@gmail.com',
                'dob' => '2000-01-01',
                'phone' => '123456789',
                'password' => Hash::make(1234),
                'facebook_link' => 'https://www.google.com',
                'linkedin_link' => 'https://www.google.com',
                'twitter_link' => 'https://www.google.com',
                'role_id' => 3,
                'profile_description' => 'demo',
                'image' => 'pic.jpg',
                'address' => 'test'
            ],
            [
                'id' => 4,
                'first_name' => 'Student',
                'last_name' => 'Student',
                'email' => 'student@gmail.com',
                'dob' => '2000-01-01',
                'phone' => '123456789',
                'password' => Hash::make(1234),
                'facebook_link' => 'https://www.google.com',
                'linkedin_link' => 'https://www.google.com',
                'twitter_link' => 'https://www.google.com',
                'role_id' => 4,
                'profile_description' => 'demo',
                'image' => 'pic.jpg',
                'address' => 'test'
            ],
            [
                'id' => 5,
                'first_name' => 'Parent',
                'last_name' => 'Parent',
                'email' => 'parent@gmail.com',
                'dob' => '2000-01-01',
                'phone' => '123456789',
                'password' => Hash::make(1234),
                'facebook_link' => 'https://www.google.com',
                'linkedin_link' => 'https://www.google.com',
                'twitter_link' => 'https://www.google.com',
                'role_id' => 5,
                'profile_description' => 'demo',
                'image' => 'pic.jpg',
                'address' => 'test'
            ],
            [
                'id' => 6,
                'first_name' => 'Organization',
                'last_name' => 'Organization',
                'email' => 'organization@gmail.com',
                'dob' => '2000-01-01',
                'phone' => '123456789',
                'password' => Hash::make(1234),
                'facebook_link' => 'https://www.google.com',
                'linkedin_link' => 'https://www.google.com',
                'twitter_link' => 'https://www.google.com',
                'role_id' => 6,
                'profile_description' => 'demo',
                'image' => 'pic.jpg',
                'address' => 'test'
            ],
        ]);
    }
}
