<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerChargeGuruMissionDetailsContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * type    Object
         * Type de contact (particulier, entreprise, collectivité, etc.) [Lookup object]
         *
         * name    String
         * Nom du contact.
         *
         * email   Email
         * Email du contact.
         *
         * mobile  String
         * Numéro de mobile du contact.
         */
        Schema::create(snake_case(__CLASS__), function (Blueprint $table) {
            $table->uuid('id');
            $table->string('type_key')->nullable();
            $table->string('type_label')->nullable();
            $table->string('name')->nullable();
            $table->string('number')->nullable();
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
