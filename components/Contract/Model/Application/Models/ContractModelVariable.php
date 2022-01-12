<?php

namespace Components\Contract\Model\Application\Models;

use App\Helpers\HasUuid;

use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelVariableEntityInterface;
use Illuminate\Database\Eloquent\Model;

class ContractModelVariable extends Model implements ContractModelVariableEntityInterface
{
    use HasUuid;

    protected $table = "addworking_contract_contract_model_variables";

    protected $fillable = [
        'name',
        'description',
        'default_value',
        'required',
        'number',
        'input_type',
        'display_name',
        'options',
        'order'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'required' => true,
        'input_type' => ContractModelVariable::INPUT_TYPE_TEXT,
    ];

    protected $casts = [
        'options' => 'array'
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function contractModel()
    {
        return $this->belongsTo(ContractModel::class, 'model_id')->withDefault();
    }

    public function contractModelParty()
    {
        return $this->belongsTo(ContractModelParty::class, 'model_party_id')->withDefault();
    }

    public function contractModelPart()
    {
        return $this->belongsTo(ContractModelPart::class, 'model_part_id')->withDefault()->orderBy('order');
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDisplayName(): ?string
    {
        return $this->display_name;
    }

    public function getContractModelParty(): ?ContractModelPartyEntityInterface
    {
        return $this->contractModelParty()->first();
    }

    public function getContractModelPart()
    {
        return $this->contractModelPart()->first();
    }

    public function getDefaultValue(): ?string
    {
        return $this->default_value;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getRequired(): bool
    {
        return $this->required;
    }

    public function getIsExportable(): bool
    {
        return $this->is_exportable;
    }

    public function getInputType(): string
    {
        return $this->input_type;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setContractModel(ContractModelEntityInterface $contract_model)
    {
        $this->contractModel()->associate($contract_model);
    }

    public function setContractModelPart(ContractModelPartEntityInterface $contract_model_part)
    {
        $this->contractModelPart()->associate($contract_model_part);
    }

    public function removeContractModelPart(ContractModelPartEntityInterface $contract_model_part)
    {
        $this->contractModelPart()->dissociate($contract_model_part);
    }

    public function setContractModelParty(ContractModelPartyEntityInterface $contract_model_party)
    {
        $this->contractModelParty()->associate($contract_model_party);
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setNumber()
    {
        $this->number = 1 + (int) self::all()->max('number');
    }

    public function setDisplayName(?string $display_name)
    {
        $this->display_name = $display_name;
    }

    public function setDescription(?string $description)
    {
        $this->description = $description;
    }

    public function setDefaultValue(?string $default_value)
    {
        $this->default_value = $default_value;
    }

    public function setRequired(bool $required)
    {
        $this->required = $required;
    }

    public function setIsExportable(bool $is_exportable)
    {
        return $this->is_exportable = $is_exportable;
    }

    public function setInputType(string $input_type)
    {
        $this->input_type = $input_type;
    }

    public function setOrder(int $order): void
    {
        $this->order = $order;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }
}
