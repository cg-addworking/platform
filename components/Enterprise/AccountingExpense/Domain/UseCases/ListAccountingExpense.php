<?php

namespace Components\Enterprise\AccountingExpense\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\AccountingExpense\Domain\Exceptions\EnterpriseIsNotFoundException;
use Components\Enterprise\AccountingExpense\Domain\Exceptions\UserIsMissingTheFinancialRoleException;
use Components\Enterprise\AccountingExpense\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\AccountingExpense\Domain\Exceptions\UserIsNotMemberOfThisEnterpriseException;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Presenters\AccountingExpenseListPresenterInterface;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\AccountingExpenseRepositoryInterface;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\MemberRepositoryInterface;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\UserRepositoryInterface;

class ListAccountingExpense
{
    protected $accountingExpenseRepository;
    protected $memberRepository;
    protected $userRepository;

    public function __construct(
        AccountingExpenseRepositoryInterface $accountingExpenseRepository,
        MemberRepositoryInterface $memberRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->accountingExpenseRepository = $accountingExpenseRepository;
        $this->memberRepository = $memberRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(
        AccountingExpenseListPresenterInterface $presenter,
        ?User $authenticated,
        ?Enterprise $enterprise,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        $this->check($authenticated, $enterprise);

        return $presenter->present(
            $this->accountingExpenseRepository->list($enterprise, $filter, $search, $page, $operator, $field_name)
        );
    }

    private function check(
        ?User $user,
        ?Enterprise $enterprise
    ) {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (is_null($enterprise)) {
            throw new EnterpriseIsNotFoundException;
        }

        if (! $this->userRepository->isSupport($user) &&
            ! $this->memberRepository->isMemberOf($user, $enterprise)
        ) {
            throw new UserIsNotMemberOfThisEnterpriseException;
        }

        if (! $this->userRepository->isSupport($user)  &&
            ! $user->hasRoleFor($enterprise, User::ROLE_FINANCIAL)
        ) {
            throw new UserIsMissingTheFinancialRoleException;
        }
    }
}
