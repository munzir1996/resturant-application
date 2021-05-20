<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResturantServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resturant_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
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
        Schema::dropIfExists('resturant_services');
    }
}
