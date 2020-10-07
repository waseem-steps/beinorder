<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('status');
            $table->unsignedBigInteger('price_plan_id');
            $table->unsignedBigInteger('next_price_plan_id');
            $table->unsignedBigInteger('rest_id');
            $table->unsignedBigInteger('activated_by')->nullable();
            $table->timestamps();

            $table->foreign('price_plan_id')->references('id')->on('price_plans')->onDelete('CASCADE');
            $table->foreign('next_price_plan_id')->references('id')->on('price_plans')->onDelete('CASCADE');
            $table->foreign('rest_id')->references('id')->on('restaurants')->onDelete('CASCADE');
            $table->foreign('activated_by')->references('id')->on('users') -> onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
