<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTablesForUserTheme extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename(
            'customer_created_user',
            'addworking_user_customer_created_user'
        );

        Schema::rename(
            'chat_messages',
            'addworking_user_chat_messages'
        );

        Schema::rename(
            'chat_room_user',
            'addworking_user_chat_rooms_has_addworking_user_users'
        );

        Schema::rename(
            'chat_rooms',
            'addworking_user_chat_rooms'
        );

        Schema::rename(
            'customer_charge_guru_passwork',
            'charge_guru_user_passworks'
        );

        Schema::rename(
            'customer_charge_guru_passworks_brands',
            'charge_guru_user_passworks_has_charge_guru_enterprise_brands'
        );

        Schema::rename(
            'customer_charge_guru_passworks_departments',
            'charge_guru_user_passworks_has_addworking_common_departments'
        );

        Schema::rename(
            'customer_charge_guru_passworks_skills',
            'charge_guru_user_passworks_has_charge_guru_common_skills'
        );

        Schema::rename(
            'customer_sogetrel_passwork',
            'sogetrel_user_passworks'
        );

        Schema::rename(
            'customer_sogetrel_passwork_department',
            'sogetrel_user_passworks_has_addworking_common_departments'
        );

        Schema::rename(
            'user_logs',
            'addworking_user_logs'
        );

        Schema::rename(
            'users',
            'addworking_user_users'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename(
            'addworking_user_customer_created_user',
            'customer_created_user'
        );

        Schema::rename(
            'addworking_user_chat_messages',
            'chat_messages'
        );

        Schema::rename(
            'addworking_user_chat_rooms_has_addworking_user_users',
            'chat_room_user'
        );

        Schema::rename(
            'addworking_user_chat_rooms',
            'chat_rooms'
        );

        Schema::rename(
            'charge_guru_user_passworks',
            'customer_charge_guru_passwork'
        );

        Schema::rename(
            'charge_guru_user_passworks_has_charge_guru_enterprise_brands',
            'customer_charge_guru_passworks_brands'
        );

        Schema::rename(
            'charge_guru_user_passworks_has_addworking_common_departments',
            'customer_charge_guru_passworks_departments'
        );

        Schema::rename(
            'charge_guru_user_passworks_has_charge_guru_common_skills',
            'customer_charge_guru_passworks_skills'
        );

        Schema::rename(
            'sogetrel_user_passworks',
            'customer_sogetrel_passwork'
        );

        Schema::rename(
            'sogetrel_user_passworks_has_addworking_common_departments',
            'customer_sogetrel_passwork_department'
        );

        Schema::rename(
            'addworking_user_logs',
            'user_logs'
        );

        Schema::rename(
            'addworking_user_users',
            'users'
        );
    }
}
