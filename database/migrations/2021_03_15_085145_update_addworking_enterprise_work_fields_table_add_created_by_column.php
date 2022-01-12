<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseWorkFieldsTableAddCreatedByColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_work_fields', function (Blueprint $table) {
            $table->uuid('created_by')->nullable();

            $table
                ->foreign('created_by')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('SET NULL');
        });

        $work_fields = DB::table('addworking_enterprise_work_fields')->cursor();

        foreach ($work_fields as $work_field) {
            $user_id = DB::table('addworking_enterprise_enterprises_has_users')
                ->where('enterprise_id', $work_field->owner_id)->first()->user_id;

            DB::table('addworking_enterprise_work_fields')
                ->where('id', $work_field->id)
                ->update(['created_by' => $user_id]);
        }

        Schema::table('addworking_enterprise_work_fields', function (Blueprint $table) {
            $table->uuid('created_by')->nullable(false)->change();
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

        if($driver !== 'sqlite') {
            Schema::table('addworking_enterprise_work_fields', function (Blueprint $table) {
                $table->dropForeign(['created_by']);
            });
        }

        Schema::table('addworking_enterprise_work_fields', function (Blueprint $table) {
            $table->dropColumn(['created_by']);
        });
    }
}
