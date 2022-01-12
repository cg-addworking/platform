<?php
namespace Components\Enterprise\InvoiceParameter\Domain\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Components\Enterprise\InvoiceParameter\Domain\Classes\InvoiceParameterInterface;

interface InvoiceParameterRepositoryInterface
{
    public function list($enterprise, ?array $filter = null, ?string $search = null);
    public function make($data = []): InvoiceParameterInterface;
    public function save(InvoiceParameterInterface $invoiceParameter): InvoiceParameterInterface;
    public function findByNumber(int $number): ?InvoiceParameter;
    public function getDeadlinesOf(Enterprise $enterprise);
}
