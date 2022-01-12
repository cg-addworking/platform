<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerChargeGuruMissionDetailsVehicles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * has_vehicle Boolean
         * Est-ce que la personne possède déjà un véhicule ?
         *
         * type    object
         * Type de véhicule à recharger. [Lookup object]
         *
         * model   String
         * Modèle de véhicule à recharger.
         *
         * distance_per_day    object
         * Distance parcouru chaque jour. [Lookup object]
         */
        Schema::create(snake_case(__CLASS__), function (Blueprint $table) {
            $table->uuid('id');
            $table->boolean('has_vehicle')->nullable();
            $table->string('type_key')->nullable();
            $table->string('type_label')->nullable();
            $table->string('model')->nullable();
            $table->string('distance_per_day_key')->nullable();
            $table->string('distance_per_day_label')->nullable();
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
