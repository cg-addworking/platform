<?php
namespace Components\Enterprise\InvoiceParameter\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\InvoiceParameter\Domain\Classes\InvoiceParameterInterface;
use Components\Enterprise\InvoiceParameter\Domain\Exceptions\EnterpriseNotExistsException;
use Components\Enterprise\InvoiceParameter\Domain\Exceptions\InvoiceParameterNotFoundException;
use Components\Enterprise\InvoiceParameter\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Enterprise\InvoiceParameter\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\CustomerBillingDeadlineRepositoryInterface;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\IbanRepositoryInterface;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\InvoiceParameterRepositoryInterface;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\UserRepositoryInterface;

class EditInvoiceParameter
{
    private $userRepository;
    private $customerBillingDeadlineRepository;
    private $ibanRepository;
    private $invoiceParameterRepository;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param CustomerBillingDeadlineRepositoryInterface $customerBillingDeadlineRepository
     * @param IbanRepositoryInterface $ibanRepository
     * @param InvoiceParameterRepositoryInterface $invoiceParameterRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        CustomerBillingDeadlineRepositoryInterface $customerBillingDeadlineRepository,
        IbanRepositoryInterface $ibanRepository,
        InvoiceParameterRepositoryInterface $invoiceParameterRepository
    ) {
        $this->userRepository = $userRepository;
        $this->customerBillingDeadlineRepository = $customerBillingDeadlineRepository;
        $this->ibanRepository = $ibanRepository;
        $this->invoiceParameterRepository = $invoiceParameterRepository;
    }

    /**
     * @param User $authUser
     * @param array $inputs
     * @param Enterprise $enterprise
     * @param InvoiceParameterInterface|null $invoiceParameter
     * @return InvoiceParameterInterface
     * @throws EnterpriseNotExistsException
     * @throws InvoiceParameterNotFoundException
     * @throws UserIsNotSupportException
     * @throws UserNotAuthentificatedException
     */
    public function handle(
        User $authUser,
        array $inputs,
        Enterprise $enterprise,
        ?InvoiceParameterInterface $invoiceParameter
    ) {
        $this->checkUser($authUser);
        $this->checkInvoiceParameter($invoiceParameter);
        $this->checkEnterprise($enterprise);

        $invoiceParameter->setDefaultManagementFeesByVendor($inputs['default_management_fees_by_vendor'] ?? 0);
        $invoiceParameter->setCustomManagementFeesByVendor($inputs['custom_management_fees_by_vendor'] ?? 0);
        $invoiceParameter->setFixedFeesByVendorAmount($inputs['fixed_fees_by_vendor_amount'] ?? 0);
        $invoiceParameter->setSubscriptionAmount($inputs['subscription_amount'] ?? 0);
        $invoiceParameter->setDiscountAmount($inputs['discount_amount'] ?? 0);
        $invoiceParameter->setDiscountEndsAt($inputs['discount_ends_at'] ?? null);
        $invoiceParameter->setDiscountStartsAt($inputs['discount_starts_at'] ?? null);
        $invoiceParameter->setAnalyticCode($inputs['analytic_code'] ?? null);
        $invoiceParameter->setBillingFloorAmount($inputs['billing_floor_amount'] ?? 0);
        $invoiceParameter->setBillingCapAmount($inputs['billing_cap_amount'] ?? 0);
        $invoiceParameter->setStartsAt($inputs['starts_at'] ?? null);
        $invoiceParameter->setEndsAt($inputs['ends_at'] ?? null);
        $invoiceParameter->setInvoicingFromInboundInvoice($inputs['invoicing_from_inbound_invoice'] ?? 0);
        $invoiceParameter->setVendorCreatingInboundInvoiceItems($inputs['vendor_creating_inbound_invoice_items'] ?? 0);

        $this->setInvoiceParameterIban($inputs['iban_id'], $invoiceParameter, $enterprise);
        $this->deleteInitialCustomerDeadlines($enterprise);
        $this->setInvoiceParameterCustomerDeadlines($inputs['customer_deadlines'] ?? null, $enterprise);

        return $this->invoiceParameterRepository->save($invoiceParameter);
    }

    /**
     * @param $authUser
     * @throws UserIsNotSupportException
     * @throws UserNotAuthentificatedException
     */
    public function checkUser($authUser)
    {
        if (is_null($authUser)) {
            throw new UserNotAuthentificatedException();
        }

        if (! $this->userRepository->isSupport($authUser)) {
            throw new UserIsNotSupportException();
        }
    }

    /**
     * @param $enterprise
     * @throws EnterpriseNotExistsException
     */
    public function checkEnterprise($enterprise)
    {
        if (is_null($enterprise)) {
            throw new EnterpriseNotExistsException();
        }
    }

    /**
     * @param InvoiceParameterInterface|null $invoiceParameter
     * @throws InvoiceParameterNotFoundException
     */
    private function checkInvoiceParameter(?InvoiceParameterInterface $invoiceParameter)
    {
        if (is_null($invoiceParameter)) {
            throw new InvoiceParameterNotFoundException();
        }
    }

    /**
     * @param Enterprise $enterprise
     */
    private function deleteInitialCustomerDeadlines(Enterprise $enterprise)
    {
        $deadlines = $this->invoiceParameterRepository->getDeadlinesOf($enterprise);

        foreach ($deadlines as $deadline) {
            $deadline->delete();
        }
    }

    /**
     * @param string $iban_id
     * @param InvoiceParameterInterface $invoice_parameter
     * @param Enterprise $enterprise
     */
    private function setInvoiceParameterIban(
        string $iban_id,
        InvoiceParameterInterface $invoice_parameter,
        Enterprise $enterprise
    ) {
        $iban = $this->ibanRepository->find($iban_id);
        $invoice_parameter->setIban($iban);
        $invoice_parameter->setEnterprise($enterprise);
    }

    /**
     * @param array|null $customer_deadlines
     * @param Enterprise $enterprise
     */
    private function setInvoiceParameterCustomerDeadlines(?array $customer_deadlines, Enterprise $enterprise)
    {
        if (! is_null($customer_deadlines)) {
            foreach ($customer_deadlines as $deadline) {
                $deadlines = $this->customerBillingDeadlineRepository->make();
                $deadlines->setEnterprise($enterprise);
                $deadlines->setDeadline($deadline);
                $this->customerBillingDeadlineRepository->save($deadlines);
            }
        }
    }
}
