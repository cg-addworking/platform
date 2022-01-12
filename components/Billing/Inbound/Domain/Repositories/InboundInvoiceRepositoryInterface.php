<?php

namespace Components\Billing\Inbound\Domain\Repositories;

use App\Models\Addworking\User\User;

interface InboundInvoiceRepositoryInterface
{
    public function listVendorInvoices(
        User $user,
        ?array $filter,
        ?string $search,
        $page = null
    );
    public function filterAndSearch(User $user, ?array $filter, ?string $search);
}
