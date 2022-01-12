<?php

namespace App\Models\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractParty;
use App\Models\Addworking\Enterprise\Document;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ContractDocument extends Model implements Htmlable
{
    use HasUuid, Routable, Viewable;

    protected $table = "addworking_contract_contract_documents";

    protected $viewPrefix = "addworking.contract.contract_document";

    protected $routePrefix = "addworking.contract.contract_document";

    protected $fillable = [
        'validated_at',
        'rejected_at',
    ];

    protected $dates = [
        'validated_at',
        'rejected_at',
    ];

    public function __toString()
    {
        return (string) $this->document;
    }

    // ------------------------------------------------------------------------
    // Relationships

    public function contractParty()
    {
        return $this->belongsTo(ContractParty::class)->withDefault();
    }

    public function document()
    {
        return $this->belongsTo(Document::class)->withDefault();
    }

    // ------------------------------------------------------------------------
    // Scopes

    public function scopeWhereContractParty($query, ContractParty $party)
    {
        return $query->whereHas('contractParty', fn($q) => $q->whereId($party->id));
    }
}
