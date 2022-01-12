<?php

namespace Components\Contract\Model\Application\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\Addworking\User\User;
use App\Helpers\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;

class ContractModel extends Model implements ContractModelEntityInterface
{
    use HasUuid, SoftDeletes;

    protected $table = "addworking_contract_contract_models";

    protected $fillable = [
        'name',
        'display_name',
        'published_at',
        'archived_at',
        'number',
        'version_number',
        'should_vendors_fill_their_variables',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'published_at',
        'archived_at',
    ];

    protected $with = [
        'parties',
        'parts',
        'variables',
    ];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------

    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function duplicatedFrom()
    {
        return $this->belongsTo(self::class)->withDefault();
    }

    public function previous()
    {
        return $this->belongsTo(self::class)->withDefault();
    }

    public function publishedBy()
    {
        return $this->belongsTo(User::class, 'published_by')->withDefault();
    }

    public function archivedBy()
    {
        return $this->belongsTo(User::class, 'archived_by')->withDefault();
    }

    public function parties()
    {
        return $this->hasMany(ContractModelParty::class, 'contract_model_id');
    }

    public function parts()
    {
        return $this->hasMany(ContractModelPart::class, 'contract_model_id');
    }

    public function variables()
    {
        return $this->hasMany(ContractModelVariable::class, 'model_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'contract_model_id');
    }

    public function versionningFrom()
    {
        return $this->belongsTo(self::class)->withDefault();
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------

    public function setEnterprise($enterprise)
    {
        $this->enterprise()->associate($enterprise);
    }

    public function setDisplayName(string $display_name)
    {
        $this->display_name = $display_name;
    }

    public function setName(string $display_name)
    {
        $this->name = Str::slug($display_name);
    }

    public function setNumber()
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setPublishedAt()
    {
        $this->published_at = Carbon::now();
    }

    public function setPublishedBy($user)
    {
        $this->publishedBy()->associate($user);
    }

    public function setDuplicatedFrom($model)
    {
        $this->duplicatedFrom()->associate($model);
    }

    public function setDraft()
    {
        $this->published_at = null;
        $this->archived_at = null;
    }

    public function setVersion(int $value)
    {
        $this->version_number = $value;
    }

    public function setArchivedAt()
    {
        $this->archived_at = Carbon::now();
    }

    public function setArchivedBy($user)
    {
        $this->archivedBy()->associate($user);
    }

    public function setVersionningFrom($model)
    {
        $this->versionningFrom()->associate($model);
    }

    public function setShouldVendorsFillTheirVariables(bool $should_vendors_fill_their_variables): void
    {
        $this->should_vendors_fill_their_variables = $should_vendors_fill_their_variables;
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------

    public function getDisplayName(): ?string
    {
        return $this->display_name;
    }

    public function getEnterprise(): ?Enterprise
    {
        return $this->enterprise()->first();
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    public function getPublishedAt()
    {
        return $this->published_at;
    }

    public function getArchivedAt()
    {
        return $this->archived_at;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getParties()
    {
        return $this->parties()->get();
    }

    public function getParts()
    {
        return $this->parts()->get();
    }

    public function getVariables()
    {
        return $this->variables()->get();
    }

    public function getStatus(): string
    {
        switch (true) {
            case ! is_null($this->getArchivedAt()):
                return self::STATUS_ARCHIVED;
                break;
            case ! is_null($this->getPublishedAt()):
                return self::STATUS_PUBLISHED;
                break;
            default:
                return self::STATUS_DRAFT;
        }
    }

    public function getDuplicatedFrom()
    {
        return $this->duplicatedFrom()->first();
    }

    public function getContracts()
    {
        return $this->contracts()->get();
    }

    public function getVersion()
    {
        return $this->version_number;
    }

    public function getVersionningFrom()
    {
        return $this->versionningFrom()->first();
    }

    public function getDisplayNameWithOwnerAttribute()
    {
        if ($this->getEnterprise()) {
            return $this->getDisplayName().' ('.$this->getEnterprise()->name.')';
        }

        return $this->getDisplayName();
    }

    public function getShouldVendorsFillTheirVariables(): ?bool
    {
        return $this->should_vendors_fill_their_variables;
    }

    public function scopeFilterStatus($query, $statuses)
    {
        return $query
            ->when(in_array('Draft', $statuses) ?? null, function ($query) {
                return $query->whereNull('archived_at')
                             ->whereNull('published_at');
            })
            ->when(in_array('Published', $statuses)  ?? null, function ($query) {
                return $query->orwhereNotNull('published_at');
            })
            ->when(in_array('Archived', $statuses)  ?? null, function ($query) {
                return $query->orwhereNotNull('archived_at');
            });
    }

    public function scopeFilterEnterprise($query, $enterprises)
    {
        return $query->whereHas('enterprise', function ($query) use ($enterprises) {
            return $query->whereIn('id', Arr::wrap($enterprises));
        });
    }

    public function scopeSearch($query, string $search, string $operator = null, string $field_name = null)
    {
        switch ($operator) {
            case "equal":
                return $query->where($field_name, $search)
                    ->orWhere($field_name, strtolower($search))
                    ->orWhere($field_name, strtoupper($search));

            case "like":
                return $query->where($field_name, 'LIKE', "%".$search."%")
                    ->orWhere($field_name, 'LIKE', "%".strtolower($search)."%")
                    ->orWhere($field_name, 'LIKE', "%".strtoupper($search)."%");
        }
    }
}
