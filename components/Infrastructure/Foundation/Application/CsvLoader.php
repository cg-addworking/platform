<?php

namespace Components\Infrastructure\Foundation\Application;

use Exception;
use Generator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use IteratorIterator;
use LimitIterator;
use RuntimeException;
use Serializable;
use SplFileObject;
use SplObjectStorage;
use SplTempFileObject;
use UnderflowException;
use stdClass;

abstract class CsvLoader implements Serializable
{
    const IGNORE_FIRST_LINE  = 0b0001;
    const RETHROW_EXCEPTIONS = 0b0010;
    const USE_TRANSACTION    = 0b0100;
    const VERBOSE            = 0b1000;

    protected $csv;
    protected $csvControls;
    protected $flags = 0;
    protected $errors;

    abstract public function headers(): array;

    abstract public function cleanup(stdClass $item): stdClass;

    abstract public function import(stdClass $item): bool;

    public static function load($file, int $flags = 0): self
    {
        return App::make(static::class)
            ->setFlags($flags)
            ->setFile(new SplFileObject($file));
    }

    public function getFile(): SplFileObject
    {
        return $this->csv;
    }

    public function setFile(
        SplFileObject $csv,
        string $delimiter = ";",
        string $enclosure = "\"",
        string $escape = "\\"
    ): self {
        $this->csv = $csv;

        $this->csv->setFlags(SplFileObject::READ_CSV
            | SplFileObject::READ_AHEAD
            | SplFileObject::SKIP_EMPTY
            | SplFileObject::DROP_NEW_LINE);

        $this->csvControls = [$delimiter, $enclosure, $escape];
        $this->csv->setCsvControl(...$this->csvControls);

        return $this;
    }

    public function getCsvControls(): array
    {
        return $this->csvControls;
    }

    public function getFlags(): int
    {
        return $this->flags;
    }

    public function setFlags(int $flags): self
    {
        $this->flags = $flags;

        return $this;
    }

    public function cursor(): Generator
    {
        if (is_null($this->csv)) {
            throw new RuntimeException("no csv file set !");
        }

        $it = $this->csv;
        $padding = array_fill(0, count($this->headers()), null);

        if ($this->flags & self::IGNORE_FIRST_LINE) {
            $it = new LimitIterator($it, 1);
        }

        foreach ($it as $row) {
            $item = (object) array_combine(
                $this->headers(),
                array_slice($row + $padding, 0, count($this->headers()))
            );

            yield $item;
        }

        return $this;
    }

    public function run(): self
    {
        if ($this->verbose()) {
            Log::debug("CsvLoader::run started");
        }

        $this->errors = new SplObjectStorage;

        try {
            if ($this->flags & self::USE_TRANSACTION) {
                DB::beginTransaction();
            }

            foreach ($this->cursor() as $item) {
                if ($this->verbose()) {
                    Log::debug("new item", (array) $item);
                }

                try {
                    if ($this->import($this->cleanup($item)) !== true) {
                        throw new RuntimeException("error importing item");
                    }

                    if ($this->verbose()) {
                        Log::debug("item imported successfully");
                    }
                } catch (Exception $e) {
                    $this->errors[$item] = $e;

                    if ($this->verbose()) {
                        Log::debug($e);
                    }

                    if ($this->flags & self::RETHROW_EXCEPTIONS) {
                        throw $e;
                    }
                }
            }

            if ($this->flags & self::USE_TRANSACTION) {
                $this->hasErrors() ? DB::rollback() : DB::commit();
            }
        } catch (Exception $e) {
            if ($this->flags & self::USE_TRANSACTION) {
                DB::rollback();
            }

            if ($this->flags & self::RETHROW_EXCEPTIONS) {
                throw $e;
            }
        }

        if ($this->verbose()) {
            Log::debug("CsvLoader::run finished");
        }

        return $this;
    }

    public function hasErrors(): bool
    {
        return count($this->getErrors() ?? []);
    }

    public function getErrors(): ?SplObjectStorage
    {
        return $this->errors;
    }

    public function getError(stdClass $item): Exception
    {
        if (! isset($this->errors[$item])) {
            throw new UnderflowException("this item doesn't have error");
        }

        return $this->errors[$item];
    }

    public function verbose(): bool
    {
        return $this->flags & self::VERBOSE;
    }

    public function serialize(): string
    {
        $errors = [];

        // workaround unserializable exception (both ValidationException and
        // QueryException contains nasty closures that prevent them to be
        // serialized.)
        foreach ($this->getErrors() as $item) {
            $exception = $this->getError($item);

            $message = $exception->getMessage();

            if ($exception instanceof ValidationException) {
                $message .= "\n" . implode("\n", Arr::flatten($exception->errors()));
            }

            $errors[] = [$item, [
                'message'    => $message,
                'code'       => $exception->getCode(),
                'file'       => $exception->getFile(),
                'line'       => $exception->getLine(),
            ]];
        }

        // rewind the CSV in order to serialize its content
        $this->csv->fseek(0);
        $contents = base64_encode($this->csv->fread($this->csv->getSize()));

        return serialize([
            'csv'         => $contents,
            'csvControls' => $this->csvControls,
            'flags'       => $this->flags,
            'errors'      => $errors,
        ]);
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        $csv = new SplTempFileObject;
        $csv->fwrite(base64_decode($data['csv']));
        $this->setFile($csv, ...$data['csvControls']);
        $this->setFlags($data['flags']);

        $errors = new SplObjectStorage;

        foreach ($data['errors'] as list($item, $exception)) {
            $errors[$item] = (new class extends Exception
            {
                public function restore(array $exception)
                {
                    foreach (['message', 'code', 'file', 'line'] as $key) {
                        $this->$key = $exception[$key] ?? null;
                    }

                    return $this;
                }
            })->restore($exception);
        }

        $this->errors = $errors;
    }
}
