<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByToMissionTrackingLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_mission_tracking_lines', function (Blueprint $table) {
            $table->uuid('created_by')->nullable();

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
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver !== 'sqlite') {
            Schema::table('addworking_mission_mission_tracking_lines', function (Blueprint $table) {
                $table->dropForeign(['created_by']);
            });
        }

        Schema::table('addworking_mission_mission_tracking_lines', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
    }
}
