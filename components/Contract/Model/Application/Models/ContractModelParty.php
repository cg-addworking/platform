<?php

namespace Components\Contract\Model\Application\Models;

use App\Helpers\HasUuid;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;
use Illuminate\Database\Eloquent\Model;

class ContractModelParty extends Model implements ContractModelPartyEntityInterface
{
    use HasUuid;

    protected $table = "addworking_contract_contract_model_parties";

    protected $fillable = [
        'denomination',
        'order',
        'number',
        'signature_position',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $with = [
        'partyDocumentTypes',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function contractModel()
    {
        return $this->belongsTo(ContractModel::class, 'contract_model_id')->withDefault();
    }

    public function variables()
    {
        return $this->hasMany(ContractModelVariable::class, 'model_party_id');
    }

    public function partyDocumentTypes()
    {
        return $this->hasMany(ContractModelDocumentType::class, 'contract_model_party_id');
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setContractModel(ContractModelEntityInterface $contract_model)
    {
        $this->contractModel()->associate($contract_model);
    }

    public function setDenomination(string $denomination)
    {
        $this->denomination = $denomination;
    }

    public function setOrder(int $order)
    {
        $this->order = $order;
    }

    public function setNumber()
    {
        $this->number = 1 + (int) self::all()->max('number');
    }

    public function setSignaturePosition(?string $position): void
    {
        $this->signature_position = $position;
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getPartyDocumentTypes()
    {
        return $this->partyDocumentTypes()->get();
    }

    public function getDenomination(): string
    {
        return $this->denomination;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getContractModel(): ?ContractModelEntityInterface
    {
        return $this->contractModel()->first();
    }

    public function getVariables()
    {
        return $this->variables()->orderBy('order', 'asc')->get();
    }

    public function getSignaturePosition(): ?string
    {
        return $this->signature_position;
    }
}
