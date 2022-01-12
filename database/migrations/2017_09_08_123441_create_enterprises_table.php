<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnterprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enterprises', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('number');
            $table->string('legal_form')->comment('SARL,EURL etc.');
            $table->string('name')->commnent('Raison Sociale')->unique();
            $table->string('identification_number')->unique()->comment('SIRET');
            $table->string('tax_identification_number')->nullable()->comment('TVA Intracommunautaire');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('enterprise_user', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->uuid('enterprise_id');
            $table->uuid('role_id')->nullable();
            $table->string('job_title')->nullable();
            $table->string('representative')->nullable();
            $table->timestamps();
            $table->primary(['user_id', 'enterprise_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('enterprise_id')->references('id')->on('enterprises')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enterprise_user');
        Schema::dropIfExists('enterprises');
    }
}
