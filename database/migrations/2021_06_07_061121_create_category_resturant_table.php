<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryResturantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_resturant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->foreignId('resturant_id');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('resturant_id')->references('id')->on('resturants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_resturant');
    }
}
