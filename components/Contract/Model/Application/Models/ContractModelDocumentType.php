<?php

namespace Components\Contract\Model\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\User\User;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelDocumentTypeEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;
use Illuminate\Database\Eloquent\Model;

class ContractModelDocumentType extends Model implements ContractModelDocumentTypeEntityInterface
{
    use HasUuid;

    protected $table = 'addworking_contract_contract_model_party_document_types';

    protected $fillable = [
        'number',
        'validation_required',
        'name',
        'display_name',
        'description',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id')->withDefault();
    }

    public function documentModel()
    {
        return $this->belongsTo(File::class, 'document_model_id')->withDefault();
    }

    public function contractModelParty()
    {
        return $this->belongsTo(ContractModelParty::class, 'contract_model_party_id')->withDefault();
    }

    public function validatedBy()
    {
        return $this->belongsTo(User::class, 'validated_by')->withDefault();
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------

    public function setContractModelParty(ContractModelPartyEntityInterface $contract_model_party)
    {
        $this->contractModelParty()->associate($contract_model_party);
    }

    public function setDocumentType($document_type)
    {
        $this->documentType()->associate($document_type);
    }

    public function setDocumentModel($document_model)
    {
        $this->documentModel()->associate($document_model);
    }

    public function setNumber()
    {
        $this->number = 1 + (int) self::all()->max('number');
    }

    public function setValidationRequired(bool $is_validation_required)
    {
        $this->validation_required = $is_validation_required;
    }

    public function setName(string $display_name)
    {
        $this->name = str_slug($display_name, '_');
    }

    public function setDisplayName(string $display_name)
    {
        $this->display_name = $display_name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    
    public function getNumber(): int
    {
        return $this->number;
    }

    public function getValidationRequired(): ?bool
    {
        return $this->validation_required;
    }

    public function getValidatedBy(): ?User
    {
        return $this->validatedBy()->first();
    }

    public function getContractModelParty(): ?ContractModelPartyEntityInterface
    {
        return $this->contractModelParty()->first();
    }

    public function getDocumentType(): ?DocumentType
    {
        return $this->documentType()->first();
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getDisplayName(): ?string
    {
        return $this->display_name;
    }

    public function getDocumentModel()
    {
        return $this->documentModel()->first();
    }
}
