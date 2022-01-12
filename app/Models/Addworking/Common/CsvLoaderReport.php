<?php

namespace App\Models\Addworking\Common;

use App\Helpers\HasUuid;
use Components\Infrastructure\Foundation\Application\CsvLoader;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use SplFileObject;

class CsvLoaderReport extends Model implements Htmlable
{
    use HasUuid, Routable, Viewable;

    protected $table = "addworking_common_csv_loader_reports";

    protected $fillable = [
        'loader', /* virtual */
        'label',
        'data',
        'line_count',
        'error_count',
    ];

    protected $casts = [
        'line_count' => "integer",
        'error_count' => "integer",
    ];

    protected $routePrefix = "addworking.common.csv_loader_report";

    public function __toString()
    {
        return (string) $this->label;
    }

    public function getLoaderAttribute(): CsvLoader
    {
        return unserialize($this->attributes['data']);
    }

    public function setLoaderAttribute(CsvLoader $value)
    {
        $this->attributes['data'] = serialize($value);
        $this->attributes['line_count'] = count(iterator_to_array($value->cursor()));
        $this->attributes['error_count'] = count($value->getErrors());
    }

    public function getErrorRateAttribute()
    {
        if ($this->line_count == 0) {
            return null;
        }

        return $this->error_count / $this->line_count;
    }

    public function getErrorCsvAttribute(): string
    {
        $loader = $this->getLoaderAttribute();

        $path = storage_path(sprintf('temp/%s.csv', $this->id ?? uniqid()));
        $file = new SplFileObject($path, 'w+');
        $file->setCsvControl(...$loader->getCsvControls());
        $file->fputcsv(array_merge($loader->headers(), ['error']));

        foreach ($loader->getErrors() as $item) {
            $row = (array) $item + ['error' => str_replace("\n", " - ", $loader->getError($item)->getMessage())];
            $file->fputcsv($row);
        }

        return $path;
    }
}
