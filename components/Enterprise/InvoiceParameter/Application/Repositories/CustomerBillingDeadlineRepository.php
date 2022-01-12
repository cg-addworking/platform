<?php

namespace Components\Enterprise\InvoiceParameter\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\InvoiceParameter\Application\Models\CustomerBillingDeadline;
use Components\Enterprise\InvoiceParameter\Domain\Classes\CustomerBillingDeadlineInterface;
use Components\Enterprise\InvoiceParameter\Domain\Exceptions\CustomerBillingDeadlineCreationFailedException;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\CustomerBillingDeadlineRepositoryInterface;

class CustomerBillingDeadlineRepository implements CustomerBillingDeadlineRepositoryInterface
{
    public function make($data = []): CustomerBillingDeadlineInterface
    {
        return new CustomerBillingDeadline;
    }

    public function save(CustomerBillingDeadline $deadline): CustomerBillingDeadlineInterface
    {
        try {
            $deadline->save();
        } catch (CustomerBillingDeadlineCreationFailedException $exception) {
            throw $exception;
        }

        $deadline->refresh();

        return $deadline;
    }

    /**
     * @param Enterprise $enterprise
     * @return array
     */
    public function getDefaultDeadLinesOf(Enterprise $enterprise)
    {
        $deadlines = [];

        $deadlines_by_default = CustomerBillingDeadline::whereHas('enterprise', function ($query) use ($enterprise) {
            return $query->where('id', $enterprise->id);
        })->get();

        foreach ($deadlines_by_default as $deadline) {
            $deadlines[] = $deadline->getDeadline()->id;
        }

        return $deadlines;
    }
}
