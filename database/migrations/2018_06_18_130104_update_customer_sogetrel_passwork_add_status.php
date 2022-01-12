<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomerSogetrelPassworkAddStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_sogetrel_passwork', function (Blueprint $table) {
            $table->string('status')->after('enterprise_id')->default('pending');
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
            $table->dropColumn('status');
        });
    }
}
