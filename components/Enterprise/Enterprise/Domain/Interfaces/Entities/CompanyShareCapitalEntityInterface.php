<?php

namespace Components\Enterprise\Enterprise\Domain\Interfaces\Entities;

interface CompanyShareCapitalEntityInterface
{
    public function getCurency();
    public function getAmount(): ?float;
}
