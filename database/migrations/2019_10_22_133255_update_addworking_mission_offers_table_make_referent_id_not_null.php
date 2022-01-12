<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingMissionOffersTableMakeReferentIdNotNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $offers = DB::table('addworking_mission_offers')->whereNull('referent_id')->get();

        foreach ($offers as $offer) {
            DB::table('addworking_mission_offers')->whereId($offer->id)->update([
                'referent_id' => "$offer->created_by",
            ]);
        }

        $connection = config('database.default');

        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE addworking_mission_offers ALTER COLUMN referent_id SET NOT NULL');
        }

        if($driver === 'sqlite') {
            Schema::table('addworking_mission_offers', function (Blueprint $table) {
                $table->string('referent_id')->nullable(false)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_mission_offers', function (Blueprint $table) {

            $connection = config('database.default');

            $driver = config("database.connections.{$connection}.driver");

            if ($driver === 'pgsql') {
                DB::statement('ALTER TABLE addworking_mission_offers ALTER COLUMN referent_id DROP NOT NULL;');
            }

            if($driver === 'sqlite') {
                Schema::table('addworking_mission_offers', function (Blueprint $table) {
                    $table->string('referent_id')->nullable()->change();
                });
            }
        });
    }
}
