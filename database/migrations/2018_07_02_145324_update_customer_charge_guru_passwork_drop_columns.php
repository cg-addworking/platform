<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomerChargeGuruPassworkDropColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
            $table->dropColumn('regions');
        });

        Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
            $table->dropColumn('brands');
        });

        Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
            $table->dropColumn('skills');
        });

        Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
            $table->dropColumn('qualifications');
        });

        Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
            $table->dropColumn('insurances');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
            $table
                ->json('regions')
                ->nullable()
                ->after('enterprise_id');

            $table
                ->json('skills')
                ->nullable()
                ->after('regions');

            $table
                ->json('qualifications')
                ->nullable()
                ->after('skills');

            $table
                ->json('insurances')
                ->nullable()
                ->after('qualifications');

            $table
                ->json('brands')
                ->nullable()
                ->after('insurances');
        });
    }
}
