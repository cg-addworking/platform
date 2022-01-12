<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerChargeGuruPassworksDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_charge_guru_passworks_departments', function (Blueprint $table) {
            $table->uuid('passwork_id');
            $table->uuid('department_id');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['passwork_id', 'department_id']);

            $table
                ->foreign('passwork_id')
                ->references('id')
                ->on('customer_charge_guru_passwork')
                ->onDelete('cascade');

            $table
                ->foreign('department_id')
                ->references('id')
                ->on('departments')
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
        Schema::dropIfExists('customer_charge_guru_passworks_departments');
    }
}
