<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomerSogetrelPassworkCapitalizeEnterpriseName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $passworks = DB::table('customer_sogetrel_passwork')->select('id', 'data')->get();

        foreach ($passworks as $passwork) {
            if (is_null($data = json_decode($passwork->data))) {
                continue;
            }

            $data->enterprise_name = strtoupper($data->enterprise_name ?? '');

            DB::table('customer_sogetrel_passwork')
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
