<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResturantLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resturant_locations', function (Blueprint $table) {
            $table->id();
            $table->double('latitude');
            $table->double('longetitue');
            $table->foreignId('resturant_id');
            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('resturant_locations');
    }
}
