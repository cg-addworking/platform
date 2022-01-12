<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddworkingContractContractTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_contract_contract_templates', function (Blueprint $table) {
            $table->text('markdown')->nullable()->change();

            $table->uuid('duplicated_from_id')->nullable();
            $table->uuid('previous_id')->nullable();

            $table->uuid('published_by')->nullable();
            $table->uuid('archived_by')->nullable();

            $table->datetime('published_at')->nullable();
            $table->datetime('archived_at')->nullable();

            $table->foreign('duplicated_from_id')
                ->references('id')->on('addworking_contract_contract_templates')
                ->onDelete('set null');

            $table->foreign('previous_id')
                ->references('id')->on('addworking_contract_contract_templates')
                ->onDelete('set null');

            $table->foreign('published_by')
                ->references('id')->on('addworking_user_users')
                ->onDelete('set null');

            $table->foreign('archived_by')
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
        Schema::table('addworking_contract_contract_templates', function (Blueprint $table) {
            $table->dropColumn('duplicated_from_id');
        });
        Schema::table('addworking_contract_contract_templates', function (Blueprint $table) {
            $table->dropColumn('previous_id');
        });
        Schema::table('addworking_contract_contract_templates', function (Blueprint $table) {
            $table->dropColumn('published_by');
        });
        Schema::table('addworking_contract_contract_templates', function (Blueprint $table) {
            $table->dropColumn('archived_by');
        });
        Schema::table('addworking_contract_contract_templates', function (Blueprint $table) {
            $table->dropColumn('published_at');
        });
        Schema::table('addworking_contract_contract_templates', function (Blueprint $table) {
            $table->dropColumn('archived_at');
        });
    }
}
