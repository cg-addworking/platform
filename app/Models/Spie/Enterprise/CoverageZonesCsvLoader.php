<?php

namespace App\Models\Spie\Enterprise;

use App\Models\Addworking\Common\Department;
use App\Models\Spie\Enterprise\CsvLoaderCasts;
use App\Models\Spie\Enterprise\Enterprise;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Support\Arr;
use RuntimeException;
use stdClass;

class CoverageZonesCsvLoader extends CsvLoader
{
    use CsvLoaderCasts;

    protected $flags = CsvLoader::IGNORE_FIRST_LINE;

    public function headers(): array
    {
        return [
            'enterprise_code',
            'index',
            'code',
            'label',
            'active',
        ];
    }

    public function cleanup(stdClass $item): stdClass
    {
        $this->string($item->enterprise_code);
        $this->string($item->code);
        $this->string($item->label);
        $this->boolean($item->active);

        $item->code = ltrim($item->code, '0');

        if ($item->code == '20') {
            $item->code = '2A'; // corse-du-sud
        }

        if (empty($item->enterprise_code)) {
            throw new RuntimeException("enterprise code should not be empty");
        }

        if (empty($item->code)) {
            throw new RuntimeException("code should not be empty");
        }

        return $item;
    }

    public function import(stdClass $item): bool
    {
        $enterprise    = Enterprise::fromCode($item->enterprise_code);
        $coverage_zone = CoverageZone::firstOrNew(['code' => $item->code], ['label' => $item->label]);

        if (! $coverage_zone->exists) {
            $department = Department::fromInseeCode($item->code);
            $coverage_zone->department()->associate($department);
            $coverage_zone->save();
        }

        $coverage_zone->enterprises()->attach($enterprise, ['active' => $item->active]);

        return true;
    }
}
