<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_activities', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('activity_id');
            $table->uuid('company_id');
            $table->text('social_object');
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('activity_id')
                ->references('id')->on('activities')
                ->onDelete('SET NULL');

            $table->foreign('company_id')
                ->references('id')->on('companies')
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
        Schema::dropIfExists('company_activities');
    }
}
