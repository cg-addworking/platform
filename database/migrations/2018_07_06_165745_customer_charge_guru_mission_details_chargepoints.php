<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerChargeGuruMissionDetailsChargepoints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * power   object
         * Puissance de la borne de recharge. [Lookup object]
         *
         * type    object
         * Usage des bornes (Usage interne avec nombre d'utilisateurs défini,
         * Usage externe : bornes ouvertes au public) [Lookup object]
         *
         * offer_model object
         * Modèle de service de recharge (gratuit, payant, etc.) [Lookup object]
         *
         * nb_chargepoints Number
         * Nombre de bornes à installer ?
         */
        Schema::create(snake_case(__CLASS__), function (Blueprint $table) {
            $table->uuid('id');
            $table->string('power_key')->nullable();
            $table->string('power_label')->nullable();
            $table->string('type_key')->nullable();
            $table->string('type_label')->nullable();
            $table->string('offer_model_key')->nullable();
            $table->string('offer_model_label')->nullable();
            $table->integer('nb_chargepoints')->nullable();
            $table->timestamps();
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(snake_case(__CLASS__));
    }
}
