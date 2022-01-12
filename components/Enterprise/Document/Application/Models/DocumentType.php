<?php

namespace Components\Enterprise\Document\Application\Models;

use App\Models\Addworking\Enterprise\Enterprise;
use Carbon\Carbon;
use Components\Enterprise\Document\Domain\Exceptions\DocumentTypeIsNotFoundException;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentTypeEntityInterface;
use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\LegalForm;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Date;

class DocumentType extends Model implements DocumentTypeEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = 'addworking_enterprise_document_types';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'is_mandatory',
        'validity_period',
        'code',
        'type',
        'need_an_authenticity_check',
        'deadline_date',
    ];

    protected $casts = [
        'is_mandatory'    => 'boolean',
        'validity_period' => 'integer',
        'need_an_authenticity_check' => 'boolean',
        'created_at' => 'date',
        'updated_at' => 'date',
        'deleted_at' => 'date',
        'deadline_date' => 'date',
    ];

    protected $attributes = [
        'is_mandatory'    => false,
        'validity_period' => 365,
        'type'            => self::TYPE_LEGAL,
        'need_an_authenticity_check' => false,
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function documents()
    {
        return $this->hasMany(Document::class, 'type_id');
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id')->withDefault();
    }

    public function legalForms()
    {
        return $this->belongsToMany(
            LegalForm::class,
            'addworking_enterprise_document_types_has_legal_forms',
            'document_type_id',
            'legal_form_id'
        )->withTimestamps();
    }

    public function documentTypeModels()
    {
        return $this->hasMany(DocumentTypeModel::class, 'document_type_id');
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------
    public function getId(): string
    {
        if (! $this->exists) {
            throw new DocumentTypeIsNotFoundException($this);
        }

        return $this->id;
    }

    public function getDisplayName(): string
    {
        return $this->display_name;
    }

    public function getEnterprise()
    {
        return $this->enterprise()->first();
    }

    public function getDocumentTypeModels()
    {
        return $this->documentTypeModels()->get();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDeadlineDate()
    {
        return $this->deadline_date;
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setDisplayName(string $display_name): void
    {
        $this->display_name = $display_name;
    }

    public function setEnterprise(Enterprise $enterprise): void
    {
        $this->enterprise()->associate($enterprise);
    }

    public function setDocumentTypeModels(array $document_type_models): void
    {
        $this->documentTypeModels()->attach($document_type_models);
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDeadlineDate($input_deadline_date_value): void
    {
        $input_deadline_date_value = $input_deadline_date_value.'/'.Carbon::now()->year;
        $deadline_date = Carbon::createFromFormat('d/m/Y', $input_deadline_date_value);

        $this->deadline_date = $deadline_date;
    }
}
