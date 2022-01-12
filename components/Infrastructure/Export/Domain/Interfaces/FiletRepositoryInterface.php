<?php

namespace Components\Infrastructure\Export\Domain\Interfaces;

use App\Models\Addworking\Common\File;

interface FiletRepositoryInterface
{
    public function createExportFile($file_path): File;

    public function save(File $file);
}
