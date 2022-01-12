<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddworkingEnterpriseEnterprisesDeletedPartners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_enterprise_enterprises_deleted_partners', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('customer_id');
            $table->uuid('vendor_id');
            $table->dateTime('activity_starts_at')->nullable();
            $table->dateTime('activity_ends_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addworking_enterprise_enterprises_deleted_partners');
    }
}
