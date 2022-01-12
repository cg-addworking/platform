<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingCommonHasPhoneNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_common_has_phone_numbers', function (Blueprint $table) {
            $table->uuid('phone_number_id');
            $table->uuid('morphable_id');
            $table->text('morphable_type');
            $table->text('note')->nullable();
            $table->boolean('primary')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table
                ->foreign('phone_number_id')
                ->references('id')->on('addworking_common_phone_numbers')
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
        Schema::dropIfExists('addworking_common_has_phone_numbers');
    }
}
