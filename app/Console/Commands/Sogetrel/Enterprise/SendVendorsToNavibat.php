<?php

namespace App\Console\Commands\Sogetrel\Enterprise;

use App\Domain\Sogetrel\Navibat\Client;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendVendorsToNavibat extends Command
{
    protected $signature = 'sogetrel:enterprise:send-vendors-to-navibat';

    protected $description = 'Sends vendors to Navibat';

    protected $client;

    public function __construct(Client $client)
    {
        parent::__construct();

        $this->client = $client;
    }

    public function handle()
    {
        $vendors = Enterprise::fromName('SOGETREL')->family()->vendors()->sortByDesc('created_at');
        foreach ($vendors as $vendor) {
            if ($vendor->sogetrelData()->exists() && ! is_null($vendor->sogetrelData->oracle_id)) {
                continue;
            }

            try {
                if (! $this->client->checkVendorExists($vendor)) {
                    $this->client->sendVendor($vendor);
                }
                sleep(5);
            } catch (\Exception $e) {
                Log::warning("Sogetrel Navibat webservice: unknown error {$vendor->name}: {$e->getMessage()}");
            }
        }
    }
}
