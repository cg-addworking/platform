<?php
namespace Components\Billing\PaymentOrder\Application\Models;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use App\Helpers\HasUuid;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use App\Models\Addworking\User\User;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\PaymentOrder\Domain\Classes\PaymentOrderInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentOrder extends Model implements PaymentOrderInterface
{
    use HasUuid,
        SoftDeletes,
        Routable;

    protected $table = "addworking_billing_payment_orders";

    protected $routePrefix = "addworking.billing.payment_order";

    protected $routeParameterAliases = [
        "outbound-invoice" => "outboundInvoice"
    ];

    protected $fillable = [
        'status',
        'customer_name',
        'bank_reference_payment',
        'executed_at',
        'number',
    ];

    protected $casts = [
        'number' => 'integer',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'executed_at',
    ];

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function outboundInvoice()
    {
        return $this->belongsTo(OutboundInvoice::class)->withDefault();
    }

    public function iban()
    {
        return $this->belongsTo(Iban::class)->withDefault();
    }

    public function file()
    {
        return $this->belongsTo(File::class)->withDefault();
    }

    public function items()
    {
        return $this->hasMany(PaymentOrderItem::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function setExecutedAt(string $date)
    {
        $this->executed_at = $date;
    }

    public function setCustomerName(string $name)
    {
        $this->customer_name = $name;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function setIban(string $id)
    {
        $this->iban()->associate($id);
    }

    public function setOutboundInvoice(string $id)
    {
        $this->outboundInvoice()->associate($id);
    }

    public function setEnterprise($id)
    {
        $this->enterprise()->associate($id);
    }

    public function setNumber()
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setDebtorName(string $name)
    {
        $this->debtor_name = $name;
    }

    public function setDebtorIban(string $iban)
    {
        $this->debtor_iban = $iban;
    }

    public function setDebtorBic(string $bic)
    {
        $this->debtor_bic = $bic;
    }

    public function setBankReferencePayment(?string $reference)
    {
        $this->bank_reference_payment = $reference;
    }

    public function setCreatedBy(string $id)
    {
        $this->createdBy()->associate($id);
    }

    public function setFile(string $id)
    {
        $this->file()->associate($id);
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCustomerName(): ?string
    {
        return $this->customer_name;
    }

    public function getExecutedAt()
    {
        return $this->executed_at;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    public function getIban()
    {
        return $this->iban()->first();
    }

    public function getEnterprise()
    {
        return $this->enterprise()->first();
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getBankReferencePayment(): ?string
    {
        return $this->bank_reference_payment;
    }
    
    public function getDebtorName()
    {
        return $this->debtor_name;
    }

    public function getDebtorIban()
    {
        return $this->debtor_iban;
    }

    public function getDebtorBic()
    {
        return $this->debtor_bic;
    }

    public function getFile()
    {
        return $this->file()->first();
    }

    public function getItems()
    {
        return $this->items()->get();
    }

    public function getOutboundInvoice()
    {
        return $this->outboundInvoice()->first();
    }

    public function getTotalAmount(): float
    {
        return $this->getItems()->reduce(function ($carry, PaymentOrderItem $item) {
            return $carry + $item->getAmount();
        }, 0);
    }

    public function getReference(): string
    {
        $number = str_pad($this->getNumber(), 6, "0", STR_PAD_LEFT);
        $exection_date = is_null($this->getExecutedAt()) ? "XXXXXXXX" : $this->getExecutedAt()->format('Ymd');
        $iban = substr($this->getDebtorIban(), -5);
        $items = str_pad($this->getItems()->count(), 6, "0", STR_PAD_LEFT);
        return $number. "-" . $exection_date . "-" . $iban . "-" . $items;
    }
}
