<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveOldPhonesAndAddressesPivotTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('addworking_common_addresses_has_enterprises');
        Schema::dropIfExists('addworking_common_addresses_has_users');
        Schema::dropIfExists('addworking_common_phone_numbers_has_users');
        Schema::dropIfExists('addworking_enterprise_enterprises_has_phone_numbers');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('addworking_enterprise_enterprises_has_phone_numbers', function (Blueprint $table) {
            $table->uuid('enterprise_id');
            $table->uuid('phone_number_id');
            $table->text('note')->nullable();
            $table->boolean('primary')->default(false);

            $table->primary(['enterprise_id', 'phone_number_id']);

            $table->foreign('enterprise_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');

            $table->foreign('phone_number_id')
                ->references('id')
                ->on('addworking_common_phone_numbers')
                ->onDelete('cascade');
        });

        $enterprisePhoneNumbers = DB::table('addworking_common_has_phone_numbers')
            ->where('morphable_type', '=', 'App\Models\Addworking\Enterprise\Enterprise')
            ->get();

        foreach ($enterprisePhoneNumbers as $enterprisePhoneNumber) {
            DB::table('addworking_enterprise_enterprises_has_phone_numbers')->insert([
                'enterprise_id'   => $enterprisePhoneNumber->morphable_id,
                'phone_number_id' => $enterprisePhoneNumber->phone_number_id,
                'note'            => $enterprisePhoneNumber->note,
                'primary'         => $enterprisePhoneNumber->primary,
            ]);
        }

        Schema::create('addworking_common_phone_numbers_has_users', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->uuid('phone_number_id');
            $table->text('note')->nullable();
            $table->boolean('primary')->default(false);

            $table->primary(['user_id', 'phone_number_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('cascade');

            $table->foreign('phone_number_id')
                ->references('id')
                ->on('addworking_common_phone_numbers')
                ->onDelete('cascade');
        });

        $userPhoneNumbers = DB::table('addworking_common_has_phone_numbers')
            ->where('morphable_type', '=', 'App\Models\Addworking\User\User')
            ->get();

        foreach ($userPhoneNumbers as $userPhoneNumber) {
            DB::table('addworking_common_phone_numbers_has_users')->insert([
                'user_id'         => $userPhoneNumber->morphable_id,
                'phone_number_id' => $userPhoneNumber->phone_number_id,
                'note'            => $userPhoneNumber->note,
                'primary'         => $userPhoneNumber->primary,
            ]);
        }

        Schema::create('addworking_common_addresses_has_users', function (Blueprint $table) {
            $table->uuid('address_id');
            $table->uuid('user_id');

            $table->primary(['address_id', 'user_id']);

            $table->foreign('address_id')
                ->references('id')
                ->on('addworking_common_addresses')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('cascade');
        });

        $userAddresses = DB::table('addworking_common_addressables')
            ->where('addressable_type', '=', 'App\Models\Addworking\User\User')
            ->get();

        foreach ($userAddresses as $userAddress) {
            DB::table('addworking_common_addresses_has_enterprises')->insert([
                'address_id'    => $userAddress->address_id,
                'user_id' => $userAddress->user_id,
            ]);
        }

        Schema::create('addworking_common_addresses_has_enterprises', function (Blueprint $table) {
            $table->uuid('address_id');
            $table->uuid('enterprise_id');

            $table->primary(['address_id', 'enterprise_id']);

            $table->foreign('address_id')
                ->references('id')
                ->on('addworking_common_addresses')
                ->onDelete('cascade');

            $table->foreign('enterprise_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');
        });

        $enterpriseAddresses = DB::table('addworking_common_addressables')
            ->where('addressable_type', '=', 'App\Models\Addworking\Enterprise\Enterprise')
            ->get();

        foreach ($enterpriseAddresses as $enterpriseAddress) {
            DB::table('addworking_common_addresses_has_enterprises')->insert([
                'address_id'    => $enterpriseAddress->address_id,
                'enterprise_id' => $enterpriseAddress->addressable_id,
            ]);
        }
    }
}
