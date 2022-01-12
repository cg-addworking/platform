<?php

namespace Components\Billing\PaymentOrder\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use App\Models\Addworking\User\User;
use Components\Billing\PaymentOrder\Domain\Classes\ReceivedPaymentInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivedPayment extends Model implements ReceivedPaymentInterface
{
    use HasUuid,
        SoftDeletes;

    protected $table = "addworking_billing_received_payments";

    protected $fillable = [
        'number',
        'bank_reference_payment',
        'iban',
        'bic',
        'amount',
        'received_at',
        'agicap_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'received_at'
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function iban()
    {
        return $this->belongsTo(Iban::class)->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function receivedPaymentOutbound()
    {
        return $this->hasMany(ReceivedPaymentOutboundInvoice::class);
    }

    // ------------------------------------------------------------------------
    // Setters & Getters
    // ------------------------------------------------------------------------

    public function setEnterprise($enterprise)
    {
        $this->enterprise()->associate($enterprise);
    }

    public function setIban($iban)
    {
        $this->iban()->associate($iban);
    }

    public function setCreatedBy($user)
    {
        $this->createdBy()->associate($user);
    }

    public function setNumber()
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setBankReferencePayment(string $reference)
    {
        $this->bank_reference_payment = $reference;
    }

    public function setIbanReference(string $iban)
    {
        $this->iban = $iban;
    }

    public function setBicReference(string $bic)
    {
        $this->bic = $bic;
    }

    public function setAmount(float $amount)
    {
        $this->amount = $amount;
    }

    public function setReceivedAt(string $date)
    {
        $this->received_at = $date;
    }

    public function setAgicapId(string $agicap_id)
    {
        $this->agicap_id = $agicap_id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getEnterprise()
    {
        return $this->enterprise()->first();
    }

    public function getIban()
    {
        return $this->iban()->first();
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getBankReferencePayment(): ?string
    {
        return $this->bank_reference_payment;
    }

    public function getIbanReference(): ?string
    {
        return $this->iban;
    }

    public function getBicReference(): ?string
    {
        return $this->bic;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function getReceivedAt()
    {
        return $this->received_at;
    }

    public function getAgicapId(): ?string
    {
        return $this->agicap_id;
    }

    public function getDeletedAt()
    {
        return $this->deleted_at;
    }
}
