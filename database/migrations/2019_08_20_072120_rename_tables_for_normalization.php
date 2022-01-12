<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTablesForNormalization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename(
            'addworking_user_customer_created_user',
            'addworking_user_customer_created_users'
        );

        Schema::rename(
            'contract_enterprise',
            'addworking_enterprise_has_contracts'
        );

        Schema::rename(
            'contract_logs',
            'addworking_contract_contract_logs'
        );

        Schema::rename(
            'contract_user',
            'addworking_contract_has_users'
        );

        Schema::rename(
            'contracts',
            'addworking_contract_contracts'
        );

        Schema::rename(
            'customer_tse_express_medical_mission_details',
            'tse_express_medical_mission_mission_details'
        );

        Schema::rename(
            'enterprise_invoice',
            'addworking_enterprise_has_invoices'
        );

        Schema::rename(
            'inbound_invoice_items',
            'addworking_billing_inbound_invoice_items'
        );

        Schema::rename(
            'inbound_invoices',
            'addworking_billing_inbound_invoices'
        );

        Schema::rename(
            'invoice_items_old',
            'addworking_billing_old_invoice_items'
        );

        Schema::rename(
            'invoice_user',
            'addworking_billing_invoice_has_users'
        );

        Schema::rename(
            'invoices_old',
            'addworking_billing_old_invoices'
        );

        Schema::rename(
            'missions_old',
            'addworking_mission_old_missions'
        );

        Schema::rename(
            'outbound_invoice_comments',
            'addworking_billing_outbound_invoice_comments'
        );

        Schema::rename(
            'outbound_invoice_items',
            'addworking_billing_outbound_invoice_items'
        );

        Schema::rename(
            'outbound_invoice_numbers',
            'addworking_billing_outbound_invoice_numbers'
        );

        Schema::rename(
            'outbound_invoice_parameters',
            'addworking_billing_outbound_invoice_parameters'
        );

        Schema::rename(
            'outbound_invoice_payment_orders',
            'addworking_billing_outbound_invoice_payment_orders'
        );

        Schema::rename(
            'outbound_invoices',
            'addworking_billing_outbound_invoices'
        );

        Schema::rename(
            'read_messages',
            'addworking_user_has_read_messages'
        );

        Schema::rename(
            'sogetrel_user_passwork_has_addworking_enterprise_enterprise',
            'sogetrel_user_passwork_has_enterprises'
        );

        Schema::rename(
            'sogetrel_user_passwork_saved_searches_scheduled',
            'sogetrel_user_passwork_saved_scheduled_searches'
        );

        Schema::rename(
            'vendors_available_billing_deadlines',
            'addworking_billing_vendors_available_billing_deadlines'
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
            'addworking_user_customer_created_users',
            'addworking_user_customer_created_user'
        );

        Schema::rename(
            'addworking_enterprise_has_contracts',
            'contract_enterprise'
        );

        Schema::rename(
            'addworking_contract_contract_logs',
            'contract_logs'
        );

        Schema::rename(
            'addworking_contract_has_users',
            'contract_user'
        );

        Schema::rename(
            'addworking_contract_contracts',
            'contracts'
        );

        Schema::rename(
            'tse_express_medical_mission_mission_details',
            'customer_tse_express_medical_mission_details'
        );

        Schema::rename(
            'addworking_enterprise_has_invoices',
            'enterprise_invoice'
        );

        Schema::rename(
            'addworking_billing_inbound_invoice_items',
            'inbound_invoice_items'
        );

        Schema::rename(
            'addworking_billing_inbound_invoices',
            'inbound_invoices'
        );

        Schema::rename(
            'addworking_billing_old_invoice_items',
            'invoice_items_old'
        );

        Schema::rename(
            'addworking_billing_invoice_has_users',
            'invoice_user'
        );

        Schema::rename(
            'addworking_billing_old_invoices',
            'invoices_old'
        );

        Schema::rename(
            'addworking_mission_old_missions',
            'missions_old'
        );

        Schema::rename(
            'addworking_billing_outbound_invoice_comments',
            'outbound_invoice_comments'
        );

        Schema::rename(
            'addworking_billing_outbound_invoice_items',
            'outbound_invoice_items'
        );

        Schema::rename(
            'addworking_billing_outbound_invoice_numbers',
            'outbound_invoice_numbers'
        );

        Schema::rename(
            'addworking_billing_outbound_invoice_parameters',
            'outbound_invoice_parameters'
        );

        Schema::rename(
            'addworking_billing_outbound_invoice_payment_orders',
            'outbound_invoice_payment_orders'
        );

        Schema::rename(
            'addworking_billing_outbound_invoices',
            'outbound_invoices'
        );

        Schema::rename(
            'addworking_user_has_read_messages',
            'read_messages'
        );

        Schema::rename(
            'sogetrel_user_passwork_has_enterprises',
            'sogetrel_user_passwork_has_addworking_enterprise_enterprise'
        );

        Schema::rename(
            'sogetrel_user_passwork_saved_scheduled_searches',
            'sogetrel_user_passwork_saved_searches_scheduled'
        );

        Schema::rename(
            'addworking_billing_vendors_available_billing_deadlines',
            'vendors_available_billing_deadlines'
        );
    }
}
