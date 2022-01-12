<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionQuotationsTableAddColumnsStatusCreatedRefused extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_quotations', function (Blueprint $table) {
            $table->string('status')->default('under_negotiation');

            $table->uuid('accepted_by')->nullable();
            $table->dateTime('accepted_at')->nullable();

            $table->uuid('refused_by')->nullable();
            $table->dateTime('refused_at')->nullable();

            $table
                ->foreign('accepted_by')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('SET NULL');

            $table
                ->foreign('refused_by')
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
        Schema::table('addworking_mission_quotations', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('addworking_mission_quotations', function (Blueprint $table) {
            $table->dropColumn('accepted_by');
        });

        Schema::table('addworking_mission_quotations', function (Blueprint $table) {
            $table->dropColumn('accepted_at');
        });

        Schema::table('addworking_mission_quotations', function (Blueprint $table) {
            $table->dropColumn('refused_by');
        });

        Schema::table('addworking_mission_quotations', function (Blueprint $table) {
            $table->dropColumn('refused_at');
        });
    }
}
