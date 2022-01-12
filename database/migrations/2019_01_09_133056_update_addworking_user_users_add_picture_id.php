<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingUserUsersAddPictureId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->uuid('picture_id')->nullable();

            $table
                ->foreign('picture_id')
                ->references('id')
                ->on('addworking_common_files')
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
         Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->dropColumn('picture_id');
         });
    }
}
