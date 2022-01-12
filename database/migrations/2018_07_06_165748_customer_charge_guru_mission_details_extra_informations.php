<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerChargeGuruMissionDetailsExtraInformations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * field_id    uuid
         * Id question Typeform non prise en compte.
         *
         * label   string
         * Qestion Typeform non prise en compte.
         *
         * value   string
         * Réponse de la question Typeform non prise en compte.
         *
         * type    string
         * Type de réponse de la question Typeform non prise en compte.
         */
        Schema::create(snake_case(__CLASS__), function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('field_id')->nullable();
            $table->string('label')->nullable();
            $table->string('value')->nullable();
            $table->string('type')->nullable();
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
