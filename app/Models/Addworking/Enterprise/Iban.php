<?php

namespace App\Models\Addworking\Enterprise;

use App\Helpers\HasUuid;
use App\Models\Addworking\Common\Concerns\File\HasAttachments;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Intervention\Validation\Validator;
use UnexpectedValueException;
use Venturecraft\Revisionable\RevisionableTrait as Revisionable;

class Iban extends Model implements Htmlable
{
    use Revisionable,
        SoftDeletes,
        HasUuid,
        Viewable,
        Routable,
        HasAttachments;

    const STATUS_APPROVED = 'approved';
    const STATUS_PENDING  = 'pending';
    const STATUS_EXPIRED  = 'expired';

    protected $table = 'addworking_enterprise_ibans';

    protected $fillable = [
        'iban',
        'bic',
        'status',
        'validation_token',
        'label'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $keepRevisionOf = [
        'iban',
        'bic',
        'file_id',
        'label'
    ];

    protected $routePrefix = "enterprise.iban";

    public function __toString()
    {
        return (string) $this->iban;
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($model) {
            $model->file()->delete();
        });
    }

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function file()
    {
        return $this->belongsTo(File::class)->withDefault();
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    // ------------------------------------------------------------------------
    // Attributes
    // ------------------------------------------------------------------------

    public function setIbanAttribute($value)
    {
        if ($value && !Validator::isIban($value)) {
            throw new UnexpectedValueException("Invalid IBAN");
        }

        $this->attributes['iban'] = str_replace(' ', '', strtoupper($value));
    }

    public function setBicAttribute($value)
    {
        if ($value && !Validator::isBic($value)) {
            throw new UnexpectedValueException("Invalid BIC");
        }

        $this->attributes['bic'] = str_replace(' ', '', strtoupper($value));
    }

    public function setStatusAttribute($value)
    {
        if (!in_array($value, self::getAvailableStatuses())) {
            throw new UnexpectedValueException("Invalid status");
        }

        $this->attributes['status'] = $value;
    }

    public function setLabelAttribute($value)
    {
        $this->attributes['label'] = $value;
    }

    public function getFormattedLabelAttribute()
    {
        return isset($this->label) ? "{$this->iban} - {$this->label}" : "{$this->iban}";
    }
    // ------------------------------------------------------------------------
    // Other
    // ------------------------------------------------------------------------

    public function isApproved(): bool
    {
        return $this->status == self::STATUS_APPROVED;
    }

    public function isPending(): bool
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function isExpired(): bool
    {
        return $this->status == self::STATUS_EXPIRED;
    }

    public static function getAvailableStatuses(): array
    {
        return [
            self::STATUS_APPROVED,
            self::STATUS_PENDING,
            self::STATUS_EXPIRED,
        ];
    }
}
