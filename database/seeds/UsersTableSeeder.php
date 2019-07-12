<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $arr = [
            [
                'first_name' => 'Root',
                'last_name' => 'User',
                'email' => 'root@example.com',
                'password' => Hash::make('12345678'),
                'type' => 'root',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@example.com',
                'password' => Hash::make('12345678'),
                'type' => 'admin',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Publisher',
                'last_name' => 'User',
                'email' => 'publisher@example.com',
                'password' => Hash::make('12345678'),
                'type' => 'publisher',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Writer',
                'last_name' => 'User',
                'email' => 'writer@example.com',
                'password' => Hash::make('12345678'),
                'type' => 'writer',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Member',
                'last_name' => 'User',
                'email' => 'member@example.com',
                'password' => Hash::make('12345678'),
                'type' => 'member',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($arr);

    }
}
