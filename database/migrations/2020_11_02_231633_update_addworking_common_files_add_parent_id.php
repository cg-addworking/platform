<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingCommonFilesAddParentId extends Migration
{
    public function up()
    {
        Schema::table('addworking_common_files', function (Blueprint $table) {
            $table->uuid('parent_id')->nullable();

            $table->foreign('parent_id')
                ->references('id')->on('addworking_common_files')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('addworking_common_files', function (Blueprint $table) {
            $table->dropColumn('parent_id');
        });
    }
}
