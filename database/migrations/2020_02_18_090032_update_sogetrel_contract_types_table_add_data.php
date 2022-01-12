<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Webpatser\Uuid\Uuid;

class UpdateSogetrelContractTypesTableAddData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('sogetrel_contract_types')->insert([
            [
                'id'           => Uuid::generate(4),
                'name'         => 'FTTA BOUYGTEL',
                'display_name' => 'FTTA BOUYGTEL',
                'created_at'   => date("Y-m-d H:i:s"),
                'updated_at'   => date("Y-m-d H:i:s"),
            ],
            [
                'id'           => Uuid::generate(4),
                'name'         => 'SUPERSONIC',
                'display_name' => 'SUPERSONIC',
                'created_at'   => date("Y-m-d H:i:s"),
                'updated_at'   => date("Y-m-d H:i:s"),
            ],
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
            ->where('name','=', 'FTTA BOUYGTEL')
            ->orWhere('name', '=','SUPERSONIC')
            ->delete();
    }
}
