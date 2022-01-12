<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingEnterpriseInvoiceParametersTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_enterprise_invoice_parameters', function (Blueprint $table) {
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('ends_at')->nullable();
        });

        $parameters = DB::table('addworking_enterprise_invoice_parameters')->get();
        foreach ($parameters as $parameter) {
            $customer = DB::table('addworking_enterprise_enterprises')->find($parameter->enterprise_id);
            DB::table('addworking_enterprise_invoice_parameters')->where('enterprise_id', $customer->id)
                ->update(['starts_at' => $customer->created_at]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_enterprise_invoice_parameters', function (Blueprint $table) {
            $table->dropColumn('starts_at');
        });

        Schema::table('addworking_enterprise_invoice_parameters', function (Blueprint $table) {
            $table->dropColumn('ends_at');
        });
    }
}
