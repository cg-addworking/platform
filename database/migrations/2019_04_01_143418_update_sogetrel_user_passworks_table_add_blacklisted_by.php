<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSogetrelUserPassworksTableAddBlacklistedBy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sogetrel_user_passworks', function (Blueprint $table) {
            $table->uuid('blacklisted_by')->nullable();
            $table->foreign('blacklisted_by')->references('id')->on('addworking_user_users')->onDelete('set null');
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
            $table->dropColumn('blacklisted_by');
        });
    }
}
