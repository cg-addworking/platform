<?php

namespace Components\Connector\Mindee\Domain\Interfaces;

use Components\Connector\Mindee\Application\Data\DocumentData;

interface DocumentExtractorInterface
{
    public function getData(string $file_content): DocumentData;
    public function extract($response): array;
}
