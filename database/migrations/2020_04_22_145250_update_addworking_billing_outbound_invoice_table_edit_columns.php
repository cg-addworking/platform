<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class UpdateAddworkingBillingOutboundInvoiceTableEditColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addworking_billing_outbound_invoices', function ($table) {
            $table->renameColumn('amount', 'amount_before_taxes')->default(0);
        });

        Schema::table('addworking_billing_outbound_invoices', function ($table) {
            $table->renameColumn('amount_vat', 'amount_of_taxes')->default(0);
        });

        Schema::table('addworking_billing_outbound_invoices', function ($table) {
            $table->renameColumn('issued_at', 'invoiced_at');
        });

        Schema::table('addworking_billing_outbound_invoices', function ($table) {
            $table->renameColumn('payable_at', 'due_at');
        });

        Schema::table('addworking_billing_outbound_invoices', function ($table) {
            $table->uuid('deadline_id')->nullable();
            $table->boolean('is_locked')->default(false);
            $table->uuid('locked_by')->nullable();
            $table->boolean('ready_for_validation')->default(false);
            $table->boolean('validated_by_addworking')->default(false);
            $table->uuid('validated_by_addworking_by')->nullable();
            $table->dateTime('validated_by_addworking_at')->nullable();
            $table->boolean('validated_by_customer')->default(false);
            $table->uuid('validated_by_customer_by')->nullable();
            $table->dateTime('validated_by_customer_at')->nullable();
            $table->softDeletes();
            $table->uuid('deleted_by')->nullable();

            $table->foreign('deadline_id')->references('id')->on('addworking_billing_deadline_types')
                ->onDelete('set null');
            $table->foreign('locked_by')->references('id')->on('addworking_user_users')
                ->onDelete('set null');
            $table->foreign('validated_by_addworking_by')->references('id')->on('addworking_user_users')
                ->onDelete('set null');
            $table->foreign('validated_by_customer_by')->references('id')->on('addworking_user_users')
                ->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('addworking_user_users')
                ->onDelete('set null');
        });

        $invoices = DB::table('addworking_billing_outbound_invoices')->get();

        if (empty($invoices)) {
            return;
        }

        foreach ($invoices as $invoice) {
            switch ($invoice->deadline) {
                case 'upon_receipt':
                    $deadline = DB::table('addworking_billing_deadline_types')->where('value', 0)->first();
                    break;
                case '30_days':
                    $deadline = DB::table('addworking_billing_deadline_types')->where('value', 30)->first();
                    break;
                case '40_days':
                    $deadline = DB::table('addworking_billing_deadline_types')->where('value', 40)->first();
                    break;
                case '45_days':
                    $deadline = DB::table('addworking_billing_deadline_types')->where('value', 45)->first();
                    break;
                default:
                    $deadline = DB::table('addworking_billing_deadline_types')->where('value', 30)->first();
            }

            DB::table('addworking_billing_outbound_invoices')->where('id', $invoice->id)->update([
                'deadline_id' => $deadline->id,
            ]);

            if (is_null($invoice->invoiced_at)) {
                DB::table('addworking_billing_outbound_invoices')->where('id', $invoice->id)->update([
                    'invoiced_at' => Carbon::parse($invoice->created_at)->startOfDay(),
                ]);
            }

            if (is_null($invoice->due_at)) {
                DB::table('addworking_billing_outbound_invoices')->where('id', $invoice->id)->update([
                    'due_at' => Carbon::parse($invoice->invoiced_at)->addDays($deadline->value)->endOfDay(),
                ]);
            }

            if (in_array($invoice->status, ['pending', 'validated', 'paid'])) {
                DB::table('addworking_billing_outbound_invoices')->where('id', $invoice->id)->update([
                    'ready_for_validation' => true,
                ]);
            }

            if (in_array($invoice->status, ['validated', 'paid'])) {
                DB::table('addworking_billing_outbound_invoices')->where('id', $invoice->id)->update([
                    'is_locked' => true,
                    'validated_by_addworking' => true,
                    'validated_by_addworking_at' => $invoice->updated_at,
                    'validated_by_customer' => true,
                    'validated_by_customer_at' => $invoice->updated_at,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('deadline_id');
        });
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('is_locked');
        });
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('locked_by');
        });
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('ready_for_validation');
        });
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('validated_by_addworking');
        });
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('validated_by_addworking_by');
        });
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('validated_by_addworking_at');
        });
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('validated_by_customer');
        });
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('validated_by_customer_by');
        });
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('validated_by_customer_at');
        });
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
        });
        Schema::table('addworking_billing_outbound_invoices', function (Blueprint $table) {
            $table->dropColumn('deleted_by');
        });
        Schema::table('addworking_billing_outbound_invoices', function ($table) {
            $table->renameColumn('amount_before_taxes', 'amount');
        });
        Schema::table('addworking_billing_outbound_invoices', function ($table) {
            $table->renameColumn('amount_of_taxes', 'amount_vat');
        });
        Schema::table('addworking_billing_outbound_invoices', function ($table) {
            $table->renameColumn('invoiced_at', 'issued_at');
        });
        Schema::table('addworking_billing_outbound_invoices', function ($table) {
            $table->renameColumn('due_at', 'payable_at');
        });
    }
}
