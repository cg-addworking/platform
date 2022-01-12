<?php

namespace App\Models\Addworking\User;

use App\Helpers\HasUuid;
use App\Contracts\Addworking\User\OnboardingProcess\Step;
use App\Contracts\Models\Searchable;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\OnboardingProcess\AddworkingScenario;
use App\Models\Addworking\User\OnboardingProcess\UndefinedStep;
use App\Models\Edenred\User\OnboardingProcess\EdenredScenario;
use App\Models\Sogetrel\User\OnboardingProcess\SogetrelScenario;
use App\Notifications\Addworking\User\OnboardingProcessUnfinishedReminderNotification;
use Carbon\Carbon;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class OnboardingProcess extends Model implements Htmlable, Searchable
{
    use HasUuid,
        Viewable,
        Routable;

    protected $table = "addworking_user_onboarding_processes";

    protected $fillable = [
        'user',          // virtual
        'enterprise',    // virtual
        'current_step',
        'complete',
        'started_at',
        'completed_at',
        'last_notified_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'last_notified_at',
    ];

    protected $casts = [
        'current_step' => "integer",
        'complete' => "boolean",
        'started_at' => "datetime",
        'completed_at' => "datetime",
    ];

    protected $routePrefix = "support.user.onboarding_process";

    protected $searchable = [];

    public function __toString()
    {
        return self::class;
    }

    // ------------------------------------------------------------------------
    // RELATIONSHIPS
    // ------------------------------------------------------------------------

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    // ------------------------------------------------------------------------
    // ATTRIBUTES
    // ------------------------------------------------------------------------

    public function getStepsAttribute(): Collection
    {
        if ($this->enterprise->isSogetrel()) {
            return new SogetrelScenario($this);
        }

        if ($this->enterprise->isEdenred()) {
            return new EdenredScenario($this);
        }

        return new AddworkingScenario($this);
    }

    public function getLastStepAttribute(): int
    {
        return count($this->steps) - 1;
    }

    public function setUserAttribute($user)
    {
        $this->user()->associate($user);

        return $user;
    }

    public function setEnterpriseAttribute($enterprise)
    {
        $this->enterprise()->associate($enterprise);

        return $enterprise;
    }

    // ------------------------------------------------------------------------
    // SCOPES
    // ------------------------------------------------------------------------

    public function scopeSearch($query, string $search): Builder
    {
        $search = strtolower($search);

        return $query
            ->orWhere(function ($query) use ($search) {
                return $query->filterUser($search);
            })
            ->orWhere(function ($query) use ($search) {
                return $query->filterEnterprise($search);
            })
            ->orWhere(function ($query) use ($search) {
                return $query->filterCustomer($search);
            })
            ->orWhere(function ($query) use ($search) {
                foreach ($this->searchable as $column) {
                    $query->orWhere(DB::raw("LOWER(CAST({$column} as TEXT))"), 'LIKE', "%{$search}%");
                }
            });
    }

    public function scopeIncomplete($query)
    {
        return $query
            ->where('complete', false)
            ->whereHas('user', function ($q) {
                return $q->whereNull('deleted_at');
            });
    }

    public function scopeComplete($query)
    {
        return $query->where('complete', true);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('complete', $status);
    }

    public function scopeOfEnterprise($query, Enterprise $enterprise)
    {
        return $query->whereHas('enterprise', function ($query) use ($enterprise) {
            $query->where('id', $enterprise->id);
        });
    }

    public function scopeOfUser($query, User $user)
    {
        return $query->whereHas('user', function ($query) use ($user) {
            $query->where('id', $user->id);
        });
    }

    public function scopeFilterUser($query, $user)
    {
        $user = strtolower($user);
        return $query->whereHas('user', function ($query) use ($user) {
            return $query->where(DB::raw('LOWER(firstname) || LOWER(lastname)'), 'LIKE', "%{$user}%");
        });
    }

    public function scopeFilterEnterprise($query, $enterprise)
    {
        return $query->whereHas('user', function ($query) use ($enterprise) {
            return $query->whereHas('enterprises', function ($query) use ($enterprise) {
                $query->where(DB::raw('LOWER(name)'), 'LIKE', "%". strtolower($enterprise)."%");
            });
        });
    }

    public function scopeFilterCustomer($query, $customer)
    {
        return $query->whereHas('user', function ($query) use ($customer) {
            return $query->whereHas('enterprises', function ($query) use ($customer) {
                return $query->whereHas('customers', function ($query) use ($customer) {
                    $query->where(DB::raw('LOWER(name)'), 'LIKE', "%". strtolower($customer)."%");
                });
            });
        });
    }

    public function scopeCurrentStep($query, int $current_step)
    {
        return $query->where('current_step', $current_step);
    }

    // ------------------------------------------------------------------------
    // MISC
    // ------------------------------------------------------------------------

    public function sendReminder(): self
    {
        Notification::send(
            $this->user,
            new OnboardingProcessUnfinishedReminderNotification($this)
        );
        $this->update(['last_notified_at' => Carbon::today()]);

        return $this;
    }

    public function step(?int $num): Step
    {
        return $this->steps[min($num, count($this->steps) - 1)] ?? new UndefinedStep($this);
    }

    public function getCurrentStep(): Step
    {
        return $this->step($this->current_step);
    }

    public function advance(): self
    {
        if (!$this->exists || $this->complete) {
            return $this;
        }

        while ($this->getCurrentStep()->passes() && $this->current_step <= $this->last_step) {
            $this->update(['current_step' => ++$this->current_step]);
        }

        return $this;
    }

    public static function getAvailableEnterprises()
    {
        // @todo replace customer by Customer::sogetrel for instance.
        return [
            Enterprise::addworking()->id => "ADDWORKING",
            Enterprise::fromName('SOGETREL')->id => "SOGETREL",
            Enterprise::fromName('EDENRED')->id => "EDENRED"
        ];
    }
}
