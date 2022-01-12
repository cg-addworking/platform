<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAddworkingEnterpriseEnterprisesHasSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $enterprises = DB::table('addworking_enterprise_enterprises')
            ->whereNotNull('sector_id')
            ->cursor();

        Schema::create('addworking_enterprise_enterprises_has_sectors', function (Blueprint $table) {
            $table->uuid('enterprise_id');
            $table->uuid('sector_id');
            $table->primary(['enterprise_id', 'sector_id']);
            $table->timestamps();

            $table->foreign('enterprise_id')
                  ->references('id')
                  ->on('addworking_enterprise_enterprises')
                  ->onDelete('cascade');

            $table->foreign('sector_id')
                  ->references('id')
                  ->on('addworking_enterprise_sectors')
                  ->onDelete('cascade');
        });

        foreach ($enterprises as $enterprise) {
            DB::table('addworking_enterprise_enterprises_has_sectors')->insert(
                [
                    'enterprise_id' => $enterprise->id,
                    'sector_id' => $enterprise->sector_id,
                ]
                );
        }

        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->dropColumn('sector_id');
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
            Schema::table('addworking_enterprise_enterprises_has_sectors', function (Blueprint $table) {
                $table->dropForeign(['sector_id']);
            });
            Schema::table('addworking_enterprise_enterprises_has_sectors', function (Blueprint $table) {
                $table->dropForeign(['enterprise_id']);
            });
        }

        Schema::dropIfExists('addworking_enterprise_enterprises_has_sectors');

        Schema::table('addworking_enterprise_enterprises', function (Blueprint $table) {
            $table->uuid('sector_id')->nullable();

            $table
                ->foreign('sector_id')
                ->references('id')
                ->on('addworking_enterprise_sectors')
                ->onDelete('SET NULL');
        });
    }
}