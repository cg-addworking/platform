<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemoveAccentAccentOnEnterpriseNamesPassworkSogetrel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $passworks = DB::table('sogetrel_user_passworks')->get();

        foreach ($passworks as $passwork) {
            if (is_null($data = json_decode($passwork->data))) {
                continue;
            }

            $data->enterprise_name = strtoupper(remove_accents($data->enterprise_name ?? ''));

            DB::table('sogetrel_user_passworks')
                ->where('id', $passwork->id)
                ->update(['data' => json_encode($data)]);
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
