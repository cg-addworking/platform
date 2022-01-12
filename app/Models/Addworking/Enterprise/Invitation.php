<?php

namespace App\Models\Addworking\Enterprise;

use App\Helpers\HasUuid;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use UnexpectedValueException;

class Invitation extends Model
{
    use HasUuid, SoftDeletes;

    const STATUS_PENDING     = 'pending';
    const STATUS_ACCEPTED    = 'accepted';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_REJECTED    = 'rejected';

    const TYPE_MEMBER        = 'member';
    const TYPE_VENDOR        = 'vendor';
    const TYPE_MISSION       = 'mission';

    const DELAY_IN_DAYS      = 14;

    protected $table = 'addworking_enterprise_invitations';

    protected $fillable = [
        'contact',
        'contact_name',
        'contact_enterprise_name',
        'type',
        'status',
        'valid_until',
        'additional_data',
    ];

    protected $dates = [
        'valid_until',
        'created_at',
        'updated_at'
    ];

    protected $routePrefix = 'addworking.enterprise.invitation';

    protected $routeParameterAliases = [
        'enterprise' => "host",
    ];

    protected $viewPrefix = 'addworking.enterprise.invitation';

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function host()
    {
        return $this->belongsTo(Enterprise::class, 'host_id')->withDefault();
    }

    public function guest()
    {
        return $this->belongsTo(User::class, 'guest_id')->withDefault();
    }

    public function guestEnterprise()
    {
        return $this->belongsTo(Enterprise::class, 'guest_enterprise_id')->withDefault();
    }

    // ------------------------------------------------------------------------
    // Accessors & Mutators
    // ------------------------------------------------------------------------

    public function setContactAttribute($value)
    {
        if (is_email($value)) {
            $this->attributes['contact'] = strtolower($value);
        }
    }

    public function setAdditionalDataAttribute(array $data)
    {
        $this->attributes['additional_data'] = json_encode($data);
    }

    public function getAdditionalDataAttribute($value)
    {
        return json_decode($value, true);
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeFilterInvite($query, $invite)
    {
        return $query->whereHas('guest', function ($query) use ($invite) {
            return $query->name($invite);
        })->orWhereHas('guestEnterprise', function ($query) use ($invite) {
            return $query->ofName($invite);
        })->orWhere(DB::raw('LOWER(contact_name) || LOWER(contact_enterprise_name)'), 'LIKE', "%{$invite}%");
    }

    public function scopeOfStatus($query, String $status)
    {
        if (!in_array($status, self::getAvailableStatuses())) {
            throw new UnexpectedValueException("Invalid status");
        }

        return $query->where('status', $status);
    }

    public function scopeOfCustomer($query, Enterprise $customer)
    {
        return $query->whereHas('host', function ($query) use ($customer) {
            return $query->where('id', $customer->id);
        });
    }

    // ------------------------------------------------------------------------
    // Miscellaneous
    // ------------------------------------------------------------------------

    public function resetExpiringDate(Carbon $startDate = null): self
    {
        $this->valid_until = ($startDate ?? new Carbon())->addDays(self::DELAY_IN_DAYS);

        return $this;
    }

    public static function getAvailableStatuses(bool $trans = false): array
    {
        $statuses = [
            self::STATUS_PENDING     => __("addworking.enterprise.invitation._invitation_status.pending"),
            self::STATUS_ACCEPTED    => __("addworking.enterprise.invitation._invitation_status.accepted"),
            self::STATUS_IN_PROGRESS => __("addworking.enterprise.invitation._invitation_status.in_progress"),
            self::STATUS_REJECTED    => __("addworking.enterprise.invitation._invitation_status.rejected"),
        ];

        return $trans ? $statuses : array_keys($statuses);
    }

    public static function getAvailableTypes(bool $trans = false): array
    {
        $types = [
            self::TYPE_MEMBER        => __("addworking.enterprise.invitation._invitation_types.member"),
            self::TYPE_VENDOR        => __("addworking.enterprise.invitation._invitation_types.vendor"),
            self::TYPE_MISSION       => __("addworking.enterprise.invitation._invitation_types.mission")
        ];

        return $trans ? $types : array_keys($types);
    }

    public static function getMessageByStatus(): array
    {
        return [
            self::STATUS_ACCEPTED    => 'Invitation déjà acceptée.',
            self::STATUS_IN_PROGRESS => 'Invitation déjà envoyé, en attente de validation.',
            self::STATUS_PENDING     => 'Invitation en attente de réponse.'
        ];
    }

    public function isAccepted(): bool
    {
        return $this->status === self::STATUS_ACCEPTED;
    }

    public function isValidating(): bool
    {
        return $this->status === self::STATUS_IN_PROGRESS;
    }

    public function markAs(string $status) : self
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }
}
