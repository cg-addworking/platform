<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEnterpriseFileAddColumnValidFromAndValidUntil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enterprise_file', function (Blueprint $table) {
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enterprise_file', function (Blueprint $table) {
            $table->dropColumn('valid_from');
        });

        Schema::table('enterprise_file', function (Blueprint $table) {
            $table->dropColumn('valid_until');
        });
    }
}
