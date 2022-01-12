<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSogetrelUserPassworkHasAddworkingEnterpriseEnterpriseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sogetrel_user_passwork_has_addworking_enterprise_enterprise', function (Blueprint $table) {
            $table->uuid('passwork_id');
            $table->uuid('enterprise_id');
            $table->timestamps();

            $table
                ->foreign('passwork_id')
                ->references('id')->on('customer_sogetrel_passwork')
                ->onDelete('cascade');

            $table
                ->foreign('enterprise_id')
                ->references('id')->on('enterprises')
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
        Schema::dropIfExists('sogetrel_user_passwork_has_addworking_enterprise_enterprise');
    }
}
