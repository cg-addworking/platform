<?php

namespace Components\Enterprise\AccountingExpense\Application\Providers;

use Components\Enterprise\AccountingExpense\Application\Models\AccountingExpense;
use Components\Enterprise\AccountingExpense\Application\Policies\AccountingExpensePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AccountingExpenseAuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        AccountingExpense::class => AccountingExpensePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
