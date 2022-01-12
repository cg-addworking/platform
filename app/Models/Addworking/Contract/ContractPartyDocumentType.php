<?php

namespace App\Models\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Models\Addworking\Contract\ContractParty;
use App\Models\Addworking\Enterprise\DocumentType;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ContractPartyDocumentType extends Model implements Htmlable
{
    use HasUuid, Routable, Viewable;

    protected $table = "addworking_contract_contract_party_document_types";

    protected $viewPrefix = "addworking.contract.contract_party_document_type";

    protected $routePrefix = "addworking.contract.contract_party_document_type";

    protected $routeParameterAliases = [
        'document_type' => "ContractTemplatePartyDocumentType",
    ];

    protected $fillable = [
        'mandatory',
        'validation_required',
    ];

    protected $casts = [
        'mandatory' => "boolean",
        'validation_required' => "boolean",
    ];

    public function __toString()
    {
        return (string) $this->documentType;
    }

    // ------------------------------------------------------------------------
    // Relationships

    public function contractParty()
    {
        return $this->belongsTo(ContractParty::class)->withDefault();
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class)->withDefault();
    }

    // ------------------------------------------------------------------------
    // Scopes

    public function scopeWhereContractParty($query, ContractParty $contract_party)
    {
        return $query->whereHas('contractParty', fn($q) => $q->whereId($contract_party->id));
    }

    public function scopeWhereDocumentType($query, DocumentType $document_type)
    {
        return $query->whereHas('documentType', fn($q) => $q->whereId($document_type->id));
    }
}
