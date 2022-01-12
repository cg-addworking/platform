<?php

namespace App\Models\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Models\Addworking\Contract\ContractTemplateVariable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ContractVariable extends Model implements Htmlable
{
    use HasUuid, Viewable, Routable;

    protected $table = "addworking_contract_contract_variables";

    protected $viewPrefix = "addworking.contract.contract_variable";

    protected $routePrefix = "addworking.contract.contract_variable";

    protected $fillable = [
        'value',
    ];

    public function __toString()
    {
        return (string) $this->variable;
    }

    // ------------------------------------------------------------------------
    // Relationships

    public function contract()
    {
        return $this->belongsTo(Contract::class)->withDefault();
    }

    public function contractTemplateVariable()
    {
        return $this
            ->belongsTo(ContractTemplateVariable::class, 'contract_model_variable_id')
            ->withDefault();
    }
}
