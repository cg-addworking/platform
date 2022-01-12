<?php

namespace Components\Infrastructure\FileDataExtractor\Application\Extractors;

use Components\Infrastructure\FileDataExtractor\Application\Extractors\Data\PurchaseOrderSignatureSogetrelData;
use Components\Infrastructure\FileDataExtractor\Domain\Interfaces\DocumentDataInterface;

class PurchaseOrderSignatureSogetrelExtractor extends DocumentDataExtractor
{
    private $is_pdf_image = false;

    public function extract(\SplFileInfo $file): DocumentDataInterface
    {
        return new PurchaseOrderSignatureSogetrelData($this, []);
    }
}
