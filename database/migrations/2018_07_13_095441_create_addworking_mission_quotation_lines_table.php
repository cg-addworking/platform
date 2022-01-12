<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingMissionQuotationLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_quotation_lines', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('mission_quotation_id');
            $table->text('designation');
            $table->string('unit')->default('fixed_price');
            $table->integer('quantity')->default(1);
            $table->float('unit_price')->default(0);
            $table->timestamps();
            $table->primary('id');

            $table
                ->foreign('mission_quotation_id')
                ->references('id')->on('mission_quotations')
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
        Schema::dropIfExists('mission_quotation_lines');
    }
}
