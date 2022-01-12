<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpieEnterpriseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spie_enterprise_orders', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id');
            $table->string('short_label');
            $table->integer('year');
            $table->string('subsidiary_company_label');
            $table->string('direction_label');
            $table->float('amount')->nullable();
            $table->timestamps();
            $table->primary('id');
            $table->unique(['short_label', 'year', 'subsidiary_company_label', 'direction_label']);

            $table->foreign('enterprise_id')
                ->references('id')->on('spie_enterprise_enterprises')
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
        Schema::dropIfExists('spie_enterprise_orders');
    }
}
