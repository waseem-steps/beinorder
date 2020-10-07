<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->text('product_description');
            $table->unsignedBigInteger('product_type_id');
            $table->unsignedBigInteger('product_cat_id');
            $table->unsignedBigInteger('rest_id');
            $table->string('img_path');
            $table->timestamps();

            $table->foreign('product_type_id')->references('id')->on('product_types')->onDelete('CASCADE');
            $table->foreign('product_cat_id')->references('id')->on('product_categories')->onDelete('CASCADE');
            $table->foreign('rest_id')->references('id')->on('restaurants')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
