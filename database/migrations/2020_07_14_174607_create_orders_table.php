<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->unsignedBigInteger('rest_id');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->string('phone_number');
            $table->string('car_color');
            $table->string('car_type');
            $table->unsignedBigInteger('order_type');
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('order_status_id');
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->text('notes');
            $table->string('ip_address');
            $table->timestamps();

            $table->foreign('rest_id')->references('id')->on('restaurants')->onDelete('CASCADE');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('CASCADE');
            $table->foreign('order_type')->references('id')->on('order_types')->onDelete('CASCADE');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onDelete('CASCADE');
            $table->foreign('voucher_id')->references('id')->on('discount_vouchers')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
