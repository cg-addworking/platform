<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingCommonAddressablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_common_addressables', function (Blueprint $table) {
            $table->uuid('address_id');
            $table->uuid('addressable_id');
            $table->text('addressable_type');
            $table->timestamps();
            $table->softDeletes();

            $table
                ->foreign('address_id')
                ->references('id')->on('addworking_common_addresses')
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
        Schema::dropIfExists('addworking_common_addressables');
    }
}
