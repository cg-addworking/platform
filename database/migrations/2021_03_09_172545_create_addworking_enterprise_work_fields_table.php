<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingEnterpriseWorkFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_work_fields', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('number');
            $table->uuid('owner_id');
            $table->uuid('archived_by')->nullable();
            $table->string('name');
            $table->string('display_name');
            $table->string('description')->nullable();
            $table->float('estimated_budget')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->dateTime('archived_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table
                ->foreign('owner_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('SET NULL');

            $table
                ->foreign('archived_by')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_enterprise_work_fields');
    }
}
