<?php

namespace Components\Billing\Outbound\Application\Policies;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceItemRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\App;

class OutboundInvoiceItemPolicy
{
    use HandlesAuthorization;

    protected $enterpriseRepository;
    protected $userRepository;
    protected $outboundInvoiceItemRepository;

    public function __construct(
        EnterpriseRepository $enterpriseRepository,
        UserRepository $userRepository,
        OutboundInvoiceItemRepository $outboundInvoiceItemRepository
    ) {
        $this->userRepository = $userRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->outboundInvoiceItemRepository = $outboundInvoiceItemRepository;
    }

    public function index(User $user, Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        if (! $this->enterpriseRepository->isCustomer($enterprise)) {
            return Response::deny("Enterprise type is not customer");
        }

        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if (is_null($outboundInvoice)) {
            return Response::deny("Outbound invoice doesn't exist");
        }

        return Response::allow();
    }

    public function create(User $user, Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        if (App::make(OutboundInvoiceRepository::class)->isValidated($outboundInvoice)) {
            return Response::deny("This outboundInvoice is validated");
        }

        if (! $this->enterpriseRepository->isCustomer($enterprise)) {
            return Response::deny("Enterprise type is not customer");
        }

        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if (is_null($outboundInvoice)) {
            return Response::deny("Outbound invoice doesn't exist");
        }

        return Response::allow();
    }

    public function delete(
        User $user,
        OutboundInvoiceItem $outboundInvoiceItem
    ) {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if (! $this->outboundInvoiceItemRepository->hasParent($outboundInvoiceItem->getId())
            && $this->outboundInvoiceItemRepository->hasInboundInvoiceItem($outboundInvoiceItem->getId())) {
            return Response::deny("Outbound invoice item can't be deleted");
        }

        return Response::allow();
    }
}
