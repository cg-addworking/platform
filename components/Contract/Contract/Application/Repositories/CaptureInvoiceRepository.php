<?php

namespace Components\Contract\Contract\Application\Repositories;

use Components\Contract\Contract\Application\Models\CaptureInvoice;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Domain\Exceptions\CaptureInvoiceCreationFailedException;
use Components\Contract\Contract\Domain\Interfaces\Repositories\CaptureInvoiceRepositoryInterface;

class CaptureInvoiceRepository implements CaptureInvoiceRepositoryInterface
{
    public function make()
    {
        return new CaptureInvoice;
    }

    public function save($captureInvoice)
    {
        try {
            $captureInvoice->save();
        } catch (CaptureInvoiceCreationFailedException $exception) {
            throw $exception;
        }

        $captureInvoice->refresh();

        return $captureInvoice;
    }

    public function list(Contract $contract)
    {
        return CaptureInvoice::query()
            ->whereHas('contract', function ($query) use ($contract) {
                return $query->where('id', $contract->getId());
            })->latest()->paginate($page ?? 25);
    }

    public function getCaptureInvoices(string $contract_id)
    {
        return CaptureInvoice::query()
            ->whereHas('contract', function ($query) use ($contract_id) {
                return $query->where('id', $contract_id);
            })->get();
    }

    public function delete(CaptureInvoice $capture_invoice)
    {
        return $capture_invoice->delete();
    }

    public function find($id)
    {
        return CaptureInvoice::where('id', $id)->first();
    }
}
