<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTablesForMissionTheme extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename(
            'customer_charge_guru_mission_detail_customer_charge_guru_mission_details_extra_information',
            'charge_guru_mission_details_has_extra_informations'
        );

        Schema::rename(
            'customer_charge_guru_mission_details',
            'charge_guru_mission_details'
        );

        Schema::rename(
            'customer_charge_guru_mission_details_chargepoints',
            'charge_guru_mission_detail_chargepoints'
        );

        Schema::rename(
            'customer_charge_guru_mission_details_companies',
            'charge_guru_mission_detail_companies'
        );

        Schema::rename(
            'customer_charge_guru_mission_details_contacts',
            'charge_guru_mission_detail_contacts'
        );

        Schema::rename(
            'customer_charge_guru_mission_details_extra_informations',
            'charge_guru_mission_detail_extra_informations'
        );

        Schema::rename(
            'customer_charge_guru_mission_details_installations',
            'charge_guru_mission_detail_installations'
        );

        Schema::rename(
            'customer_charge_guru_mission_details_parkings',
            'charge_guru_mission_detail_parkings'
        );

        Schema::rename(
            'customer_charge_guru_mission_details_skills',
            'charge_guru_mission_detail_skills'
        );

        Schema::rename(
            'customer_charge_guru_mission_details_syndics',
            'charge_guru_mission_detail_syndics'
        );

        Schema::rename(
            'customer_charge_guru_mission_details_users',
            'charge_guru_mission_detail_users'
        );

        Schema::rename(
            'customer_charge_guru_mission_details_vehicles',
            'charge_guru_mission_detail_vehicles'
        );

        Schema::rename(
            'customer_charge_guru_mission_offers',
            'charge_guru_mission_offers'
        );

        Schema::rename(
            'customer_charge_guru_mission_quotations',
            'charge_guru_mission_quotations'
        );

        Schema::rename(
            'customer_charge_guru_mission_quotations_details',
            'charge_guru_mission_quotation_details'
        );

        Schema::rename(
            'mission_profiles',
            'addworking_mission_profiles'
        );

        Schema::rename(
            'mission_quotation_lines',
            'addworking_mission_quotation_lines'
        );

        Schema::rename(
            'mission_quotations',
            'addworking_mission_quotations'
        );

        Schema::rename(
            'missions',
            'addworking_mission_missions'
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
            'charge_guru_mission_details_has_extra_informations',
            'customer_charge_guru_mission_detail_customer_charge_guru_mission_details_extra_information'
        );

        Schema::rename(
            'charge_guru_mission_details',
            'customer_charge_guru_mission_details'
        );

        Schema::rename(
            'charge_guru_mission_detail_chargepoints',
            'customer_charge_guru_mission_details_chargepoints'
        );

        Schema::rename(
            'charge_guru_mission_detail_companies',
            'customer_charge_guru_mission_details_companies'
        );

        Schema::rename(
            'charge_guru_mission_detail_contacts',
            'customer_charge_guru_mission_details_contacts'
        );

        Schema::rename(
            'charge_guru_mission_detail_extra_informations',
            'customer_charge_guru_mission_details_extra_informations'
        );

        Schema::rename(
            'charge_guru_mission_detail_installations',
            'customer_charge_guru_mission_details_installations'
        );

        Schema::rename(
            'charge_guru_mission_detail_parkings',
            'customer_charge_guru_mission_details_parkings'
        );

        Schema::rename(
            'charge_guru_mission_detail_skills',
            'customer_charge_guru_mission_details_skills'
        );

        Schema::rename(
            'charge_guru_mission_detail_syndics',
            'customer_charge_guru_mission_details_syndics'
        );

        Schema::rename(
            'charge_guru_mission_detail_users',
            'customer_charge_guru_mission_details_users'
        );

        Schema::rename(
            'charge_guru_mission_detail_vehicles',
            'customer_charge_guru_mission_details_vehicles'
        );

        Schema::rename(
            'charge_guru_mission_offers',
            'customer_charge_guru_mission_offers'
        );

        Schema::rename(
            'charge_guru_mission_quotations',
            'customer_charge_guru_mission_quotations'
        );

        Schema::rename(
            'charge_guru_mission_quotation_details',
            'customer_charge_guru_mission_quotations_details'
        );

        Schema::rename(
            'addworking_mission_profiles',
            'mission_profiles'
        );

        Schema::rename(
            'addworking_mission_quotation_lines',
            'mission_quotation_lines'
        );

        Schema::rename(
            'addworking_mission_quotations',
            'mission_quotations'
        );

        Schema::rename(
            'addworking_mission_missions',
            'missions'
        );
    }
}
