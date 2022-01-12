<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerChargeGuruMissionDetailsInstallations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * is_electrical_mains_ok  object
         * La colonne montante électrique de l'immeuble est-elle aux normes ? [Lookup object]
         *
         * is_renovation_needed    boolean
         * La rénovation de la colonne montante pourrait être nécessaire ?
         *
         * building_construction_year  date
         * Année de construction de l'immeuble ?
         *
         * building_construction_date  object
         * Le bâtiment à plus ou moins de 2 ans ? [Lookup object]
         *
         * electrical_panel_same_room  boolean
         * Le tableau électrique et la borne de recharge seront-ils dans la même pièce ?
         *
         * electrical_panel_distance   object
         * Distance approximative entre le tableau électrique et la borne de recharge à installer
         *
         * can_share_pics  boolean
         * Est-ce que l'utilisteur peut transmettre une photo de la place de parking et du tableau électrique ?
         */
        Schema::create(snake_case(__CLASS__), function (Blueprint $table) {
            $table->uuid('id');
            $table->string('is_electrical_mains_ok_key')->nullable();
            $table->string('is_electrical_mains_ok_label')->nullable();
            $table->boolean('is_renovation_needed')->nullable();
            $table->date('building_construction_year')->nullable();
            $table->string('building_construction_date_key')->nullable();
            $table->string('building_construction_date_label')->nullable();
            $table->boolean('electrical_panel_same_room')->nullable();
            $table->string('electrical_panel_distance_key')->nullable();
            $table->string('electrical_panel_distance_label')->nullable();
            $table->boolean('can_share_pics')->nullable();
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
