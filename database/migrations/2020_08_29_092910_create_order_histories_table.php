<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('order_code')->unique();
            $table->unsignedBigInteger('rest_id');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('phone_number');
            $table->string('car_color');
            $table->string('car_type');
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('li_number')->nullable();
            $table->unsignedBigInteger('order_type');
            $table->string('payment_method');
            $table->unsignedBigInteger('order_status_id');
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->string('ip_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_histories');
    }
}
