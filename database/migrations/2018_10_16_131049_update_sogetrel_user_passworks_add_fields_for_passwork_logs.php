<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSogetrelUserPassworksAddFieldsForPassworkLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sogetrel_user_passworks', function (Blueprint $table) {
            $table->uuid('pre_qualified_by')->nullable();
            $table->foreign('pre_qualified_by')->references('id')->on('addworking_user_users')->onDelete('set null');
            $table->uuid('accepted_by')->nullable();
            $table->foreign('accepted_by')->references('id')->on('addworking_user_users')->onDelete('set null');
            $table->uuid('refused_by')->nullable();
            $table->foreign('refused_by')->references('id')->on('addworking_user_users')->onDelete('set null');
            $table->uuid('administrative_manager')->nullable();
            $table->foreign('administrative_manager')->references('id')->on('addworking_user_users')->onDelete('set null');
            $table->dateTime('work_starts_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sogetrel_user_passworks', function (Blueprint $table) {
            $table->dropColumn('pre_qualified_by');
        });

        Schema::table('sogetrel_user_passworks', function (Blueprint $table) {
            $table->dropColumn('accepted_by');
        });

        Schema::table('sogetrel_user_passworks', function (Blueprint $table) {
            $table->dropColumn('refused_by');
        });

        Schema::table('sogetrel_user_passworks', function (Blueprint $table) {
            $table->dropColumn('administrative_manager');
        });

        Schema::table('sogetrel_user_passworks', function (Blueprint $table) {
            $table->dropColumn('work_starts_at');
        });
    }
}
