<?php

namespace Components\Enterprise\AccountingExpense\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\AccountingExpense\Domain\Exceptions\AccountingExpenseHasMissionTrackingLinesException;
use Components\Enterprise\AccountingExpense\Domain\Exceptions\AccountingExpenseIsNotFoundException;
use Components\Enterprise\AccountingExpense\Domain\Exceptions\EnterpriseIsNotFoundException;
use Components\Enterprise\AccountingExpense\Domain\Exceptions\UserIsMissingTheFinancialRoleException;
use Components\Enterprise\AccountingExpense\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\AccountingExpense\Domain\Exceptions\UserIsNotMemberOfThisEnterpriseException;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Entities\AccountingExpenseEntityInterface;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\AccountingExpenseRepositoryInterface;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\MemberRepositoryInterface;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\UserRepositoryInterface;

class DeleteAccountingExpense
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
        ?User $authenticated,
        ?Enterprise $enterprise,
        ?AccountingExpenseEntityInterface $accounting_expense
    ) {
        $this->check($authenticated, $enterprise, $accounting_expense);

        return $this->accountingExpenseRepository->delete($accounting_expense);
    }

    private function check(
        ?User $user,
        ?Enterprise $enterprise,
        ?AccountingExpenseEntityInterface $accounting_expense
    ) {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (is_null($enterprise)) {
            throw new EnterpriseIsNotFoundException;
        }

        if (is_null($accounting_expense)) {
            throw new AccountingExpenseIsNotFoundException;
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

        if (count($accounting_expense->getMissionTrackingLines())) {
            throw new AccountingExpenseHasMissionTrackingLinesException;
        }
    }
}
