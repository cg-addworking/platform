<?php

namespace App\Models\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractPartyDocumentType;
use App\Models\Addworking\Contract\ContractTemplateParty;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Models\Concerns\HasNumber;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractParty extends Model implements Htmlable
{
    use HasUuid, Routable, Viewable, SoftDeletes, HasNumber;

    protected $with = ['enterprise'];

    protected $table = "addworking_contract_contract_parties";

    protected $viewPrefix = "addworking.contract.contract_party";

    protected $routePrefix = "addworking.contract.contract_party";

    protected $fillable = [
        'denomination',
        'order',
        'enterprise_name',
        'signatory_name',
        'signed',
        'signed_at',
        'declined',
        'declined_at',
    ];

    protected $dates = [
        'signed_at',
        'declined_at',
        'deleted_at',
    ];

    protected $casts = [
        'order' => "integer",
        'signed' => "boolean",
        'declined' => "boolean",
    ];

    public function __toString()
    {
        return $this->denomination ?? 'n/a';
    }

    // ------------------------------------------------------------------------
    // Relationships

    public function contract()
    {
        return $this->belongsTo(Contract::class)->withDefault();
    }

    public function contractPartyDocumentTypes()
    {
        return $this->hasMany(ContractPartyDocumentType::class);
    }

    public function contractTemplateParty()
    {
        return $this->belongsTo(ContractTemplateParty::class, 'contract_model_party_id')->withDefault();
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'signatory_id')->withDefault();
    }

    // ------------------------------------------------------------------------
    // Scopes

    public function scopeOfContract($query, Contract $contract)
    {
        return $query->whereHas('contract', fn($q) => $q->whereId($contract->id));
    }

    public function scopeWhereEnterprise($query, Enterprise $enterprise)
    {
        return $query->whereHas('enterprise', fn($q) => $q->whereId($enterprise->id));
    }

    public function scopeWhereCustomer($query)
    {
        return $query->whereHas('enterprise', fn($q) => $q->whereIsCustomer());
    }

    public function scopeWhereVendor($query)
    {
        return $query->whereHas('enterprise', fn($q) => $q->whereIsVendor());
    }

    // ------------------------------------------------------------------------
    // Attributes

    public function getNameAttribute(): string
    {
        return (string) $this->denomination;
    }

    public function setOrderAttribute($value)
    {
        if ($value < 0) {
            throw new \InvalidArgumentException("order cannot be negative");
        }

        $this->attributes['order'] = (int) $value;
    }

    // ------------------------------------------------------------------------
    // Miscelaneous

    public function hasSigned(): bool
    {
        return $this->signed;
    }

    public function hasDeclined(): bool
    {
        return $this->declined;
    }

    public function needsSignatory()
    {
        return ! $this->hasSigned()
            && ! $this->hasDeclined()
            && ! $this->user()->exists();
    }

    public function needsToSign(): bool
    {
        if ($this->needsSignatory() ||
            $this->hasSigned() ||
            $this->hasDeclined()
        ) {
            return false;
        }

        if ($this->order == 1) {
            return true;
        }

        // did all previous parties have signed?
        return $this->contract
            ->contractParties()
            ->where('order', '<', $this->order)
            ->get()
            ->every(fn($party) => $party->hasSigned());
    }

    public function isWaitingToSign(): bool
    {
        return ! $this->hasSigned()
            && ! $this->hasDeclined()
            && ! $this->needsToSign();
    }
}
