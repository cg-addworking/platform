<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvoicesAddMonth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('month')->nullable()->after('number');
        });

        foreach (DB::table('users')->get() as $user) {
            foreach ($user->vendors as $vendor) {
                foreach ($vendor->enterprise->invoices as $invoice) {
                    $invoice->update(['month' => '10/2017']);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('month');
        });
    }
}
