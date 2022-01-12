<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Repositories\CaptureInvoiceRepository;
use Components\Contract\Contract\Application\Repositories\SubcontractingDeclarationRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;

class CreateCaptureInvoice
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

    public function handle(?User $auth_user, ?Contract $contract, array $inputs, $file)
    {
        $this->checkUser($auth_user);
        $this->checkContract($contract);

        if ($file) {
            $file = $this->subcontractingDeclarationRepository->createFile($file);
        }

        $invoice = $this->createCaptureInvoice($auth_user, $contract, $inputs, $file);
        return $this->captureInvoiceRepository->save($invoice);
    }

    private function checkUser($user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException();
        }
    }

    private function checkContract($contract)
    {
        if (is_null($contract)) {
            throw new ContractIsNotFoundException();
        }
    }

    private function createCaptureInvoice(User $auth_user, Contract $contract, array $inputs, ?File $file)
    {
        $invoice = $this->captureInvoiceRepository->make();
        $invoice->setShortId();
        $invoice->setInvoicedAt($inputs['invoiced_at']);
        $invoice->setInvoiceNumber($inputs['invoice_number']);
        $invoice->setDepositGuaranteedHoldbackNumber($inputs['deposit_guaranteed_holdback_number']);
        $invoice->setDepositGoodEndNumber($inputs['deposit_good_end_number']);
        $invoice->setInvoiceAmountBeforeTaxes($inputs['invoice_amount_before_taxes']);
        $invoice->setInvoiceAmountOfTaxes($inputs['invoice_amount_of_taxes']);
        $invoice->setAmountGuaranteedHoldback($inputs['amount_guaranteed_holdback']);
        $invoice->setAmountGoodEnd($inputs['amount_good_end']);
        $invoice->setCustomer($auth_user->enterprise);
        $invoice->setCreatedBy($auth_user);

        $invoice->setContract($contract);
        $invoice->setContractNumber($contract->getNumber());

        $vendor = Enterprise::find($inputs['vendor_id']);
        $invoice->setVendor($vendor);

        if (!is_null($inputs['dc4_date']) && !is_null($inputs['dc4_percent'])) {
            $subcontracting_declaration = $this->subcontractingDeclarationRepository->make();
            $subcontracting_declaration->setContract($contract);
            $subcontracting_declaration->setValidationDate($inputs['dc4_date']);
            $subcontracting_declaration->setPercentOfAggregation($inputs['dc4_percent']);
            if (!is_null($file)) {
                $subcontracting_declaration->setFile($file);
            }
            $this->subcontractingDeclarationRepository->save($subcontracting_declaration);
        }

        return $invoice;
    }
}
