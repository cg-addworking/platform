<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\PostgresConnection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropChargeGuruTables extends Migration
{
    protected $tables = [
        'charge_guru_mission_detail_chargepoints',
        'charge_guru_mission_detail_companies',
        'charge_guru_mission_detail_contacts',
        'charge_guru_mission_detail_extra_informations',
        'charge_guru_mission_detail_installations',
        'charge_guru_mission_detail_parkings',
        'charge_guru_mission_detail_skills',
        'charge_guru_mission_detail_syndics',
        'charge_guru_mission_detail_users',
        'charge_guru_mission_detail_vehicles',
        'charge_guru_mission_details_has_extra_informations',
        'charge_guru_mission_details',
        'charge_guru_mission_offers',
        'charge_guru_mission_quotation_details',
        'charge_guru_mission_quotations',
        'charge_guru_user_passworks',
        'charge_guru_user_passworks_has_addworking_common_departments',
        'charge_guru_user_passworks_has_charge_guru_common_skills',
        'charge_guru_user_passworks_has_charge_guru_enterprise_brands',
        'customer_charge_guru_brands',
        'customer_charge_guru_skills',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::connection() instanceof PostgresConnection) {
            foreach ($this->tables as $table) {
                try {
                    DB::connection()->statement("DROP TABLE \"$table\" CASCADE");
                } catch (Exception $e) {
                    //
                }
            }

            return;
        }

        Schema::disableForeignKeyConstraints();
        foreach ($this->tables as $table) {
            Schema::dropIfExists($table);
        }
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('charge_guru_mission_detail_chargepoints', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_mission_detail_companies', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_mission_detail_contacts', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_mission_detail_extra_informations', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_mission_detail_installations', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_mission_detail_parkings', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_mission_detail_skills', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_mission_detail_syndics', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_mission_detail_users', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_mission_detail_vehicles', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_mission_details_has_extra_informations', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_mission_details', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('mission_detail_user_id')->nullable();
            $table->string('mission_detail_contact_id')->nullable();
            $table->string('mission_detail_company_id')->nullable();
            $table->string('mission_detail_syndic_id')->nullable();
            $table->string('mission_detail_chargepoint_id')->nullable();
            $table->string('mission_detail_parking_id')->nullable();
            $table->string('mission_detail_vehicle_id')->nullable();
            $table->string('mission_detail_installation_id')->nullable();
            $table->string('payload')->nullable();
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_mission_offers', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_mission_quotation_details', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('mission_quotation_detail_id')->nullable();
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_mission_quotations', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_user_passworks', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('irve')->nullable();
            $table->string('irve_file_id')->nullable();
            $table->string('ze_ready')->nullable();
            $table->string('ze_ready_file_id')->nullable();
            $table->string('ev_ready')->nullable();
            $table->string('ev_ready_file_id')->nullable();
            $table->string('rc_pro')->nullable();
            $table->string('rc_pro_file_id')->nullable();
            $table->string('rc_pro_expired_at')->nullable();
            $table->string('decennale')->nullable();
            $table->string('decennale_file_id')->nullable();
            $table->string('decennale_expired_at')->nullable();
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_user_passworks_has_addworking_common_departments', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_user_passworks_has_charge_guru_common_skills', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('charge_guru_user_passworks_has_charge_guru_enterprise_brands', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('customer_charge_guru_brands', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });

        Schema::create('customer_charge_guru_skills', function (Blueprint $table) {
            $table->uuid('id');
            $table->timestamps();
            $table->primary('id');
        });
    }
}
