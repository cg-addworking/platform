<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingEnterpriseWorkFieldHasDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_work_field_has_departements', function (Blueprint $table) {
            $table->uuid('workfield_id');
            $table->uuid('department_id');
            $table->timestamps();

            $table->primary(['workfield_id', 'department_id']);

            $table
                ->foreign('workfield_id')
                ->references('id')
                ->on('addworking_enterprise_work_fields')
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
        Schema::dropIfExists('addworking_enterprise_work_field_has_departements');
    }
}
