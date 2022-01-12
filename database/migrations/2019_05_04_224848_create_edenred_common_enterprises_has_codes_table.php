<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdenredCommonEnterprisesHasCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edenred_common_average_daily_rates', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('code_id');
            $table->uuid('vendor_id');
            $table->float('rate');
            $table->timestamps();
            $table->primary('id');
            $table->unique(['code_id', 'vendor_id']);

            $table->foreign('code_id')
                ->references('id')
                ->on('edenred_common_codes')
                ->onDelete('cascade');

            $table->foreign('vendor_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('edenred_common_average_daily_rates');
    }
}
