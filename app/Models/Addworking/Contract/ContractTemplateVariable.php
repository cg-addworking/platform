<?php

namespace App\Models\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ContractTemplateVariable extends Model implements Htmlable
{
    use HasUuid, Viewable, Routable;

    protected $table = "addworking_contract_contract_model_variables";

    protected $viewPrefix = "addworking.contract.contract_template_variable";

    protected $routePrefix = "addworking.contract.contract_template_variable";

    protected $fillable = [
        'name',
        'description',
        'default_value',
        'required',
    ];

    protected $casts = [
        'required' => "boolean",
    ];

    public function __toString()
    {
        return $this->name ?? 'n/a';
    }

    // ------------------------------------------------------------------------
    // Relationships

    public function contractTemplate()
    {
        return $this->belongsTo(ContractTemplate::class)->withDefault();
    }
}
