<?php
namespace Components\Enterprise\InvoiceParameter\Domain\Repositories;

interface IbanRepositoryInterface
{
    public function make($data = []);

    public function find(string $id);

    public function findByEnterprise($enterprise);

    public function getAllByEnterprise($enterprise);
}
