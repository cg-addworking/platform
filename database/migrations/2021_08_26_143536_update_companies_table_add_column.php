<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCompaniesTableAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->boolean('is_sole_shareholder')->default(false);
        });

        Schema::table('company_invoicing_details', function (Blueprint $table) {
            $table->boolean('vat_exemption')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('is_sole_shareholder');
        });

        Schema::table('company_invoicing_details', function (Blueprint $table) {
            $table->dropColumn('vat_exemption');
        });
    }
}
