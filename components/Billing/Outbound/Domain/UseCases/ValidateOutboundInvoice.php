<?php
namespace Components\Billing\Outbound\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceStatusIsNotFileGeneratedException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ValidateOutboundInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $outboundInvoiceRepository;
    private $userRepository;

    /**
     * @param OutboundInvoiceRepositoryInterface $outboundInvoiceRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        OutboundInvoiceRepositoryInterface $outboundInvoiceRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->outboundInvoiceRepository = $outboundInvoiceRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param User|null $auth_user
     * @param OutboundInvoiceInterface|null $outbound_invoice
     * @return mixed
     * @throws OutboundInvoiceNotExistsException
     * @throws OutboundInvoiceStatusIsNotFileGeneratedException
     * @throws UserIsNotSupportException
     * @throws UserNotAuthentificatedException
     */
    public function handle(?User $auth_user, ?OutboundInvoiceInterface $outbound_invoice)
    {
        $this->checkUser($auth_user);
        $this->checkOutboundInvoice($outbound_invoice);

        return $this->outboundInvoiceRepository->validate($auth_user, $outbound_invoice);
    }

    /**
     * @param $auth_user
     * @throws UserIsNotSupportException
     * @throws UserNotAuthentificatedException
     */
    public function checkUser($auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserNotAuthentificatedException();
        }

        if (! $this->userRepository->isSupport($auth_user)) {
            throw new UserIsNotSupportException();
        }
    }

    /**
     * @param $outbound_invoice
     * @throws OutboundInvoiceNotExistsException
     * @throws OutboundInvoiceStatusIsNotFileGeneratedException
     */
    public function checkOutboundInvoice($outbound_invoice)
    {
        if (is_null($outbound_invoice)) {
            throw new OutboundInvoiceNotExistsException();
        }

        if (! $this->outboundInvoiceRepository->checkIfStatusEqualsToFileGenerated($outbound_invoice)) {
            throw new OutboundInvoiceStatusIsNotFileGeneratedException();
        }
    }
}
