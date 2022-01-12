<?php

namespace Components\Billing\Inbound\Application\Repositories;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\User\User;
use Components\Billing\Inbound\Domain\Repositories\InboundInvoiceRepositoryInterface;

class InboundInvoiceRepository implements InboundInvoiceRepositoryInterface
{
    public function listVendorInvoices(
        User $user,
        ?array $filter,
        ?string $search,
        $page = null
    ) {
        $query = $this->filterAndSearch($user, $filter, $search);

        return $query->latest()->paginate($page ?? 25);
    }

    public function filterAndSearch(User $user, ?array $filter, ?string $search)
    {
        return InboundInvoice::with('enterprise', 'customer')
            ->whereHas('customer', function ($query) use ($user) {
                return $query->whereIn('id', $user->enterprises->pluck('id'));
            })
            ->when($filter['customers'] ?? null, function ($query, $customer) {
                return $query->customer($customer);
            })
            ->when($filter['months'] ?? null, function ($query, $month) {
                return $query->month($month);
            })
            ->when($filter['status'] ?? null, function ($query, $status) {
                return $query->statuses($status);
            })
            ->when($filter['vendors'] ?? null, function ($query, $vendor) {
                return $query->vendors($vendor);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }
}
