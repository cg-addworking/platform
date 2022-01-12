<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSogetrelUserPassworkAcceptationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sogetrel_user_passwork_acceptations', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('number');
            $table->uuid('passwork_id');
            $table->uuid('enterprise_id');

            $table->dateTime('contract_starting_at')->nullable();
            $table->dateTime('contract_ending_at')->nullable();

            $table->uuid('accepted_by')->nullable();
            $table->string('accepted_by_name');

            $table->uuid('operational_manager')->nullable();
            $table->string('operational_manager_name');

            $table->uuid('administrative_assistant')->nullable();
            $table->string('administrative_assistant_name');

            $table->uuid('administrative_manager')->nullable();
            $table->string('administrative_manager_name');

            $table->uuid('contract_signatory')->nullable();
            $table->string('contract_signatory_name');

            $table->uuid('acceptation_comment')->nullable();
            $table->uuid('operational_monitoring_data_comment')->nullable();
            $table->boolean('needs_decennial_insurance')->default(false);
            $table->string('applicable_price_slip');
            $table->float('bank_guarantee_amount')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->primary('id');

            $table->foreign('passwork_id')
                ->references('id')->on('sogetrel_user_passworks')
                ->onDelete('CASCADE');

            $table->foreign('enterprise_id')
                ->references('id')->on('addworking_enterprise_enterprises')
                ->onDelete('CASCADE');

            $table->foreign('accepted_by')
                ->references('id')->on('addworking_user_users')
                ->onDelete('SET NULL');

            $table->foreign('operational_manager')
                ->references('id')->on('addworking_user_users')
                ->onDelete('SET NULL');

            $table->foreign('administrative_assistant')
                ->references('id')->on('addworking_user_users')
                ->onDelete('SET NULL');

            $table->foreign('administrative_manager')
                ->references('id')->on('addworking_user_users')
                ->onDelete('SET NULL');

            $table->foreign('contract_signatory')
                ->references('id')->on('addworking_user_users')
                ->onDelete('SET NULL');

            $table->foreign('acceptation_comment')
                ->references('id')->on('addworking_common_comments')
                ->onDelete('SET NULL');

            $table->foreign('operational_monitoring_data_comment')
                ->references('id')->on('addworking_common_comments')
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
        Schema::dropIfExists('sogetrel_user_passwork_acceptations');
    }
}
