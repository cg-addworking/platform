<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MigratePhoneNumbersToTheNewPolymorphicSystem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $enterprisePhoneNumbers = DB::table('addworking_enterprise_enterprises_has_phone_numbers')->get();

        foreach ($enterprisePhoneNumbers as $enterprisePhoneNumber) {
            DB::table('addworking_common_has_phone_numbers')->insert([
                'phone_number_id' => $enterprisePhoneNumber->phone_number_id,
                'morphable_id'    => $enterprisePhoneNumber->enterprise_id,
                'morphable_type'  => 'App\Models\Addworking\Enterprise\Enterprise',
                'note'            => $enterprisePhoneNumber->note,
                'primary'         => $enterprisePhoneNumber->primary,
            ]);
        }

        $userPhoneNumbers = DB::table('addworking_common_phone_numbers_has_users')->get();

        foreach ($userPhoneNumbers as $userPhoneNumber) {
            DB::table('addworking_common_has_phone_numbers')->insert([
                'phone_number_id' => $userPhoneNumber->phone_number_id,
                'morphable_id'    => $userPhoneNumber->user_id,
                'morphable_type'  => 'App\Models\Addworking\User\User',
                'note'            => $userPhoneNumber->note,
                'primary'         => $userPhoneNumber->primary,
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
        DB::table('addworking_common_has_phone_numbers')->truncate();
    }
}
