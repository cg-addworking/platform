<?php

namespace App\Models\Addworking\Enterprise;

use Components\Enterprise\Document\Application\Repositories\DocumentTypeRejectReasonRepository;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Illuminate\Support\Facades\App;
use ZipArchive;
use Carbon\Carbon;
use RuntimeException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Conner\Tagging\Taggable;
use UnexpectedValueException;
use Illuminate\Support\Facades\DB;
use App\Contracts\Models\Searchable;
use App\Models\Addworking\User\User;
use App\Helpers\HasUuid;
use App\Models\Addworking\Common\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Common\Common\Application\Models\Action;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Components\Contract\Contract\Application\Models\Contract;
use App\Models\Addworking\Common\Concerns\Comment\Commentable;
use Components\Infrastructure\Foundation\Application\Model\Routable;
use Components\Infrastructure\Foundation\Application\Model\Viewable;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Components\Contract\Model\Application\Models\ContractModelDocumentType;

class Document extends Model implements Htmlable, Searchable
{
    use HasUuid, Viewable, Routable, Commentable, Taggable, SoftDeletes;

    const STATUS_PENDING_SIGNATURE = 'pending_signature';
    const STATUS_REFUSED_SIGNATURE = 'refused_signature';
    const STATUS_PENDING   = 'pending';
    const STATUS_VALIDATED = 'validated';
    const STATUS_REJECTED  = 'rejected';
    const STATUS_OUTDATED  = 'outdated';

    const REJECTED_FOR_NON_COMPLIANCE = 'non_compliance';
    const REJECTED_FOR_INCOMPLETE = 'document_incomplete';
    const REJECTED_FOR_EXPIRATION = 'document_outdated';

    protected $table = 'addworking_enterprise_documents';

    protected $fillable = [
        'file', // virtual
        'status',
        'reason_for_rejection',
        'valid_from',
        'valid_until',
        'accepted_at',
        'rejected_at',
        'last_notified_at',
        'is_pre_check',
        'signed_at',
        'yousign_file_id',
        'yousign_procedure_id',
        'yousign_member_id',
        'signatory_name',
    ];

    protected $attributes = [
        'status'               => self::STATUS_PENDING,
        'reason_for_rejection' => null,
        'valid_until'          => null,
    ];

    protected $dates = [
        'valid_from',
        'valid_until',
        'accepted_at',
        'rejected_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'last_notified_at',
        'signed_at',
    ];

    protected $searchable = [];

    protected $routePrefix = "addworking.enterprise.document";

    public function __toString()
    {
        return $this->getNameAttribute();
    }

