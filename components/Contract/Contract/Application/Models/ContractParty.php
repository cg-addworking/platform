<?php

namespace Components\Contract\Contract\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Model\Application\Models\ContractModelParty;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ContractParty extends Model implements ContractPartyEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "addworking_contract_contract_parties";

    protected $fillable = [
        'number',
        'denomination',
        'order',
        'enterprise_name',
        'user_name',
        'signed',
        'signed_at',
        'declined',
        'declined_at',
        'yousign_member_id',
        'yousign_file_object_id',
        'signature_position',
        'is_validator',
        'validated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'signed_at',
        'validated_at',
        'declined_at',
        'declined_at',
    ];

    protected $attributes = [
        'signed' => false,
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id')->withDefault();
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id')->withDefault();
    }

    public function contractModelParty()
    {
        return $this->belongsTo(ContractModelParty::class, 'contract_model_party_id')->withDefault();
    }

    public function signatory()
    {
        return $this->belongsTo(User::class, 'signatory_id')->withDefault();
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setContract(ContractEntityInterface $contract)
    {
        $this->contract()->associate($contract);
    }

    public function setEnterprise(Enterprise $enterprise)
    {
        $this->enterprise()->associate($enterprise);
    }

    public function setContractModelParty(ContractModelPartyEntityInterface $contractModelParty)
    {
        $this->contractModelParty()->associate($contractModelParty);
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
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setEnterpriseName(string $name)
    {
        $this->enterprise_name = $name;
    }

    public function setSignatory(?User $signatory)
    {
        $this->signatory()->associate($signatory);
    }

    public function setSignatoryName(?string $name)
    {
        $this->signatory_name = $name;
    }

    public function setSignedAt(?string $date)
    {
        $this->signed_at = $date;
    }

    public function setDeclinedAt(?string $date): void
    {
        $this->declined_at = $date;
    }

    public function setYousignMemberId(?string $id): void
    {
        $this->yousign_member_id = $id;
    }

    public function setYousignFileObjectId(?string $id): void
    {
        $this->yousign_file_object_id = $id;
    }
    
    public function setSignaturePosition(?string $position): void
    {
        $this->signature_position = $position;
    }

    public function setIsValidator(bool $is_validator): void
    {
        $this->is_validator = $is_validator;
    }

    public function setValidatedAt($validated_at): void
    {
        $this->validated_at = $validated_at;
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------

    public function getEnterprise(): ?Enterprise
    {
        return $this->enterprise()->first();
    }

    public function getContract(): ?ContractEntityInterface
    {
        return $this->contract()->first();
    }

    public function getContractModelParty(): ?ContractModelPartyEntityInterface
    {
        return $this->contractModelParty()->first();
    }

    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    public function getSignatory(): ?User
    {
        return $this->signatory()->first();
    }

    public function getDenomination(): string
    {
        return $this->denomination;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function getEnterpriseName(): string
    {
        return $this->enterprise_name;
    }

    public function getSignatoryName(): string
    {
        return $this->signatory_name;
    }

    public function getSignedAt()
    {
        return $this->signed_at;
    }

    public function getDeclinedAt()
    {
        return $this->declined_at;
    }

    public function getYousignMemberId(): ?string
    {
        return $this->yousign_member_id;
    }

    public function getYousignFileObjectId(): ?string
    {
        return $this->yousign_file_object_id;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function getSignaturePosition(): ?string
    {
        return $this->signature_position;
    }

    public function getIsValidator(): bool
    {
        return $this->is_validator;
    }

    public function getValidatedAt()
    {
        return $this->validated_at;
    }
}
