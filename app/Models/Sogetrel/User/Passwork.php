<?php

namespace App\Models\Sogetrel\User;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\Concerns\Comment\Commentable;
use App\Models\Addworking\Common\Concerns\File\HasAttachments;
use App\Models\Addworking\Common\Department;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\User\User;

use App\Models\Sogetrel\Contract\Type as ContractType;
use App\Models\Sogetrel\User\Quizz;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Components\Sogetrel\Passwork\Application\Models\Acceptation;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Venturecraft\Revisionable\RevisionableTrait as Revisionable;

class Passwork extends Model implements Htmlable
{
    use Revisionable,
        SoftDeletes,
        HasUuid,
        Viewable,
        Routable,
        Commentable,
        HasAttachments,
        HasStatus;

    protected $table = 'sogetrel_user_passworks';

    const STATUS_PENDING            = 'pending';
    const STATUS_PREQUALIFIED       = 'prequalified';
    const STATUS_ACCEPTED           = 'accepted';
    const STATUS_REFUSED            = 'refused';
    const STATUS_NOT_RESULTED       = 'not_resulted';
    const STATUS_ACCEPTED_QUEUED    = 'accepted_queued';
    const STATUS_BLACKLISTED        = 'blacklisted';

    protected $fillable = [
        'status',
        'flag_parking',
        'flag_contacted',
        'comment',
        'data',
        'work_starts_at',
        'date_due_at',
        'needs_decennial_insurance',
        'applicable_price_slip',
        'bank_guarantee_amount',
    ];

    protected $casts = [
        'flag_parking'   => "boolean",
        'flag_contacted' => "boolean",
        'data'           => "json",
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'work_starts_at',
        'date_due_at'
    ];

    protected $routePrefix = "sogetrel.passwork";

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function contractTypes()
    {
        return $this->belongsToMany(
            ContractType::class,
            'sogetrel_user_passworks_has_contract_types',
            'passwork_id',
            'type_id'
        )->withTimestamps();
    }

    public function administrativeManager()
    {
        return $this->belongsTo(User::class, 'administrative_manager')->withDefault();
    }

    public function administrativeAssistant()
    {
        return $this->belongsTo(User::class, 'administrative_assistant')->withDefault();
    }

    public function operationalManager()
    {
        return $this->belongsTo(User::class, 'operational_manager')->withDefault();
    }

    public function contractSignatory()
    {
        return $this->belongsTo(User::class, 'contract_signatory')->withDefault();
    }

    public function acceptedBy()
    {
        return $this->belongsTo(User::class, 'accepted_by')->withDefault();
    }

    public function refusedBy()
    {
        return $this->belongsTo(User::class, 'refused_by')->withDefault();
    }

    public function preQualifiedBy()
    {
        return $this->belongsTo(User::class, 'pre_qualified_by')->withDefault();
    }

