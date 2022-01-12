<?php

namespace Components\Billing\Outbound\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\Outbound\Application\Repositories\UserRepository;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsUnpublishedException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\Exceptions\UserNotAuthentificatedException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UnpublishOutboundInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $outboundInvoiceRepository;

    public function __construct(
        UserRepository $userRepository,
        OutboundInvoiceRepository $outboundInvoiceRepository
    ) {
        $this->userRepository            = $userRepository;
        $this->outboundInvoiceRepository = $outboundInvoiceRepository;
    }

    public function handle(?User $auth_user, ?OutboundInvoiceInterface $outbound_invoice)
    {
        $this->checkUser($auth_user);
        $this->checkOutboundInvoice($outbound_invoice);

        return $this->outboundInvoiceRepository->unpublish($outbound_invoice);
    }

    public function checkUser($auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserNotAuthentificatedException;
        }

        if (! $this->userRepository->isSupport($auth_user)) {
            throw new UserIsNotSupportException;
        }
    }

    public function checkOutboundInvoice($outbound_invoice)
    {
        if (is_null($outbound_invoice)) {
            throw new OutboundInvoiceNotExistsException;
        }

        if (! $this->outboundInvoiceRepository->isPublished($outbound_invoice)) {
            throw new OutboundInvoiceIsUnpublishedException;
        }
    }
}
