<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Concerns\HasNumber;
use Illuminate\Support\Arr;

class EnterprisesCreationFromSogetrelPassworks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sogetrel_passworks = DB::table('sogetrel_user_passworks')->get();

        foreach ($sogetrel_passworks as $passwork) {
            if (!$user = DB::table('addworking_user_users')->where('id', $passwork->user_id)->first()) {
                continue;
            }

            $data = json_decode($passwork->data, true);

            $name_enterprise = Arr::has($data, 'enterprise_name')
                ? Arr::get($data, 'enterprise_name')
                : "{$user->firstname} {$user->lastname}";

            if (DB::table('addworking_enterprise_enterprises')->where('name', $name_enterprise)->exists()
                || DB::table('addworking_enterprise_enterprises_has_users')->where('user_id', $user->id)->exists()) {
                continue;
            }

            $enterprise_id = Uuid::generate(4);

            $number_max = DB::table('addworking_enterprise_enterprises')->max('number');

            DB::table('addworking_enterprise_enterprises')
                ->insert(
                    [
                        'id'                        => $enterprise_id,
                        'legal_form'                => "none",
                        'name'                      => $name_enterprise,
                        'number'                    => ++$number_max,
                        'is_vendor'                 => true,
                        'created_at'                => date("Y-m-d H:i:s"),
                        'updated_at'                => date("Y-m-d H:i:s"),
                    ]
                );

            DB::table('addworking_enterprise_enterprises_has_users')
                ->insert(
                    [
                        'user_id'                   => $user->id,
                        'enterprise_id'             => $enterprise_id,
                        'created_at'                => date("Y-m-d H:i:s"),
                        'updated_at'                => date("Y-m-d H:i:s"),
                        'is_signatory'              => true,
                        'is_legal_representative'   => true,
                        'primary'                   => true,
                        'is_admin'                  => true,
                        'access_to_billing'         => true,
                        'access_to_mission'         => true,
                        'access_to_contract'        => true,
                        'access_to_user'            => true,
                        'access_to_enterprise'      => true,
                        'current'                   => true,
                    ]
                );

            if (!$number_phone = Arr::get($data, 'phone')) {
                continue;
            }

            if (DB::table('addworking_common_phone_numbers')->where('number', $number_phone)->exists()) {
                continue;
            }

            $number_phone_id = Uuid::generate(4);

            DB::table('addworking_common_phone_numbers')
                ->insert(
                    [
                        'id'                        => $number_phone_id,
                        'number'                    => $number_phone,
                        'created_at'                => date("Y-m-d H:i:s"),
                        'updated_at'                => date("Y-m-d H:i:s"),
                    ]
                );

            DB::table('addworking_common_has_phone_numbers')
                ->insert(
                    [
                        'phone_number_id'           => $number_phone_id,
                        'morphable_id'              => $enterprise_id,
                        'morphable_type'            => "App\Models\Addworking\Enterprise\Enterprise",
                        'note'                      => "",
                        'primary'                   => true,
                        'created_at'                => date("Y-m-d H:i:s"),
                        'updated_at'                => date("Y-m-d H:i:s"),
                    ]
                );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // reversal of migration impossible
    }
}