    // ------------------------------------------------------------------------
    // Relationships
    // ------------------------------------------------------------------------

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'type_id')->withDefault();
    }

    public function documentTypeModel()
    {
        return $this->belongsTo(DocumentTypeModel::class, 'document_type_model_id')->withDefault();
    }

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class, 'enterprise_id')->withDefault();
    }

    public function signedBy()
    {
        return $this->belongsTo(User::class, 'signed_by')->withDefault();
    }

    public function files()
    {
        return $this->belongsToMany(
            File::class,
            'addworking_enterprise_document_has_files',
            'document_id',
            'file_id'
        )->withTimestamps();
    }

    public function fields()
    {
        return $this
            ->belongsToMany(
                DocumentTypeField::class,
                'addworking_enterprise_document_has_fields',
                'document_id',
                'field_id'
            )
            ->withPivot('content')
            ->whereNull('addworking_enterprise_document_has_fields.deleted_at')
            ->withTimestamps();
    }

    public function actions()
    {
        return $this->morphMany(Action::class, 'trackable');
    }

    public function acceptedBy()
    {
        return $this->belongsTo(User::class, 'accepted_by')->withDefault();
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by')->withDefault();
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id')->withDefault();
    }

    public function contractModelPartyDocumentType()
    {
        return $this->belongsTo(ContractModelDocumentType::class, 'contract_model_party_document_type_id')
            ->withDefault();
    }

    public function proofAuthenticity()
    {
        return $this->belongsTo(File::class, 'proof_authenticity_id')->withDefault();
    }

    public function requiredDocument()
    {
        return $this->belongsTo(File::class, "required_document_id")->withDefault();
    }

    // ------------------------------------------------------------------------
    // Scopes
    // ------------------------------------------------------------------------

    public function scopeOfEnterprise(Builder $query, Enterprise $enterprise)
    {
        return $query->whereHas('enterprise', function (Builder $query) use ($enterprise) {
            return $query->where('id', $enterprise->id);
        });
    }

    public function scopeOfContract(Builder $query, Contract $contract)
    {
        return $query->whereHas('contract', function (Builder $query) use ($contract) {
            return $query->where('id', $contract->getId());
        });
    }

    public function scopeOfDocumentType(Builder $query, DocumentType $document_type)
    {
        return $query->whereHas('documentType', function (Builder $query) use ($document_type) {
            return $query->where('id', $document_type->id);
        });
    }

    public function scopeOfDocumentTypes($query, Collection $types)
    {
        return $query->whereHas('documentType', function ($query) use ($types) {
            return $query->whereIn('id', $types->pluck('id'));
        });
    }

    public function scopeOnlyPending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeOnlyValidated(Builder $query)
    {
        return $query->where('status', self::STATUS_VALIDATED);
    }

    public function scopeOnlyPendingOrValidated(Builder $query)
    {
        return $query->whereIn('status', [self::STATUS_PENDING, self::STATUS_VALIDATED]);
    }

    public function scopeOnlyRejected(Builder $query)
    {
        return $query->where('status', self::STATUS_REJECTED);
    }

    public function scopeOnlyOutdated(Builder $query)
    {
        return $query->where('status', self::STATUS_OUTDATED);
    }

    public function scopeWithDocumentType(Builder $query, $document_type)
    {
        return $query->whereHas('documentType', function (Builder $query) use ($document_type) {
            return $query->whereIn('id', Arr::wrap($document_type));
        });
    }

    public function scopeOfVendor(Builder $query, Enterprise $vendor)
    {
        return $query->whereHas('enterprise', function ($query) use ($vendor) {
            return $query->where('id', $vendor->id);
        });
    }

    public function scopeCreatedAfter(Builder $query, $created_after)
    {
        return $query->where('created_at', '>=', $created_after);
    }

    public function scopeCreatedBefore(Builder $query, $created_before)
    {
        return $query->where('created_at', '<=', $created_before);
    }

    public function scopeStatus(Builder $query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeExpired(Builder $query)
    {
        return $query->where('valid_until', '<=', Carbon::now());
    }

    public function scopeInvalid(Builder $query)
    {
        return $query->where(function ($q) {
            return $q->expired()->orWhereIn('status', [self::STATUS_REJECTED, self::STATUS_OUTDATED]);
        });
    }

    public function scopeRequiredBy(Builder $query, Enterprise $customer)
    {
        return $query->whereHas('documentType', function ($q) use ($customer) {
            return $q->requiredByCustomer($customer);
        });
    }

    public function scopeFilterCustomer($query, $customer)
    {
        return $query->whereHas('documentType', function ($query) use ($customer) {
            return $query->whereHas('enterprise', function ($query) use ($customer) {
                $query->where(DB::raw('LOWER(name)'), 'like', "%" . strtolower($customer) . "%");
            });
        });
    }

    public function scopeOwnerOfDocumentType($query, $owner)
    {
        return $query->whereHas('documentType', function ($query) use ($owner) {
            return $query->whereHas('enterprise', function ($query) use ($owner) {
                $ancestors = app(FamilyEnterpriseRepository::class)
                    ->getAncestors(Enterprise::find($owner), true)->pluck('id');
                return $query->whereIn('id', $ancestors);
            });
        });
    }

    public function scopeOfStatuses($query, array $statuses)
    {
        return $query->whereIn('status', $statuses);
    }

    public function scopeFilterVendor($query, $vendor)
    {
        return $query->whereHas('enterprise', function ($query) use ($vendor) {
            $query->where(DB::raw('LOWER(name)'), 'like', "%" . strtolower($vendor) . "%");
        });
    }

    public function scopeSearch($query, string $search): Builder
    {
        $search = strtolower($search);

        return $query
            ->orWhere(function ($query) use ($search) {
                return $query->filterCustomer($search);
            })
            ->orWhere(function ($query) use ($search) {
                return $query->filterVendor($search);
            })
            ->orWhere(function ($query) use ($search) {
                foreach ($this->searchable as $column) {
                    $query->orWhere(DB::raw("LOWER(CAST({$column} as TEXT))"), 'LIKE', "%{$search}%");
                }
            });
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

    public function setReasonForRejectionAttribute($value)
    {
        if (!is_null($value)
            && !in_array($value, self::getAvailableReasonsForRejection($this->getDocumentType()))) {
            throw new UnexpectedValueException("Invalid reason for rejection");
        }

        $this->attributes['reason_for_rejection'] = $value;
    }

    public function setFileAttribute($value)
    {
        if (is_null($value)) {
            return;
        }

        $file = File::from($value)->name("/%uniq%-%ts%.%ext%")->saveAndGet();

        $this->files()->attach($file);
    }

    public function getFilename() : string
    {
        return sprintf(
            "%s_%s_%s.zip",
            date('YmdHis'),
            Str::slug($this->enterprise->name),
            Str::slug($this->documentType->display_name)
        );
    }

    public function getStatusLabelAttribute()
    {
        if (! $this->exists) {
            return __("Manquant");
        }

        if ($this->isRejected() && $this->reason_for_rejection) {
            return sprintf(
                "%s: %s",
                self::getAvailableStatuses(true)[$this->status],
                $this->reason_for_rejection
            );
        }

        return self::getAvailableStatuses(true)[$this->status] ?? __("Inconnu");
    }

    public function getNameAttribute()
    {
        return (string) $this->documentType;
    }

    public function setPreCheckAttribute(bool $bool)
    {
        $this->is_pre_check = $bool;
    }

    public function getPreCheckAttribute()
    {
        return $this->is_pre_check;
    }

    public function getEnterprise()
    {
        return $this->enterprise;
    }

    public function getDocumentType()
    {
        return $this->documentType()->first();
    }

    public function getExpiresInAttribute()
    {
        $now = Carbon::now();
        if (! is_null($this->valid_until) && $this->valid_until->gt($now)) {
            $diff = $this->valid_until->diffInDays($now);
            return ($diff > 0) ? $diff : 0;
        }

        return 0;
    }

    public function getExpiredSinceAttribute()
    {
        $now = Carbon::now();
        if (! is_null($this->valid_until) && $this->valid_until->lt($now)) {
            $diff = $this->valid_until->diffInDays($now);
            return ($diff > 0) ? $diff : 0;
        }

        return 0;
    }

    public function getProofAuthenticity(): ?File
    {
        return $this->proofAuthenticity()->first();
    }

    public function setProofAuthenticity(File $file): void
    {
        $this->proofAuthenticity()->associate($file);
    }

    // ------------------------------------------------------------------------
    // Misc
    // ------------------------------------------------------------------------

    public function newCollection(array $models = [])
    {
        return new DocumentCollection($models);
    }

    public static function getAvailableStatuses(bool $translate = false): array
    {
        $statuses = [
            self::STATUS_PENDING   => __("En attente"),
            self::STATUS_VALIDATED => __("Validé"),
            self::STATUS_REJECTED  => __("Rejeté"),
            self::STATUS_OUTDATED  => __("Périmé"),
        ];

        return $translate ? $statuses : array_keys($statuses);
    }

    public static function getAvailableReasonsForRejection(DocumentType $document_type): array
    {
        return App::make(DocumentTypeRejectReasonRepository::class)->listRejectReason($document_type)->toArray();
    }

    public function isPending(): bool
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function isValidated(): bool
    {
        return $this->status == self::STATUS_VALIDATED;
    }

    public function isRejected(): bool
    {
        return $this->status == self::STATUS_REJECTED;
    }

    public function isOutdated(): bool
    {
        return $this->status == self::STATUS_OUTDATED;
    }

    public function hasExpired(): bool
    {
        return !is_null($this->valid_until) && $this->isValidated() && $this->valid_until->endOfDay()->isPast();
    }

    public function isInvalid(): bool
    {
        return ! $this->exists || $this->isRejected() || $this->isOutdated() || $this->hasExpired();
    }

    public function shouldNotify(int $days): bool
    {
        return is_null($this->last_notified_at) ||
            ($this->last_notified_at->addDays($days)->toDateString() === Carbon::now()->toDateString());
    }

    public function expiresInStrictly(int $days): bool
    {
        return !is_null($this->valid_until) &&
            $this->isValidated() &&
            (Carbon::now()->toDateString() === $this->valid_until->subDays($days)->toDateString());
    }

    public function expiredSince(int $days): bool
    {
        return !is_null($this->valid_until) &&
            $this->isOutdated() &&
            ($this->valid_until->addDays($days)->toDateString() >= Carbon::now()->toDateString());
    }

    public function expiresIn(int $days): bool
    {
        return $this->isValidated() && $this->valid_until->endOfDay()->subDays($days)->isPast();
    }

    public function zip() : string
    {
        if (! $this->files()->exists()) {
            throw new RuntimeException('Some files are missing');
        }

        $zip  = new ZipArchive();
        $path = storage_path("temp/{$this->id}.zip");
        $zip->open($path, ZipArchive::CREATE);

        foreach ($this->files()->cursor() as $i => $file) {
            $zip->addFromString(
                vsprintf("%s-part%d.%s", [
                    Str::slug($this->documentType->display_name), $i, $file->extension
                ]),
                $file->content
            );
        }

        $zip->close();
        return $path;
    }

    public function sendToStorage(string $disk = null): bool
    {
        $disk   = $disk ?? Config::get('documents.storage.disk');
        $path   = $this->zip();
        $handle = fopen($path, 'r');

        $result = Storage::disk($disk)->put($this->getStoragePath(), $handle);

        unlink($path);
        return $result;
    }

    public function getStoragePath(): string
    {
        if (! $this->enterprise->exists) {
            throw new ModelNotFoundException("No enterprise found on document");
        }

        return vsprintf("%s/%s/%s.%s", [
            $this->enterprise->id, $this->documentType->id, $this->id, 'zip'
        ]);
    }

    public function getDocumentTypeModel()
    {
        return $this->documentTypeModel()->first();
    }

    public function getRequiredDocument(): ?File
    {
        return $this->requiredDocument()->first();
    }

    public function setRequiredDocument(File $file)
    {
        $this->requiredDocument()->associate($file)->save();
    }
  
    public function getYousignMemberId(): ?string
    {
        return $this->yousign_member_id;
    }

    public function setSignatoryName(?string $signatory_name)
    {
        $this->signatory_name = $signatory_name;
    }

    public function getSignatoryName(): ?string
    {
        return $this->signatory_name;
    }

    public function getSignedAt()
    {
        return $this->signed_at;
    }

    public function getValidUntil()
    {
        return $this->valid_until;
    }

    public function getValidFrom()
    {
        return $this->valid_from;
    }
}
