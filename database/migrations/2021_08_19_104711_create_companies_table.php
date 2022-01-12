<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('short_id');
            $table->string('identification_number')->nullable();
            $table->uuid('legal_form_id');
            $table->uuid('country_id');
            $table->date('creation_date')->nullable();
            $table->date('cessation_date')->nullable();
            $table->uuid('parent_id');
            $table->dateTime('last_updated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('legal_form_id')
                ->references('id')->on('addworking_enterprise_legal_forms')
                ->onDelete('SET NULL');
            
            $table->foreign('country_id')
                ->references('id')->on('countries')
                ->onDelete('SET NULL');

            $table->foreign('parent_id')
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
        Schema::dropIfExists('companies');
    }
}

