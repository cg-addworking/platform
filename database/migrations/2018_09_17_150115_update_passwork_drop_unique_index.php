<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePassworkDropUniqueIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_sogetrel_passwork', function (Blueprint $table) {
            $table->dropUnique('customer_sogetrel_passwork_user_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $rows = DB::table('customer_sogetrel_passwork')->select('id', 'user_id')->get();

        foreach ($rows as $row) {
            $dupplicates = DB::table('customer_sogetrel_passwork')
                ->select('id')
                ->where('user_id', $row->user_id)
                ->where('id', '!=', $row->id)
                ->get();

            DB::table('customer_sogetrel_passwork')
                ->whereIn('id', array_pluck($dupplicates, 'id'))
                ->delete();
        }

        Schema::table('customer_sogetrel_passwork', function (Blueprint $table) {
            $table->unique('user_id');
        });
    }
}
