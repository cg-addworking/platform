<?php

namespace Components\Enterprise\DocumentTypeModel\Application\Models;

use App\Helpers\HasUuid;
use Components\Enterprise\DocumentTypeModel\Domain\Entities\DocumentTypeModelVariableEntityInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DocumentTypeModelVariable extends Model implements DocumentTypeModelVariableEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "addworking_enterprise_document_type_model_variables";

    protected $fillable = [
        'short_id',
        'name',
        'display_name',
        'description',
        'default_value',
        'required',
        'input_type',
        'options',
    ];

    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'required'   => 'boolean',
        'options'    => 'array',
    ];

    protected $attributes = [
        'required' => true,
        'input_type' => DocumentTypeModelVariableEntityInterface::INPUT_TYPE_TEXT,
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function documentTypeModel()
    {
        return $this->belongsTo(DocumentTypeModel::class, 'document_type_model_id')->withDefault();
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setDocumentTypeModel($document_type_model): void
    {
        $this->documentTypeModel()->associate($document_type_model);
    }

    public function setDisplayName(string $display_name): void
    {
        $this->display_name = $display_name;
    }

    public function setName(string $display_name): void
    {
        $this->name = Str::slug($display_name, '_');
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setShortId(): void
    {
        $query = 'SELECT max("aedtmv"."short_id") as "max_number"';
        $query .= ' FROM "public"."'.$this->table.'" AS "aedtmv"';

        $max = DB::select(DB::raw("$query"));
        $this->short_id = 1 + $max[0]->max_number;
    }

    public function setDefaultValue(?string $default_value): void
    {
        $this->default_value = $default_value;
    }

    public function setRequired(bool $required): void
    {
        $this->required = $required;
    }

    public function setInputType(string $input_type): void
    {
        $this->input_type = $input_type;
    }

    public function setOptions(?array $options): void
    {
        $this->options = $options;
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------

    public function getDocumentTypeModel(): ?DocumentTypeModel
    {
        return $this->documentTypeModel()->first();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDisplayName(): ?string
    {
        return $this->display_name;
    }

    public function getInputType()
    {
        return $this->input_type;
    }

    public function getDefaultValue()
    {
        return $this->default_value;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}
