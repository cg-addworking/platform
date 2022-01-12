<?php

namespace App\Models\Addworking\Enterprise;

use App\Helpers\HasUuid;
use App\Contracts\Models\Searchable;
use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Billing\InboundInvoice;
use App\Models\Addworking\Billing\VendorsAvailableBillingDeadlines;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\Folder;
use App\Models\Addworking\Common\Job;
use App\Models\Addworking\Common\Passwork;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Enterprise\Log as EnterpriseLog;
use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\MissionTracking;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\Mission\Proposal;
use App\Models\Addworking\User\User;
use App\Models\Concerns\HasActivities;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasNumber;
use App\Models\Concerns\HasPasswork;
use App\Models\Edenred\Common\AverageDailyRate;
use App\Models\Sogetrel\Enterprise\Data;
use App\Models\Spie\Enterprise\Enterprise as SpieEnterprise;
use Carbon\Carbon;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\Outbound\Application\Models\OutboundInvoiceItem;
use Components\Common\Common\Domain\Interfaces\Entities\CountryEntityInterface;
use Components\Contract\Contract\Application\Models\Annex;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Enterprise\AccountingExpense\Application\Models\AccountingExpense;
use Components\Enterprise\ActivityReport\Application\Models\ActivityReport;
use Components\Enterprise\BusinessTurnover\Application\Models\BusinessTurnover;
use Components\Enterprise\Enterprise\Application\Models\Company;
use Components\Enterprise\Enterprise\Domain\Interfaces\EnterpriseEntityInterface;
use Components\Enterprise\Resource\Application\Models\ActivityPeriod;
use Components\Enterprise\Resource\Application\Models\Resource;
use Components\Enterprise\WorkField\Application\Models\Sector;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Integer;
use UnexpectedValueException;

class Enterprise extends Model implements Htmlable, Searchable, EnterpriseEntityInterface
{
    use HasUuid,
        SoftDeletes,
        Viewable,
        Routable,
        HasActivities,
        HasFilters,
        HasNumber,
        HasPasswork,
        EnterpriseCompat;

    const PAYMENT_30_DAYS              = '30_days';
    const PAYMENT_IMMEDIATE            = 'immediate';
    const PAYMENT_UPFRONT_TRIMESTER    = 'upfront_trimester';
    const BILLING_END_OF_MONTH         = 'end_of_month';

    const CUSTOMER_CREATION_PENDING    = 'pending';
    const CUSTOMER_CREATION_ACCEPTED   = 'accepted';
    const CUSTOMER_CREATION_REFUSED    = 'refused';

    const SEARCHABLE_ATTRIBUTE_NAME    = 'name';
    const SEARCHABLE_ATTRIBUTE_PHONE   = 'phone';
    const SEARCHABLE_ATTRIBUTE_IDENTIFICATION_NUMBER = 'identification_number';
    const SEARCHABLE_ATTRIBUTE_ZIPCODE = 'zipcode';

    protected $table = 'addworking_enterprise_enterprises';

    protected $touches = ['users'];

    protected $fillable = [
        'name',
        'identification_number',
        'registration_town',
        'registration_date',
        'tax_identification_number',
        'main_activity_code',
        'vat_rate',
        'billing_starts_at',
        'billing_ends_at',
        'payment_terms',
        'billing_date',
        'type',
        'temporary',
        'external_id',
        'is_customer',
        'is_vendor',
        'country',
        'is_business_plus',
        'collect_business_turnover',
        'contractualization_language',
    ];

    protected $appends = [
        'first_address',
        'primary_phone_number',
        'secondary_phone_number',
        'activity',
    ];

    protected $casts = [
        'vat_rate'    => 'float',
        'is_customer' => 'boolean',
        'is_vendor'   => 'boolean',
        'is_business_plus' => 'boolean',
        'collect_business_turnover' => 'boolean',
        'registration_date' => 'date',
    ];

    protected $attributes = [
        'is_customer' => false,
        'is_vendor' => false,
        'country' => CountryEntityInterface::CODE_FRANCE,
        'is_business_plus' => false,
        'collect_business_turnover' => true,
        'contractualization_language' => CountryEntityInterface::CODE_FRANCE,
    ];

    protected $searchable = [
        'name',
        'identification_number',
        'tax_identification_number',
        'external_id',
    ];

    public function __toString()
    {
        return $this->name ?? 'n/a';
    }

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function ibans()
    {
        return $this->hasMany(Iban::class);
    }

