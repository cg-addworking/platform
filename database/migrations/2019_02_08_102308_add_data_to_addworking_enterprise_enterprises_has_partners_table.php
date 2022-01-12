<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataToAddworkingEnterpriseEnterprisesHasPartnersTable extends Migration
{
    /**
     * List of customers
     *
     * @var array
     */
    protected $customers = [
        'COURSIER.FR',
        'GCS EUROPE',
        'GRDF',
        'SOGETREL',
        'SOGETREL - DIRECTION OPERATIONNELLE EST',
        'SOGETREL - DIRECTION OPERATIONNELLE IDF',
        'SOGETREL - DIRECTION OPERATIONNELLE OUEST',
        'SOGETREL - DIRECTION OPERATIONNELLE SUD EST',
        'SOGETREL - DIRECTION OPERATIONNELLE SUD OUEST',
        'STARS SERVICE',
        'TRANSPORT SCIENTIFIQUE MEDICAL',
        'TSE EXPRESS MEDICAL',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $vendor_role_id = optional(DB::table('roles')
            ->select('id')->where('name', 'vendor')->first())->id;

        foreach ($this->customers as $customer_name) {
            $customer = DB::table('addworking_enterprise_enterprises')
                ->select('id')->where('name', $customer_name)->first();

            if ($customer) {
                DB::table('addworking_enterprise_enterprises')->where('id', $customer->id)
                    ->update(['is_customer' => true]);

                $vendors = DB::table('addworking_enterprise_enterprises_has_users')
                    ->select('enterprise_id', 'vendor_enterprise_id', 'created_at', 'updated_at')
                    ->where('enterprise_id', $customer->id)
                    ->where('role_id', $vendor_role_id)
                    ->whereNotNull('vendor_enterprise_id')
                    ->get();

                foreach ($vendors as $vendor) {
                    DB::table('addworking_enterprise_enterprises')->where('id', $vendor->vendor_enterprise_id)
                        ->update(['is_vendor' => true]);

                    DB::table('addworking_enterprise_enterprises_has_partners')->insert([
                        'customer_id' => $customer->id,
                        'vendor_id'   => $vendor->vendor_enterprise_id,
                        'created_at'  => $vendor->created_at,
                        'updated_at'  => $vendor->updated_at
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('addworking_enterprise_enterprises_has_partners')->truncate();
    }
}
