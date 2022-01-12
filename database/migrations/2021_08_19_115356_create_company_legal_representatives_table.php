<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyLegalRepresentativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_legal_representatives', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('short_id');
            $table->uuid('company_id');
            $table->string('quality');
            $table->date('starts_at');
            $table->date('ends_at')->nullable();
            $table->string('denomination')->nullable();
            $table->string('identification_number')->nullable();
            $table->uuid('legal_form_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('date_birth')->nullable();
            $table->uuid('city_birth_id')->nullable();
            $table->uuid('country_birth_id')->nullable();
            $table->uuid('country_nationality_id')->nullable();
            $table->string('address');
            $table->string('additional_address')->nullable();
            $table->uuid('city_id');
            $table->uuid('country_id');
            $table->uuid('user_id')->nullable();
            $table->uuid('company_holding_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('company_id')
                ->references('id')->on('companies')
                ->onDelete('CASCADE');
            
            $table->foreign('legal_form_id')
                ->references('id')->on('addworking_enterprise_legal_forms')
                ->onDelete('SET NULL');

            $table->foreign('city_birth_id')
                ->references('id')->on('cities')
                ->onDelete('SET NULL');

            $table->foreign('country_birth_id')
                ->references('id')->on('countries')
                ->onDelete('SET NULL');
            
            $table->foreign('country_nationality_id')
                ->references('id')->on('countries')
                ->onDelete('SET NULL');
        
            $table->foreign('city_id')
                ->references('id')->on('cities')
                ->onDelete('SET NULL');
            
            $table->foreign('country_id')
                ->references('id')->on('countries')
                ->onDelete('SET NULL');
                
            $table->foreign('user_id')
                ->references('id')->on('addworking_user_users')
                ->onDelete('SET NULL');
            
            $table->foreign('company_holding_id')
                ->references('id')->on('companies')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_legal_representatives');
    }
}