    public function documentTypes()
    {
        return $this->HasMany(DocumentType::class, 'enterprise_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'enterprise_id');
    }

    public function legalRepresentatives()
    {
        return $this->belongsToMany(User::class, 'addworking_enterprise_enterprises_has_users')
            ->withPivot('job_title', 'primary', 'current', 'is_signatory', 'is_legal_representative')
            ->where('is_legal_representative', true)
            ->whereNull('addworking_enterprise_enterprises_has_users.deleted_at')
            ->withTimestamps();
    }

    public function vendorMissions()
    {
        return $this->hasMany(Mission::class, 'vendor_enterprise_id');
    }

    public function customerMissions()
    {
        return $this->hasMany(Mission::class, 'customer_enterprise_id');
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class, 'vendor_enterprise_id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'customer_id');
    }

    public function customers()
    {
        return $this->belongsToMany(
            Enterprise::class,
            'addworking_enterprise_enterprises_has_partners',
            'vendor_id',
            'customer_id'
        )->withPivot(
            'custom_management_fees_tag',
            'activity_starts_at',
            'activity_ends_at',
            'updated_by'
        )->withTimestamps();
    }

    public function vendors()
    {
        return $this->belongsToMany(
            Enterprise::class,
            'addworking_enterprise_enterprises_has_partners',
            'customer_id',
            'vendor_id'
        )->withPivot(
            'custom_management_fees_tag',
            'activity_starts_at',
            'activity_ends_at',
            'updated_by',
            'vendor_external_id'
        )->withTimestamps();
    }

    public function signatories()
    {
        return $this->belongsToMany(User::class, 'addworking_enterprise_enterprises_has_users')
            ->withPivot('job_title', 'primary', 'is_signatory', 'is_legal_representative')
            ->where('is_signatory', true)
            ->whereNull('addworking_enterprise_enterprises_has_users.deleted_at')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'addworking_enterprise_enterprises_has_users')
            ->withPivot(
                'job_title',
                'primary',
                'current',
                'is_signatory',
                'is_legal_representative',
                'is_admin',
                'is_operator',
                'is_readonly'
            )
            ->whereNull('addworking_enterprise_enterprises_has_users.deleted_at')
            ->withTimestamps();
    }

    public function vendorMissionTrackings()
    {
        return $this->hasManyThrough(MissionTracking::class, Mission::class, 'vendor_enterprise_id', 'mission_id');
    }

    public function customerMissionTrackings()
    {
        return $this->hasManyThrough(MissionTracking::class, Mission::class, 'customer_enterprise_id', 'mission_id');
    }

