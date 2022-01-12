<?php

namespace Components\Billing\Outbound\Application\Policies;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Application\Models\Fee;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Outbound\Application\Repositories\FeeRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\App;

class FeePolicy
{
    use HandlesAuthorization;

    protected $enterpriseRepository;
    protected $userRepository;
    protected $feeRepository;

    public function __construct(
        EnterpriseRepository $enterpriseRepository,
        UserRepository $userRepository,
        FeeRepository $feeRepository
    ) {
        $this->enterpriseRepository = $enterpriseRepository;
        $this->userRepository       = $userRepository;
        $this->feeRepository        = $feeRepository;
    }

    public function index(User $user, Enterprise $enterprise, OutboundInvoice $outboundInvoice)
    {
        if (! $this->enterpriseRepository->isCustomer($enterprise)) {
            return Response::deny("Enterprise type is not customer");
        }

        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("Connected user is not support");
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
            return Response::deny("Connected user is not support");
        }

        return Response::allow();
    }

    public function delete(User $user, Fee $fee)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if (! $this->feeRepository->hasParent($fee)) {
            return Response::deny("Outbound invoice item can't be deleted");
        }

        return Response::allow();
    }

    public function export(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }
}
