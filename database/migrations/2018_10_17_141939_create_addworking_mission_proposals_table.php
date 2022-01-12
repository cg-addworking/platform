<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingMissionProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addworking_mission_proposals', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('mission_offer_id');
            $table->uuid('vendor_id');

            $table->string('label')->nullable();
            $table->text('details')->nullable();
            $table->string('external_id')->nullable();

            $table->string('status')->default('pending');
            $table->boolean('need_quotation')->default(false);
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_until')->nullable();

            $table->integer('quantity')->nullable();
            $table->float('unit_price')->nullable();
            $table->string('unit')->nullable();

            $table->uuid('created_by');

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->uuid('accepted_by')->nullable();
            $table->dateTime('accepted_at')->nullable();

            $table->uuid('refused_by')->nullable();
            $table->dateTime('refused_at')->nullable();

            $table
                ->foreign('mission_offer_id')
                ->references('id')
                ->on('addworking_mission_offers')
                ->onDelete('cascade');

            $table
                ->foreign('vendor_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');

            $table
                ->foreign('created_by')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('SET NULL');

            $table
                ->foreign('accepted_by')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('SET NULL');

            $table
                ->foreign('refused_by')
                ->references('id')
                ->on('addworking_user_users')
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
        Schema::dropIfExists('addworking_mission_proposals');
    }
}
