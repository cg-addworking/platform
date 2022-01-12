<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSogetrelUserPassworksTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sogetrel_user_passworks', function (Blueprint $table) {
            $table->uuid('operational_manager')->nullable();
            $table->uuid('contract_signatory')->nullable();
            $table->datetime('date_due_at')->nullable();

            $table
                ->foreign('operational_manager')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('set null');

            $table
                ->foreign('contract_signatory')
                ->references('id')
                ->on('addworking_user_users')
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
        Schema::table('sogetrel_user_passworks', function (Blueprint $table) {
            $table->dropColumn('date_due_at');
        });

        Schema::table('sogetrel_user_passworks', function (Blueprint $table) {
            $table->dropColumn('contract_signatory');
        });

        Schema::table('sogetrel_user_passworks', function (Blueprint $table) {
            $table->dropColumn('operational_manager');
        });
    }
}
