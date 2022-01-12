<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingEnterpriseEnterprisesHasPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_enterprises_has_partners', function (Blueprint $table) {
            $table->uuid('customer_id');
            $table->uuid('vendor_id');

            $table->timestamps();
            $table->softDeletes();

            $table->primary(['customer_id', 'vendor_id']);

            $table
                ->foreign('customer_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');

            $table
                ->foreign('vendor_id')
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
        Schema::dropIfExists('addworking_enterprise_enterprises_has_partners');
    }
}
