<?php

namespace Components\Enterprise\AccountingExpense\Application\Policies;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\AccountingExpense\Application\Models\AccountingExpense;
use Components\Enterprise\AccountingExpense\Application\Repositories\MemberRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\UserRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AccountingExpensePolicy
{
    use HandlesAuthorization;

    protected $memberRepository;
    protected $userRepository;

    public function __construct(
        MemberRepository $memberRepository,
        UserRepository $userRepository
    ) {
        $this->memberRepository = $memberRepository;
        $this->userRepository = $userRepository;
    }

    public function index(User $user, Enterprise $enterprise)
    {
        return $this->create($user, $enterprise);
    }

    public function create(User $user, Enterprise $enterprise)
    {
        if ($this->userRepository->isSupport($user)) {
            return Response::allow();
        }

        if (! $this->memberRepository->isMemberOf($user, $enterprise)) {
            return Response::deny("you are not a member of {$enterprise->name}");
        }

        if (! $user->hasRoleFor($enterprise, User::ROLE_FINANCIAL)) {
            return Response::deny("you don't have the financial role");
        }

        return Response::allow();
    }

    public function edit(User $user, AccountingExpense $accounting_expense, Enterprise $enterprise)
    {
        return $this->create($user, $enterprise);
    }

    public function delete(User $user, AccountingExpense $accounting_expense, Enterprise $enterprise)
    {
        return $this->create($user, $enterprise);
    }
}