    public function blacklistedBy()
    {
        return $this->belongsTo(User::class, 'blacklisted_by')->withDefault();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function customers()
    {
        return $this->belongsToMany(
            Enterprise::class,
            'sogetrel_user_passwork_has_enterprises', // table
            'passwork_id',
            'enterprise_id'
        )->withTimestamps();
    }

    public function departments()
    {
        return $this->belongsToMany(
            Department::class,
            'sogetrel_user_passworks_has_addworking_common_departments',
            'passwork_id',
            'department_id'
        )->withTimestamps();
    }

    public function offers()
    {
        return $this->belongsToMany(
            Offer::class,
            'sogetrel_user_passworks_has_offers',
            'passwork_id',
            'offer_id'
        )->withTimestamps();
    }

    public function quizzes()
    {
        return $this->hasMany(Quizz::class);
    }

    public function acceptations()
    {
        return $this->hasMany(Acceptation::class);
    }


    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeHasWorkedWithInTechnicienCavi($query, $has_worked_with_in_technicien_cavi)
    {
        foreach (array_wrap($has_worked_with_in_technicien_cavi) as $i => $value) {
            $query
                ->{$i == 0 ? 'where' : 'orWhere'}("data->technicien_cavi->$value", "1")
                ->orWhere("data->technicien_cavi->$value", "1");
        }

        return $query;
    }

    public function scopeHasWorkedWithInEngineeringComputer($query, $has_worked_with_in_engineering_computer)
    {
        foreach (array_wrap($has_worked_with_in_engineering_computer) as $i => $value) {
            $query
                ->{$i == 0 ? 'where' : 'orWhere'}("data->engineering_computer->$value", "1")
                ->orWhere("data->engineering_computer->$value", "1");
        }

        return $query;
    }

    public function scopeHasWorkedWithInCivilEngineering($query, $has_worked_with_in_civil_engineering)
    {
        foreach (array_wrap($has_worked_with_in_civil_engineering) as $i => $value) {
            $query
                ->{$i == 0 ? 'whereJsonContains' : 'orWhereJsonContains'}(
                    "data->has_worked_with_in_civil_engineering",
                    $value
                );
        }
    }

    public function scopeHasWorkedWithInEngineeringOffice($query, $has_worked_with_in_engineering_office)
    {
        $jobs = [
            'study_manager', 'qgis', 'gaia', 'ipon_geofibre', 'kheops', 'netgeo', 'drawer_drafter', 'exe',
            'grace_thd', 'aerial_studies', 'gc_studies', 'security_studies', 'gcblo_owf', 'telecom_picketer',
        ];

        foreach (array_wrap($has_worked_with_in_engineering_office) as $i => $value) {
            if (in_array($value, $jobs)) {
                $query
                    ->{$i == 0 ? 'where' : 'orWhere'}("data->has_worked_with_in_engineering_office->$value", "true")
                    ->orWhere("data->has_worked_with_in_engineering_office->$value", "true");
            }

            $query
                ->{$i == 0 ? 'where' : 'orWhere'}("data->wants_to_work_with->$value", "true")
                ->orWhere("data->wants_to_work_with->$value", "true");
        }

        return $query;
    }

    public function scopeElectrician($query, $electrician = true)
    {
        return $query->where('data->electrician', $electrician);
    }

    public function scopeCivilEngineering($query, $civilEngineering = true)
    {
        return $query->where('data->civil_engineering', $civilEngineering);
    }

    public function scopeMultiActivities($query, $multi_activities = true)
    {
        return $query->where('data->multi_activities', $multi_activities);
    }

    public function scopeEngineeringOffice($query, $engineering_office = true)
    {
        return $query->where('data->engineering_office', $engineering_office);
    }

    public function scopeTechnicienCavi($query, $cavi = true)
    {
        return $query->where('data->cavi', $cavi);
    }

    public function scopeEngineeringComputer($query, $engineering_computer = true)
    {
        return $query->where('data->engineering_computer_mib', $engineering_computer);
    }

    public function scopeElectricalClearance($query, $electrical_clearance)
    {
        foreach (array_wrap($electrical_clearance) as $i => $value) {
            $query->{$i == 0 ? 'whereJsonContains' : 'orWhereJsonContains'}("data->electrical_clearances", $value);
        }

        return $query;
    }

    public function scopeDepartment($query, $department)
    {
        return $query->whereHas('departments', function ($query) use ($department) {
            $query->whereIn('id', $department);
        });
    }

    public function scopeOfOperationalDirection($query, $enterpriseIds)
    {
        return $query->whereHas('departments', function ($query) use ($enterpriseIds) {
            return $query->whereHas('activities', function ($query) use ($enterpriseIds) {
                return $query->whereHas('enterprise', function ($query) use ($enterpriseIds) {
                    $query->whereIn('id', $enterpriseIds);
                });
            });
        });
    }

    public function scopeRegion($query, $region)
    {
        return $query->whereHas('departments', function ($query) use ($region) {
            $query->whereIn('region_id', $region);
        });
    }

    public function scopeWantsToWorkWith($query, $wants_to_work_with)
    {
        foreach (array_wrap($wants_to_work_with) as $i => $value) {
            $query
                ->{$i == 0 ? 'where' : 'orWhere'}("data->wants_to_work_with->$value", "true")
                ->orWhere("data->wants_to_work_with->$value", "true");
        }

        return $query;
    }

    public function scopeStatus($query, $status)
    {
        return $query->whereIn('status', array_wrap($status));
    }

    public function scopeFlagParking($query, $flag_parking = true)
    {
        return $query->where('flag_parking', $flag_parking);
    }

    public function scopeFlagContacted($query, $flag_contacted = true)
    {
        return $query
            ->where('flag_contacted', $flag_contacted)
            ->when($flag_contacted == true, function ($query) {
                return $query->orderBy('updated_at', 'desc');
            });
    }

    public function scopeEmployees($query, $employees = true)
    {
        return $query->where('data->employees', $employees ? '>' : '=', 0);
    }

    public function scopeName($query, string $name)
    {
        $names = explode(' ', trim($name));

        return $query->whereHas('user', function ($query) use ($names) {
            foreach ($names as $i => $name) {
                $firstname = ucwords(strtolower($name));
                $lastname  = strtoupper($name);

                $query
                    ->{ $i == 0 ? 'where' : 'orWhere'}('firstname', 'like', "%{$firstname}%")
                    ->orWhere('lastname', 'like', "%{$lastname}%");
            }
        });
    }

    public function scopeEnterprise($query, string $enterprise)
    {
        return $query->where('data->enterprise_name', 'like', '%'.strtoupper($enterprise).'%');
    }

    public function scopeVendors($query, $customer)
    {
        return $query->whereHas('user', function ($query) use ($customer) {
            return $query->whereHas('enterprises', function ($query) use ($customer) {
                return $query->whereHas('customers', function ($query) use ($customer) {
                    return $query->where('id', $customer->id);
                });
            });
        });
    }

    public function scopeHeadquartersDepartment($query, $headquarter_departments)
    {
        return $query->where(function ($query) use ($headquarter_departments) {
            foreach ($headquarter_departments as $headquarter_department) {
                if ($headquarter_department === "2A" || $headquarter_department === "2B") {
                    $query->orWhere('data->enterprise_postal_code', 'like', '20%');
                }
                $query->orwhere('data->enterprise_postal_code', 'like', $headquarter_department .'%');
            }
        });
    }

    public function scopeIdentificationNumber($query, $identification_number)
    {
        return $query->whereHas('user', function ($query) use ($identification_number) {
            return $query->whereHas('enterprises', function ($query) use ($identification_number) {
                return $query->where('identification_number', 'LIKE', "%{$identification_number}%");
            });
        });
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function setStatusAttribute($status)
    {
        if (!in_array($status, self::getAvailableStatuses())) {
            throw new InvalidArgumentException("Invalid status: $status");
        }

        $this->attributes['status'] = $status;
    }

    /**
     * @deprecated v0.5.40 passworks are no longer attached to enterprises
     */
    public function getEnterpriseAttribute(): Enterprise
    {
        return $this->user->enterprise;
    }

    public function setDataAttribute($value)
    {
        // converts arrays into objects
        // e.g. ['foo','bar'] => {"foo" => true, "bar" => true}
        // so they are render queryable
        // e.g. Passwork::where('data->foo', true);

        $properties = [
            'has_worked_with',
            'wants_to_work_with',
            'has_worked_with_in_engineering_office',
            'wants_to_work_with_in_engineering_office',
            'telecom_picketer.other_experience',
            'engineering_office_software.dao_software',
            'engineering_office_software.sig_software',
            'engineering_office_software.business_software',
        ];

        $mapper = function ($item) {
            return [$item => true];
        };

        foreach ($properties as $prop) {
            array_set($value, $prop, collect(array_get($value, $prop, []))->mapWithKeys($mapper)->toArray());
        }

        // capitalize enterprise name
        $enterpriseName = strtoupper(remove_accents(array_get($value, 'enterprise_name') ?: ''));
        array_set($value, 'enterprise_name', $enterpriseName);

        $value = $this->castAttributeAsJson('data', $value);
        $this->attributes['data'] = $value;
    }

    public function setWorkStartsAtAttribute($date)
    {
        if (is_string($date) && is_date_fr($date)) {
            $date = date_fr_to_iso($date);
        }

        $this->attributes['work_starts_at'] = $this->fromDateTime($date);
    }

    public function setDateDueAtAttribute($date)
    {
        if (is_string($date) && is_date_fr($date)) {
            $date = date_fr_to_iso($date);
        }

        $this->attributes['date_due_at'] = $this->fromDateTime($date);
    }

    public function setNeedsDecennialInsurance($needs_decennial_insurance)
    {
        if (is_bool($needs_decennial_insurance)) {
            $this->attributes['needs_decennial_insurance'] = $needs_decennial_insurance;
        }
    }

    public function setApplicablePricerSlip($applicable_price_slip)
    {
        $this->attributes['applicable_price_slip'] = $applicable_price_slip;
    }

    public function setBankGuaranteeAmount(?float $bank_guarantee_amount)
    {
        $this->attributes['bank_guarantee_amount'] = $bank_guarantee_amount;
    }

    // ------------------------------------------------------------------------
    // Miscellaneous
    // ------------------------------------------------------------------------

    public static function search(Request $request): Builder
    {
        $fields = [
            'electrician'    , 'multi_activities'   , 'engineering_office'  ,
            'department'     , 'wants_to_work_with' , 'status'              ,
            'flag_parking'   , 'flag_contacted'     , 'employees'           ,
            'name'           , 'region'             , 'electrical_clearance',
            'enterprise'     , 'vendors'            , 'has_worked_with_in_engineering_office',
            'of_operational_direction'              , 'has_worked_with_in_civil_engineering',
            'civil_engineering', 'headquarters_department', 'identification_number',
            'technicien_cavi', 'has_worked_with_in_technicien_cavi',
            'engineering_computer', 'has_worked_with_in_engineering_computer',
        ];

        return self::query()->when($request->has('search'), function ($query) use ($request, $fields) {
            foreach ($fields as $field) {
                if (!is_null($value = $request->input("search.{$field}"))) {
                    $query->{camel_case($field)}($value);
                }
            }
        });
    }

    public static function searchWithArray(array $search): Builder
    {
        $fields = [
            'electrician'    , 'multi_activities'   , 'engineering_office'  ,
            'department'     , 'wants_to_work_with' , 'status'              ,
            'flag_parking'   , 'flag_contacted'     , 'employees'           ,
            'name'           , 'region'             , 'electrical_clearance',
            'enterprise'     , 'vendors'            , 'has_worked_with_in_engineering_office',
            'of_operational_direction'              , 'has_worked_with_in_civil_engineering',
            'civil_engineering', 'headquarters_department', 'identification_number',
            'technicien_cavi', 'has_worked_with_in_technicien_cavi',
            'engineering_computer', 'has_worked_with_in_engineering_computer',
        ];

        return self::query()->when(!is_null($search), function ($query) use ($search, $fields) {
            foreach ($fields as $field) {
                if (isset($search[$field])) {
                    $query->{camel_case($field)}($search[$field]);
                }
            }
        });
    }

    public static function getAvailableSharingRecipients(): array
    {
        foreach (Enterprise::fromName('SOGETREL')->users as $user) {
            $users[$user->id] = $user->enterprise->name.' - '.$user->name.' - '.$user->enterprise->job_title;
        }

        foreach (Enterprise::fromName('SOGETREL')->children as $childrenEnterprise) {
            foreach ($childrenEnterprise->users as $user) {
                $users[$user->id] = $user->enterprise->name.' - '.$user->name.' - '.$user->enterprise->pivot->job_title;
            }
        }

        return $users;
    }

    public function getClassName(): string
    {
        return "sogetrel_passwork";
    }

    public function getVarName(): string
    {
        return "passwork";
    }
}
