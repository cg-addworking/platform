<?php

namespace Components\Billing\Outbound\Application\Jobs;

use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Domain\UseCases\AssociateInboundInvoiceToOutboundInvoice;
use Components\Billing\Outbound\Domain\UseCases\CalculateAddworkingFees;
use Components\Billing\Outbound\Domain\UseCases\CreateOutboundInvoiceForEnterprise;
use Components\Billing\Outbound\Domain\UseCases\GenerateOutboundInvoiceFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class CreateOutboundInvoiceFromInboundInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $auth_user;
    protected $inbound_invoice;
    protected $inputs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $auth_user, InboundInvoice $inbound_invoice, array $inputs)
    {
        $this->auth_user = $auth_user;
        $this->inbound_invoice = $inbound_invoice;
        $this->inputs = $inputs;
    }

    public function handle()
    {
        $outboundInvoice = App::make(CreateOutboundInvoiceForEnterprise::class)->handle(
            $this->auth_user,
            $this->inputs
        );

        App::make(AssociateInboundInvoiceToOutboundInvoice::class)->handle(
            $this->auth_user,
            $this->inbound_invoice->enterprise,
            $this->inbound_invoice,
            $outboundInvoice->getEnterprise(),
            $outboundInvoice
        );

        if ($this->inputs['include_fees'] == 1) {
            App::make(CalculateAddworkingFees::class)->handle(
                $this->auth_user,
                $outboundInvoice->getEnterprise(),
                $outboundInvoice,
                $outboundInvoice
            );
        }

        App::make(GenerateOutboundInvoiceFile::class)->handle(
            $this->auth_user,
            $outboundInvoice->getEnterprise(),
            $outboundInvoice,
            $this->inputs
        );

        return $outboundInvoice;
    }
}
