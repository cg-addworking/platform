<?php

namespace App\Models\Spie\Enterprise;

use App\Models\Spie\Enterprise\CsvLoaderCasts;
use App\Models\Spie\Enterprise\Enterprise;
use App\Models\Spie\Enterprise\Qualification;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Support\Arr;
use RuntimeException;
use stdClass;

class QualificationsCsvLoader extends CsvLoader
{
    use CsvLoaderCasts;

    protected $flags = CsvLoader::IGNORE_FIRST_LINE;

    public function headers(): array
    {
        return [
            'enterprise_code',
            'index',
            'code',
            'name',
            'display_name',
            'follow_up',
            'active',
            'valid_until',
            'revived_at',
            'site',
        ];
    }

    public function cleanup(stdClass $item): stdClass
    {
        $this->string($item->enterprise_code);
        $this->string($item->code);
        $this->string($item->name);
        $this->string($item->display_name);
        $this->boolean($item->follow_up);
        $this->boolean($item->active);
        $this->date($item->valid_until);
        $this->date($item->revived_at);
        $this->string($item->site);

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
        $attributes = Arr::except(
            (array) $item,
            ['enterprise_code', 'index', 'code']
        );

        $enterprise = Enterprise::fromCode($item->enterprise_code);

        $qualification = Qualification::firstOrNew(['code' => $item->code]);
        $qualification->fill($attributes);
        $qualification->enterprise()->associate($enterprise);

        return $qualification->save();
    }
}
