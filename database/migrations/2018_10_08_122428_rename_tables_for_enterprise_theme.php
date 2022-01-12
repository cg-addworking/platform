<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTablesForEnterpriseTheme extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename(
            'enterprise_activities',
            'addworking_enterprise_activities'
        );

        Schema::rename(
            'enterprise_file',
            'addworking_enterprise_enterprises_has_files'
        );

        Schema::rename(
            'enterprise_member',
            'addworking_enterprise_members'
        );

        Schema::rename(
            'enterprise_membership_requests',
            'addworking_enterprise_membership_requests'
        );

        Schema::rename(
            'enterprise_outbound_invoice',
            'addworking_enterprise_enterprises_has_outbound_invoices'
        );

        Schema::rename(
            'enterprise_outbound_invoice_payment_order',
            'addworking_enterprise_enterprises_has_payment_orders'
        );

        Schema::rename(
            'enterprise_phone_number',
            'addworking_enterprise_enterprises_has_phone_numbers'
        );

        Schema::rename(
            'enterprise_role',
            'addworking_enterprise_enterprises_has_roles'
        );

        Schema::rename(
            'enterprise_user',
            'addworking_enterprise_enterprises_has_users'
        );

        Schema::rename(
            'enterprise_vendor_documents',
            'addworking_enterprise_vendor_documents'
        );

        Schema::rename(
            'enterprises',
            'addworking_enterprise_enterprises'
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
            'addworking_enterprise_activities',
            'enterprise_activities'
        );

        Schema::rename(
            'addworking_enterprise_enterprises_has_files',
            'enterprise_file'
        );

        Schema::rename(
            'addworking_enterprise_members',
            'enterprise_member'
        );

        Schema::rename(
            'addworking_enterprise_membership_requests',
            'enterprise_membership_requests'
        );

        Schema::rename(
            'addworking_enterprise_enterprises_has_outbound_invoices',
            'enterprise_outbound_invoice'
        );

        Schema::rename(
            'addworking_enterprise_enterprises_has_payment_orders',
            'enterprise_outbound_invoice_payment_order'
        );

        Schema::rename(
            'addworking_enterprise_enterprises_has_phone_numbers',
            'enterprise_phone_number'
        );

        Schema::rename(
            'addworking_enterprise_enterprises_has_roles',
            'enterprise_role'
        );

        Schema::rename(
            'addworking_enterprise_enterprises_has_users',
            'enterprise_user'
        );

        Schema::rename(
            'addworking_enterprise_vendor_documents',
            'enterprise_vendor_documents'
        );

        Schema::rename(
            'addworking_enterprise_enterprises',
            'enterprises'
        );
    }
}
