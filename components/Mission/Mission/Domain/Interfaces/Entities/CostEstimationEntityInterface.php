<?php

namespace Components\Mission\Mission\Domain\Interfaces\Entities;

interface CostEstimationEntityInterface
{
    public function setFile($file);
    public function setAmountBeforeTaxes($value): void;

    public function getFile();
    public function getAmountBeforeTaxes(): ?float;
}
