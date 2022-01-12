<?php

namespace Components\Contract\Model\Domain\Interfaces\Repositories;

interface EnterpriseRepositoryInterface
{
    public function findBySiret(string $siret);
    public function make();
    public function find(string $id);
}
