<?php

namespace App\Models\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Models\Addworking\Contract\ContractTemplateParty;
use App\Models\Addworking\Enterprise\DocumentType;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ContractTemplatePartyDocumentType extends Model implements Htmlable
{
    use HasUuid, Routable, Viewable;

    protected $table = "addworking_contract_contract_model_party_document_types";

    protected $viewPrefix = "addworking.contract.contract_template_party_document_type";

    protected $routePrefix = "addworking.contract.contract_template_party_document_type";

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
        return (string) $this->document_type;
    }

    // ------------------------------------------------------------------------
    // Relationships

    public function contractTemplateParty()
    {
        return $this->belongsTo(ContractTemplateParty::class, 'contract_model_party_id')->withDefault();
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class)->withDefault();
    }

    public function validatedBy()
    {
        return $this->belongsTo(ContractTemplateParty::class, 'validated_by')->withDefault();
    }
}
