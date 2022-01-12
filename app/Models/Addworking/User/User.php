<?php

namespace App\Models\Addworking\User;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Contracts\Models\Searchable;
use App\Events\UserCreated;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\Concerns\Comment\Commentable;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\Mission\MissionTracking;
use App\Models\Addworking\User\Concerns\User\HasChats;
use App\Models\Addworking\User\Concerns\User\HasComments;
use App\Models\Addworking\User\Concerns\User\HasConfirmationToken;
use App\Models\Addworking\User\Concerns\User\HasEnterprises;
use App\Models\Addworking\User\Concerns\User\HasLogs;
use App\Models\Addworking\User\Concerns\User\HasMissionTrackings;
use App\Models\Addworking\User\Concerns\User\HasNotifications;
use App\Models\Addworking\User\Concerns\User\HasOnboardingProcesses;
use App\Models\Addworking\User\Concerns\User\HasPassworks;
use App\Models\Addworking\User\Concerns\User\HasPermissions;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasNumber;
use App\Notifications\Addworking\User\Auth\ResetPasswordNotification;
use App\Notifications\Addworking\User\ManuallyResetedPasswordNotification;
use App\Repositories\Addworking\Enterprise\EnterpriseMemberRepository;
use Components\Common\Common\Domain\Exceptions\ModelDoesNotExistsException;
use Components\User\User\Domain\Interfaces\UserEntityInterface;
use Conner\Tagging\Taggable;
use DateTime;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Lab404\Impersonate\Models\Impersonate as Impersonatable;
use RuntimeException;

class User extends Authenticatable implements Htmlable, Searchable, UserEntityInterface
{
    use Authorizable,
        Notifiable,
        Impersonatable,
        Taggable,
        HasUuid,
        Routable,
        Viewable,
        HasNumber,
        HasConfirmationToken,
        HasEnterprises,
        HasPermissions,
        HasPassworks,
        HasChats,
        HasComments,
        HasLogs,
        HasOnboardingProcesses,
        HasNotifications,
        HasMissionTrackings,
        HasFilters,
        Commentable,
        UserCompat,
        SoftDeletes;

    protected $table = 'addworking_user_users';

    protected $fillable = [
        'gender',
        'firstname',
        'lastname',
        'email',
        'password',
        'iban_validation_token',
        'last_login',
        'last_activity',
        'is_confirmed',
        'is_system_superadmin',
        'is_system_admin',
        'is_system_operator',
        'tos_accepted',
        'is_customer',
        'is_vendor',
        'locale',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'confirmation_token',
        'validation_token',
        'is_system_superadmin',
        'is_system_admin',
        'is_system_operator',
    ];

    protected $attributes = [
        'is_confirmed'         => false,
        'is_system_superadmin' => false,
        'is_system_admin'      => false,
        'is_system_operator'   => false,
    ];

    protected $dates = [
        'deleted_at',
        'last_login',
        'last_activity',
    ];

    protected $casts = [
        'is_confirmed'         => "boolean",
        'is_system_superadmin' => "boolean",
        'is_system_admin'      => "boolean",
        'is_system_operator'   => "boolean",
    ];

    protected $dispatchesEvents = [
        'created' => UserCreated::class,
    ];

    protected $searchable = [
        'firstname',
        'lastname',
        'email'
    ];

    const IS_SYSTEM_SUPERADMIN             = 'is_system_superadmin';
    const IS_SYSTEM_ADMIN                  = 'is_system_admin';
    const IS_SYSTEM_OPERATOR               = 'is_system_operator';

    // deprecated
    const IS_SIGNATORY                     = 'is_signatory';
    const IS_LEGAL_REPRESENTATIVE          = 'is_legal_representative';
    const IS_ADMIN                         = 'is_admin';
    const IS_OPERATOR                      = 'is_operator';
    const IS_READONLY                      = 'is_readonly';
    const IS_MISSION_OFFER_BROADCASTER     = 'is_mission_offer_broadcaster';
    const IS_MISSION_OFFER_CLOSER          = 'is_mission_offer_closer';
    const IS_VENDOR_COMPLIANCE_MANAGER     = 'is_vendor_compliance_manager';
    const IS_CUSTOMER_COMPLIANCE_MANAGER   = 'is_customer_compliance_manager';

