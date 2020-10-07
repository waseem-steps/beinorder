<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        App\User::create([
            'name' => 'Administrator',
            'email'=>'admin@admin.com',
            'password'=> Hash::make('admin'),
            'role_id'=>1,
            'ip_address'=>'127.0.0.1'
        ]);

        App\User::create([
            'name' => 'Restaurant Admin',
            'email' => 'rest_admin@admin.com',
            'password' => Hash::make('rest_admin'),
            'role_id' => 2,
            'ip_address' => '127.0.0.1'
        ]);

        App\User::create([
            'name' => 'Branch Admin',
            'email' => 'branch_admin@admin.com',
            'password' => Hash::make('branch_admin'),
            'role_id' => 3,
            'ip_address' => '127.0.0.1'
        ]);

        App\User::create([
            'name' => 'Anonymous',
            'email' => 'anonymous@anonymous.com',
            'password' => Hash::make('123456789'),
            'role_id' => 4,
            'ip_address' => '127.0.0.1'
        ]);

        App\User::create([
            'name' => 'Client',
            'email' => 'client@client.com',
            'password' => Hash::make('client'),
            'role_id' => 5,
            'ip_address' => '127.0.0.1'
        ]);
    }
}
