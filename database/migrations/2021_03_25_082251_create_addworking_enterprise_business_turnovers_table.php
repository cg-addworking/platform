<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingEnterpriseBusinessTurnoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_business_turnovers', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('number');
            $table->uuid('enterprise_id')->nullable();
            $table->string('enterprise_name');
            $table->uuid('created_by')->nullable();
            $table->string('created_by_name');
            $table->integer('year');
            $table->float('amount');
            $table->boolean('no_activity');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->unique(['enterprise_id', 'year'], 'business_turnover_year_unique');

            $table
                ->foreign('enterprise_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('SET NULL');

            $table
                ->foreign('created_by')
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
        Schema::dropIfExists('addworking_enterprise_business_turnovers');
    }
}
