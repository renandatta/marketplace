<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_level_id');
            $table->string('name');
            $table->string('slug');
            $table->string('address');
            $table->string('city');
            $table->string('district');
            $table->string('phone');
            $table->string('email');
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->decimal('rating', 5, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('store_level_id')->references('id')->on('store_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
