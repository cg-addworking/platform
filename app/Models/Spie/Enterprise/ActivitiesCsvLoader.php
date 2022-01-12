<?php

namespace App\Models\Spie\Enterprise;

use App\Models\Addworking\Enterprise\EnterpriseActivity;
use App\Models\Spie\Enterprise\Enterprise;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Illuminate\Support\Arr;
use RuntimeException;
use stdClass;

class ActivitiesCsvLoader extends CsvLoader
{
    use CsvLoaderCasts;

    protected $flags = CsvLoader::IGNORE_FIRST_LINE;

    public function headers(): array
    {
        return [
            'enterprise_code',
            'index',
            'label',
            'active',
        ];
    }

    public function cleanup(stdClass $item): stdClass
    {
        $this->string($item->enterprise_code);
        $this->string($item->index);
        $this->string($item->label);
        $this->boolean($item->active);

        if (empty($item->label)) {
            throw new RuntimeException("label should not be empty");
        }

        if (empty($item->enterprise_code)) {
            throw new RuntimeException("enterprise code should not be empty");
        }

        return $item;
    }

    public function import(stdClass $item): bool
    {
        $enterprise = Enterprise::fromCode($item->enterprise_code);
        $key = ['enterprise_id' => $enterprise->enterprise->id, 'field' => $item->label];

        $activity = EnterpriseActivity::firstOrNew($key);
        $activity->fill(['activity' => $item->label]);
        $activity->enterprise()->associate($enterprise->enterprise);

        return $item->active ? $activity->save() : $activity->delete();
    }
}
