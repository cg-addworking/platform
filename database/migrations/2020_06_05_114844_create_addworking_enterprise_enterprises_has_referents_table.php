<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingEnterpriseEnterprisesHasReferentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_enterprises_has_referents', function (Blueprint $table) {
            $table->uuid('vendor_id');
            $table->uuid('customer_id');
            $table->uuid('user_id');
            $table->uuid('created_by');
            $table->timestamps();

            $table->foreign('vendor_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');

            $table->foreign('customer_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('addworking_user_users')
                ->onDelete('cascade');

            $table->foreign('created_by')
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
        Schema::dropIfExists('addworking_enterprise_enterprises_has_referents');
    }
}
