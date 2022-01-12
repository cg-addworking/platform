<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerChargeGuruPassworksSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_charge_guru_passworks_skills', function (Blueprint $table) {
            $table->uuid('passwork_id');
            $table->uuid('skill_id');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['passwork_id', 'skill_id']);

            $table
                ->foreign('passwork_id')
                ->references('id')
                ->on('customer_charge_guru_passwork')
                ->onDelete('cascade');

            $table
                ->foreign('skill_id')
                ->references('id')
                ->on('customer_charge_guru_skills')
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
        Schema::dropIfExists('customer_charge_guru_passworks_skills');
    }
}
