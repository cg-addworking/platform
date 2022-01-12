<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Presenters\CaptureInvoicePresenter;
use Components\Contract\Contract\Application\Repositories\CaptureInvoiceRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;

class ListCaptureInvoice
{
    private $captureInvoiceRepository;

    public function __construct(CaptureInvoiceRepository $captureInvoiceRepository)
    {
        $this->captureInvoiceRepository = $captureInvoiceRepository;
    }

    public function handle(CaptureInvoicePresenter $presenter, ?User $auth_user, ?Contract $contract)
    {
        $this->checkUser($auth_user);
        $this->checkContract($contract);

        return $presenter->present($this->captureInvoiceRepository->list($contract));
    }

    public function checkUser(?User $auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException();
        }
    }

    public function checkContract(?Contract $contract)
    {
        if (is_null($contract)) {
            throw new ContractIsNotFoundException();
        }
    }
}
