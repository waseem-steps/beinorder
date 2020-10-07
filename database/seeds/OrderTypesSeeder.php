<?php

use Illuminate\Database\Seeder;

class OrderTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        App\OrderType::create([
            'type_name' => 'Internal',
            'ar_type_name'
            => htmlentities('داخلي', ENT_QUOTES, "UTF-8")
        ]);

        App\OrderType::create([
            'type_name' => 'External',
            'ar_type_name'
            => htmlentities('خارجي', ENT_QUOTES, "UTF-8")
        ]);
    }
}
