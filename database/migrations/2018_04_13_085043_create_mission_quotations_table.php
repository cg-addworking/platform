<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_quotations', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('vendor_id');
            $table->uuid('mission_id');
            $table->uuid('file_id');
            $table->string('brand');
            $table->string('reference');
            $table->string('tools');
            $table->float('price');
            $table->datetime('valid_from');
            $table->datetime('valid_until');
            $table->softDeletes();
            $table->timestamps();

            $table->primary('id');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->foreign('vendor_id')->references('id')->on('enterprises')->onDelete('cascade');
            $table->foreign('mission_id')->references('id')->on('missions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mission_quotations');
    }
}
