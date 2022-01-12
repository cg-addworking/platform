<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingAnnexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_contract_annexes', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('file_id');
            $table->uuid('enterprise_id');

            $table->integer('number');
            $table->string('name');
            $table->string('display_name');
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
            $table->foreign('file_id')
                ->references('id')
                ->on('addworking_common_files')
                ->onDelete('cascade');
            $table->foreign('enterprise_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
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
        Schema::dropIfExists('addworking_contract_annexes');
    }
}
