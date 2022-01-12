<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerChargeGuruMissionDetailsSyndics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * syndic_name String
         * Nom du syndic de copropriété.
         *
         * address String
         * Adresse du syndic de copropriété.
         *
         * email   Email
         * Email syndic de copropriété.
         *
         * phone   String
         * Téléphone du syndic de copropriété.
         *
         * next_general_meeting_date   date
         * Date de la prochaine assemblée générale.
         */
        Schema::create(snake_case(__CLASS__), function (Blueprint $table) {
            $table->uuid('id');
            $table->string('syndic_name')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->date('next_general_meeting_date')->nullable();
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
