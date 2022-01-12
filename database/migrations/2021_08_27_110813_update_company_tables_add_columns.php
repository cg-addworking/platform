<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCompanyTablesAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('origin_data')->nullable();
        });

        Schema::table('company_employees', function (Blueprint $table) {
            $table->string('origin_data')->nullable();
        });

        Schema::table('company_legal_representatives', function (Blueprint $table) {
            $table->string('origin_data')->nullable();
        });

        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->string('origin_data')->nullable();
        });

        Schema::table('company_activities', function (Blueprint $table) {
            $table->string('origin_data')->nullable();
            $table->integer('short_id')->nullable();
        });

        Schema::table('company_activities', function (Blueprint $table) {
            $table->text('social_object')->nullable()->change();
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->uuid('parent_id')->nullable()->change();
        });

        Schema::table('company_legal_representatives', function (Blueprint $table) {
            $table->string('address')->nullable()->change();
            $table->uuid('city_id')->nullable()->change();
            $table->uuid('country_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('origin_data');
        });

        Schema::table('company_employees', function (Blueprint $table) {
            $table->dropColumn('origin_data');
        });

        Schema::table('company_legal_representatives', function (Blueprint $table) {
            $table->dropColumn('origin_data');
        });

        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->dropColumn('origin_data');
        });

        Schema::table('company_activities', function (Blueprint $table) {
            $table->dropColumn('origin_data');
        });

        Schema::table('company_activities', function (Blueprint $table) {
            $table->dropColumn('short_id');
        });
    }
}
