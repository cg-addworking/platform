<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerChargeGuruMissionDetailsParkings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * address String
         * Adresse du parking où sera installé les bornes de recharge.
         *
         * city    String
         * Ville
         *
         * postal_code String
         * Code postal
         *
         * location    object
         * Où souhaitez-vous installer les solutions de recharge (ex: pavillon, lieu de travail, etc.) ? [Lookup object]
         *
         * situation   object
         * Quelle est la configuration du parking (ex: intérieur, extérieur) ? [Lookup object]
         *
         * size    object
         * Combien y a-t-il de places de parking ? [Lookup object]
         *
         * nb_company_sites    object
         * Combien de sites l'utilisateur souhaite équiper ? [Lookup object]
         *
         * company_parking_type    object
         * Le parking est privé ? ou partagé avec d'autres sociétés ? [Lookup object]
         */
        Schema::create(snake_case(__CLASS__), function (Blueprint $table) {
            $table->uuid('id');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('location_key')->nullable();
            $table->string('location_label')->nullable();
            $table->string('situation_key')->nullable();
            $table->string('situation_label')->nullable();
            $table->string('size_key')->nullable();
            $table->string('size_label')->nullable();
            $table->string('nb_company_sites_key')->nullable();
            $table->string('nb_company_sites_label')->nullable();
            $table->string('company_parking_type_key')->nullable();
            $table->string('company_parking_type_label')->nullable();
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
