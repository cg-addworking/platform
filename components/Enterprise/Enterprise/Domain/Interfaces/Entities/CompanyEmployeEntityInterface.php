<?php

namespace Components\Enterprise\Enterprise\Domain\Interfaces\Entities;

interface CompanyEmployeEntityInterface
{
    public function getNumber(): ?int;
    public function getYear();
    public function getRange();
    public function getOriginData();
}
