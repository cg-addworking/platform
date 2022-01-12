<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerChargeGuruPassworksBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_charge_guru_passworks_brands', function (Blueprint $table) {
            $table->uuid('passwork_id');
            $table->uuid('brand_id');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['passwork_id', 'brand_id']);

            $table
                ->foreign('passwork_id')
                ->references('id')
                ->on('customer_charge_guru_passwork')
                ->onDelete('cascade');

            $table
                ->foreign('brand_id')
                ->references('id')
                ->on('customer_charge_guru_brands')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_charge_guru_passworks_brands');
    }
}
