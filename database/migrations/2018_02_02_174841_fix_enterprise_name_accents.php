<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixEnterpriseNameAccents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (DB::table('enterprises')->select('id', 'name')->get() as $row) {
            DB::table('enterprises')
                ->where('id', $row->id)
                ->update(['name' => strtoupper(remove_accents($row->name))]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
