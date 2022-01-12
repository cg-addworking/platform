<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyCapitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_share_capitals', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('short_id');
            $table->uuid('company_id');
            $table->uuid('currency_id');
            $table->float('amount')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('CASCADE');
            
            $table->foreign('currency_id')
                ->references('id')->on('currencies')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_share_capitals');
    }
}
