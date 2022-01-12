<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdenredCommonCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edenred_common_codes', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('skill_id');
            $table->string('level');
            $table->string('code');
            $table->timestamps();
            $table->primary('id');

            $table->foreign('skill_id')
                ->references('id')
                ->on('addworking_common_skills')
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
        Schema::dropIfExists('edenred_common_codes');
    }
}
