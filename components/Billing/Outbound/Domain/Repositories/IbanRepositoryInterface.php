<?php
namespace Components\Billing\Outbound\Domain\Repositories;

interface IbanRepositoryInterface
{
    public function find(string $id);
    public function findByEnterprise($enterprise);
    public function getAllIbansOf($enterprise);
}
