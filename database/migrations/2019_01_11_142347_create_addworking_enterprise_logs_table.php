<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingEnterpriseLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_enterprise_logs', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id');
            $table->string('domain')->nullable();
            $table->string('type')->nullable();
            $table->string('process_type')->nullable();
            $table->string('process_name')->nullable();
            $table->text('message');
            $table->longText('content')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');
            $table
                ->foreign('enterprise_id')
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
        Schema::dropIfExists('addworking_enterprise_enterprise_logs');
    }
}
