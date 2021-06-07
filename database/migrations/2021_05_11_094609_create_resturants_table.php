<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResturantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resturants', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar'); //
            $table->string('name_en')->nullable(); //
            $table->string('manager_name'); //
            $table->string('manager_phone'); //
            $table->string('email'); //
            $table->string('commercial_registration_no'); //
            $table->json('services')->nullable();
            $table->double('maximum_delivery_distance')->nullable();
            $table->double('neighborhood_delivery_price')->nullable();
            $table->double('outside_neighborhood_delivery_price')->nullable();
            $table->double('minimum_purchase_free_delivery_in_neighborhood')->nullable();
            $table->double('minimum_purchase_free_delivery_outside_neighborhood')->nullable();
            $table->string('open_time')->nullable();
            $table->string('close_time')->nullable();
            $table->json('accepted_payment_methods')->nullable();
            $table->string('loyalty_points')->nullable();
            $table->double('customer_earn_points')->nullable();
            $table->foreignId('client_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resturants');
    }
}
