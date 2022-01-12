<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingMissionQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mission_quotations', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('mission_id');
            $table->uuid('vendor_id');
            $table->string('number');
            $table->date('issued_at');
            $table->date('expires_at');
            $table->uuid('customer_address_id')->nullable();
            $table->uuid('delivery_address_id')->nullable();
            $table->string('delivery_address_floor')->nullable();
            $table->string('customer_name')->nullable();
            $table->text('description')->nullable();
            $table->text('payment_instructions')->nullable();
            $table->text('transport_instructions')->nullable();
            $table->timestamps();
            $table->primary('id');

            $table
                ->foreign('mission_id')
                ->references('id')->on('missions')
                ->onDelete('cascade');

            $table
                ->foreign('vendor_id')
                ->references('id')->on('enterprises')
                ->onDelete('cascade');

            $table
                ->foreign('customer_address_id')
                ->references('id')->on('addresses')
                ->onDelete('set null');

            $table
                ->foreign('delivery_address_id')
                ->references('id')->on('addresses')
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
        Schema::dropIfExists('mission_quotations');
    }
}
