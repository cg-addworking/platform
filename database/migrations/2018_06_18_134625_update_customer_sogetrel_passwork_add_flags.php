<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomerSogetrelPassworkAddFlags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_sogetrel_passwork', function (Blueprint $table) {
            $table->boolean('flag_parking')->default(false);
            $table->boolean('flag_contacted')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_sogetrel_passwork', function (Blueprint $table) {
            $table->dropColumn('flag_parking');
        });

        Schema::table('customer_sogetrel_passwork', function (Blueprint $table) {
            $table->dropColumn('flag_contacted');
        });
    }
}
