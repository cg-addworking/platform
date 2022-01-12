<?php

namespace Components\Sogetrel\Passwork\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Sogetrel\Contract\Type as ContractType;
use Components\Sogetrel\Passwork\Domain\Interfaces\Entities\AcceptationContractTypeEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AcceptationContractType extends Model implements AcceptationContractTypeEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "sogetrel_user_passwork_acceptation_has_contract_types";

    protected $fillable = [
        'number',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function acceptation()
    {
        return $this->belongsTo(Acceptation::class, 'passwork_acceptation_id')->withDefault();
    }

    public function contractType()
    {
        return $this->belongsTo(ContractType::class, 'contract_type_id')->withDefault();
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setNumber(): void
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    //
    public function setAcceptation(Acceptation $acceptation)
    {
        $this->acceptation()->associate($acceptation);
    }

    public function setContractType(ContractType $contract_type)
    {
        $this->contractType()->associate($contract_type);
    }
}
