<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSogetrelEnterpriseDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sogetrel_enterprise_enterprise_data', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id');
            $table->string('navibat_id');
            $table->string('compta_marche_group')->default('FRANCE');
            $table->string('compta_marche_tva_group')->default('FR-ENCAISS');
            $table->string('compta_produit_group')->default('NORMT');
            $table->boolean('navibat_sent')->default(false);


            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table
                ->foreign('enterprise_id')
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
        Schema::dropIfExists('sogetrel_enterprise_enterprise_data');
    }
}