    // use these instead
    const ROLE_SIGNATORY                   = 'is_signatory';
    const ROLE_LEGAL_REPRESENTATIVE        = 'is_legal_representative';
    const ROLE_ADMIN                       = 'is_admin';
    const ROLE_OPERATOR                    = 'is_operator';
    const ROLE_READONLY                    = 'is_readonly';
    const ROLE_MISSION_OFFER_BROADCASTER   = 'is_mission_offer_broadcaster';
    const ROLE_MISSION_OFFER_CLOSER        = 'is_mission_offer_closer';
    const ROLE_VENDOR_COMPLIANCE_MANAGER   = 'is_vendor_compliance_manager';
    const ROLE_CUSTOMER_COMPLIANCE_MANAGER = 'is_customer_compliance_manager';
    const ROLE_CONTRACT_CREATOR            = 'is_contract_creator';
    const ROLE_SEND_CONTRACT_TO_SIGNATURE  = 'is_allowed_to_send_contract_to_signature';
    const ROLE_WORKFIELD_CREATOR           = 'is_work_field_creator';
    const ROLE_INVITE_VENDORS              = 'is_allowed_to_invite_vendors';
    const ROLE_VIEW_BUSINESS_TURNOVER      = 'is_allowed_to_view_business_turnover';
    const ROLE_FINANCIAL                   = 'is_financial';
    const ROLE_ACCOUNTING_MONITORING       = 'is_accounting_monitoring';

    const ACCESS_TO_BILLING                = 'access_to_billing';
    const ACCESS_TO_MISSION                = 'access_to_mission';
    const ACCESS_TO_MISSION_PURCHASE_ORDER = 'access_to_mission_purchase_order';
    const ACCESS_TO_CONTRACT               = 'access_to_contract';
    const ACCESS_TO_USER                   = 'access_to_user';
    const ACCESS_TO_ENTERPRISE             = 'access_to_enterprise';

    public function __toString()
    {
        return $this->getNameAttribute();
    }

