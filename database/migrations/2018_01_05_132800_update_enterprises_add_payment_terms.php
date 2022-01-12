<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEnterprisesAddPaymentTerms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enterprises', function (Blueprint $table) {
            $table->string('payment_terms')->nullable()->after('iban');
        });

        DB::table('enterprises')
            ->whereIn('name', ["STARS SERVICE", "TSE EXPRESS MEDICAL", "CHARGE GURU"])
            ->update(['payment_terms' => '30_days']);

        DB::table('enterprises')
            ->whereIn('name', ["COURSIER.FR", "GCS EUROPE"])
            ->update(['payment_terms' => 'immediate']);

        DB::table('enterprises')
            ->whereIn('name', ["GRDF"])
            ->update(['payment_terms' => 'upfront_trimester']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enterprises', function (Blueprint $table) {
            $table->dropColumn('payment_terms');
        });
    }
}
