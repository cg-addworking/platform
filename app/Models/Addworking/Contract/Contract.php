<?php

namespace App\Models\Addworking\Contract;

use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Helpers\HasUuid;
use App\Contracts\Models\Searchable;
use App\Jobs\Addworking\Contract\Synchronize;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Contract\ContractAddendum;
use App\Models\Addworking\Contract\ContractAnnex;
use App\Models\Addworking\Contract\ContractCompat;
use App\Models\Addworking\Contract\ContractDocument;
use App\Models\Addworking\Contract\ContractParty;
use App\Models\Addworking\Contract\ContractTemplate;
use App\Models\Addworking\Contract\ContractVariable;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Models\Concerns\HasFilters;
use App\Models\Concerns\HasNumber;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Venturecraft\Revisionable\RevisionableTrait as Revisionable;

class Contract extends Model implements Htmlable, Searchable
{
    use SoftDeletes,
        Revisionable,
        Viewable,
        Routable,
        HasUuid,
        HasNumber,
        HasFilters,
        ContractCompat;

    const STATUS_DRAFT             = "draft";
    const STATUS_READY_TO_GENERATE = "ready_to_generate";
    const STATUS_GENERATING        = "generating";
    const STATUS_GENERATED         = "generated";
    const STATUS_UPLOADING         = "uploading";
    const STATUS_UPLOADED          = "uploaded";
    const STATUS_READY_TO_SIGN     = "ready_to_sign";
    const STATUS_BEING_SIGNED      = "being_signed";
    const STATUS_CANCELLED         = "cancelled";
    const STATUS_ACTIVE            = "active";
    const STATUS_INACTIVE          = "inactive";
    const STATUS_EXPIRED           = "expired";
    const STATUS_ERROR             = "error";
    const STATUS_DECLINED          = "declined";
    const STATUS_LOCKED            = "locked";
    const STATUS_UNKNOWN           = "unknown";

    const TYPE_CPS1                = "cps1";
    const TYPE_CPS2                = "cps2";
    const TYPE_CPS3                = "cps3";

    protected $with = ['contractParties'];

    protected $table = "addworking_contract_contracts";

    protected $viewPrefix = "addworking.contract.contract";

    protected $routePrefix = "addworking.contract.contract";

    protected $fillable = [
        'status',
        'name',
        'valid_from',
        'valid_until',
        'signinghub_package_id',
        'signinghub_document_id',
        'external_identifier',
    ];

    protected $dates = [
        'valid_from',
        'valid_until',
        'deleted_at',
    ];

    protected $keepRevisionOf = [
        'status',
        'name',
        'valid_from',
        'valid_until',
        'signinghub_package_id',
        'signinghub_document_id',
        'external_identifier',
    ];

    protected $revisionCreationsEnabled = true;

    protected $searchable = [];

    public function __toString()
    {
        return $this->name ?? 'n/a';
    }

    // ------------------------------------------------------------------------
    // Relationships

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function contractAnnexes()
    {
        return $this->hasMany(ContractAnnex::class);
    }

    public function contractDocuments()
    {
        return $this->hasManyThrough(ContractDocument::class, ContractParty::class);
    }

    public function contractParties()
    {
        return $this->hasMany(ContractParty::class);
    }

    public function contractTemplate()
    {
        return $this->belongsTo(ContractTemplate::class, 'contract_model_id')->withDefault();
    }

