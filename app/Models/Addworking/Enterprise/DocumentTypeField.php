<?php

namespace App\Models\Addworking\Enterprise;

use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use UnexpectedValueException;

class DocumentTypeField extends Model implements Htmlable
{
    use HasUuid, Viewable, Routable, SoftDeletes;

    const INPUT_TYPE_TEXT     = 'text';
    const INPUT_TYPE_DATE     = 'date';
    const INPUT_TYPE_TEXTAREA = 'textarea';

    protected $table = 'addworking_enterprise_document_type_fields';

    protected $fillable = [
        'name',
        'display_name',
        'help_text',
        'is_mandatory',
        'input_type',
    ];

    protected $casts = [
        'is_mandatory' => 'boolean',
    ];

    protected $attributes = [
        'is_mandatory' => false,
        'input_type'   => self::INPUT_TYPE_TEXT,
        'help_text'    => null,
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $routePrefix = "addworking.enterprise.document-type.field";

    protected $routeParameterAliases = [
        'field' => "document_type_field",
        'type'  => "document_type",
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'type_id');
    }

    public function documents()
    {
        return $this
            ->belongsToMany(
                Document::class,
                'addworking_enterprise_document_has_fields',
                'field_id',
                'document_id'
            )
            ->withPivot('content')
            ->whereNull('addworking_enterprise_document_has_fields.deleted_at')
            ->withTimestamps();
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function setInputTypeAttribute($value)
    {
        if (!is_null($value) && !in_array($value, self::getAvailableInputTypes())) {
            throw new UnexpectedValueException("Invalid input type");
        }

        $this->attributes['input_type'] = $value;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = snake_case(remove_accents($value));
    }

    public function getInputNameAttribute(): string
    {
        return "document_type_field.{$this->id}.content";
    }

    public function getValidationRuleAttribute(): array
    {
        $rule = ['string'];

        if ($this->input_type == self::INPUT_TYPE_DATE) {
            $rule = ['date'];
        }

        if ($this->isMandatory()) {
            $rule[] = 'required';
        }

        return [$this->input_name => $rule];
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeMandatory($query)
    {
        return $query->where('is_mandatory', true);
    }

    // ------------------------------------------------------------------------
    // Misc
    // ------------------------------------------------------------------------

    public function isMandatory(): bool
    {
        return $this->is_mandatory;
    }

    public static function fromName(string $name): self
    {
        return self::where(@compact('name'))->firstOrFail();
    }

    public static function getAvailableInputTypes()
    {
        return [
            self::INPUT_TYPE_TEXT,
            self::INPUT_TYPE_DATE,
            self::INPUT_TYPE_TEXTAREA,
        ];
    }
}
