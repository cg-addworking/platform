<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingMissionMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_missions', function (Blueprint $table) {
            $table->string('analytic_code')->nullable();
            $table->softDeletes();
        });

        Schema::table('addworking_mission_missions', function (Blueprint $table) {
            $table->uuid('workfield_id')->nullable();
            $table->uuid('referent_id')->nullable();

            $table
                ->foreign('workfield_id')
                ->references('id')
                ->on('addworking_enterprise_work_fields')
                ->onDelete('SET NULL');

            $table
                ->foreign('referent_id')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('SET NULL');
        });

        Schema::table('addworking_common_files_has_missions', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
        });

        Schema::create('addworking_mission_missions_has_departments', function (Blueprint $table) {
            $table->uuid('mission_id');
            $table->uuid('department_id');
            $table->timestamps();

            $table->primary(['mission_id', 'department_id']);

            $table
                ->foreign('mission_id')
                ->references('id')
                ->on('addworking_mission_missions')
                ->onDelete('cascade');

            $table
                ->foreign('department_id')
                ->references('id')
                ->on('addworking_common_departments')
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
        Schema::table('addworking_mission_missions', function (Blueprint $table) {
            $table->dropColumn('analytic_code');
        });

        Schema::table('addworking_mission_missions', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver !== 'sqlite') {
            Schema::table('addworking_mission_missions', function (Blueprint $table) {
                $table->dropForeign(['workfield_id']);
            });

            Schema::table('addworking_mission_missions', function (Blueprint $table) {
                $table->dropForeign(['referent_id']);
            });
        }

        Schema::table('addworking_mission_missions', function (Blueprint $table) {
            $table->dropColumn('workfield_id');
        });

        Schema::table('addworking_mission_missions', function (Blueprint $table) {
            $table->dropColumn(['referent_id']);
        });

        Schema::dropIfExists('addworking_mission_missions_has_departments');
    }
}
