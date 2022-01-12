<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSogetrelPassworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sogetrel_user_passworks', function (Blueprint $table) {
            $table->boolean('needs_decennial_insurance')->nullable();
            $table->string('applicable_price_slip')->nullable();
            $table->float('bank_guarantee_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sogetrel_user_passworks', function (Blueprint $table) {
            $table->dropColumn([
                'needs_decennial_insurance',
                'applicable_price_slip',
                'bank_guarantee_amount'
            ]);
        });
    }
}
