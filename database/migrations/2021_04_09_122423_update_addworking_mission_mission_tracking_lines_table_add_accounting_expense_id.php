<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingMissionMissionTrackingLinesTableAddAccountingExpenseId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_mission_mission_tracking_lines', function (Blueprint $table) {
            $table->uuid('accounting_expense_id')->nullable();

            $table
                ->foreign('accounting_expense_id')
                ->references('id')
                ->on('addworking_enterprise_accounting_expenses')
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
                $table->dropForeign(['accounting_expense_id']);
            });
        }

        Schema::table('addworking_mission_mission_tracking_lines', function (Blueprint $table) {
            $table->dropColumn('accounting_expense_id');
        });
    }
}
