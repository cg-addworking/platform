<?php

namespace Components\Contract\Contract\Domain\Interfaces\Entities;

interface SubcontractingDeclarationEntityInterface
{
    public function setContract($value);
    public function setFile($value);
    public function setValidationDate($value);
    public function setPercentOfAggregation($value);

    public function getId();
    public function getContract();
    public function getFile();
    public function getValidationDate();
    public function getPercentOfAggregation();
}
