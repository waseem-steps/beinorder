<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_code');
            $table->integer('percentage')->default(0);
            $table->integer('amount')->defauly(0);
            $table->unsignedBigInteger('country_id');
            $table->integer('validity_days')->default(1);
            $table->timestamps();

            /* $table->foreign('country_id')->references('id')->on('countries')->onDelete('NO ACTION'); */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_vouchers');
    }
}
