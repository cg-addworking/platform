<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddworkingEnterpriseActivitiesHasDepartments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_activities_has_departments', function (Blueprint $table) {
            $table->uuid('activity_id');
            $table->uuid('department_id');
            $table->timestamps();

            $table->primary(['activity_id', 'department_id']);

            $table
                ->foreign('activity_id')
                ->references('id')
                ->on('addworking_enterprise_activities')
                ->onDelete('cascade');

            $table
                ->foreign('department_id')
                ->references('id')
                ->on('addworking_common_departments')
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
        Schema::dropIfExists('addworking_enterprise_activities_has_departments');
    }
}
