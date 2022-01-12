<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpieEnterpriseEnterprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spie_enterprise_enterprises', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id')->unique();
            $table->string('code')->unique();
            $table->string('index')->nullable();
            $table->boolean('active')->nullable();
            $table->string('email')->nullable();
            $table->integer('rank')->nullable();
            $table->integer('year')->nullable();
            $table->float('gross_income')->nullable();
            $table->string('topology')->nullable();
            $table->boolean('al')->nullable();
            $table->date('last_coface_enquiry')->nullable();
            $table->float('last_coface_grade')->nullable();
            $table->date('previous_coface_enquiry')->nullable();
            $table->float('previous_coface_grade')->nullable();
            $table->boolean('nuclear_qualification')->nullable();
            $table->boolean('addressable_volume_large_order')->nullable();
            $table->boolean('addressable_volume_average_order')->nullable();
            $table->boolean('adressable_volume_small_order')->nullable();
            $table->timestamps();
            $table->primary('id');

            $table->foreign('enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
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
        Schema::dropIfExists('spie_enterprise_enterprises');
    }
}
