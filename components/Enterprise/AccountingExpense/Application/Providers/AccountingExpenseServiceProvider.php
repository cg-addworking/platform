<?php

namespace Components\Enterprise\AccountingExpense\Application\Providers;

use Components\Enterprise\AccountingExpense\Application\Models\AccountingExpense;
use Components\Enterprise\AccountingExpense\Application\Presenters\AccountingExpenseListPresenter;
use Components\Enterprise\AccountingExpense\Application\Repositories\AccountingExpenseRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\MemberRepository;
use Components\Enterprise\AccountingExpense\Application\Repositories\UserRepository;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Entities\AccountingExpenseEntityInterface;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Presenters\AccountingExpenseListPresenterInterface;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\AccountingExpenseRepositoryInterface;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\MemberRepositoryInterface;
use Components\Enterprise\AccountingExpense\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Enterprise\AccountingExpense\Domain\UseCases\CreateAccountingExpense;
use Components\Enterprise\AccountingExpense\Domain\UseCases\EditAccountingExpense;
use Components\Enterprise\AccountingExpense\Domain\UseCases\ListAccountingExpense;
use Illuminate\Support\ServiceProvider;

class AccountingExpenseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'accounting_expense');

        $this->loadTranslationsFrom(__DIR__.'/../Langs', 'accounting_expense');
    }

    public function register()
    {
        $this->bindEntityInterfaces();
        $this->bindPresenterInterfaces();
        $this->bindRepositoryInterfaces();
        $this->bindUseCases();
    }

    private function bindEntityInterfaces()
    {
        $this->app->bind(
            AccountingExpenseEntityInterface::class,
            AccountingExpense::class
        );
    }

    private function bindPresenterInterfaces()
    {
        $this->app->bind(
            AccountingExpenseListPresenterInterface::class,
            AccountingExpenseListPresenter::class
        );
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            AccountingExpenseRepositoryInterface::class,
            AccountingExpenseRepository::class
        );

        $this->app->bind(
            EnterpriseRepositoryInterface::class,
            EnterpriseRepository::class
        );

        $this->app->bind(
            MemberRepositoryInterface::class,
            MemberRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }

    private function bindUseCases()
    {
        $this->bindCreateAccountingExpenseUseCase();
        $this->bindEditAccountingExpenseUseCase();
    }

    private function bindCreateAccountingExpenseUseCase()
    {
        $this->app->bind(
            CreateAccountingExpense::class,
            function ($app) {
                return new CreateAccountingExpense(
                    $app->make(AccountingExpenseRepositoryInterface::class),
                    $app->make(MemberRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class)
                );
            }
        );
    }

    private function bindEditAccountingExpenseUseCase()
    {
        $this->app->bind(
            EditAccountingExpense::class,
            function ($app) {
                return new EditAccountingExpense(
                    $app->make(AccountingExpenseRepositoryInterface::class),
                    $app->make(MemberRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class)
                );
            }
        );
    }
}
