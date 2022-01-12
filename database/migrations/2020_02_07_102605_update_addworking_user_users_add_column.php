<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingUserUsersAddColumn extends Migration
{
    public function up()
    {
        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->uuid('deleted_by')->nullable();
            $table
                ->foreign('deleted_by')
                ->references('id')
                ->on('addworking_user_users')
                ->onDelete('set null');
        });

        if ($this->connection instanceof PostgresConnection) {
            Schema::table('addworking_mission_offers', function (Blueprint $table) {
                $table->dropForeign('addworking_mission_offers_created_by_foreign');
                $table
                    ->foreign('created_by')
                    ->references('id')
                    ->on('addworking_user_users')
                    ->onDelete('cascade');

                $table->dropForeign('addworking_mission_offers_referent_id_foreign');
                $table
                    ->foreign('referent_id')
                    ->references('id')
                    ->on('addworking_user_users')
                    ->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::table('addworking_user_users', function (Blueprint $table) {
            $table->dropColumn('deleted_by');
        });
        
        if ($this->connection instanceof PostgresConnection) {
            Schema::table('addworking_mission_offers', function (Blueprint $table) {
                $table->dropForeign('addworking_mission_offers_created_by_foreign');
                $table
                    ->foreign('created_by')
                    ->references('id')
                    ->on('addworking_user_users')
                    ->onDelete('set null');

                $table->dropForeign('addworking_mission_offers_referent_id_foreign');
                $table
                    ->foreign('referent_id')
                    ->references('id')
                    ->on('addworking_user_users')
                    ->onDelete('set null');
            });
        }
    }
}
