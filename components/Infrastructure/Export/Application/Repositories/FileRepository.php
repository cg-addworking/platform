<?php

namespace Components\Infrastructure\Export\Application\Repositories;

use App\Models\Addworking\Common\File;
use Components\Common\Common\Domain\Exceptions\UnableToSaveException;
use Components\Infrastructure\Export\Domain\Interfaces\FiletRepositoryInterface;

class FileRepository implements FiletRepositoryInterface
{
    public function createExportFile($file_path): File
    {
        return new File([
            'path'      => $file_path,
            'mime_type' => 'text/csv',
            'content'   => file_get_contents($file_path),
        ]);
    }

    public function save(File $file)
    {
        try {
            $file->save();
        } catch (UnableToSaveException $exception) {
            throw $exception;
        }

        $file->refresh();

        return $file;
    }
}
