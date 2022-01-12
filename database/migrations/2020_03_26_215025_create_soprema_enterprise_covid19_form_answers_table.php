<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSopremaEnterpriseCovid19FormAnswersTable extends Migration
{
    public function up()
    {
        Schema::create('soprema_enterprise_covid19_form_answers', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('customer_id')->nullable();
            $table->uuid('vendor_id')->nullable();
            $table->string('vendor_name');
            $table->string('vendor_siret');
            $table->boolean('pursuit');
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('soprema_enterprise_covid19_form_answers');
    }
}
