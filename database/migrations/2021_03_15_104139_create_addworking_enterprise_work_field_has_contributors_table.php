<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingEnterpriseWorkFieldHasContributorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_work_field_has_contributors', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('number');
            $table->uuid('work_field_id');
            $table->uuid('contributor_id');
            $table->uuid('enterprise_id');
            $table->boolean('is_admin');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table
                ->foreign('work_field_id')
                ->references('id')
                ->on('addworking_enterprise_work_fields')
                ->onDelete('CASCADE');

            $table
                ->foreign('contributor_id')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('CASCADE');

            $table
                ->foreign('enterprise_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_enterprise_work_field_has_contributors');
    }
}
