<?php

use Illuminate\Database\Seeder;

class PricePlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        App\PricePlan::create([
            'plan_name' => 'Golden Monthly',
            'status' => 1,
            'period'=>30,
            'price'=>50000,
            'branch_count' => 5,
            'ar_plan_name'=>'باقة شهرية ذهبية',
            'country_id'=>1
        ]);
    }
}
