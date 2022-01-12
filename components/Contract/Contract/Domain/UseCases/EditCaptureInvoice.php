<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\CaptureInvoice;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\CaptureInvoiceEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\CaptureInvoiceRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\SubcontractingDeclarationRepositoryInterface;

class EditCaptureInvoice
{
    private $captureInvoiceRepository;
    private $subcontractingDeclarationRepository;

    public function __construct(
        CaptureInvoiceRepositoryInterface $captureInvoiceRepository,
        SubcontractingDeclarationRepositoryInterface $subcontractingDeclarationRepository
    ) {
        $this->captureInvoiceRepository = $captureInvoiceRepository;
        $this->subcontractingDeclarationRepository = $subcontractingDeclarationRepository;
    }

    public function handle(
        ?User $auth_user,
        ContractEntityInterface $contract,
        CaptureInvoiceEntityInterface $invoice,
        array $inputs,
        $file
    ) {
        $this->checkUser($auth_user);

        if ($file) {
            $file = $this->subcontractingDeclarationRepository->createFile($file);
        }

        $invoice = $this->editCaptureInvoice($contract, $invoice, $inputs, $file);

        return $this->captureInvoiceRepository->save($invoice);
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }
    }

    private function editCaptureInvoice(
        ContractEntityInterface $contract,
        CaptureInvoiceEntityInterface $invoice,
        array $inputs,
        ?File $file
    ) {
        $invoice->setInvoicedAt($inputs['invoiced_at']);
        $invoice->setInvoiceNumber($inputs['invoice_number']);
        $invoice->setInvoiceAmountBeforeTaxes($inputs['invoice_amount_before_taxes']);
        $invoice->setInvoiceAmountOfTaxes($inputs['invoice_amount_of_taxes']);
        $invoice->setDepositGoodEndNumber($inputs['deposit_good_end_number']);
        $invoice->setDepositGuaranteedHoldbackNumber($inputs['deposit_guaranteed_holdback_number']);
        $invoice->setAmountGuaranteedHoldback($inputs['amount_guaranteed_holdback']);
        $invoice->setAmountGoodEnd($inputs['amount_good_end']);

        if (!is_null($inputs['dc4_date']) && !is_null($inputs['dc4_percent'])) {
            $subcontracting_declaration =
                $this->subcontractingDeclarationRepository->getSubcontractingDeclarationOf($contract);
            $this->subcontractingDeclarationRepository->delete($subcontracting_declaration);
            $declaration = $this->subcontractingDeclarationRepository->make();
            $declaration->setContract($contract);
            $declaration->setValidationDate($inputs['dc4_date']);
            $declaration->setPercentOfAggregation($inputs['dc4_percent']);
            if (!is_null($file)) {
                $declaration->setFile($file);
            }
            $this->subcontractingDeclarationRepository->save($declaration);
        }



        return $invoice;
    }
}
