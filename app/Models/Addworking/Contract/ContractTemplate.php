<?php

namespace App\Models\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Models\Addworking\Contract\ContractTemplateAnnex;
use App\Models\Addworking\Contract\ContractTemplateParty;
use App\Models\Addworking\Contract\ContractTemplateVariable;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractTemplate extends Model implements Htmlable
{
    use HasUuid, Routable, Viewable, SoftDeletes;

    protected $table = "addworking_contract_contract_models";

    protected $viewPrefix = "addworking.contract.contract_template";

    protected $routePrefix = "addworking.contract.contract_template";

    protected $fillable = [
        'name',
        'display_name',
        'markdown',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function __toString()
    {
        return $this->display_name ?? 'n/a';
    }

    // ------------------------------------------------------------------------
    // Relationships

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function contractTemplateAnnexes()
    {
        return $this->hasMany(ContractTemplateAnnex::class);
    }

    public function contractTemplateParties()
    {
        return $this->hasMany(ContractTemplateParty::class, 'contract_model_id');
    }

    public function contractTemplateVariables()
    {
        return $this->hasMany(ContractTemplateVariable::class, 'model_id');
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    // ------------------------------------------------------------------------
    // Scopes

    public function scopeWhereDisplayName($query, $display_name)
    {
        return $query->where('display_name', 'like', '%'.$display_name.'%');
    }

    public function scopeOfEnterprise($query, Enterprise $enterprise)
    {
        return $query->whereHas('enterprise', fn($q) => $q->whereId($enterprise->id));
    }
}
