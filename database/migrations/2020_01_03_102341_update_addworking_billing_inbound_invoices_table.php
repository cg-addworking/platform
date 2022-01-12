<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAddworkingBillingInboundInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_billing_inbound_invoices', function (Blueprint $table) {
            $table->uuid('deadline_id')->nullable();
            $table->date('invoiced_at')->nullable();
            $table->date('due_at')->nullable();
            $table->float('amount_before_taxes')->default(0);
            $table->float('amount_of_taxes')->default(0);
            $table->float('amount_all_taxes_included')->default(0);
            $table->text('note')->nullable();

            $table->softDeletes();
            $table->uuid('deleted_by')->nullable();

            $table
                ->foreign('deadline_id')
                ->references('id')
                ->on('addworking_billing_deadline_types')
                ->onDelete('set null');

            $table
                ->foreign('deleted_by')
                ->references('id')
                ->on('addworking_user_users')
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
        Schema::table('addworking_billing_inbound_invoices', function (Blueprint $table) {
            $table->dropColumn('deadline_id');
        });

        Schema::table('addworking_billing_inbound_invoices', function (Blueprint $table) {
            $table->dropColumn('invoiced_at');
        });

        Schema::table('addworking_billing_inbound_invoices', function (Blueprint $table) {
            $table->dropColumn('due_at');
        });

        Schema::table('addworking_billing_inbound_invoices', function (Blueprint $table) {
            $table->dropColumn('amount_before_taxes');
        });

        Schema::table('addworking_billing_inbound_invoices', function (Blueprint $table) {
            $table->dropColumn('amount_of_taxes');
        });

        Schema::table('addworking_billing_inbound_invoices', function (Blueprint $table) {
            $table->dropColumn('amount_all_taxes_included');
        });

        Schema::table('addworking_billing_inbound_invoices', function (Blueprint $table) {
            $table->dropColumn('note');
        });

        Schema::table('addworking_billing_inbound_invoices', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });

        Schema::table('addworking_billing_inbound_invoices', function (Blueprint $table) {
            $table->dropColumn('deleted_by');
        });
    }
}
