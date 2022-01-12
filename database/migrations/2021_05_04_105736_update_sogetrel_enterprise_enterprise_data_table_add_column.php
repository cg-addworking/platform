<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSogetrelEnterpriseEnterpriseDataTableAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sogetrel_enterprise_enterprise_data', function (Blueprint $table) {
            $table->string('oracle_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sogetrel_enterprise_enterprise_data', function (Blueprint $table) {
            $table->dropColumn('oracle_id');
        });
    }
}
