<?php
namespace Components\Enterprise\InvoiceParameter\Application\Repositories;

use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\InvoiceParameter\Application\Models\CustomerBillingDeadline;
use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Components\Enterprise\InvoiceParameter\Domain\Classes\InvoiceParameterInterface;
use Components\Enterprise\InvoiceParameter\Domain\Exceptions\InvoiceParameterCreationFailedException;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\InvoiceParameterRepositoryInterface;

class InvoiceParameterRepository implements InvoiceParameterRepositoryInterface
{
    public function list($enterprise, ?array $filter = null, ?string $search = null)
    {
        return InvoiceParameter::query()
            ->whereHas('enterprise', function ($query) use ($enterprise) {
                $query->where('identification_number', $enterprise->identification_number);
            })->latest()->withTrashed()->paginate(25);
    }

    public function make($data = []): InvoiceParameterInterface
    {
        $class = InvoiceParameter::class;

        return new $class($data);
    }

    public function save(InvoiceParameterInterface $invoiceParameter): InvoiceParameterInterface
    {
        try {
            $invoiceParameter->save();
        } catch (InvoiceParameterCreationFailedException $exception) {
            throw $exception;
        }

        $invoiceParameter->refresh();

        return $invoiceParameter;
    }

    /**
     * @param int $number
     * @return InvoiceParameter|null
     */
    public function findByNumber(int $number): ?InvoiceParameter
    {
        return InvoiceParameter::where('number', $number)->first();
    }

    /**
     * @param Enterprise $enterprise
     * @return mixed
     */
    public function getDeadlinesOf(Enterprise $enterprise)
    {
        return CustomerBillingDeadline::whereHas('enterprise', function ($query) use ($enterprise) {
            return $query->where('id', $enterprise->id);
        })->get();
    }
}
