<?php

use Illuminate\Database\Seeder;

class OrderStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        App\OrderStatus::create([
            'status_name' => 'Active',
            'ar_status_name'
            => htmlentities('فعّال', ENT_QUOTES, "UTF-8")
        ]);

        App\OrderStatus::create([
            'status_name' => 'Submitted',
            'ar_status_name'
            => htmlentities('تم الإرسال', ENT_QUOTES, "UTF-8")
        ]);

        App\OrderStatus::create([
            'status_name' => 'Preparing',
            'ar_status_name'
            => htmlentities('جاري التحضير', ENT_QUOTES, "UTF-8")
        ]);

        App\OrderStatus::create([
            'status_name' => 'Ready',
            'ar_status_name'
            => htmlentities('جاهز', ENT_QUOTES, "UTF-8")
        ]);

        App\OrderStatus::create([
            'status_name' => 'Delivered',
            'ar_status_name'
            => htmlentities('مسلّم', ENT_QUOTES, "UTF-8")
        ]);
    }
}
