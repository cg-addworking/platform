<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingCommonSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_common_skills', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('job_id');
            $table->string('name');
            $table->string('display_name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->primary('id');

            $table->foreign('job_id')
                ->references('id')
                ->on('addworking_common_jobs')
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
        Schema::dropIfExists('addworking_common_skills');
    }
}
