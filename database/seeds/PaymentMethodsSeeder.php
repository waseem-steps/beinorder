<?php

use Illuminate\Database\Seeder;

class PaymentMethodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        App\PaymentMethod::create([
            'method_name' => 'Cash'
        ]);

        App\PaymentMethod::create([
            'method_name' => 'E-Payment'
        ]);
    }
}
