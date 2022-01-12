<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerChargeGuruMissionDetailsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * id  Number
         * Id de l'utilisateur de ChargeGuru.
         *
         * name    String
         * Nom/prénom de l'utilisateur de ChargeGuru.
         *
         * email   Email
         * Adresse email de l'utilisateur de ChargeGuru.
         *
         * email_confirmed Boolean
         * L'utilisateur de ChargeGuru a-t-il confirmé son adresse email ?
         *
         * mobile  String
         * Numéro de mobile de l'utilisateur de ChargeGuru.
         */
        Schema::create(snake_case(__CLASS__), function (Blueprint $table) {
            $table->uuid('id');
            $table->string('external_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->boolean('email_confirmed')->nullable();
            $table->string('mobile')->nullable();
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
