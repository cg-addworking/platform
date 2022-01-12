<?php

namespace Components\Contract\Model\Application\Models;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\File;
use Components\Contract\Contract\Application\Models\ContractPart;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContractModelPart extends Model implements ContractModelPartEntityInterface
{
    use HasUuid;

    protected $table = "addworking_contract_contract_model_parts";

    protected $fillable = [
        'name',
        'display_name',
        'text',
        'is_initialled',
        'is_signed',
        'should_compile',
        'order',
        'number',
        'signature_page',
        'signature_mention',
        'sign_on_last_page',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $attributes = [
        'is_initialled'  => false,
        'is_signed'      => false,
        'should_compile' => false,
        'sign_on_last_page' => false,
        'signature_mention' => 'Lu et approuvé',
        'signature_page' => 1,
    ];

    protected $cast = [
        'sign_on_last_page' => 'boolean',
    ];

    protected $with = [
        'variables',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function contractModel()
    {
        return $this->belongsTo(ContractModel::class, 'contract_model_id')->withDefault();
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id')->withDefault();
    }

    public function variables()
    {
        return $this->hasMany(ContractModelVariable::class, 'model_part_id');
    }

    public function contractParts()
    {
        return $this->hasMany(ContractPart::class, 'contract_model_part_id');
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setDisplayName(string $display_name)
    {
        $this->display_name = $display_name;
    }

    public function setName(string $display_name)
    {
        $this->name = Str::slug($display_name);
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function setContractModel(ContractModelEntityInterface $contract_model)
    {
        $this->contractModel()->associate($contract_model);
    }

    public function setOrder(int $order)
    {
        $this->order = $order;
    }

    public function setIsInitialled(bool $is_initialled)
    {
        $this->is_initialled = $is_initialled;
    }

    public function setIsSigned(bool $is_signed)
    {
        $this->is_signed = $is_signed;
    }

    public function setShouldCompile(bool $should_compile)
    {
        $this->should_compile = $should_compile;
    }

    public function setFile(File $file)
    {
        $this->file()->associate($file);
    }

    public function setNumber()
    {
        $this->number = 1 + (int) self::all()->max('number');
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
        if (! $this->exists) {
            throw new \RuntimeException("this contract piece doesn't exists");
        }

        return $this->id;
    }

    public function getDisplayName(): ?string
    {
        return $this->display_name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getText(): ?string
    {
        return !is_null($this->text) ? $this->text : $this->getFile()->content;
    }

    public function getContractModel(): ?ContractModelEntityInterface
    {
        return $this->contractModel()->first();
    }

    public function getOrder(): ?int
    {
        return $this->order;
    }

    public function getIsInitialled(): bool
    {
        return $this->is_initialled;
    }

    public function getIsSigned(): bool
    {
        return $this->is_signed;
    }

    public function getShouldCompile(): bool
    {
        return $this->should_compile;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getFile()
    {
        return $this->file()->first();
    }

    public function getVariables()
    {
        return $this->variables()->orderBy('order', 'asc')->get();
    }

    public function getContractParts()
    {
        return $this->contractParts()->get();
    }

    public function setSignaturePage(?int $page): void
    {
        $this->signature_page = $page;
    }

    public function setSignatureMention(?string $mention): void
    {
        $this->signature_mention = $mention;
    }

    public function getSignaturePage(): ?int
    {
        return $this->signature_page;
    }

    public function getSignatureMention(): ?string
    {
        return $this->signature_mention;
    }

    public function getSignOnLastPage(): bool
    {
        return $this->sign_on_last_page;
    }
}
