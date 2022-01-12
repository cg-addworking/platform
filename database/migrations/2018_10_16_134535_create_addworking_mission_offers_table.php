<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingMissionOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_mission_offers', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('customer_id');

            $table->date('starts_at');
            $table->date('ends_at')->nullable();

            $table->string('external_id')->nullable();
            $table->integer('number')->nullable();
            $table->string('status')->default('draft');
            $table->string('label');
            $table->text('description');
            $table->text('objectives')->nullable();
            $table->uuid('department_id')->nullable();
            $table->uuid('file_id')->nullable();

            $table->uuid('created_by');
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table
                ->foreign('created_by')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('set null');

            $table->foreign('customer_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');

            $table->foreign('department_id')
                ->references('id')
                ->on('addworking_common_departments')
                ->onDelete('set null');

            $table->foreign('file_id')
                ->references('id')
                ->on('addworking_common_files')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_mission_offers');
    }
}
