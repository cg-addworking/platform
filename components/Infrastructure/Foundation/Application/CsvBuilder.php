<?php

namespace Components\Infrastructure\Foundation\Application;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use SplFileObject;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CsvBuilder extends SplFileObject
{
    /**
     * CSV file headers
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Constructor
     *
     * @param string|null $path
     * @param string      $separator
     * @param string      $enclosure
     * @param string      $escape
     */
    public function __construct(
        string $path = null,
        string $separator = ";",
        string $enclosure = "\"",
        string $escape = "\\"
    ) {
        parent::__construct($path ?? storage_path(sprintf("/temp/%s.csv", uniqid())), 'w+');
        parent::setCsvControl($separator, $enclosure, $escape);
    }

    /**
     * Append a model to the CSV
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return int
     */
    public function append(Model $model): int
    {
        return parent::fputcsv($this->normalize($model));
    }

    /**
     * Appends all models to the CSV
     *
     * @param traversable $models
     * @param callable $callback
     * @return Foundation\CsvBuilder
     */
    public function addAll(iterable $models, callable $callback = null): self
    {
        if (!empty($this->headers)) {
            $this->fputcsv($this->headers);
        }

        foreach ($models as $model) {
            $this->append($model);

            if ($callback) {
                $callback($model);
            }
        }

        return $this;
    }

    /**
     * Get the array representation for the given model
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return array
     */
    protected function normalize(Model $model): array
    {
        return $model->toArray();
    }

    /**
     * Download the CSV
     *
     * @param  bool $delete_after_send
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(bool $delete_after_send = true): BinaryFileResponse
    {
        return response()
            ->download($this->getPathName())
            ->deleteFileAfterSend($delete_after_send);
    }
}
