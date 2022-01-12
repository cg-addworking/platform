<?php

namespace Components\Billing\Outbound\Domain\UseCases;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Billing\Outbound\Application\Models\Fee;
use Components\Billing\Outbound\Domain\Classes\FeeInterface;
use Components\Billing\Outbound\Domain\Classes\OutboundInvoiceInterface;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseDoesntHaveAccessToBillingException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Billing\Outbound\Domain\Exceptions\EnterpriseNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\InvoiceParametersNotInformedException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsAlreadyValidatedException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceIsNotInPendingStatusException;
use Components\Billing\Outbound\Domain\Exceptions\OutboundInvoiceNotExistsException;
use Components\Billing\Outbound\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\Outbound\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Billing\Outbound\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\FeeRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\InvoiceParameterRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\ModuleRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceItemRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\OutboundInvoiceRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\UserRepositoryInterface;
use Components\Billing\Outbound\Domain\Repositories\VatRateRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CalculateAddworkingFees implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $outboundInvoiceRepository;
    private $enterpriseRepository;
    private $moduleRepository;
    private $invoiceParameterRepository;
    private $vatRateRepository;
    private $feeRepository;
    private $outboundInvoiceItemRepository;

    private $saved = [];

    public function __construct(
        UserRepositoryInterface $userRepository,
        OutboundInvoiceRepositoryInterface $outboundInvoiceRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        ModuleRepositoryInterface $moduleRepository,
        InvoiceParameterRepositoryInterface $invoiceParameterRepository,
        VatRateRepositoryInterface $vatRateRepository,
        FeeRepositoryInterface $feeRepository,
        OutboundInvoiceItemRepositoryInterface $outboundInvoiceItemRepository
    ) {
        $this->userRepository                = $userRepository;
        $this->outboundInvoiceRepository     = $outboundInvoiceRepository;
        $this->enterpriseRepository          = $enterpriseRepository;
        $this->moduleRepository              = $moduleRepository;
        $this->invoiceParameterRepository    = $invoiceParameterRepository;
        $this->vatRateRepository             = $vatRateRepository;
        $this->feeRepository                 = $feeRepository;
        $this->outboundInvoiceItemRepository = $outboundInvoiceItemRepository;
    }

    public function handle(
        ?User $auth_user,
        ?Enterprise $customer,
        ?OutboundInvoiceInterface $outbound_invoice,
        ?OutboundInvoiceInterface $outbound_invoice_output
    ) {
        $this->checkUser($auth_user);
        $this->checkCustomer($customer);
        $this->checkOutboundInvoice($outbound_invoice);
        $this->checkOutboundInvoice($outbound_invoice_output);

        $invoice_parameter = $this->invoiceParameterRepository
            ->getActiveParameterInPeriod($customer, $outbound_invoice->getMonth());

        $this->checkParameter($invoice_parameter);

        $items = $this->outboundInvoiceItemRepository->getItemsOfOutboundInvoice($outbound_invoice);

        $fees = $this->feeRepository->getFeesOfOutboundInvoice($outbound_invoice);

        if (count($fees) > 0) {
            foreach ($fees as $fee) {
                $this->feeRepository->delete($fee);
            }
        }

        foreach ($items as $item) {
            if ($invoice_parameter->getDefaultManagementFeesByVendor() > 0) {
                $this->saved[] = $this
                    ->createDefaultManagementFeesByVendor(
                        $customer,
                        $item,
                        $invoice_parameter,
                        $outbound_invoice_output
                    );
            }

            if ($invoice_parameter->getCustomManagementFeesByVendor() > 0) {
                $tag = $this->enterpriseRepository->hasCustomManagementFeesTag(
                    $customer,
                    $item->getInboundInvoice()->enterprise
                );

                if ($tag) {
                    $this->saved[] = $this
                        ->createCustomManagementFeesByVendor(
                            $customer,
                            $item,
                            $invoice_parameter,
                            $outbound_invoice_output
                        );
                }
            }
        }

        if ($invoice_parameter->getFixedFeesByVendor() > 0) {
            $this->createFixedFees($customer, $outbound_invoice_output, $invoice_parameter);
        }

        if ($invoice_parameter->getSubscription() > 0) {
            $this->createSubscriptionFees($customer, $outbound_invoice_output, $invoice_parameter);
        }

        if ($invoice_parameter->getDiscount() > 0) {
            $this->createDiscount($customer, $outbound_invoice_output, $invoice_parameter);
        }

        $this->outboundInvoiceRepository->updateStatusTo(
            $outbound_invoice,
            OutboundInvoiceInterface::STATUS_FEES_CALCULATED
        );
        
        return $this->saved;
    }

    private function checkUser($auth_user)
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
        /*
        if (! $this->outboundInvoiceRepository->hasStatus($outboundInvoice, OutboundInvoiceInterface::STATUS_PENDING)) {
            throw new OutboundInvoiceIsNotInPendingStatusException();
        }
        */

        if ($this->outboundInvoiceRepository->isValidated($outbound_invoice)) {
            throw new OutboundInvoiceIsAlreadyValidatedException();
        }
    }

    public function checkParameter($invoice_parameter)
    {
        if (is_null($invoice_parameter)) {
            throw new InvoiceParametersNotInformedException();
        }
    }

    private function createDefaultManagementFeesByVendor($customer, $item, $invoice_parameter, $outbound_invoice)
    {
        $defaultFee = new Fee;
        $defaultFee->setCustomer($customer);
        $defaultFee->setNumber();
        $defaultFee->setAmountBeforeTaxes(
            $item->getAmountBeforeTaxes(),
            $invoice_parameter->getDefaultManagementFeesByVendor()
        );
        $defaultFee->setLabel($item->getLabel());
        $defaultFee->setItem($item);
        $defaultFee->setType(FeeInterface::DEFAULT_MANAGMENT_FEES_TYPE);
        $defaultFee->setVendor($item->getInboundInvoice()->enterprise);
        $defaultFee->setInvoice($outbound_invoice);
        $defaultFee->setInvoiceParameter($invoice_parameter);
        $defaultFee->setVatRate($this->vatRateRepository->findByValue(0.2));

        return $this->feeRepository->save($defaultFee);
    }

    private function createCustomManagementFeesByVendor($customer, $item, $invoice_parameter, $outbound_invoice)
    {
        $customFee = new Fee;
        $customFee->setCustomer($customer);
        $customFee->setNumber();
        $customFee->setAmountBeforeTaxes(
            $item->getAmountBeforeTaxes(),
            $invoice_parameter->getCustomManagementFeesByVendor()
        );
        $customFee->setLabel($item->getLabel());
        $customFee->setItem($item);
        $customFee->setType(FeeInterface::CUSTOM_MANAGMENT_FEES_TYPE);
        $customFee->setVendor($item->getInboundInvoice()->enterprise);
        $customFee->setInvoice($outbound_invoice);
        $customFee->setInvoiceParameter($invoice_parameter);
        $customFee->setVatRate($this->vatRateRepository->findByValue(0.2));

        return $this->feeRepository->save($customFee);
    }

    private function createFixedFees($customer, $outbound_invoice, $invoice_parameter)
    {
        $vendors = $this->enterpriseRepository->getActiveVendors($customer, $outbound_invoice->getMonth());

        foreach ($vendors as $vendor) {
            if (! $this->feeRepository->hasFixedFeesByVendorForPeriod(
                $customer,
                $vendor,
                $outbound_invoice->getMonth()
            )) {
                $fixedFee = new Fee;
                $fixedFee->setCustomer($customer);
                $fixedFee->setNumber();
                $fixedFee->setLabel($vendor->name);
                $fixedFee->setAmountBeforeTaxes(1, $invoice_parameter->getFixedFeesByVendor());
                $fixedFee->setType(FeeInterface::FIXED_FEES_TYPE);
                $fixedFee->setVendor($vendor);
                $fixedFee->setInvoice($outbound_invoice);
                $fixedFee->setInvoiceParameter($invoice_parameter);
                $fixedFee->setVatRate($this->vatRateRepository->findByValue(0.2));

                $this->saved[] = $this->feeRepository->save($fixedFee);
            }
        }
    }

    private function createSubscriptionFees($customer, $outbound_invoice, $invoice_parameter)
    {
        if (! $this->feeRepository->hasSubscriptionForPeriod(
            $customer,
            $outbound_invoice->getMonth()
        )) {
            $subscriptionFee = new Fee;
            $subscriptionFee->setCustomer($customer);
            $subscriptionFee->setNumber();
            $subscriptionFee->setLabel($customer->name);
            $subscriptionFee->setAmountBeforeTaxes(1, $invoice_parameter->getSubscription());
            $subscriptionFee->setType(FeeInterface::SUBSCRIPTION_TYPE);
            $subscriptionFee->setInvoice($outbound_invoice);
            $subscriptionFee->setInvoiceParameter($invoice_parameter);
            $subscriptionFee->setVatRate($this->vatRateRepository->findByValue(0.2));

            $this->saved[] = $this->feeRepository->save($subscriptionFee);
        }
    }

    private function createDiscount($customer, $outbound_invoice, $invoice_parameter)
    {
        $hasDiscount = $this->feeRepository->hasDiscountForPeriod($customer, $outbound_invoice->getMonth());
        if (! is_null($invoice_parameter->getDiscountStartsAt())
            && ! is_null($invoice_parameter->getDiscountEndsAt())) {
            $canUseDiscount = Carbon::parse($outbound_invoice->getInvoicedAt())
                ->between(
                    Carbon::parse($invoice_parameter->getDiscountStartsAt()),
                    Carbon::parse($invoice_parameter->getDiscountEndsAt())
                );

            if ($canUseDiscount && ! $hasDiscount) {
                $discountFee = new Fee;
                $discountFee->setCustomer($customer);
                $discountFee->setNumber();
                $discountFee->setLabel($customer->name);
                $discountFee->setAmountBeforeTaxes(-1, $invoice_parameter->getDiscount());
                $discountFee->setType(FeeInterface::DISCOUNT_TYPE);
                $discountFee->setInvoice($outbound_invoice);
                $discountFee->setInvoiceParameter($invoice_parameter);
                $discountFee->setVatRate($this->vatRateRepository->findByValue(0.2));

                $this->saved[] = $this->feeRepository->save($discountFee);
            }
        }
    }
}
