<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class AddAddWorkingDeutschlandGmbhEnterprise extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $addworking_deutschland_gmbh_enterprise = DB::table('addworking_enterprise_enterprises')
            ->where('name', "ADDWORKING DEUTSCHLAND GMBH")->first();

        if (is_null($addworking_deutschland_gmbh_enterprise)) {
            $order = 1 + DB::table('addworking_enterprise_enterprises')->get()->max('order');

            DB::table('addworking_enterprise_enterprises')->insert([
                'id' => Uuid::generate(4),
                'name' => "ADDWORKING DEUTSCHLAND GMBH",
                'identification_number' => "HRA32456456789199",
                'registration_town' => "SAARBRÜCKEN",
                'tax_identification_number' => 'DE' . random_numeric_string(11),
                'is_customer' => 0,
                'is_vendor' => 0,
                'number' => $order,
                'country' => 'de'
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
        DB::table('addworking_enterprise_enterprises')
            ->where('name', "ADDWORKING DEUTSCHLAND GMBH")
            ->delete();
    }
}
