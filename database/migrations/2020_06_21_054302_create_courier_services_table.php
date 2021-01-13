<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourierServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courier_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('courier_id');
            $table->string('name');
            $table->double('price')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('courier_id')->references('id')->on('couriers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('curier_services');
    }
}
