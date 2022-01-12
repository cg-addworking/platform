<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTablesForCommonTheme extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename(
            'address_enterprise',
            'addworking_common_addresses_has_enterprises'
        );

        Schema::rename(
            'address_user',
            'addworking_common_addresses_has_users'
        );

        Schema::rename(
            'addresses',
            'addworking_common_addresses'
        );

        Schema::rename(
            'comments',
            'addworking_common_comments'
        );

        Schema::rename(
            'departments',
            'addworking_common_departments'
        );

        Schema::rename(
            'file_mission',
            'addworking_common_files_has_missions'
        );

        Schema::rename(
            'files',
            'addworking_common_files'
        );

        Schema::rename(
            'ibans',
            'addworking_enterprise_ibans'
        );

        Schema::rename(
            'phone_number_user',
            'addworking_common_phone_numbers_has_users'
        );

        Schema::rename(
            'phone_numbers',
            'addworking_common_phone_numbers'
        );

        Schema::rename(
            'regions',
            'addworking_common_regions'
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
            'addworking_common_addresses_has_enterprises',
            'address_enterprise'
        );

        Schema::rename(
            'addworking_common_addresses_has_users',
            'address_user'
        );

        Schema::rename(
            'addworking_common_addresses',
            'addresses'
        );

        Schema::rename(
            'addworking_common_comments',
            'comments'
        );

        Schema::rename(
            'addworking_common_departments',
            'departments'
        );

        Schema::rename(
            'addworking_common_files_has_missions',
            'file_mission'
        );

        Schema::rename(
            'addworking_common_files',
            'files'
        );

        Schema::rename(
            'addworking_enterprise_ibans',
            'ibans'
        );

        Schema::rename(
            'addworking_common_phone_numbers_has_users',
            'phone_number_user'
        );

        Schema::rename(
            'addworking_common_phone_numbers',
            'phone_numbers'
        );

        Schema::rename(
            'addworking_common_regions',
            'regions'
        );
    }
}
