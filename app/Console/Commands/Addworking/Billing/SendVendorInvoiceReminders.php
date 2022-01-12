<?php

namespace App\Console\Commands\Addworking\Billing;

use App\Mail\BillingReminder;
use App\Models\Addworking\User\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendVendorInvoiceReminders extends Command
{
    protected $signature = 'addworking:billing:send-vendor-invoice-reminders';

    protected $description = 'Send reminder email to vendors who must send their invoices';

    public function handle()
    {
        $month = date('m/Y', strtotime('previous month'));
        Log::debug("Checking invoices of {$month}");

        $users = User::whereHas('enterprises', function ($query) {
            return $query->whereIsCustomer();
        })->cursor();

        foreach ($users as $customerUser) {
            if (!($customerEnterprise = $customerUser->enterprise)->exists) {
                Log::debug("User {$customerUser->id} has no enterprise");
                continue;
            }

            Log::debug("Sending billing email reminders for vendors of {$customerEnterprise->id}");

            if (!($start = $customerEnterprise->billing_starts_at) || !($end = $customerEnterprise->billing_ends_at)) {
                Log::debug("Enterprise {$customerEnterprise->id} has no billing period defined");
                continue;
            }

            if (date('d') < $start || date('d') > $end) {
                Log::debug("Billing period of {$customerEnterprise->id} hasn't started yet");
                continue;
            }

            $vendorEnterprises = $customerEnterprise->vendors()
                ->whereDoesntHave('inboundInvoices', function ($query) use ($customerEnterprise, $month) {
                    return $query
                        ->where('month', $month)
                        ->where('customer_id', $customerEnterprise->id);
                })
                ->get();

            foreach ($vendorEnterprises as $vendorEnterprise) {
                Log::debug("Enterprise {$vendorEnterprise->id} didn't send its invoices yet");

                foreach ($vendorEnterprise->legalRepresentatives as $vendorUser) {
                    Log::debug("Sending billing notification to {$vendorUser->email}");

                    Mail::to($vendorUser->email)->bcc('compta@addworking.com')->send(
                        new BillingReminder($customerEnterprise, $vendorUser, $month)
                    );
                }
            }
        }
    }
}
