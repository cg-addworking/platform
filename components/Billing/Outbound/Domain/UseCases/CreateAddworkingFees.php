<?php
namespace Components\Billing\Outbound\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Application\Models\Fee;
use Components\Billing\Outbound\Domain\Classes\FeeInterface;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\EnterprisesDoesntHavePartnershipException;
use Components\Billing\Outbound\Domain\Exceptions\FeeNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\InvoiceParametersNotInformedException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\Outbound\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\FeeRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\InvoiceParameterRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\ModuleRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\UserRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\VatRateRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateAddworkingFees implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $feeRepository;
    private $outboundInvoiceRepository;
    private $enterpriseRepository;
    private $invoiceParameterRepository;
    private $moduleRepository;
    private $vatRateRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        FeeRepositoryInterface $feeRepository,
        OutboundInvoiceRepositoryInterface $outboundInvoiceRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        InvoiceParameterRepositoryInterface $invoiceParameterRepository,
        ModuleRepositoryInterface $moduleRepository,
        VatRateRepositoryInterface $vatRateRepository
    ) {
        $this->userRepository             = $userRepository;
        $this->feeRepository              = $feeRepository;
        $this->outboundInvoiceRepository  = $outboundInvoiceRepository;
        $this->enterpriseRepository       = $enterpriseRepository;
        $this->invoiceParameterRepository = $invoiceParameterRepository;
        $this->moduleRepository           = $moduleRepository;
        $this->vatRateRepository          = $vatRateRepository;
    }

    public function handle(?User $auth_user, ?OutboundInvoiceInterface $outbound_invoice, array $data)
    {
        $this->checkUser($auth_user);
        $this->checkOutboundInvoice($outbound_invoice);

        $customer = $outbound_invoice->getEnterprise();
        $this->checkCustomer($customer);

        $invoice_parameter = $this->invoiceParameterRepository
            ->getActiveParameterInPeriod($customer, $outbound_invoice->getMonth());

        $this->checkParameter($invoice_parameter);

        $fee = new Fee;
        $fee->setInvoice($outbound_invoice);
        $fee->setInvoiceParameter($invoice_parameter);
        $fee->setCustomer($customer);
        $fee->setNumber();

        if (isset($data['vendor_id'])) {
            $vendor = $this->enterpriseRepository->find($data['vendor_id']);
            $this->checkVendor($vendor, $customer);
            $fee->setVendor($vendor);
        }

        $fee->setVatRate($this->vatRateRepository->findByValue(0.2));
        $fee->setType($data['type']);
        $fee->setAmountBeforeTaxes($data['amount_before_taxes'], 1);
        $fee->setLabel($data['label']);

        return $this->feeRepository->save($fee);
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

    public function checkFee($old_fee)
    {
        if (is_null($old_fee)) {
            throw new FeeNotExistsException;
        }
    }

    public function checkOutboundInvoice($outbound_invoice)
    {
        if (is_null($outbound_invoice)) {
            throw new OutboundInvoiceNotExistsException;
        }
    }

    public function checkCustomer($customer)
    {
        if (is_null($customer)) {
            throw new EnterpriseNotExistsException;
        }

        if (! $this->enterpriseRepository->isCustomer($customer)) {
            throw new EnterpriseIsNotCustomerException;
        }

        if (! $this->moduleRepository->hasAccessToBilling($customer)) {
            throw new EnterpriseDoesntHaveAccessToBillingException;
        }
    }

    public function checkVendor($vendor, $customer)
    {
        if (is_null($vendor)) {
            throw new EnterpriseNotExistsException;
        }

        if (! $this->enterpriseRepository->hasPartnershipWith($customer, $vendor)) {
            throw new EnterprisesDoesntHavePartnershipException();
        }
    }

    public function checkParameter($invoice_parameter)
    {
        if (is_null($invoice_parameter)) {
            throw new InvoiceParametersNotInformedException();
        }
    }
}
