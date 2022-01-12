<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddworkingCommonFilesTableAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_common_files', function (Blueprint $table) {
            $table->uuid('attachable_id')->nullable();
            $table->string('attachable_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_common_files', function (Blueprint $table) {
            $table->dropColumn('attachable_id');
        });

        Schema::table('addworking_common_files', function (Blueprint $table) {
            $table->dropColumn('attachable_type');
        });
    }
}
