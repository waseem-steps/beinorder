<?php

use Illuminate\Database\Seeder;

class RestaurantBranchTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         App\RestaurantBranchType::create([
            'type_name' => 'Restaurant'
        ]);

        App\RestaurantBranchType::create([
            'type_name' => 'Branch'
        ]);
    }
}
