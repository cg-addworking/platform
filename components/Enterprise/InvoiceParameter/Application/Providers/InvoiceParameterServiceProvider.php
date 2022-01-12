<?php

namespace Components\Enterprise\InvoiceParameter\Application\Providers;

use Components\Enterprise\InvoiceParameter\Application\Models\CustomerBillingDeadline;
use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Components\Enterprise\InvoiceParameter\Application\Repositories\CustomerBillingDeadlineRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\IbanRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\InvoiceParameterRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\UserRepository;
use Components\Enterprise\InvoiceParameter\Domain\Classes\InvoiceParameterInterface;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\CustomerBillingDeadlineRepositoryInterface;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\IbanRepositoryInterface;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\InvoiceParameterRepositoryInterface;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\UserRepositoryInterface;
use Components\Enterprise\InvoiceParameter\Domain\UseCases\CreateInvoiceParameter;
use Components\Enterprise\InvoiceParameter\Domain\UseCases\EditInvoiceParameter;
use Components\Enterprise\InvoiceParameter\Domain\UseCases\ListInvoiceParameter;
use Illuminate\Support\ServiceProvider;

class InvoiceParameterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'invoice_parameter');

        $this->loadFactoriesFrom(__DIR__.'/../Factories');
            
        $this->bootDirectives();
    }

    public function register()
    {
        $this->bindModelInterfaces();

        $this->bindRepositoryInterfaces();

        $this->bindUseCases();
    }

    public function provides()
    {
        //
    }

    protected function bootDirectives()
    {
        //
    }

    protected function bootForConsole()
    {
        //
    }

    private function bindModelInterfaces()
    {
        $this->app->bind(
            InvoiceParameterInterface::class,
            InvoiceParameter::class
        );
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            EnterpriseRepositoryInterface::class,
            EnterpriseRepository::class
        );

        $this->app->bind(
            InvoiceParameterRepositoryInterface::class,
            InvoiceParameterRepository::class
        );

        $this->app->bind(
            CustomerBillingDeadlineRepositoryInterface::class,
            CustomerBillingDeadlineRepository::class
        );

        $this->app->bind(
            IbanRepositoryInterface::class,
            IbanRepository::class
        );
    }

    private function bindUseCases()
    {
        $this->bindListInvoiceParameterUseCase();
        $this->bindCreateInvoiceParameterUseCase();
        $this->bindEditInvoiceParameterUseCase();
    }

    private function bindListInvoiceParameterUseCase()
    {
        $this->app->bind(
            ListInvoiceParameter::class,
            function ($app) {
                return new ListInvoiceParameter(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(InvoiceParameterRepositoryInterface::class)
                );
            }
        );
    }

    private function bindCreateInvoiceParameterUseCase()
    {
        $this->app->bind(
            CreateInvoiceParameter::class,
            function ($app) {
                return new CreateInvoiceParameter(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(CustomerBillingDeadlineRepositoryInterface::class),
                    $app->make(IbanRepositoryInterface::class),
                    $app->make(InvoiceParameterRepositoryInterface::class)
                );
            }
        );
    }

    private function bindEditInvoiceParameterUseCase()
    {
        $this->app->bind(
            EditInvoiceParameter::class,
            function ($app) {
                return new EditInvoiceParameter(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(CustomerBillingDeadlineRepositoryInterface::class),
                    $app->make(IbanRepositoryInterface::class),
                    $app->make(InvoiceParameterRepositoryInterface::class),
                );
            }
        );
    }
}
