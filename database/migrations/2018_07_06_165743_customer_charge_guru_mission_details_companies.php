<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerChargeGuruMissionDetailsCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * company_name    String
         * Nom de la société.
         *
         * name    String
         * Nom de la personne à contacter.
         *
         * email   Email
         * Email de la personne à contacter.
         *
         * phone   String
         * Numéro de téléphone de la personne à contacter.
         *
         * job String
         * Poste de la personne à contacter.
         *
         * company_site_size   Object
         * Combien de personnes travaillent sur le site ? [Lookup object]
         */
        Schema::create(snake_case(__CLASS__), function (Blueprint $table) {
            $table->uuid('id');
            $table->string('company_name')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('job')->nullable();
            $table->string('company_site_size_key')->nullable();
            $table->string('company_site_size_label')->nullable();
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
