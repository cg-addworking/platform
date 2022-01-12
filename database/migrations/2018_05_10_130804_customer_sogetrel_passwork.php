<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerSogetrelPasswork extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_sogetrel_passwork', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id');
            $table->json('data');
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');

            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_sogetrel_passwork');
    }
}
