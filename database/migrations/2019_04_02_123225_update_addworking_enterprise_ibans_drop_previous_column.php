<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingEnterpriseIbansDropPreviousColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_ibans', function (Blueprint $table) {
            $table->dropColumn('previous');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_enterprise_ibans', function (Blueprint $table) {
            $table->json('previous')->nullable()->after('validation_token');
        });
    }
}
