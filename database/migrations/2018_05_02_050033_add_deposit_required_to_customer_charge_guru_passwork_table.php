<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepositRequiredToCustomerChargeGuruPassworkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
            $table->boolean('deposit_required')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('customer_charge_guru_passwork', 'deposit_required')) {
            Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
                $table->dropColumn('deposit_required');
            });
        }
    }
}
