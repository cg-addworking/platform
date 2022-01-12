<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseInvoiceParametersTableAddNumberColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_invoice_parameters', function (Blueprint $table) {
            $table->integer('number')->nullable();
        });

        $invoice_parameters = DB::table('addworking_enterprise_invoice_parameters')->get();

        $number = 1;
        foreach ($invoice_parameters as $invoice_parameter) {
            DB::table('addworking_enterprise_invoice_parameters')
                ->where('id', $invoice_parameter->id)
                ->update(['number' => $number]);

            $number += 1;
        }

        Schema::table('addworking_enterprise_invoice_parameters', function (Blueprint $table) {
            $table->integer('number')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_enterprise_invoice_parameters', function (Blueprint $table) {
            $table->dropColumn('number');
        });
    }
}
