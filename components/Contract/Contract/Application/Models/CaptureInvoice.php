<?php

namespace Components\Contract\Contract\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Interfaces\Entities\CaptureInvoiceEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CaptureInvoice extends Model implements CaptureInvoiceEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "contract_capture_invoices";

    protected $fillable = [
        'short_id',
        'contract_number',
        'invoice_number',
        'amount_guaranteed_holdback',
        'deposit_guaranteed_holdback_number',
        'amount_good_end',
        'deposit_good_end_number',
        'invoice_amount_before_taxes',
        'invoice_amount_of_taxes',
        'invoiced_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'invoiced_at',
    ];

    ////////////////////////////////////////////////
    /// Relationships                           ///
    ///////////////////////////////////////////////

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id')->withDefault();
    }

    public function customer()
    {
        return $this->belongsTo(Enterprise::class, 'customer_id')->withDefault();
    }

    public function vendor()
    {
        return $this->belongsTo(Enterprise::class, 'vendor_id')->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    ////////////////////////////////////////////////
    /// Setters                                 ///
    ///////////////////////////////////////////////

    public function setCustomer($value)
    {
        $this->customer()->associate($value);
    }

    public function setCreatedBy($value)
    {
        $this->createdBy()->associate($value);
    }

    public function setContract($value)
    {
        $this->contract()->associate($value);
    }

    public function setVendor($value)
    {
        $this->vendor()->associate($value);
    }

    public function setShortId()
    {
        $this->short_id = 1 + (int) self::withTrashed()->get()->max('short_id');
    }

    public function setInvoiceNumber($value)
    {
        $this->invoice_number = $value;
    }

    public function setContractNumber($value)
    {
        $this->contract_number = $value;
    }

    public function setInvoicedAt($value)
    {
        $this->invoiced_at = $value;
    }

    public function setDepositGuaranteedHoldbackNumber($value)
    {
        $this->deposit_guaranteed_holdback_number = $value;
    }

    public function setDepositGoodEndNumber($value)
    {
        $this->deposit_good_end_number = $value;
    }

    public function setInvoiceAmountBeforeTaxes($value)
    {
        $this->invoice_amount_before_taxes = $value;
    }

    public function setInvoiceAmountOfTaxes($value)
    {
        $this->invoice_amount_of_taxes = $value;
    }

    public function setAmountGuaranteedHoldback($value)
    {
        $this->amount_guaranteed_holdback = $value;
    }

    public function setAmountGoodEnd($value)
    {
        $this->amount_good_end = $value;
    }

    ////////////////////////////////////////////////
    /// Getters                                 ///
    ///////////////////////////////////////////////

    public function getAmountGuaranteedHoldback()
    {
        return $this->amount_guaranteed_holdback;
    }

    public function getAmountGoodEnd()
    {
        return $this->amount_good_end;
    }

    public function getDepositGuaranteedHoldbackNumber()
    {
        return $this->deposit_guaranteed_holdback_number;
    }

    public function getDepositGoodEndNumber()
    {
        return $this->deposit_good_end_number;
    }

    public function getInvoiceAmountBeforeTaxes()
    {
        return $this->invoice_amount_before_taxes;
    }

    public function getInvoiceAmountOfTaxes()
    {
        return $this->invoice_amount_of_taxes;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getInvoiceNumber()
    {
        return $this->invoice_number;
    }

    public function getContract()
    {
        return $this->contract()->first();
    }

    public function getInvoicedAt()
    {
        return $this->invoiced_at;
    }

    public function getContractNumber()
    {
        return $this->contract_number;
    }
}
