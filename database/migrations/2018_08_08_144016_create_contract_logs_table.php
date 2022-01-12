<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_logs', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('contract_id');
            $table->text('message');
            $table->json('data')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->primary('id');

            $table
                ->foreign('contract_id')
                ->references('id')->on('contracts')
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
        Schema::dropIfExists('contract_logs');
    }
}
