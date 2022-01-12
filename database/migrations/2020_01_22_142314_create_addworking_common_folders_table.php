<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddworkingCommonFoldersTable extends Migration
{
    public function up()
    {
        Schema::create('addworking_common_folders', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('enterprise_id');
            $table->uuid('created_by')->nullable();
            $table->string('name');
            $table->string('display_name');
            $table->timestamps();

            $table->primary('id');

            $table->foreign('created_by')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('set null');

            $table->foreign('enterprise_id')
                ->references('id')
                ->on('addworking_enterprise_enterprises')
                ->onDelete('cascade');
        });

        Schema::create('addworking_common_folders_has_items', function (Blueprint $table) {
            $table->uuid('folder_id');
            $table->uuid('item_id');
            $table->string('item_type');
            $table->timestamps();

            $table->primary(['folder_id', 'item_id']);

            $table->foreign('folder_id')
                ->references('id')
                ->on('addworking_common_folders')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('addworking_common_folders_has_items');
        Schema::dropIfExists('addworking_common_folders');
    }
}
