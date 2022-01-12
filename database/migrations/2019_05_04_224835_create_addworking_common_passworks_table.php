<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingCommonPassworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_common_passworks', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('customer_id')->nullable();
            $table->uuid('passworkable_id');
            $table->string('passworkable_type');
            $table->timestamps();
            $table->primary('id');

            $table->foreign('customer_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_common_passworks');
    }
}
