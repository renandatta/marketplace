<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePurchaseDetailsTableShippingCost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_details', function (Blueprint $table) {
            $table->double('shipping_cost')->default(0);
            $table->unsignedBigInteger('courier_service_id');

            $table->foreign('courier_service_id')->references('id')->on('courier_services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_details', function (Blueprint $table) {
            $table->dropColumn('shipping_cost');
            $table->dropForeign(['courier_service_id']);
            $table->dropColumn('courier_service_id');
        });
    }
}
