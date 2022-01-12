<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEverialMissionOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('everial_mission_offers', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('customer_id');
            $table->uuid('referent_id')->nullable();
            $table->uuid('created_by');
            $table->uuid('destination_address')->nullable();
            $table->uuid('shipping_address')->nullable();

            $table->date('starts_at_desired');
            $table->date('ends_at')->nullable();

            $table->string('external_id')->nullable();
            $table->string('status')->default('draft');
            $table->string('label');
            $table->string('analytic_code')->nullable();
            $table->string('unit')->nullable();
            
            $table->integer('number')->nullable();
            $table->integer('quantity')->nullable();

            $table->text('description');
            $table->text('objectives')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table
                ->foreign('created_by')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('set null');

            $table->foreign('customer_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');

            $table
                ->foreign('referent_id')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('set null');

            $table
                ->foreign('destination_address')
                ->references('id')
                ->on('addworking_common_addresses')
                ->onDelete('set null');

            $table
                ->foreign('shipping_address')
                ->references('id')
                ->on('addworking_common_addresses')
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
        Schema::dropIfExists('everial_mission_offers');
    }
}
