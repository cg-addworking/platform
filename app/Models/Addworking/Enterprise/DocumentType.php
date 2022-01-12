<?php

namespace App\Models\Addworking\Enterprise;

use Carbon\Carbon;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Contract\ContractPartyDocumentType;
use App\Support\Facades\Repository;
use Components\Contract\Model\Application\Models\ContractModelDocumentType;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use UnexpectedValueException;

class DocumentType extends Model implements Htmlable
{
    use HasUuid, Viewable, Routable, SoftDeletes;

    const TYPE_LEGAL       = 'legal';
    const TYPE_BUSINESS    = 'business';
    const TYPE_INFORMATIVE = 'informative';
    const TYPE_CONTRACTUAL = 'contractual';

    const DOCUMENT_TYPES_CERTIFICATE_OF_ESTABLISHMENT = 'certificate_of_establishment';
    const DOCUMENT_TYPES_CERTIFICATE_OF_PAYMENT_SOCIAL_CONTRIBUTION = 'certificate_of_payment_social_contribution';
    const DOCUMENT_TYPES_CERTIFICATE_OF_PROFESSIONNAL_LIABILITY = 'certificate_of_professionnal_liability';
    const DOCUMENT_TYPES_CERTIFICATE_OF_EMPLOYEE_OUTSIDE_THE_EU = 'certificate_of_employee_outside_the_eu';
    const DOCUMENT_TYPES_CERTIFICATE_OF_TAX_REGULARITY = 'certificate_of_tax_regularity';
    const DOCUMENT_TYPES_CERTIFICATE_OF_PERSONNAL_TAX_REGULARITY_OF_SARLU_OWNER =
                                    'attestation-de-paiement-des-cotisations-personnelles-du-gerant-sarlu';

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
        'is_automatically_generated',
        'needs_customer_validation',
        'needs_support_validation',
        'deadline_date',
    ];

    protected $casts = [
        'is_mandatory'    => 'boolean',
        'is_automatically_generated' => 'boolean',
        'validity_period' => 'integer',
        'need_an_authenticity_check' => 'boolean',
        'needs_customer_validation' => 'boolean',
        'needs_support_validation' => 'boolean',
        'deadline_date' => 'date',
    ];

    protected $attributes = [
        'is_mandatory'    => false,
        'is_automatically_generated' => false,
        'validity_period' => 365,
        'type'            => self::TYPE_LEGAL,
        'need_an_authenticity_check' => false,
        'needs_customer_validation' => false,
        'needs_support_validation' => true,
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'deadline_date',
    ];

    protected $routePrefix = "addworking.enterprise.document-type";

    protected $routeParameterAliases = [
        "type" => "document_type",
    ];

    public function __toString()
    {
        return $this->display_name ?? 'n/a';
    }

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function contractModelPartyDocumentTypes()
    {
        return $this->hasMany(ContractModelDocumentType::class, 'document_type_id');
    }

    // @deprecated
    public function contractPartyDocumentType()
    {
        return $this->hasMany(ContractPartyDocumentType::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'type_id');
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id')->withDefault();
    }

    public function documentTypeFields()
    {
        return $this->hasMany(DocumentTypeField::class, 'type_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'document_model_id')->withDefault();
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

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function setTypeAttribute($value)
    {
        if (!is_null($value) && !in_array($value, self::getAvailableTypes())) {
            throw new UnexpectedValueException("Invalid type");
        }

        $this->attributes['type'] = $value;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = snake_case(remove_accents($value));
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeExceptType($query, $type)
    {
        return $query->where('type', '<>', $type);
    }

    public function scopeOfEnterprise($query, Enterprise $enterprise)
    {
        return $query->whereHas('enterprise', function ($query) use ($enterprise) {
            $query->where('id', $enterprise->id);
        });
    }

    public function scopeOfEnterprises($query, Enterprise ...$enterprises)
    {
        return $query->whereHas('enterprise', function ($query) use ($enterprises) {
            $query->whereIn('id', Collection::wrap($enterprises)->pluck('id'));
        });
    }

    public function scopeMandatory($query)
    {
        return $query->where('is_mandatory', true);
    }

    public function scopeOfLegalForm($query, LegalForm $form)
    {
        return $query->whereHas('legalForms', function ($query) use ($form) {
            return $query->where('id', $form->id);
        });
    }

    /**
     * Filters out all document types for a given vendor, that is to say,
     * every document types demanded by AddWorking plus anu document type
     * demanded by ANY of his customers or their parent enterprises.
     */
    public function scopeRequiredByVendor($query, Enterprise $vendor)
    {
        return $query->whereHas('enterprise', function ($query) use ($vendor) {
            $query
                ->whereIn('id', $vendor->getAllCustomersAndAncestors()->pluck('id'))
                ->orWhere('id', Enterprise::addworking()->id);
        });
    }

    /**
     * Filters out all documents types demanded by a given customer AND any of
     * its parent enterprises as well plus the usual types demanded by
     * AddWorking.
     */
    public function scopeRequiredByCustomer($query, Enterprise $customer)
    {
        return $query->whereHas('enterprise', function ($query) use ($customer) {
            $query
                ->whereIn('id', $customer->ancestors(true)->pluck('id'))
                ->orWhere('id', Enterprise::addworking()->id);
        });
    }
    
    // ------------------------------------------------------------------------
    // Misc
    // ------------------------------------------------------------------------

    public function isLegal(): bool
    {
        return $this->type == self::TYPE_LEGAL;
    }

    public function isBusiness(): bool
    {
        return $this->type == self::TYPE_BUSINESS;
    }

    public function isInformative(): bool
    {
        return $this->type == self::TYPE_INFORMATIVE;
    }

    public function isMandatory(): bool
    {
        return $this->is_mandatory;
    }

    public static function fromName(string $name): self
    {
        return self::where(@compact('name'))->firstOrFail();
    }

    public static function options()
    {
        return self::all()->mapWithKeys(function ($type) {
            return [$type->id => "{$type->enterprise->name} - {$type->display_name}"];
        })->sort();
    }

    /**
     * @deprecated v0.58.0 relaced by DocumentTypeRepository::getAvailableTypes
     */
    public static function getAvailableTypes(bool $translate = false): array
    {
        return Repository::get(self::class)->getAvailableTypes($translate);
    }

    /**
     * @deprecated v0.48.0 replaced by getDocumentsOf
     */
    public function getDocumentForEnterprise(Enterprise $enterprise): Document
    {
        return $this->documents()
            ->ofEnterprise($enterprise)
            ->latest()
            ->firstOrNew([])
            ->enterprise()->associate($enterprise)
            ->documentType()->associate($this);
    }

    public function getNeedAnAuthenticityCheck(): bool
    {
        return $this->need_an_authenticity_check;
    }

    public function setNeedAnAuthenticityCheck($need_an_authenticity_check): void
    {
        $this->need_an_authenticity_check = $need_an_authenticity_check;
    }

    public function getDocumentTypeModels()
    {
        return $this->documentTypeModels()->get();
    }

    public function setIsAutomaticallyGenerated($value): void
    {
        $this->is_automatically_generated = $value;
    }

    public function getIsAutomaticallyGenerated(): bool
    {
        return $this->is_automatically_generated;
    }

    public function getDeadlineDate()
    {
        return $this->deadline_date;
    }

    public function setDeadlineDate($input_deadline_date_value): void
    {
        $input_deadline_date_value = $input_deadline_date_value.'/'.Carbon::now()->year;
        $deadline_date = Carbon::createFromFormat('d/m/Y', $input_deadline_date_value);

        $this->deadline_date = $deadline_date;
    }

    public function getValidityPeriod()
    {
        return $this->validity_period;
    }
}
