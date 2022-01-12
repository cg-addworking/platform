<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateContractsMutlipleUsersAndEnterprises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'enterprise_id']);
        });

        Schema::create('contract_user', function (Blueprint $table) {
            $table->uuid('contract_id');
            $table->uuid('user_id');
            $table->boolean('signed')->default(false);
            $table->integer('order');

            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('contract_enterprise', function (Blueprint $table) {
            $table->uuid('contract_id');
            $table->uuid('enterprise_id');

            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contract_enterprise');
        Schema::dropIfExists('contract_user');

        Schema::table('contracts', function (Blueprint $table) {
            $table->uuid('user_id')->nullable();
            $table->uuid('enterprise_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('set null');
        });
    }
}
