<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseLegalFormsTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_legal_forms', function (Blueprint $table) {
            $table->uuid('country_id')->nullable();
            $table->string('type')->nullable();

            $table->foreign('country_id')
                ->references('id')->on('countries')
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
        Schema::table('addworking_enterprise_legal_forms', function (Blueprint $table) {
            $table->dropColumn(['type', 'country_id']);
        });
    }
}
