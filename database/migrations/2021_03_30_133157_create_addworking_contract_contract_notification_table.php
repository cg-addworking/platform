<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingContractContractNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_contract_contract_notifications', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('contract_id');
            $table->uuid('sent_to');
            $table->string('notification_name');
            $table->dateTime('sent_date')->nullable();

            $table->timestamps();

            $table->primary('id');
            $table->foreign('contract_id')
                ->references('id')
                ->on('addworking_contract_contracts')
                ->onDelete('cascade');

            $table
                ->foreign('sent_to')
                ->references('id')
                ->on('addworking_user_users')
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
        Schema::dropIfExists('addworking_contract_contract_notifications');
    }
}
