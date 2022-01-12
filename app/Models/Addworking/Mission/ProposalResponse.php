<?php

namespace App\Models\Addworking\Mission;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Models\Addworking\Common\Concerns\Comment\Commentable;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Mission\Offer;
use App\Models\Addworking\User\User;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use UnexpectedValueException;

class ProposalResponse extends Model implements Htmlable
{
    use SoftDeletes,
        HasUuid,
        Viewable,
        Routable,
        Commentable;

    const STATUS_PENDING             = 'pending';
    const STATUS_OK_TO_MEET          = 'ok_to_meet';
    const STATUS_INTERVIEW_REQUESTED = 'interview_requested';
    const STATUS_INTERVIEW_POSITIVE  = 'interview_positive';
    const STATUS_FINAL_VALIDATION    = 'final_validation';
    const STATUS_REFUSED             = 'refused';

    const REJECTED_FOR_ANSWER_NOT_OK     = 'answer_not_ok';
    const REJECTED_FOR_QUANTITY_NOT_OK   = 'quantity_not_ok';
    const REJECTED_FOR_UNIT_PRICE_NOT_OK = 'unit_price_not_ok';
    const REJECTED_FOR_ENDS_AT_NOT_OK    = 'ends_at_not_ok';
    const REJECTED_FOR_STARTS_AT_NOT_OK  = 'starts_at_not_ok';
    const REJECTED_FOR_OTHER             = 'other';

    const UNIT_HOURS      = 'hours';
    const UNIT_DAYS       = 'days';
    const UNIT_FIXED_FEES = 'fixed_fees';
    const UNIT_UNIT       =  'unit';

    protected $table = 'addworking_mission_proposal_responses';

    protected $fillable = [
        'status',
        'starts_at',
        'ends_at',
        'quantity',
        'valid_from',
        'valid_until',
        'accepted_at',
        'refused_at',
        'unit',
        'unit_price',
        'reason_for_rejection',
        'files', //virtual
    ];

    protected $dates = [
        'starts_at',
        'ends_at',
        'valid_from',
        'valid_until',
        'accepted_at',
        'refused_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'quantity' => 'float',
        'unit_price'   => 'float',
    ];

    protected $attributes = [
        'unit'   => self::UNIT_DAYS,
    ];

    protected $routePrefix = "enterprise.offer.proposal.response";

    protected $routeParameterAliases = [
        'response' => "proposal_response",
        'enterprise' => "customer",
    ];

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id');
    }

    public function mission()
    {
        return $this->hasOne(Mission::class)->withDefault();
    }

    public function files()
    {
        return $this
            ->belongsToMany(
                File::class,
                'addworking_mission_proposal_response_has_files',
                'response_id'
            )
            ->withTimestamps();
    }

    public function acceptedBy()
    {
        return $this->belongsTo(User::class, 'accepted_by');
    }

    public function refusedBy()
    {
        return $this->belongsTo(User::class, 'refused_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function setStatusAttribute($value)
    {
        if (!is_null($value) && !in_array($value, self::getAvailableStatuses())) {
            throw new UnexpectedValueException("Invalid status");
        }

        $this->attributes['status'] = $value;
    }

    public function setUnitAttribute($value)
    {
        if (!is_null($value) && !in_array($value, self::getAvailableUnits())) {
            throw new UnexpectedValueException("Invalid unit");
        }

        $this->attributes['unit'] = $value;
    }

    public function setFilesAttribute($values)
    {
        if (is_null($values)) {
            return;
        }

        foreach ($values as $value) {
            $file = File::from($value)
                ->name("/%uniq%-%ts%.%ext%")
                ->saveAndGet();

            $this->files()->attach($file);
        }
    }

    public function setReasonForRejectionAttribute($value)
    {
        if (!is_null($value) && !in_array($value, self::getAvailableReasonForRejection())) {
            throw new UnexpectedValueException("Invalid reason for rejection");
        }

        $this->attributes['reason_for_rejection'] = $value;
    }

    // ------------------------------------------------------------------------
    // Miscelaneous
    // ------------------------------------------------------------------------

    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_OK_TO_MEET,
            self::STATUS_INTERVIEW_REQUESTED,
            self::STATUS_INTERVIEW_POSITIVE,
            self::STATUS_FINAL_VALIDATION,
            self::STATUS_REFUSED,
        ];
    }

    public static function getAvailableUnits()
    {
        return [
            self::UNIT_HOURS,
            self::UNIT_DAYS,
            self::UNIT_FIXED_FEES,
            self::UNIT_UNIT,
            
        ];
    }

    public static function getAvailableReasonForRejection()
    {
        return [
            self::REJECTED_FOR_QUANTITY_NOT_OK,
            self::REJECTED_FOR_UNIT_PRICE_NOT_OK,
            self::REJECTED_FOR_ENDS_AT_NOT_OK,
            self::REJECTED_FOR_STARTS_AT_NOT_OK,
            self::REJECTED_FOR_ANSWER_NOT_OK,
            self::REJECTED_FOR_OTHER,
        ];
    }

    public function isRefused()
    {
        return $this->status == self::STATUS_REFUSED;
    }

    public function isFinalValidated()
    {
        return $this->status == self::STATUS_FINAL_VALIDATION;
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeFilterLabel($query, $label)
    {
        return $query->whereHas('proposal', function ($query) use ($label) {
            return $query->whereHas('offer', function ($query) use ($label) {
                return $query->where('label', 'like', "%".$label."%");
            });
        });
    }

    public function scopeFilterCustomer($query, $enterprise)
    {
        return $query->whereHas('proposal', function ($query) use ($enterprise) {
            return $query->whereHas('offer', function ($query) use ($enterprise) {
                return $query->whereHas('customer', function ($query) use ($enterprise) {
                    $query->where(DB::raw('LOWER(name)'), 'like', "%". strtolower($enterprise)."%");
                });
            });
        });
    }

    public function scopeFilterVendor($query, $enterprise)
    {
        return $query->whereHas('proposal', function ($query) use ($enterprise) {
            return $query->whereHas('vendor', function ($query) use ($enterprise) {
                $query->where(DB::raw('LOWER(name)'), 'like', "%". strtolower($enterprise)."%");
            });
        });
    }

    public function scopeFilterCreatedAt($query, $date)
    {
        return $query->where('created_at', 'like', "%{$date}%");
    }

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeOfOffer($query, Offer $offer)
    {
        return $query->whereHas(
            'proposal',
            fn ($q) => $q->whereHas(
                'offer',
                fn ($q) => $q->whereId($offer->id)
            )
        );
    }
}
