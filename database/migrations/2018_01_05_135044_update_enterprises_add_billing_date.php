<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEnterprisesAddBillingDate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enterprises', function (Blueprint $table) {
            $table->string('billing_date')->nullable()->after('payment_terms');
        });

        DB::table('enterprises')
            ->whereIn('name', ["STARS SERVICE", "TSE EXPRESS MEDICAL"])
            ->update(['billing_date' => 'end_of_month']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enterprises', function (Blueprint $table) {
            $table->dropColumn('billing_date');
        });
    }
}
