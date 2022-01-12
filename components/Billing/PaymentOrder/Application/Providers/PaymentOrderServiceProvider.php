<?php

namespace Components\Billing\PaymentOrder\Application\Providers;

use Components\Billing\PaymentOrder\Application\Models\PaymentOrder;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrderItem;
use Components\Billing\PaymentOrder\Application\Models\ReceivedPayment;
use Components\Billing\PaymentOrder\Application\Repositories\DeadlineRepository;
use Components\Billing\PaymentOrder\Application\Repositories\EnterpriseRepository;
use Components\Billing\PaymentOrder\Application\Repositories\IbanRepository;
use Components\Billing\PaymentOrder\Application\Repositories\InboundInvoiceRepository;
use Components\Billing\PaymentOrder\Application\Repositories\InvoiceParameterRepository;
use Components\Billing\PaymentOrder\Application\Repositories\ModuleRepository;
use Components\Billing\PaymentOrder\Application\Repositories\OutboundInvoiceItemRepository;
use Components\Billing\PaymentOrder\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\PaymentOrder\Application\Repositories\PaymentOrderFileRepository;
use Components\Billing\PaymentOrder\Application\Repositories\PaymentOrderItemRepository;
use Components\Billing\PaymentOrder\Application\Repositories\PaymentOrderRepository;
use Components\Billing\PaymentOrder\Application\Repositories\ReceivedPaymentOutboundInvoiceRepository;
use Components\Billing\PaymentOrder\Application\Repositories\ReceivedPaymentRepository;
use Components\Billing\PaymentOrder\Application\Repositories\UserRepository;
use Components\Billing\PaymentOrder\Application\Repositories\VatRateRepository;
use Components\Billing\PaymentOrder\Domain\Classes\PaymentOrderInterface;
use Components\Billing\PaymentOrder\Domain\Classes\PaymentOrderItemInterface;
use Components\Billing\PaymentOrder\Domain\Classes\ReceivedPaymentInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\DeadlineRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\IbanRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\InboundInvoiceRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\InvoiceParameterRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\ModuleRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\OutboundInvoiceItemRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\OutboundInvoiceRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\PaymentOrderFileRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\PaymentOrderItemRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\PaymentOrderRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\ReceivedPaymentOutboundInvoiceRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\ReceivedPaymentRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\UserRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\Repositories\VatRateRepositoryInterface;
use Components\Billing\PaymentOrder\Domain\UseCases\AssociateInvoiceToPaymentOrder;
use Components\Billing\PaymentOrder\Domain\UseCases\CreatePaymentOrder;
use Components\Billing\PaymentOrder\Domain\UseCases\CreateReceivedPayment;
use Components\Billing\PaymentOrder\Domain\UseCases\DeletePaymentOrder;
use Components\Billing\PaymentOrder\Domain\UseCases\DissociateInvoiceFromPaymentOrder;
use Components\Billing\PaymentOrder\Domain\UseCases\EditPaymentOrder;
use Components\Billing\PaymentOrder\Domain\UseCases\EditReceivedPayment;
use Components\Billing\PaymentOrder\Domain\UseCases\GeneratePaymentOrderFile;
use Components\Billing\PaymentOrder\Domain\UseCases\ListPaymentOrder;
use Components\Billing\PaymentOrder\Domain\UseCases\ListReceivedPayment;
use Components\Billing\PaymentOrder\Domain\UseCases\MarkPaymentOrderAsPaid;
use Components\Billing\PaymentOrder\Domain\UseCases\ShowPaymentOrder;
use Illuminate\Support\ServiceProvider;

class PaymentOrderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'payment_order');

        $this->loadFactoriesFrom(__DIR__.'/../Factories');

        $this->loadTranslationsFrom(__DIR__.'/../Langs', 'payment_order');

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
            ModuleRepositoryInterface::class,
            ModuleRepository::class
        );

        $this->app->bind(
            OutboundInvoiceRepositoryInterface::class,
            OutboundInvoiceRepository::class
        );

        $this->app->bind(
            DeadlineRepositoryInterface::class,
            DeadlineRepository::class
        );

        $this->app->bind(
            OutboundInvoiceItemRepositoryInterface::class,
            OutboundInvoiceItemRepository::class
        );

        $this->app->bind(
            InboundInvoiceRepositoryInterface::class,
            InboundInvoiceRepository::class
        );

        $this->app->bind(
            InvoiceParameterRepositoryInterface::class,
            InvoiceParameterRepository::class
        );

        $this->app->bind(
            VatRateRepositoryInterface::class,
            VatRateRepository::class
        );

        $this->app->bind(
            PaymentOrderRepositoryInterface::class,
            PaymentOrderRepository::class
        );

        $this->app->bind(
            IbanRepositoryInterface::class,
            IbanRepository::class
        );

        $this->app->bind(
            PaymentOrderItemRepositoryInterface::class,
            PaymentOrderItemRepository::class
        );

        $this->app->bind(
            PaymentOrderFileRepositoryInterface::class,
            PaymentOrderFileRepository::class
        );

        $this->app->bind(
            ReceivedPaymentRepositoryInterface::class,
            ReceivedPaymentRepository::class
        );

        $this->app->bind(
            ReceivedPaymentOutboundInvoiceRepositoryInterface::class,
            ReceivedPaymentOutboundInvoiceRepository::class
        );
    }

    private function bindModelInterfaces()
    {
        $this->app->bind(
            PaymentOrderInterface::class,
            PaymentOrder::class
        );

        $this->app->bind(
            PaymentOrderItemInterface::class,
            PaymentOrderItem::class
        );

        $this->app->bind(
            ReceivedPaymentInterface::class,
            ReceivedPayment::class
        );
    }

    private function bindUseCases()
    {
        $this->bindCreatePaymentOrderUseCase();
        $this->bindEditPaymentOrderUseCase();
        $this->bindListPaymentOrderUseCase();
        $this->bindShowPaymentOrderUseCase();
        $this->bindAssociateInvoiceToPaymentOrderUseCase();
        $this->bindGeneratePaymentOrderFileUseCase();
        $this->bindDissociateInvoiceToPaymentOrderUseCase();
        $this->bindMarkPaymentOrderAsPaidUseCase();
        $this->bindDeletePaymentOrderUseCase();

        $this->bindCreateReceivedPaymentUseCase();
        $this->bindListReceivedPaymentUseCase();
        $this->bindEditReceivedPaymentUseCase();
    }

    private function bindCreatePaymentOrderUseCase()
    {
        $this->app->bind(
            CreatePaymentOrder::class,
            function ($app) {
                return new CreatePaymentOrder(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class),
                    $app->make(DeadlineRepositoryInterface::class),
                    $app->make(IbanRepositoryInterface::class),
                    $app->make(PaymentOrderRepositoryInterface::class),
                );
            }
        );
    }

    private function bindEditPaymentOrderUseCase()
    {
        $this->app->bind(
            EditPaymentOrder::class,
            function ($app) {
                return new EditPaymentOrder(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(IbanRepositoryInterface::class),
                    $app->make(PaymentOrderRepositoryInterface::class),
                );
            }
        );
    }

    private function bindListPaymentOrderUseCase()
    {
        $this->app->bind(
            ListPaymentOrder::class,
            function ($app) {
                return new ListPaymentOrder(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(PaymentOrderRepositoryInterface::class),
                );
            }
        );
    }

    private function bindShowPaymentOrderUseCase()
    {
        $this->app->bind(
            ShowPaymentOrder::class,
            function ($app) {
                return new ShowPaymentOrder(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(PaymentOrderRepositoryInterface::class),
                );
            }
        );
    }

    private function bindAssociateInvoiceToPaymentOrderUseCase()
    {
        $this->app->bind(
            AssociateInvoiceToPaymentOrder::class,
            function ($app) {
                return new AssociateInvoiceToPaymentOrder(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(IbanRepositoryInterface::class),
                    $app->make(PaymentOrderRepositoryInterface::class),
                    $app->make(InboundInvoiceRepositoryInterface::class),
                    $app->make(PaymentOrderItemRepositoryInterface::class),
                    $app->make(OutboundInvoiceItemRepositoryInterface::class),
                );
            }
        );
    }

    private function bindGeneratePaymentOrderFileUseCase()
    {
        $this->app->bind(
            GeneratePaymentOrderFile::class,
            function ($app) {
                return new GeneratePaymentOrderFile(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(PaymentOrderRepositoryInterface::class),
                    $app->make(PaymentOrderItemRepositoryInterface::class),
                    $app->make(PaymentOrderFileRepositoryInterface::class),
                );
            }
        );
    }

    private function bindDissociateInvoiceToPaymentOrderUseCase()
    {
        $this->app->bind(
            DissociateInvoiceFromPaymentOrder::class,
            function ($app) {
                return new DissociateInvoiceFromPaymentOrder(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(IbanRepositoryInterface::class),
                    $app->make(PaymentOrderRepositoryInterface::class),
                    $app->make(InboundInvoiceRepositoryInterface::class),
                    $app->make(PaymentOrderItemRepositoryInterface::class),
                    $app->make(OutboundInvoiceItemRepositoryInterface::class),
                );
            }
        );
    }

    private function bindMarkPaymentOrderAsPaidUseCase()
    {
        $this->app->bind(
            MarkPaymentOrderAsPaid::class,
            function ($app) {
                return new MarkPaymentOrderAsPaid(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(PaymentOrderRepositoryInterface::class),
                    $app->make(PaymentOrderItemRepositoryInterface::class),
                );
            }
        );
    }

    private function bindDeletePaymentOrderUseCase()
    {
        $this->app->bind(
            DeletePaymentOrder::class,
            function ($app) {
                return new DeletePaymentOrder(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(PaymentOrderRepositoryInterface::class),
                    $app->make(PaymentOrderItemRepositoryInterface::class),
                );
            }
        );
    }

    private function bindCreateReceivedPaymentUseCase()
    {
        $this->app->bind(
            CreateReceivedPayment::class,
            function ($app) {
                return new CreateReceivedPayment(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(IbanRepositoryInterface::class),
                    $app->make(ReceivedPaymentRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class),
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                    $app->make(ReceivedPaymentOutboundInvoiceRepositoryInterface::class)
                );
            }
        );
    }

    private function bindListReceivedPaymentUseCase()
    {
        $this->app->bind(
            ListReceivedPayment::class,
            function ($app) {
                return new ListReceivedPayment(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ReceivedPaymentRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class),
                );
            }
        );
    }

    private function bindEditReceivedPaymentUseCase()
    {
        $this->app->bind(
            EditReceivedPayment::class,
            function ($app) {
                return new EditReceivedPayment(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(IbanRepositoryInterface::class),
                    $app->make(ReceivedPaymentRepositoryInterface::class),
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                    $app->make(ReceivedPaymentOutboundInvoiceRepositoryInterface::class)
                );
            }
        );
    }
}
