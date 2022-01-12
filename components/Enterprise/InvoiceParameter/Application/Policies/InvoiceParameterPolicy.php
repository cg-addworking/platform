<?php

namespace Components\Enterprise\InvoiceParameter\Application\Policies;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class InvoiceParameterPolicy
{
    use HandlesAuthorization;

    protected $userRepository;
    protected $enterpriseRepository;

    public function __construct(
        UserRepository $userRepository,
        EnterpriseRepository $enterpriseRepository
    ) {
        $this->userRepository = $userRepository;
        $this->enterpriseRepository = $enterpriseRepository;
    }

    public function index(User $user)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        return Response::allow();
    }

    public function show(User $user, InvoiceParameter $invoiceParameter)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if (! $this->enterpriseRepository->isCustomer($invoiceParameter->getEnterprise())) {
            return Response::deny("Enterprise type is not customer");
        }

        return Response::allow();
    }

    public function create(User $user, Enterprise $enterprise)
    {
        if (! $this->userRepository->isSupport($user)) {
            return Response::deny("User is not support");
        }

        if (! $this->enterpriseRepository->isCustomer($enterprise)) {
            return Response::deny("Enterprise type is not customer");
        }

        return Response::allow();
    }

    public function store(User $user, Enterprise $enterprise)
    {
        return $this->create($user, $enterprise);
    }

    /**
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        return Response::deny("User is not support");
    }
}