    public function contractVariables()
    {
        return $this->hasMany(ContractVariable::class);
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function file()
    {
        return $this->belongsTo(File::class)->withDefault();
    }

    public function parent()
    {
        return $this->belongsTo(self::class)->withDefault();
    }

    // ------------------------------------------------------------------------
    // Attributes

    /**
     * @deprecated v0.5.48 use the signed scopes instead
     */
    public function getSignedAttribute()
    {
        foreach ($this->users as $user) {
            if (!$this->isSignedBy($user)) {
                return false;
            }
        }

        return true;
    }

    public function getNextSignatoryAttribute(): ?User
    {
        foreach ($this->users()->orderBy('pivot_order')->get() as $user) {
            if (!$user->pivot->signed) {
                return $user;
            }
        }

        return null;
    }

    public function setStatusAttribute($value)
    {
        $value = strtolower($value);

        if (! in_array($value, $this->getAvailableStatuses(), true)) {
            throw new InvalidArgumentException("invalid status: $value");
        }

        $this->attributes['status'] = $value;
    }

    public function setValidFromAttribute($value)
    {
        if (is_date_fr($value)) {
            $value = date_fr_to_iso($value);
        }

        $this->attributes['valid_from'] = $this->fromDateTime($value);
    }

    public function setValidUntilAttribute($value)
    {
        if (is_date_fr($value)) {
            $value = date_fr_to_iso($value);
        }

        $this->attributes['valid_until'] = $this->fromDateTime($value);
    }

    // ------------------------------------------------------------------------
    // Scopes

    public function scopeExceptAddendums($query)
    {
        return $query->whereDoesntHave('parent');
    }

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeDraft($query)
    {
        return $this->scopeStatus($query, self::STATUS_DRAFT);
    }

    public function scopeReadyToGenerate($query)
    {
        return $this->scopeStatus($query, self::STATUS_READY_TO_GENERATE);
    }

    public function scopeGenerating($query)
    {
        return $this->scopeStatus($query, self::STATUS_GENERATING);
    }

    public function scopeGenerated($query)
    {
        return $this->scopeStatus($query, self::STATUS_GENERATED);
    }

    public function scopeUploading($query)
    {
        return $this->scopeStatus($query, self::STATUS_UPLOADING);
    }

    public function scopeUploaded($query)
    {
        return $this->scopeStatus($query, self::STATUS_UPLOADED);
    }

    public function scopeReadyToSign($query)
    {
        return $this->scopeStatus($query, self::STATUS_READY_TO_SIGN);
    }

    public function scopeBeingSigned($query)
    {
        return $this->scopeStatus($query, self::STATUS_BEING_SIGNED);
    }

    public function scopeCancelled($query)
    {
        return $this->scopeStatus($query, self::STATUS_CANCELLED);
    }

    public function scopeInactive($query)
    {
        return $this->scopeStatus($query, self::STATUS_INACTIVE);
    }

    public function scopeExpired($query)
    {
        return $this->scopeStatus($query, self::STATUS_EXPIRED);
    }

    public function scopeError($query)
    {
        return $this->scopeStatus($query, self::STATUS_ERROR);
    }

    public function scopeActive($query)
    {
        return $this->scopeStatus($query, self::STATUS_ACTIVE);
    }

    public function scopeNotActive($query)
    {
        return $query->where('status', '!=', self::STATUS_ACTIVE);
    }

    public function scopeOfEnterprise($query, Enterprise $enterprise)
    {
        return $query->where(function ($query) use ($enterprise) {
            $query->whereHas('enterprise', fn($q) => $q->whereId($enterprise->id))
                ->orWhereHas('contractParties', fn($q) => $q->whereEnterprise($enterprise));
        });
    }

    public function scopeOfTemplate($query, ContractTemplate $template)
    {
        return $query->whereHas('contractTemplate', fn($q) => $q->whereId($template->id));
    }

    public function scopeCreatedAt($query, $date)
    {
        return $query->where('created_at', 'like', "%{$date}%");
    }

    public function scopeValidFrom($query, $date)
    {
        return $query->where('valid_from', 'like', "%{$date}%");
    }

    public function scopeValidUntil($query, $date)
    {
        return $query->where('valid_until', 'like', "%{$date}%");
    }

    public function scopeSearch($query, string $search): Builder
    {
        $search = strtolower($search);

        return $query
            ->orWhere(function ($query) use ($search) {
                foreach ($this->searchable as $column) {
                    $query->orWhere(DB::raw("LOWER(CAST({$column} as TEXT))"), 'LIKE', "%{$search}%");
                }
            });
    }

    public function scopeOrphan($query)
    {
        return $query->doesntHave('enterprise');
    }

    public function scopeName($query, $name)
    {
        return $query->where(DB::raw('LOWER(name)'), 'like', strtolower("%{$name}%"));
    }

    public function scopeContractPartyEnterprise($query, $name)
    {
        return $query->whereHas('contractParties', function ($query) use ($name) {
            return $query->whereHas('enterprise', function ($query) use ($name) {
                return $query->where(DB::raw('LOWER(name)'), 'like', strtolower("%{$name}%"));
            });
        });
    }

    // ------------------------------------------------------------------------
    // Misc

    public function isAddendum(): bool
    {
        return $this->parent->exists;
    }

    public static function getAvailableStatuses(): array
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_READY_TO_GENERATE,
            self::STATUS_GENERATING,
            self::STATUS_GENERATED,
            self::STATUS_UPLOADING,
            self::STATUS_UPLOADED,
            self::STATUS_READY_TO_SIGN,
            self::STATUS_BEING_SIGNED,
            self::STATUS_CANCELLED,
            self::STATUS_ACTIVE,
            self::STATUS_INACTIVE,
            self::STATUS_EXPIRED,
            self::STATUS_ERROR,
            self::STATUS_DECLINED,
        ];
    }

    public static function getAvailableTypes(): array
    {
        return [
            self::TYPE_CPS1,
            self::TYPE_CPS2,
            self::TYPE_CPS3,
        ];
    }
}
