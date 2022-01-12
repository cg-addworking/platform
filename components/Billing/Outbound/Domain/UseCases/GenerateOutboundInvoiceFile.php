<?php
namespace Components\Billing\Outbound\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsAlreadyValidatedException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\Outbound\Domain\Repositories\AddressRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\ModuleRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceFileRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\UserRepositoryInterface;

class GenerateOutboundInvoiceFile
{
    private $outboundInvoiceRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $moduleRepository;
    private $outboundInvoiceFileRepository;
    private $addressRepository;

    public function __construct(
        OutboundInvoiceRepositoryInterface $outboundInvoiceRepository,
        UserRepositoryInterface $userRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        ModuleRepositoryInterface $moduleRepository,
        OutboundInvoiceFileRepositoryInterface $outboundInvoiceFileRepository,
        AddressRepositoryInterface $addressRepository
    ) {
        $this->outboundInvoiceRepository = $outboundInvoiceRepository;
        $this->userRepository = $userRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->moduleRepository = $moduleRepository;
        $this->outboundInvoiceFileRepository = $outboundInvoiceFileRepository;
        $this->addressRepository = $addressRepository;
    }

    public function handle(
        ?User $auth_user,
        ?Enterprise $customer,
        ?OutboundInvoiceInterface $outbound_invoice,
        $data = []
    ) {
        $this->checkUser($auth_user);
        $this->checkCustomer($customer);
        $this->checkOutboundInvoice($outbound_invoice);

        if (! empty($data)) {
            $outbound_invoice->setLegalNotice($data['legal_notice']);
            $outbound_invoice->setReverseChargeVat($data['reverse_charge_vat'] ?? false);
            $outbound_invoice->setDaillyAssignment($data['dailly_assignment'] ?? false);
            $outbound_invoice = $this->outboundInvoiceRepository->save($outbound_invoice);
        }

        $address = $this->addressRepository->find($data['address']);

        $generated = $this->outboundInvoiceFileRepository->generate($outbound_invoice, $address);

        $this->outboundInvoiceRepository->updateStatusTo(
            $outbound_invoice,
            OutboundInvoiceInterface::STATUS_FILE_GENERATED
        );

        return $generated;
    }

    public function checkUser($auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserNotAuthentificatedException();
        }

        if (! $this->userRepository->isSupport($auth_user)) {
            throw new UserIsNotSupportException();
        }
    }

    public function checkCustomer($customer)
    {
        if (is_null($customer)) {
            throw new EnterpriseNotExistsException();
        }

        if (! $this->enterpriseRepository->isCustomer($customer)) {
            throw new EnterpriseIsNotCustomerException();
        }

        if (! $this->moduleRepository->hasAccessToBilling($customer)) {
            throw new EnterpriseDoesntHaveAccessToBillingException();
        }
    }

    public function checkOutboundInvoice($outbound_invoice)
    {
        if (is_null($outbound_invoice)) {
            throw new OutboundInvoiceNotExistsException();
        }

        if ($this->outboundInvoiceRepository->isValidated($outbound_invoice)) {
            throw new OutboundInvoiceIsAlreadyValidatedException();
        }
    }
}
