<?php

namespace Components\Billing\Outbound\Application\Providers;

use Components\Billing\Outbound\Application\Models\Fee;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Billing\Outbound\Application\Repositories\AddressRepository;
use Components\Billing\Outbound\Application\Repositories\DeadlineRepository;
use Components\Billing\Outbound\Application\Repositories\EnterpriseRepository;
use Components\Billing\Outbound\Application\Repositories\FeeRepository;
use Components\Billing\Outbound\Application\Repositories\IbanRepository;
use Components\Billing\Outbound\Application\Repositories\InboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\InvoiceParameterRepository;
use Components\Billing\Outbound\Application\Repositories\MemberRepository;
use Components\Billing\Outbound\Application\Repositories\ModuleRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceFileRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceItemRepository;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Application\Repositories\VatRateRepository;
use Components\Billing\Outbound\Domain\Classes\FeeInterface;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceItemInterface;
use Components\Billing\Outbound\Domain\Repositories\AddressRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\DeadlineRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\FeeRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\IbanRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\InboundInvoiceRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\InvoiceParameterRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\MemberRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\ModuleRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceFileRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceItemRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\UserRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\VatRateRepositoryInterface;
use Components\Billing\Outbound\Domain\UseCases\AddAdHocLineToOutboundInvoice;
use Components\Billing\Outbound\Domain\UseCases\AssociateInboundInvoiceToOutboundInvoice;
use Components\Billing\Outbound\Domain\UseCases\CalculateAddworkingFees;
use Components\Billing\Outbound\Domain\UseCases\CreateAddworkingFees;
use Components\Billing\Outbound\Domain\UseCases\CreateCreditAddworkingFees;
use Components\Billing\Outbound\Domain\UseCases\CreateCreditLineForOutboundInvoiceItem;
use Components\Billing\Outbound\Domain\UseCases\CreateCreditNoteForOutboundInvoice;
use Components\Billing\Outbound\Domain\UseCases\CreateOutboundInvoiceForEnterprise;
use Components\Billing\Outbound\Domain\UseCases\DeleteAdHocLineFromOutboundInvoice;
use Components\Billing\Outbound\Domain\UseCases\DeleteCreditAddworkingFeeFromCreditNote;
use Components\Billing\Outbound\Domain\UseCases\DissociateInboundInvoiceFromOutboundInvoice;
use Components\Billing\Outbound\Domain\UseCases\EditOutboundInvoice;
use Components\Billing\Outbound\Domain\UseCases\GenerateOutboundInvoiceFile;
use Components\Billing\Outbound\Domain\UseCases\PublishOutboundInvoice;
use Components\Billing\Outbound\Domain\UseCases\ShowOutboundInvoice;
use Components\Billing\Outbound\Domain\UseCases\UnpublishOutboundInvoice;
use Illuminate\Support\ServiceProvider;

class OutboundInvoiceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'outbound_invoice');

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
            MemberRepositoryInterface::class,
            MemberRepository::class
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
            FeeRepositoryInterface::class,
            FeeRepository::class
        );

        $this->app->bind(
            VatRateRepositoryInterface::class,
            VatRateRepository::class
        );

        $this->app->bind(
            OutboundInvoiceFileRepositoryInterface::class,
            OutboundInvoiceFileRepository::class
        );

        $this->app->bind(
            AddressRepositoryInterface::class,
            AddressRepository::class
        );

        $this->app->bind(
            IbanRepositoryInterface::class,
            IbanRepository::class
        );
    }

    private function bindModelInterfaces()
    {
        $this->app->bind(
            OutboundInvoiceInterface::class,
            OutboundInvoice::class
        );

        $this->app->bind(
            OutboundInvoiceItemInterface::class,
            OutboundInvoiceItem::class
        );

        $this->app->bind(
            FeeInterface::class,
            Fee::class
        );
    }

    private function bindUseCases()
    {
        $this->bindCreateOutboundInvoiceForEnterpriseUseCase();
        $this->bindAssociateInboundInvoiceToOutboundInvoiceUseCase();
        $this->bindDissociateInboundInvoiceFromOutboundInvoiceUseCase();
        $this->bindAddAdHocLineToOutboundInvoiceUseCase();
        $this->bindCalculateAddworkingFeesUseCase();
        $this->bindCreateAddworkingFeesUseCase();
        $this->generateOutboundInvoiceFileUseCase();
        $this->bindPublishOutboundInvoiceUseCase();
        $this->bindUnpublishOutboundInvoiceUseCase();
        $this->bindShowOutboundInvoiceUseCase();
        $this->bindCreateCreditNoteForOutboundInvoiceUseCase();
        $this->bindCreateCreditLineForOutboundInvoiceItemUseCase();
        $this->bindCreateCreditAddworkingFeesUseCase();
        $this->bindDeleteAdHocLineFromOutboundInvoiceUseCase();
        $this->bindEditOutboundInvoiceUseCase();
        $this->bindDeleteCreditAddworkingFeeFromCreditNoteUseCase();
    }

    private function bindCreateOutboundInvoiceForEnterpriseUseCase()
    {
        $this->app->bind(
            CreateOutboundInvoiceForEnterprise::class,
            function ($app) {
                return new CreateOutboundInvoiceForEnterprise(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class),
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                    $app->make(DeadlineRepositoryInterface::class)
                );
            }
        );
    }

    private function bindAssociateInboundInvoiceToOutboundInvoiceUseCase()
    {
        $this->app->bind(
            AssociateInboundInvoiceToOutboundInvoice::class,
            function ($app) {
                return new AssociateInboundInvoiceToOutboundInvoice(
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                    $app->make(InboundInvoiceRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class),
                    $app->make(OutboundInvoiceItemRepositoryInterface::class),
                );
            }
        );
    }

    private function bindDissociateInboundInvoiceFromOutboundInvoiceUseCase()
    {
        $this->app->bind(
            DissociateInboundInvoiceFromOutboundInvoice::class,
            function ($app) {
                return new DissociateInboundInvoiceFromOutboundInvoice(
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                    $app->make(InboundInvoiceRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class),
                    $app->make(OutboundInvoiceItemRepositoryInterface::class),
                );
            }
        );
    }

    private function bindAddAdHocLineToOutboundInvoiceUseCase()
    {
        $this->app->bind(
            AddAdHocLineToOutboundInvoice::class,
            function ($app) {
                return new AddAdHocLineToOutboundInvoice(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class),
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                    $app->make(OutboundInvoiceItemRepositoryInterface::class),
                );
            }
        );
    }

    private function bindCalculateAddworkingFeesUseCase()
    {
        $this->app->bind(
            CalculateAddworkingFees::class,
            function ($app) {
                return new CalculateAddworkingFees(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class),
                    $app->make(InvoiceParameterRepositoryInterface::class),
                    $app->make(VatRateRepositoryInterface::class),
                    $app->make(FeeRepositoryInterface::class),
                    $app->make(OutboundInvoiceItemRepositoryInterface::class)
                );
            }
        );
    }

    private function bindCreateAddworkingFeesUseCase()
    {
        $this->app->bind(
            CreateAddworkingFees::class,
            function ($app) {
                return new CreateAddworkingFees(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(FeeRepositoryInterface::class),
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(InvoiceParameterRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class),
                    $app->make(VatRateRepositoryInterface::class)
                );
            }
        );
    }

    private function generateOutboundInvoiceFileUseCase()
    {
        $this->app->bind(
            GenerateOutboundInvoiceFile::class,
            function ($app) {
                return new GenerateOutboundInvoiceFile(
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class),
                    $app->make(OutboundInvoiceFileRepositoryInterface::class),
                    $app->make(AddressRepositoryInterface::class),
                );
            }
        );
    }

    private function bindPublishOutboundInvoiceUseCase()
    {
        $this->app->bind(
            PublishOutboundInvoice::class,
            function ($app) {
                return new PublishOutboundInvoice(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                );
            }
        );
    }

    private function bindUnpublishOutboundInvoiceUseCase()
    {
        $this->app->bind(
            UnpublishOutboundInvoice::class,
            function ($app) {
                return new UnpublishOutboundInvoice(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(OutboundInvoiceRepositoryInterface::class)
                );
            }
        );
    }

    private function bindShowOutboundInvoiceUseCase()
    {
        $this->app->bind(
            ShowOutboundInvoice::class,
            function ($app) {
                return new ShowOutboundInvoice(
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class),
                    $app->make(MemberRepositoryInterface::class),
                );
            }
        );
    }

    private function bindCreateCreditNoteForOutboundInvoiceUseCase()
    {
        $this->app->bind(
            CreateCreditNoteForOutboundInvoice::class,
            function ($app) {
                return new CreateCreditNoteForOutboundInvoice(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class),
                    $app->make(DeadlineRepositoryInterface::class)
                );
            }
        );
    }

    private function bindCreateCreditLineForOutboundInvoiceItemUseCase()
    {
        $this->app->bind(
            CreateCreditLineForOutboundInvoiceItem::class,
            function ($app) {
                return new CreateCreditLineForOutboundInvoiceItem(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(OutboundInvoiceItemRepositoryInterface::class),
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class)
                );
            }
        );
    }

    private function bindCreateCreditAddworkingFeesUseCase()
    {
        $this->app->bind(
            CreateCreditAddworkingFees::class,
            function ($app) {
                return new CreateCreditAddworkingFees(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(FeeRepositoryInterface::class),
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(InvoiceParameterRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class),
                    $app->make(VatRateRepositoryInterface::class)
                );
            }
        );
    }

    private function bindDeleteAdHocLineFromOutboundInvoiceUseCase()
    {
        $this->app->bind(
            DeleteAdHocLineFromOutboundInvoice::class,
            function ($app) {
                return new DeleteAdHocLineFromOutboundInvoice(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                    $app->make(OutboundInvoiceItemRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class)
                );
            }
        );
    }

    private function bindEditOutboundInvoiceUseCase()
    {
        $this->app->bind(
            EditOutboundInvoice::class,
            function ($app) {
                return new EditOutboundInvoice(
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class),
                    $app->make(MemberRepositoryInterface::class),
                    $app->make(DeadlineRepositoryInterface::class),
                );
            }
        );
    }

    private function bindDeleteCreditAddworkingFeeFromCreditNoteUseCase()
    {
        $this->app->bind(
            DeleteCreditAddworkingFeeFromCreditNote::class,
            function ($app) {
                return new DeleteCreditAddworkingFeeFromCreditNote(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(OutboundInvoiceRepositoryInterface::class),
                    $app->make(FeeRepositoryInterface::class),
                    $app->make(ModuleRepositoryInterface::class)
                );
            }
        );
    }
}
