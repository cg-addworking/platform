<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingContractContractPartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_contract_contract_parties', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('contract_id');
            $table->uuid('contract_template_party_id')->nullable();
            $table->uuid('enterprise_id')->nullable();
            $table->uuid('user_id')->nullable();
            $table->string('denomination');
            $table->integer('order');
            $table->string('enterprise_name')->nullable();
            $table->string('user_name')->nullable();
            $table->boolean('signed')->default(false);
            $table->datetime('signed_at')->nullable();
            $table->boolean('declined')->default(false);
            $table->datetime('declined_at')->nullable();
            $table->timestamps();
            $table->primary('id');

            $table->foreign('contract_id')
                ->references('id')->on('addworking_contract_contracts')
                ->onDelete('cascade');

            $table->foreign('contract_template_party_id')
                ->references('id')->on('addworking_contract_contract_template_parties')
                ->onDelete('set null');

            $table->foreign('enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('set null');

            $table->foreign('user_id')
                ->references('id')->on('addworking_user_users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_contract_contract_parties');
    }
}
