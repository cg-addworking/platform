<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingCommonFoldersAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_common_folders', function (Blueprint $table) {
            $table->boolean('shared_with_vendors')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_common_folders', function (Blueprint $table) {
            $table->dropColumn('shared_with_vendors');
        });
    }
}
