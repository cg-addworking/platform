<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateIbansAddIbanPendingAndValidationToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ibans', function (Blueprint $table) {
            $table->string('iban_validation_token')->nullable()->after('iban');
            $table->string('iban_pending')->nullable()->after('iban_validation_token');
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
            $table->dropColumn('iban_validation_token');
        });

        Schema::table('ibans', function (Blueprint $table) {
            $table->dropColumn('iban_pending');
        });
    }
}
