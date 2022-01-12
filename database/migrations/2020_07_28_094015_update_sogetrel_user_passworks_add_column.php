<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSogetrelUserPassworksAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sogetrel_user_passworks', function (Blueprint $table) {
            $table->uuid('administrative_assistant')->nullable();

            $table
                ->foreign('administrative_assistant')
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
            $table->dropColumn('administrative_assistant');
        });
    }
}
