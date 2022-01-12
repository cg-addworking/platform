<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerChargeGuruPassworkAddNewColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
            $table
                ->string('irve')
                ->nullable()
                ->after('brands');

            $table
                ->uuid('irve_file_id')
                ->nullable()
                ->after('irve');

            $table
                ->string('ze_ready')
                ->nullable()
                ->after('irve_file_id');

            $table
                ->uuid('ze_ready_file_id')
                ->nullable()
                ->after('ze_ready');

            $table
                ->string('ev_ready')
                ->nullable()
                ->after('ze_ready_file_id');

            $table
                ->uuid('ev_ready_file_id')
                ->nullable()
                ->after('ev_ready');

            $table
                ->string('rc_pro')
                ->nullable()
                ->after('ev_ready_file_id');

            $table
                ->uuid('rc_pro_file_id')
                ->nullable()
                ->after('rc_pro');

            $table
                ->timestamp('rc_pro_expired_at')
                ->nullable()
                ->after('rc_pro_file_id');

            $table
                ->string('decennale')
                ->nullable()
                ->after('rc_pro_expired_at');

            $table
                ->uuid('decennale_file_id')
                ->nullable()
                ->after('decennale');

            $table
                ->timestamp('decennale_expired_at')
                ->nullable()
                ->after('decennale_file_id');

            $table
                ->foreign('irve_file_id')
                ->references('id')
                ->on('files')
                ->onDelete('set null');

            $table
                ->foreign('ze_ready_file_id')
                ->references('id')
                ->on('files')
                ->onDelete('set null');

            $table
                ->foreign('ev_ready_file_id')
                ->references('id')
                ->on('files')
                ->onDelete('set null');

            $table
                ->foreign('rc_pro_file_id')
                ->references('id')
                ->on('files')
                ->onDelete('set null');

            $table
                ->foreign('decennale_file_id')
                ->references('id')
                ->on('files')
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
        if (Schema::hasColumn('customer_charge_guru_passwork', 'irve')) {
            Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
                $table->dropColumn('irve');
            });
        }

        if (Schema::hasColumn('customer_charge_guru_passwork', 'irve_file_id')) {
            Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
                $table->dropColumn('irve_file_id');
            });
        }

        if (Schema::hasColumn('customer_charge_guru_passwork', 'ze_ready')) {
            Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
                $table->dropColumn('ze_ready');
            });
        }

        if (Schema::hasColumn('customer_charge_guru_passwork', 'ze_ready_file_id')) {
            Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
                $table->dropColumn('ze_ready_file_id');
            });
        }

        if (Schema::hasColumn('customer_charge_guru_passwork', 'ev_ready')) {
            Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
                $table->dropColumn('ev_ready');
            });
        }

        if (Schema::hasColumn('customer_charge_guru_passwork', 'ev_ready_file_id')) {
            Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
                $table->dropColumn('ev_ready_file_id');
            });
        }

        if (Schema::hasColumn('customer_charge_guru_passwork', 'rc_pro')) {
            Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
                $table->dropColumn('rc_pro');
            });
        }

        if (Schema::hasColumn('customer_charge_guru_passwork', 'rc_pro_file_id')) {
            Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
                $table->dropColumn('rc_pro_file_id');
            });
        }

        if (Schema::hasColumn('customer_charge_guru_passwork', 'rc_pro_expired_at')) {
            Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
                $table->dropColumn('rc_pro_expired_at');
            });
        }

        if (Schema::hasColumn('customer_charge_guru_passwork', 'decennale')) {
            Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
                $table->dropColumn('decennale');
            });
        }

        if (Schema::hasColumn('customer_charge_guru_passwork', 'decennale_file_id')) {
            Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
                $table->dropColumn('decennale_file_id');
            });
        }

        if (Schema::hasColumn('customer_charge_guru_passwork', 'decennale_expired_at')) {
            Schema::table('customer_charge_guru_passwork', function (Blueprint $table) {
                $table->dropColumn('decennale_expired_at');
            });
        }
    }
}
