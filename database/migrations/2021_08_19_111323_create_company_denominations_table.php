<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyDenominationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_denominations', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('short_id');
            $table->uuid('company_id');
            $table->string('name');
            $table->string('commercial_name')->nullable();
            $table->string('acronym')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_denominations');
    }
}
