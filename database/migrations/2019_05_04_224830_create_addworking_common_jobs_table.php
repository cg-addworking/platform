<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingCommonJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_common_jobs', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('parent_id')->nullable();
            $table->uuid('enterprise_id')->nullable();
            $table->string('name');
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->primary('id');

            $table->foreign('parent_id')
                ->references('id')
                ->on('addworking_common_jobs')
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
        Schema::dropIfExists('addworking_common_jobs');
    }
}
