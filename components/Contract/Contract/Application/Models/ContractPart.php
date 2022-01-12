<?php

namespace Components\Contract\Contract\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\File;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartEntityInterface;
use Components\Contract\Model\Application\Models\ContractModelPart;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContractPart extends Model implements ContractPartEntityInterface
{
    use HasUuid;

    protected $table = "addworking_contract_contract_parts";

    protected $fillable = [
        'name',
        'display_name',
        'order',
        'is_hidden',
        'number',
        'yousign_file_id',
        'signature_mention',
        'signature_page',
        'is_signed',
        'is_used_in_contract_body',
        'sign_on_last_page',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'is_hidden' => false,
        'is_signed' => false,
        'is_used_in_contract_body' => true,
        'sign_on_last_page' => false,
    ];

    protected $cast = [
        'is_used_in_contract_body' => 'boolean',
        'sign_on_last_page' => 'boolean',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id')->withDefault();
    }

    public function contractModelPart()
    {
        return $this->belongsTo(ContractModelPart::class, 'contract_model_part_id')->withDefault();
    }

    public function file()
    {
        return $this->belongsTo(File::class, "file_id")->withDefault();
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------

    public function setContract(ContractEntityInterface $contract): void
    {
        $this->contract()->associate($contract);
    }

    public function setContractModelPart(ContractModelPartEntityInterface $contract_model_part): void
    {
        $this->contractModelPart()->associate($contract_model_part);
    }

    public function setFile(File $file): void
    {
        $this->file()->associate($file);
    }

    public function setOrder(?int $order): void
    {
        $this->order = $order;
    }

    public function setDisplayName(?string $display_name): void
    {
        $this->display_name = $display_name;
    }

    public function setName(?string $display_name): void
    {
        $this->name = Str::slug($display_name);
    }

    public function setIsHidden(bool $bool): void
    {
        $this->is_hidden = $bool;
    }

    public function setNumber(): void
    {
        $this->number = 1 + (int) self::get()->max('number');
    }

    public function setYousignFileId(?string $id): void
    {
        $this->yousign_file_id = $id;
    }

    public function setSignaturePage(?int $page): void
    {
        $this->signature_page = $page;
    }

    public function setSignatureMention(?string $mention): void
    {
        $this->signature_mention = $mention;
    }

    public function setIsSigned(bool $is_signed)
    {
        $this->is_signed = $is_signed;
    }

    public function setIsUsedInContractBody(bool $is_used_in_contract_body): void
    {
        $this->is_used_in_contract_body = $is_used_in_contract_body;
    }

    public function setSignOnLastPage(bool $sign_on_last_page): void
    {
        $this->sign_on_last_page = $sign_on_last_page;
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------

    public function getId(): string
    {
        return $this->id;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getFile()
    {
        return $this->file()->first();
    }
    
    public function getContractModelPart()
    {
        return $this->contractModelPart()->first();
    }
    
    public function getContract()
    {
        return $this->contract()->first();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDisplayName(): string
    {
        return $this->display_name;
    }

    public function getIsHidden(): bool
    {
        return $this->is_hidden;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getYousignFileId(): ?string
    {
        return $this->yousign_file_id;
    }

    public function getSignedAt()
    {
        return $this->signed_at;
    }

    public function getSignaturePage(): ?int
    {
        return $this->signature_page;
    }

    public function getSignatureMention(): ?string
    {
        return $this->signature_mention;
    }

    public function getIsSigned(): bool
    {
        return $this->is_signed;
    }

    public function getIsUsedInContractBody(): bool
    {
        return $this->is_used_in_contract_body;
    }

    public function getSignOnLastPage(): bool
    {
        return $this->sign_on_last_page;
    }
}
