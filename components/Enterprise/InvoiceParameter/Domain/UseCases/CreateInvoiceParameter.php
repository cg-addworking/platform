<?php
namespace Components\Enterprise\InvoiceParameter\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\InvoiceParameter\Domain\Exceptions\EnterpriseNotExistsException;
use Components\Enterprise\InvoiceParameter\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Enterprise\InvoiceParameter\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\CustomerBillingDeadlineRepositoryInterface;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\IbanRepositoryInterface;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\InvoiceParameterRepositoryInterface;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\UserRepositoryInterface;

class CreateInvoiceParameter
{
    private $userRepository;
    private $enterpriseRepository;
    private $customerBillingDeadlineRepository;
    private $ibanRepository;
    private $invoiceParameterRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        CustomerBillingDeadlineRepositoryInterface $customerBillingDeadlineRepository,
        IbanRepositoryInterface $ibanRepository,
        InvoiceParameterRepositoryInterface $invoiceParameterRepository
    ) {
        $this->userRepository             = $userRepository;
        $this->enterpriseRepository       = $enterpriseRepository;
        $this->customerBillingDeadlineRepository = $customerBillingDeadlineRepository;
        $this->ibanRepository             = $ibanRepository;
        $this->invoiceParameterRepository = $invoiceParameterRepository;
    }

    public function handle(User $authUser, array $inputs, Enterprise $enterprise)
    {
        $this->checkUser($authUser);
        $this->checkEnterprise($enterprise);

        $invoiceParameter = $this->invoiceParameterRepository->make();
        $invoiceParameter->setDefaultManagementFeesByVendor($inputs['default_management_fees_by_vendor']);
        $invoiceParameter->setCustomManagementFeesByVendor($inputs['custom_management_fees_by_vendor']);
        $invoiceParameter->setFixedFeesByVendorAmount($inputs['fixed_fees_by_vendor_amount']);
        $invoiceParameter->setSubscriptionAmount($inputs['subscription_amount']);
        $invoiceParameter->setDiscountAmount($inputs['discount_amount']);
        $invoiceParameter->setDiscountEndsAt($inputs['discount_ends_at']);
        $invoiceParameter->setDiscountStartsAt($inputs['discount_starts_at']);
        $invoiceParameter->setAnalyticCode($inputs['analytic_code']);
        $invoiceParameter->setBillingFloorAmount($inputs['billing_floor_amount']);
        $invoiceParameter->setBillingCapAmount($inputs['billing_cap_amount']);
        $invoiceParameter->setStartsAt($inputs['starts_at']);
        $invoiceParameter->setEndsAt($inputs['ends_at']);
        $invoiceParameter->setInvoicingFromInboundInvoice($inputs['invoicing_from_inbound_invoice']);
        $invoiceParameter->setVendorCreatingInboundInvoiceItems($inputs['vendor_creating_inbound_invoice_items']);
        $invoiceParameter->setNumber();

        $iban = $this->ibanRepository->find($inputs['iban_id']);
        $invoiceParameter->setIban($iban);
        $invoiceParameter->setEnterprise($enterprise);

        foreach ($inputs['customer_deadlines'] as $deadline) {
            $deadlines = $this->customerBillingDeadlineRepository->make();
            $deadlines->setEnterprise($enterprise);
            $deadlines->setDeadline($deadline);
            $this->customerBillingDeadlineRepository->save($deadlines);
        }

        return $this->invoiceParameterRepository->save($invoiceParameter);
    }

    public function checkUser($authUser)
    {
        if (is_null($authUser)) {
            throw new UserNotAuthentificatedException();
        }

        if (! $this->userRepository->isSupport($authUser)) {
            throw new UserIsNotSupportException();
        }
    }

    public function checkEnterprise($enterprise)
    {
        if (is_null($enterprise)) {
            throw new EnterpriseNotExistsException();
        }
    }
}