    public function milestones()
    {
        return $this->HasManyThrough(Milestone::class, Mission::class, 'customer_enterprise_id', 'mission_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class)->withDefault();
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function addresses()
    {
        return $this->morphToMany(Address::class, 'addressable', 'addworking_common_addressables');
    }

    public function phoneNumbers()
    {
        return $this->morphToMany(PhoneNumber::class, 'morphable', 'addworking_common_has_phone_numbers')
            ->withPivot('note');
    }

    public function vendorsAvailableBillingDeadlines()
    {
        return $this->hasMany(VendorsAvailableBillingDeadlines::class);
    }

    public function files()
    {
        return $this->documents();
    }

    public function inboundInvoices()
    {
        return $this->hasMany(InboundInvoice::class);
    }

    public function outboundInvoices()
    {
        return $this->hasMany(OutboundInvoice::class);
    }

    public function outboundInvoiceItems()
    {
        return $this->hasMany(OutboundInvoiceItem::class, 'vendor_id');
    }

    public function authorizedDeadlineForVendor()
    {
        return $this->belongsToMany(
            DeadlineType::class,
            'addworking_enterprise_vendor_has_deadline_types',
            'vendor_id',
            'deadline_id'
        )
            ->withPivot('customer_id')
            ->withTimestamps();
    }

    public function legalForm()
    {
        return $this->belongsTo(LegalForm::class)->withDefault();
    }

    public function logs()
    {
        return $this->hasMany(EnterpriseLog::class, 'enterprise_id');
    }

    public function sogetrelData()
    {
        return $this->hasOne(Data::class, 'enterprise_id');
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function passworks()
    {
        return $this->morphMany(Passwork::class, 'passworkable');
    }

    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    public function spieEnterprise()
    {
        return $this->hasOne(SpieEnterprise::class)->withDefault();
    }

    public function averageDailyRates()
    {
        return $this->hasMany(AverageDailyRate::class, 'vendor_id');
    }

    public function folders()
    {
        return $this->hasMany(Folder::class);
    }

    public function contractTemplates()
    {
        return $this->hasMany(ContractTemplate::class);
    }

    public function logo()
    {
        return $this->belongsTo(File::class, 'logo_id')->withDefault();
    }

    public function vendorReferents()
    {
        return $this->belongsToMany(
            User::class,
            'addworking_enterprise_enterprises_has_referents',
            'vendor_id',
            'user_id'
        )->withPivot('customer_id', 'created_by')->withTimestamps();
    }

    public function resources()
    {
        return $this->hasMany(Resource::class, 'vendor_id');
    }

    public function activityPeriods()
    {
        return $this->hasMany(ActivityPeriod::class, 'customer_id');
    }

    public function activityReports()
    {
        return $this->hasMany(ActivityReport::class, 'vendor_id');
    }

    public function contractModels()
    {
        return $this->hasMany(ContractModel::class);
    }

    public function publishedContractModels()
    {
        return $this->contractModels()->whereNotNull('published_at');
    }

    public function sectors()
    {
        return $this->belongsToMany(
            Sector::class,
            'addworking_enterprise_enterprises_has_sectors',
            'enterprise_id',
            'sector_id'
        )->withTimestamps();
    }

    public function workFields()
    {
        return $this->hasMany(WorkField::class, 'owner_id');
    }

    public function businessTurnovers()
    {
        return $this->hasMany(BusinessTurnover::class, 'enterprise_id');
    }

    public function accountingExpenses()
    {
        return $this->hasMany(AccountingExpense::class, 'enterprise_id');
    }

    // todo: temporary relation with company, delete it after migration
    public function company()
    {
        return $this->belongsTo(Company::class)->withDefault();
    }

    public function annexes()
    {
        return $this->hasMany(Annex::class);
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeCustomerOf($query, Enterprise $vendor)
    {
        return $query->whereHas('vendors', function ($query) use ($vendor) {
            $query->where('id', $vendor->id);
        });
    }

    public function scopeVendorOf($query, Enterprise $customer)
    {
        return $query->whereHas('customers', function ($query) use ($customer) {
            $query->where('id', $customer->id);
        });
    }

    public function scopeWhereIsCustomer($query)
    {
        return $query->where('is_customer', true);
    }

    public function scopeWhereIsVendor($query)
    {
        return $query->where('is_vendor', true);
    }

    public function scopeExceptAddworking($query)
    {
        return $query->where('name', '!=', 'ADDWORKING');
    }

    public function scopeSearch($query, string $search, string $operator = null, string $field_name = null)
    {
        switch ($operator) {
            case 'like':
                if ($field_name == 'phone') {
                    return $query->whereHas('phoneNumbers', function ($query) use ($search) {
                        return $query->where('number', 'LIKE', "%".$search."%")
                            ->orWhere('number', 'LIKE', "%".strtolower($search)."%")
                            ->orWhere('number', 'LIKE', "%".strtoupper($search)."%");
                    });
                }
                if ($field_name == 'zipcode') {
                    return $query->whereHas('addresses', function ($query) use ($search) {
                        return $query->where('zipcode', 'LIKE', "%".$search."%")
                            ->orWhere('zipcode', 'LIKE', "%".strtolower($search)."%")
                            ->orWhere('zipcode', 'LIKE', "%".strtoupper($search)."%");
                    });
                }
                return $query->where($field_name, 'LIKE', "%".remove_accents($search)."%")
                    ->orWhere($field_name, 'LIKE', "%".mb_strtolower(remove_accents($search))."%")
                    ->orWhere(DB::raw('LOWER('.$field_name.')'), 'LIKE', "%".mb_strtolower(remove_accents($search))."%")
                    ->orWhere($field_name, 'LIKE', "%".mb_strtoupper(remove_accents($search))."%")
                    ->orWhere(DB::raw('UPPER('.$field_name.')'), 'LIKE', "%".mb_strtoupper(remove_accents($search))."%")
                    ;
            case 'equal':
                if ($field_name == 'phone') {
                    return $query->whereHas('phoneNumbers', function ($query) use ($search) {
                        return $query->where('number', $search);
                    });
                }
                if ($field_name == 'zipcode') {
                    return $query->whereHas('addresses', function ($query) use ($search) {
                        return $query->where('zipcode', $search);
                    });
                }
                return $query->where($field_name, $search)
                                ->orWhere($field_name, strtolower($search))
                                ->orWhere($field_name, strtoupper($search));
        }
    }

    public function scopeCreatedBefore($query, $date)
    {
        // we need to specify the tablename here because this where condition
        // is ambiguous when used with a BelongsToMany object for instance
        // with $enterprise->vendorEnterprises()->createdBefore('...')
        return $query->where("{$this->table}.created_at", '<', $date);
    }

    public function scopeOfNonSupportUser($query, User $user)
    {
        return $query->when(! $user->isSupport(), function ($query) use ($user) {
            return $query->where('id', $user->enterprise->id);
        });
    }

    public function scopeOfName($query, $enterprise)
    {
        return $query->where(DB::raw('LOWER(name)'), 'like', "%". strtolower($enterprise)."%");
    }

    public function scopeOfType($query, $type)
    {
        foreach (explode('+', $type) as $type) {
            $query->where("is_{$type}", true);
        }
    }

    public function scopeOfLegalRepresentative($query, $user)
    {
        return $query->whereHas('users', function ($query) use ($user) {
            $query->where(function ($query) use ($user) {
                $query->where(DB::raw('LOWER(firstname)'), 'like', "%". strtolower($user)."%")
                    ->orwhere(DB::raw('LOWER(lastname)'), 'like', "%". strtolower($user)."%");
            })->where('is_legal_representative', true);
        });
    }

    public function scopeOfLegalForm($query, $legalForm)
    {
        return $query->whereHas('legalForm', function ($query) use ($legalForm) {
            $query->where('id', $legalForm);
        });
    }

    public function scopeOfActivityField($query, $field)
    {
        return $query->whereHas('activities', function ($query) use ($field) {
            $query->where('field', $field);
        });
    }

    public function scopeFilterIdentificationNumber($query, $number)
    {
        return $query->where('identification_number', 'LIKE', "{$number}%");
    }

    public function scopeOfActivity($query, $activity)
    {
        $activity = strtolower($activity);
        return $query->whereHas('activities', function ($query) use ($activity) {
            $query->where(DB::raw('LOWER(activity)'), 'like', "%{$activity}%");
        });
    }

    public function scopeOfMainActivityCode($query, $code)
    {
        $code = strtolower($code);
        return $query->where(DB::raw('LOWER(main_activity_code)'), 'like', "%{$code}%");
    }

    public function scopeOfPhone($query, $phone)
    {
        return $query->whereHas('phoneNumbers', function ($query) use ($phone) {
            $query->where(function ($query) use ($phone) {
                $query->where('number', 'like', "%{$phone}%");
            });
        });
    }

    public function scopeOfAddress($query, $address)
    {
        $address = strtolower($address);
        return $query->whereHas('addresses', function ($query) use ($address) {
            $query->where(function ($query) use ($address) {
                $query->where(DB::raw('LOWER(address)'), 'like', "%{$address}%")
                    ->orWhere(DB::raw('LOWER(additionnal_address)'), 'like', "%{$address}%")
                    ->orWhere('zipcode', 'like', "%{$address}%")
                    ->orWhere(DB::raw('LOWER(town)'), 'like', "%{$address}%")
                    ->orWhere(DB::raw('LOWER(country)'), 'like', "%{$address}%");
            });
        });
    }

    public function scopeFilterJob($query, $job)
    {
        return $query->whereHas('passworks', function ($query) use ($job) {
            $query->whereHas('skills', function ($query) use ($job) {
                $query->whereHas('job', function ($query) use ($job) {
                    $query->where(DB::raw('LOWER(display_name)'), 'LIKE', "%". strtolower($job)."%");
                });
            });
        });
    }

    public function scopeFilterSkill($query, $skill)
    {
        return $query->whereHas('passworks', function ($query) use ($skill) {
            $query->whereHas('skills', function ($query) use ($skill) {
                $query->where(DB::raw('LOWER(display_name)'), 'LIKE', "%". strtolower($skill)."%");
            });
        });
    }

    public function scopeFilterSogetrelNavibatId($query, $navibat_id)
    {
        return $query->whereHas('sogetrelData', function ($query) use ($navibat_id) {
            $query->where(DB::raw('LOWER(navibat_id)'), 'LIKE', "%". strtolower($navibat_id)."%");
        });
    }

    public function scopeOfReferent($query, $enterprise, $referent)
    {
        return $query->whereHas('vendorReferents', function ($query) use ($enterprise, $referent) {
            $query->where('customer_id', $enterprise)->where('user_id', $referent);
        });
    }

    public function scopeFilterFamily($query, $family)
    {
        return $query->whereIn('id', $this->getFamily(Enterprise::fromName($family))->pluck('id'));
    }

    public function scopeFilterZipCode($query, $code)
    {
        return $query->whereHas('addresses', function ($query) use ($code) {
            $query->where('zipcode', 'LIKE', "{$code}%");
        });
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = self::sanitizeName($value);
    }

    public function setVatRateAttribute($value)
    {
        $value = (float) $value;

        if ($value < 0 || $value > 1) {
            throw new UnexpectedValueException("VAT rate should be between 0 and 1");
        }

        $this->attributes['vat_rate'] = $value;
    }

    public function setRegistrationTownAttribute($value)
    {
        $this->attributes['registration_town'] = strtoupper($value);
    }

    public function setRegistrationDate($registration_date)
    {
        $this->registration_date = $registration_date;
    }

    public function setCountry(string $country)
    {
        $this->country = $country;
    }

    public function setIdentificationNumberAttribute($value)
    {
        $this->attributes['identification_number'] = str_replace(' ', '', $value);
    }

    //FR Entreprises
    public function getSirenAttribute()
    {
        return substr(trim($this->identification_number), 0, 9);
    }

    // ------------------------------------------------------------------------
    // Miscellaneous
    // ------------------------------------------------------------------------

    public function getFamily(Enterprise $enterprise): Collection
    {
        while ($enterprise->parent->exists) {
            $enterprise = $enterprise->parent;
        }

        $family = new Collection;

        foreach ($enterprise->children as $child) {
            $family->push($child);
        }

        return $family->push($enterprise);
    }

    public function newCollection(array $models = [])
    {
        return new EnterpriseCollection($models);
    }

    public function vendorReferentsOf(Enterprise $enterprise)
    {
        return $this->vendorReferents()->wherePivot('customer_id', $enterprise->id);
    }

    public function vendorInActivityWithCustomer(Enterprise $customer)
    {
        $partnership = $this->customers()->wherePivot('customer_id', $customer->id)->first();
        if (is_null($partnership)) {
            return false;
        }

        $now = Carbon::now();
        $starts_at = is_null($partnership->pivot->activity_starts_at)
            ? null
            : Carbon::createFromFormat('Y-m-d H:i:s', $partnership->pivot->activity_starts_at);
        $ends_at = is_null($partnership->pivot->activity_ends_at)
            ? null
            : Carbon::createFromFormat('Y-m-d H:i:s', $partnership->pivot->activity_ends_at);

        if (is_null($starts_at) || $now->lt($starts_at) || ! $now->between($starts_at, $ends_at)) {
            return false;
        }

        return true;
    }

    public function vendorIsInactiveForAllCustomers()
    {
        $inactive = true;

        foreach ($this->customers as $customer) {
            if ($this->vendorInActivityWithCustomer($customer)) {
                $inactive = false;
            }
        }

        return $inactive;
    }

    // ------------------------------------------------------------------------
    // Interface methods
    // ------------------------------------------------------------------------

    public function getId(): string
    {
        if (! $this->exists) {
            throw new \RuntimeException("this enterprise doesn't exists");
        }

        return $this->id;
    }

    public function isCustomer(): bool
    {
        return $this->is_customer;
    }

    public function isVendor(): bool
    {
        return $this->is_vendor;
    }

    public function isBusinessPlus(): bool
    {
        return $this->is_business_plus;
    }
  
    public function isHybrid(): bool
    {
        return $this->is_vendor && $this->is_customer;
    }

    public function isVendorOf(EnterpriseEntityInterface $customer, bool $including_subsidiaries = false): bool
    {
        if ($including_subsidiaries) {
            $enterprises = Enterprise::where('id', $customer->id)->first()->descendants()->pluck('id');
            return $this->customers()->whereIn('customer_id', $enterprises)->exists();
        }

        return $this->customers()->where('id', $customer->getId())->exists();
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getAvailableCountry()
    {
        return [
            CountryEntityInterface::CODE_FRANCE => CountryEntityInterface::NAME_FRANCE,
            CountryEntityInterface::CODE_DEUTSCHLAND => CountryEntityInterface::NAME_DEUTSCHLAND,
            CountryEntityInterface::CODE_BELGIUM => CountryEntityInterface::NAME_BELGIUM
        ];
    }

    public static function calculateTaxIdentificationNumber(Enterprise $enterprise): string
    {
        $key = (12+3*(intval($enterprise->siren) % 97)) % 97;

        return strtoupper($enterprise->country)
            .str_pad($key, 2, "0", STR_PAD_LEFT)
            .$enterprise->siren;
    }

    public function getContractualizationLanguage(): ?string
    {
        return $this->contractualization_language;
    }

    public function setContractualizationLanguage(?string $contractualization_language): void
    {
        $this->contractualization_language = $contractualization_language;
    }

    public function getRegistrationDate()
    {
        return $this->registration_date;
    }

    public function getAnnexes()
    {
        return $this->annexes()->get();
    }
}
