<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MigrateEnterpriseAddressesToTheNewPolymorphicAddressSystems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $enterpriseAddresses = DB::table('addworking_common_addresses_has_enterprises')->get();

        foreach ($enterpriseAddresses as $enterpriseAddress) {
            DB::table('addworking_common_addressables')->insert([
                'address_id'       => $enterpriseAddress->address_id,
                'addressable_id'   => $enterpriseAddress->enterprise_id,
                'addressable_type' => 'App\Models\Addworking\Enterprise\Enterprise',
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
        DB::table('addworking_common_addressables')->truncate();
    }
}
