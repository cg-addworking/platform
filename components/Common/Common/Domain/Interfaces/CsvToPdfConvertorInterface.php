<?php

namespace Components\Common\Common\Domain\Interfaces;

use App\Models\Addworking\Common\File;

interface CsvToPdfConvertorInterface
{
    /**
     * @param File $file
     * @return mixed
     */
    public function convert(File $file);
}
