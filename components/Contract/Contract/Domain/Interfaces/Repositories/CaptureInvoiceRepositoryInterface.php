<?php

namespace Components\Contract\Contract\Domain\Interfaces\Repositories;

use Components\Contract\Contract\Application\Models\CaptureInvoice;
use Components\Contract\Contract\Application\Models\Contract;

interface CaptureInvoiceRepositoryInterface
{
    public function make();
    public function save($captureInvoice);
    public function list(Contract $contract);
    public function getCaptureInvoices(string $contract_id);
    public function delete(CaptureInvoice $capture_invoice);
    public function find($id);
}
