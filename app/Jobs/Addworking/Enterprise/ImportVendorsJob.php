<?php

namespace App\Jobs\Addworking\Enterprise;

use App\Models\Addworking\Common\CsvLoaderReport;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\VendorsCsvLoader;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportVendorsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $csv;
    protected $customer;

    public function __construct(File $csv, Enterprise $customer)
    {
        $this->csv = $csv;
        $this->customer = $customer;
    }

    public function handle()
    {
        $loader = new VendorsCsvLoader;
        $loader->setFile($this->csv->asSplFileObject());
        $loader->setCustomer($this->customer);
        $loader->run();

        CsvLoaderReport::create(
            ['label' => "Import de prestataires pour {$this->customer->name}"] + @compact('loader')
        );
    }
}
