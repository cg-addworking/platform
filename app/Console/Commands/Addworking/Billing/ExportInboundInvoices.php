<?php

namespace App\Console\Commands\Addworking\Billing;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Billing\InboundInvoiceCsvBuilder;
use Illuminate\Console\Command;

class ExportInboundInvoices extends Command
{
    protected $signature = 'addworking:billing:export-inbound-invoices';

    protected $description = 'Outputs the inbound invoices as CSV';

    public function handle()
    {
        $csv = (new InboundInvoiceCsvBuilder)->addAll(InboundInvoice::latest()->get());

        foreach ($csv as $line) {
            $this->output->write($line);
        }
    }
}
