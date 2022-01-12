<?php

namespace Components\Billing\Inbound\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Billing\Inbound\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\Inbound\Domain\Repositories\InboundInvoiceRepositoryInterface;

class ListInboundInvoicesAsCustomer
{
    private $inboundInvoiceRepository;

    public function __construct(InboundInvoiceRepositoryInterface $inboundInvoiceRepository)
    {
        $this->inboundInvoiceRepository = $inboundInvoiceRepository;
    }

    public function handle(User $auth_user, ?array $filter, ?string $search, $page = null)
    {
        $this->checkUser($auth_user);

        return $this->inboundInvoiceRepository->listVendorInvoices($auth_user, $filter, $search, $page);
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserNotAuthentificatedException();
        }
    }
}
