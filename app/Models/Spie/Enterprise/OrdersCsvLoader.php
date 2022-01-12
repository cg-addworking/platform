<?php

namespace App\Models\Spie\Enterprise;

use App\Models\Spie\Enterprise\CsvLoaderCasts;
use App\Models\Spie\Enterprise\Enterprise;
use App\Models\Spie\Enterprise\Order;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Support\Arr;
use RuntimeException;
use stdClass;

class OrdersCsvLoader extends CsvLoader
{
    use CsvLoaderCasts;

    protected $flags = CsvLoader::IGNORE_FIRST_LINE;

    public function headers(): array
    {
        return [
            'enterprise_code',
            'index',
            'short_label',
            'year',
            'subsidiary_company_label',
            'direction_label',
            'amount',
        ];
    }

    public function cleanup(stdClass $item): stdClass
    {
        $this->string($item->enterprise_code);
        $this->string($item->short_label);
        $this->integer($item->year);
        $this->string($item->subsidiary_company_label);
        $this->string($item->direction_label);
        $this->float($item->amount);

        if (empty($item->enterprise_code)) {
            throw new RuntimeException("enterprise code should not be empty");
        }

        if (empty($item->short_label)) {
            throw new RuntimeException("order short label should not be empty");
        }

        return $item;
    }

    public function import(stdClass $item): bool
    {
        $enterprise = Enterprise::fromCode($item->enterprise_code);
        $key = Arr::only((array) $item, ['short_label', 'year', 'subsidiary_company_label', 'direction_label']);

        $order = Order::firstOrNew($key);
        $order->fill(['amount' => $item->amount]);
        $order->enterprise()->associate($enterprise);

        return $order->save();
    }
}
