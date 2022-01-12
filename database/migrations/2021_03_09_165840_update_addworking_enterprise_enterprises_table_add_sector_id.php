<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseEnterprisesTableAddSectorId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->uuid('sector_id')->nullable();

            $table
                ->foreign('sector_id')
                ->references('id')
                ->on('addworking_enterprise_sectors')
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
            Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
                $table->dropForeign(['sector_id']);
            });
        }

        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->dropColumn('sector_id');
        });
    }
}
