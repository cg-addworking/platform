<?php

namespace Components\Billing\Outbound\Application\Jobs;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\UseCases\GenerateOutboundInvoiceFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class GenerateOutboundInvoiceFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $auth_user;
    protected $enterprise;
    protected $outbound_invoice;
    protected $inputs;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        User $auth_user,
        Enterprise $enterprise,
        OutboundInvoiceInterface $outbound_invoice,
        array $inputs
    ) {
        $this->auth_user = $auth_user;
        $this->enterprise = $enterprise;
        $this->outbound_invoice = $outbound_invoice;
        $this->inputs = $inputs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        App::make(GenerateOutboundInvoiceFile::class)
            ->handle(
                $this->auth_user,
                $this->enterprise,
                $this->outbound_invoice,
                $this->inputs
            );
    }
}