    public static function fromEmail(string $email): self
    {
        return self::where(compact('email'))->firstOrFail();
    }

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function createdBy()
    {
        return $this->belongsToMany(
            Enterprise::class,
            'addworking_user_customer_created_users',
            'user_id',
            'enterprise_id'
        )->withPivot('status')->withTimestamps();
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function missionsClosed()
    {
        return $this->hasMany(Mission::class, 'closed_by');
    }

    public function picture()
    {
        return $this->belongsTo(File::class, 'picture_id')->withDefault();
    }

    public function contracts()
    {
        return $this->belongsToMany(Contract::class, "addworking_contract_has_users")->withPivot('signed', 'order');
    }

    public function referentVendors()
    {
        return $this->belongsToMany(
            Enterprise::class,
            'addworking_enterprise_enterprises_has_referents',
            'user_id',
            'vendor_id'
        )->withPivot('customer_id', 'created_by')->withTimestamps();
    }

    public function phoneNumbers()
    {
        return $this->morphToMany(PhoneNumber::class, 'morphable', 'addworking_common_has_phone_numbers')
            ->withPivot('note');
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeSearch($query, string $search): Builder
    {
        $search = strtolower($search);

        return $query
            ->orWhere(function ($query) use ($search) {
                return $query->filterEnterprise($search);
            })
            ->orWhere(function ($query) use ($search) {
                foreach ($this->searchable as $column) {
                    $query->orWhere(DB::raw("LOWER(CAST({$column} as TEXT))"), 'LIKE', "%{$search}%");
                }
            });
    }

    public function scopeOfNonSupportUser($query, self $user)
    {
        return $query->when(! $user->isSupport(), function ($query) use ($user) {
            return $query->whereHas('enterprises', function ($query) use ($user) {
                return $query->where('id', $user->enterprise->id);
            });
        });
    }

    public function scopeName($query, $name)
    {
        $name = strtolower($name);
        return $query->where(DB::raw('LOWER(firstname) || LOWER(lastname)'), 'like', "%{$name}%");
    }

    public function scopeEmail($query, $email)
    {
        return $query->where(DB::raw('LOWER(email)'), 'like', "%". strtolower($email)."%");
    }

    public function scopeOfType($query, $type)
    {
        if ($type == 'support') {
            return $query->where('is_system_superadmin', true)
                ->orWhere('is_system_admin', true)
                ->orWhere('is_system_operator', true);
        }

        return $query->whereHas('enterprises', function ($query) use ($type) {
            $query->where("is_{$type}", true);
        });
    }

    public function scopeFilterEnterprise($query, $enterprise)
    {
        return $query->whereHas('enterprises', function ($query) use ($enterprise) {
            return $query->where(DB::raw('LOWER(name)'), 'like', "%". strtolower($enterprise)."%");
        });
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function getNameAttribute()
    {
        if (isset($this->firstname, $this->lastname)) {
            return vsprintf('%s %s %s', [
                __("messages.gender.{$this->gender}_short"),
                $this->firstname,
                $this->lastname,
            ]);
        }

        return null;
    }

    public function setFirstnameAttribute($firstname)
    {
        $this->attributes['firstname'] = ucwords($firstname);
    }

    public function setLastnameAttribute($lastname)
    {
        $this->attributes['lastname'] = strtoupper($lastname);
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = strtolower($email);
    }

    // ------------------------------------------------------------------------
    // Miscellaneous
    // ------------------------------------------------------------------------

    public function hasVendorCreationStatus($status, Enterprise $customer)
    {
        if (!$enterprise = $this->createdBy()->find($customer->id)) {
            return false;
        }

        if ($enterprise->pivot->status != $status) {
            return false;
        }

        return true;
    }

    public function hasAcceptedTermsOfService(): bool
    {
        return (bool)$this->tos_accepted;
    }

    public function isConfirmed(): bool
    {
        return $this->is_confirmed;
    }

    public function confirm(): self
    {
        $this->update(['is_confirmed' => true]);

        return $this;
    }

    public static function getAvailableGenders(): array
    {
        return [
            'male',
            'female',
        ];
    }

    public static function loginFromIbanValidationToken(string $token): self
    {
        $user = self::where('iban_validation_token', $token)->first();

        if (! $user) {
            throw new AuthenticationException("No such user for IBAN validation token: '$token'");
        }

        if (! Auth::loginUsingId($user->id, true)) {
            throw new AuthenticationException("Unable to login.");
        }

        return $user;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($this, $token));
    }

    public function manualPasswordReset(): self
    {
        $password = Str::random(10);

        if (! $this->update(['password' => Hash::make($password)])) {
            throw new RuntimeException("unable to reset password");
        }

        $this->notify(new ManuallyResetedPasswordNotification($this, $password));

        return $this;
    }

    public function getJobTitleFor(Enterprise $enterprise): ?string
    {
        return optional($this->enterprises()->findOrNew($enterprise->id)->pivot)->job_title;
    }

    public function getMemberSinceFor(Enterprise $enterprise): ?DateTime
    {
        return optional($this->enterprises()->findOrNew($enterprise->id)->pivot)->created_at;
    }

    public static function getAvailableMembersFor(Enterprise $enterprise): array
    {
        return self::whereDoesntHave('enterprises', function ($query) use ($enterprise) {
            return $query->where('id', $enterprise->id);
        })->orderBy('lastname', 'asc')->get()->pluck('name', 'id')->all();
    }

    public function referentVendorsOf(Enterprise $enterprise)
    {
        return $this->referentVendors()->wherePivot('customer_id', $enterprise->id);
    }

    // ------------------------------------------------------------------------
    // UserEntityInterface methods
    // ------------------------------------------------------------------------

    public function getId(): string
    {
        if (! $this->exists) {
            throw new ModelDoesNotExistsException($this);
        }

        return $this->id;
    }
}
