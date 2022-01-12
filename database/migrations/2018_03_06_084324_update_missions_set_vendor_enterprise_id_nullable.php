<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMissionsSetVendorEnterpriseIdNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $uuids = DB::table('missions')->select('id', 'vendor_enterprise_id')->get();

        Schema::table('missions', function (Blueprint $table) {
            $table->dropColumn('vendor_enterprise_id');
        });

        Schema::table('missions', function (Blueprint $table) {
            $table->uuid('vendor_enterprise_id')->nullable();
            $table->foreign('vendor_enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
        });

        foreach ($uuids as $row) {
            DB::table('missions')->where('id', $row->id)->update([
                'vendor_enterprise_id' => $row->vendor_enterprise_id,
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
