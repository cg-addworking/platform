<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIbansTableChangeColumnNames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ibans', function (Blueprint $table) {
            $table->renameColumn('iban_validation_token', 'validation_token');
        });

        Schema::table('ibans', function (Blueprint $table) {
            $table->renameColumn('iban_pending', 'status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ibans', function (Blueprint $table) {
            $table->renameColumn('validation_token', 'iban_validation_token');
        });

        Schema::table('ibans', function (Blueprint $table) {
            $table->renameColumn('status', 'iban_pending');
        });
    }
}
