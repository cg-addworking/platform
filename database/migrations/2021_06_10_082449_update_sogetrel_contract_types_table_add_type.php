<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Webpatser\Uuid\Uuid;

class UpdateSogetrelContractTypesTableAddType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $order = 1 + DB::table('sogetrel_contract_types')->get()->max('order');
        DB::table('sogetrel_contract_types')->insert([
                'id'           => Uuid::generate(4),
                'name'         => str_slug('AUTRE TRAVAUX'),
                'display_name' => 'AUTRE TRAVAUX',
                'created_at'   => date("Y-m-d H:i:s"),
                'updated_at'   => date("Y-m-d H:i:s"),
                'order'        => $order
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('sogetrel_contract_types')
            ->where('name','=', 'AUTRE TRAVAUX')
            ->delete();
    }
}
