<?php

namespace Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface;

interface EnterpriseRepositoryInterface
{
    public function make();
    public function findBySiret(string $siret);
}
