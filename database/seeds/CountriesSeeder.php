<?php

use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        App\Country::create([
            'country_name' => 'Syria',
            'country_code' => 'SYR',
            'country_currency' => 'Syrian Pound',
            'currency_symbol' => 'SYP',
            'int_code' => '+963',
            'ar_country_name' => htmlentities('سوريا', ENT_QUOTES, "UTF-8"),
            'ar_country_code'
            => htmlentities('ج.ع.س', ENT_QUOTES, "UTF-8"),
            'ar_country_currency' =>
            htmlentities('ليرة سورية', ENT_QUOTES, "UTF-8"),
            'ar_currency_symbol'
            => htmlentities('ل.س', ENT_QUOTES, "UTF-8"),
        ]);
    }
}
