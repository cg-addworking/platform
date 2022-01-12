<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\CaptureInvoice;
use Components\Contract\Contract\Application\Models\SubcontractingDeclaration;
use Components\Contract\Contract\Application\Repositories\CaptureInvoiceRepository;
use Components\Contract\Contract\Application\Repositories\SubcontractingDeclarationRepository;
use Components\Contract\Contract\Domain\Exceptions\CaptureInvoiceIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;

class DeleteCaptureInvoice
{
    private $captureInvoiceRepository;
    private $subcontractingDeclarationRepository;

    public function __construct(
        CaptureInvoiceRepository $captureInvoiceRepository,
        SubcontractingDeclarationRepository $subcontractingDeclarationRepository
    ) {
        $this->captureInvoiceRepository = $captureInvoiceRepository;
        $this->subcontractingDeclarationRepository = $subcontractingDeclarationRepository;
    }

    public function handle(User $auth_user, CaptureInvoice $capture_invoice)
    {
        $this->checkUser($auth_user);
        $this->checkCaptureInvoice($capture_invoice);

        $declaration = SubcontractingDeclaration::whereHas('contract', function ($query) use ($capture_invoice) {
            $query->where('id', $capture_invoice->getContract()->getId());
        })->first();

        if ($declaration) {
            $this->subcontractingDeclarationRepository->delete($declaration);
        }

        return $this->captureInvoiceRepository->delete($capture_invoice);
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }
    }

    private function checkCaptureInvoice($capture_invoice)
    {
        if (is_null($capture_invoice)) {
            throw new CaptureInvoiceIsNotFoundException();
        }
    }
}
