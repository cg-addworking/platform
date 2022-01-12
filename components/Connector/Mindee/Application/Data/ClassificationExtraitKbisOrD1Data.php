<?php

namespace Components\Connector\Mindee\Application\Data;

use Components\Connector\Mindee\Application\Extractors\ClassificationExtraitKbisOrD1Extractor;

class ClassificationExtraitKbisOrD1Data extends DocumentData
{
    const EXTRAIT_KBIS = 'ExtraitKbis';
    const EXTRAIT_D1 = 'ExtraitD1';

    public function getClassification()
    {
        return $this->getData(ClassificationExtraitKbisOrD1Extractor::FIELD_CLASSIFICATION);
    }

    public function isExtraitKbis(): bool
    {
        return !is_null($this->getClassification()) && $this->getClassification() === self::EXTRAIT_KBIS;
    }

    public function isExtraitD1(): bool
    {
        return !is_null($this->getClassification()) && $this->getClassification() === self::EXTRAIT_D1;
    }
}
