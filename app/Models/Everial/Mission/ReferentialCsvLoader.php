<?php

namespace App\Models\Everial\Mission;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use stdClass;
use RuntimeException;

class ReferentialCsvLoader extends CsvLoader
{
    protected $flags = CsvLoader::IGNORE_FIRST_LINE | CsvLoader::VERBOSE;

    public function headers(): array
    {
        return [
            'shipping_site',
            'shipping_address',
            'destination_site',
            'destination_address',
            'distance',
            'pallet_type',
            'pallet_number',
            'analytic_code',
            'best_bidder_vendor',
            'SODATRANS',
            'AEM',
            'ZIEGLER',
            'BENITO',
            'SODEL',
            'TRANS SUD EST',
            '3D TRANSEUROP',
            'ABSOLUTFRET',
        ];
    }

    public function import(stdClass $item): bool
    {
        $everial_referential = Referential::firstOrNew([
            'shipping_site'       => $item->shipping_site,
            'shipping_address'    => strtoupper(remove_accents($item->shipping_address)),
            'destination_site'    => $item->destination_site,
            'destination_address' => strtoupper(remove_accents($item->destination_address)),
            'distance'            => $item->distance,
            'pallet_type'         => $item->pallet_type,
            'pallet_number'       => $item->pallet_number,
            'analytic_code'       => $item->analytic_code,
        ]);

        if (!is_null($item->best_bidder_vendor) && Enterprise::where('name', $item->best_bidder_vendor)->exists()) {
            $everial_referential->bestBidder()->associate(Enterprise::fromName($item->best_bidder_vendor));
        }

        $everial_referential->save();

        foreach ($vendors = Enterprise::fromName('EVERIAL')->vendors()->pluck('name') as $vendor) {
            if (!is_null($item->{$vendor})) {
                $everial_price         = new Price;
                $everial_price->amount = $item->{$vendor};
                $everial_price->vendor()->associate(Enterprise::fromName($vendor));
                $everial_price->referential()->associate($everial_referential);
                $everial_price->save();
            }
        }

        return true;
    }

    public function cleanup(stdClass $item): stdClass
    {
        // trim all strings and casts empty strings as null
        foreach ($this->headers() as $key) {
            $item->$key = ($str = trim($item->$key)) ? $str : null;
        }

        return $item;
    }
}
