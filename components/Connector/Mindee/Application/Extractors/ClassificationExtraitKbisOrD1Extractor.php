<?php

namespace Components\Connector\Mindee\Application\Extractors;

use Components\Connector\Mindee\Application\Data\ClassificationExtraitKbisOrD1Data;
use Components\Connector\Mindee\Domain\Interfaces\DocumentExtractorInterface;

class ClassificationExtraitKbisOrD1Extractor extends DocumentExtractor implements DocumentExtractorInterface
{
    const FIELD_CLASSIFICATION = 'classification';

    public function getData(string $file_content): ClassificationExtraitKbisOrD1Data
    {
        return new ClassificationExtraitKbisOrD1Data(
            $this->extract($this->client->classificationExtraitKbisOrExtraitD1Scan($file_content))
        );
    }
}
