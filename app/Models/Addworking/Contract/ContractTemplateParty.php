<?php

namespace App\Models\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Contract\ContractTemplatePartyDocumentType;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ContractTemplateParty extends Model implements Htmlable
{
    use HasUuid, Viewable, Routable;

    protected $table = "addworking_contract_contract_model_parties";

    protected $viewPrefix = "addworking.contract.contract_template_party";

    protected $routePrefix = "addworking.contract.contract_template_party";

    protected $fillable = [
        'denomination',
        'order',
    ];

    protected $casts = [
        'order' => "integer",
    ];

    public function __toString()
    {
        return $this->denomination ?? 'n/a';
    }

    // ------------------------------------------------------------------------
    // Relationships

    public function contractTemplate()
    {
        return $this->belongsTo(ContractTemplate::class)->withDefault();
    }

    public function contractTemplatePartyDocumentTypes()
    {
        return $this->hasMany(ContractTemplatePartyDocumentType::class);
    }
}
