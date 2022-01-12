<?php

namespace Components\Billing\Inbound\Application\Providers;

use Components\Billing\Inbound\Application\Repositories\DeadlineRepository;
use Components\Billing\Inbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Inbound\Application\Repositories\InboundInvoiceRepository;
use Components\Billing\Inbound\Application\Repositories\UserRepository;
use Components\Billing\Inbound\Domain\Repositories\DeadlineRepositoryInterface;
use Components\Billing\Inbound\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Billing\Inbound\Domain\Repositories\InboundInvoiceRepositoryInterface;
use Components\Billing\Inbound\Domain\Repositories\UserRepositoryInterface;
use Components\Billing\Inbound\Domain\UseCases\ListInboundInvoicesAsCustomer;
use Illuminate\Support\ServiceProvider;

class InboundInvoiceServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'inbound');
    }

    public function register()
    {
        $this->bindRepositoryInterfaces();
        $this->bindUseCases();
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            EnterpriseRepositoryInterface::class,
            EnterpriseRepository::class
        );

        $this->app->bind(
            InboundInvoiceRepositoryInterface::class,
            InboundInvoiceRepository::class
        );

        $this->app->bind(
            DeadlineRepositoryInterface::class,
            DeadlineRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }

    private function bindUseCases()
    {
        $this->bindListInboundInvoicesAsCustomerUseCase();
    }

    private function bindListInboundInvoicesAsCustomerUseCase()
    {
        $this->app->bind(
            ListInboundInvoicesAsCustomer::class,
            function ($app) {
                return new ListInboundInvoicesAsCustomer(
                    $app->make(InboundInvoiceRepositoryInterface::class),
                );
            }
        );
    }
}
