<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        App\Role::create([
            'role_name' => 'Administrator',
            'ar_role_name'
            => htmlentities('مدير', ENT_QUOTES, "UTF-8")
        ]);

        App\Role::create([
            'role_name' => 'Restaurant Admin',
            'ar_role_name'
            => htmlentities('مدير مطعم', ENT_QUOTES, "UTF-8")
        ]);

        App\Role::create([
            'role_name' => 'Branch Admin',
            'ar_role_name'
            => htmlentities('مدير فرع', ENT_QUOTES, "UTF-8")
        ]);

        App\Role::create([
            'role_name' => 'Anonymous',
            'ar_role_name'
            => htmlentities('زائر', ENT_QUOTES, "UTF-8")
        ]);

        App\Role::create([
            'role_name' => 'Client',
            'ar_role_name'
            => htmlentities('مشترك', ENT_QUOTES, "UTF-8")
        ]);
    }
}
