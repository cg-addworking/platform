<?php

namespace Components\Contract\Contract\Domain\Interfaces\Entities;

interface CaptureInvoiceEntityInterface
{
    ////////////////////////////////////////////////
    /// Setters                                 ///
    ///////////////////////////////////////////////

    public function setCustomer($value);
    public function setCreatedBy($value);
    public function setContract($value);
    public function setVendor($value);
    public function setShortId();
    public function setInvoiceNumber($value);
    public function setContractNumber($value);
    public function setInvoicedAt($value);
    public function setDepositGuaranteedHoldbackNumber($value);
    public function setDepositGoodEndNumber($value);
    public function setInvoiceAmountBeforeTaxes($value);
    public function setInvoiceAmountOfTaxes($value);
    public function setAmountGuaranteedHoldback($value);
    public function setAmountGoodEnd($value);

    ////////////////////////////////////////////////
    /// Getters                                 ///
    ///////////////////////////////////////////////

    public function getAmountGuaranteedHoldback();
    public function getAmountGoodEnd();
    public function getDepositGuaranteedHoldbackNumber();
    public function getDepositGoodEndNumber();
    public function getInvoiceAmountBeforeTaxes();
    public function getInvoiceAmountOfTaxes();
    public function getId();
    public function getInvoiceNumber();
    public function getContract();
    public function getInvoicedAt();
    public function getContractNumber();
}
