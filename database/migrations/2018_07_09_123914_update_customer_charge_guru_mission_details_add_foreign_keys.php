<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCustomerChargeGuruMissionDetailsAddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_charge_guru_mission_details', function (Blueprint $table) {
            $table->uuid('mission_detail_user_id')->nullable();
            $table->uuid('mission_detail_contact_id')->nullable();
            $table->uuid('mission_detail_company_id')->nullable();
            $table->uuid('mission_detail_syndic_id')->nullable();
            $table->uuid('mission_detail_chargepoint_id')->nullable();
            $table->uuid('mission_detail_parking_id')->nullable();
            $table->uuid('mission_detail_vehicle_id')->nullable();
            $table->uuid('mission_detail_installation_id')->nullable();

            $table
                ->foreign('mission_detail_user_id')
                ->references('id')
                ->on('customer_charge_guru_mission_details_users')
                ->onDelete('set null');

            $table
                ->foreign('mission_detail_contact_id')
                ->references('id')
                ->on('customer_charge_guru_mission_details_contacts')
                ->onDelete('set null');

            $table
                ->foreign('mission_detail_company_id')
                ->references('id')
                ->on('customer_charge_guru_mission_details_companies')
                ->onDelete('set null');

            $table
                ->foreign('mission_detail_syndic_id')
                ->references('id')
                ->on('customer_charge_guru_mission_details_syndics')
                ->onDelete('set null');

            $table
                ->foreign('mission_detail_chargepoint_id')
                ->references('id')
                ->on('customer_charge_guru_mission_details_chargepoints')
                ->onDelete('set null');

            $table
                ->foreign('mission_detail_parking_id')
                ->references('id')
                ->on('customer_charge_guru_mission_details_parkings')
                ->onDelete('set null');

            $table
                ->foreign('mission_detail_vehicle_id')
                ->references('id')
                ->on('customer_charge_guru_mission_details_vehicles')
                ->onDelete('set null');

            $table
                ->foreign('mission_detail_installation_id')
                ->references('id')
                ->on('customer_charge_guru_mission_details_installations')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_charge_guru_mission_details', function (Blueprint $table) {
            $table->dropColumn('mission_detail_user_id');
        });

        Schema::table('customer_charge_guru_mission_details', function (Blueprint $table) {
            $table->dropColumn('mission_detail_contact_id');
        });

        Schema::table('customer_charge_guru_mission_details', function (Blueprint $table) {
            $table->dropColumn('mission_detail_company_id');
        });

        Schema::table('customer_charge_guru_mission_details', function (Blueprint $table) {
            $table->dropColumn('mission_detail_syndic_id');
        });

        Schema::table('customer_charge_guru_mission_details', function (Blueprint $table) {
            $table->dropColumn('mission_detail_chargepoint_id');
        });

        Schema::table('customer_charge_guru_mission_details', function (Blueprint $table) {
            $table->dropColumn('mission_detail_parking_id');
        });

        Schema::table('customer_charge_guru_mission_details', function (Blueprint $table) {
            $table->dropColumn('mission_detail_vehicle_id');
        });

        Schema::table('customer_charge_guru_mission_details', function (Blueprint $table) {
            $table->dropColumn('mission_detail_installation_id');
        });
    }
}
