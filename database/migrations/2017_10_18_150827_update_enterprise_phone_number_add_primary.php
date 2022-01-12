<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEnterprisePhoneNumberAddPrimary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enterprise_phone_number', function (Blueprint $table) {
            $table->boolean('primary')->default(false);
        });

        foreach (DB::table('enterprises')->get() as $enterprise) {
            if ($number = $enterprise->phoneNumbers()->first()) {
                $enterprise->phoneNumbers()->updateExistingPivot($number->id, ['primary' => true]);
            }
        }

        Schema::table('phone_number_user', function (Blueprint $table) {
            $table->boolean('primary')->default(false);
        });

        foreach (DB::table('users')->get() as $user) {
            if ($number = $user->phoneNumbers()->first()) {
                $user->phoneNumbers()->updateExistingPivot($number->id, ['primary' => true]);
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
        Schema::table('phone_number_user', function (Blueprint $table) {
            $table->dropColumn('primary');
        });

        Schema::table('enterprise_phone_number', function (Blueprint $table) {
            $table->dropColumn('primary');
        });
    }
}
