<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMissionsSetContractIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $uuids = DB::table('missions')->select('id', 'contract_id')->get();

        Schema::table('missions', function (Blueprint $table) {
            $table->dropColumn('contract_id');
        });

        Schema::table('missions', function (Blueprint $table) {
            $table->uuid('contract_id')->nullable();
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
        });

        foreach ($uuids as $row) {
            DB::table('missions')->where('id', $row->id)->update([
                'contract_id' => $row->contract_id,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // this migration is impossible to revert
    }
}
