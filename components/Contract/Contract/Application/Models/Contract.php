<?php

namespace Components\Contract\Contract\Application\Models;

use App\Models\Addworking\Common\Concerns\Comment\Commentable;
use App\Helpers\HasUuid;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Common\Common\Application\Models\Action;
use Components\Contract\Contract\Application\Models\Scopes\SearchScope;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Mission\Mission\Application\Models\Mission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class Contract extends Model implements ContractEntityInterface
{
    use HasUuid, SoftDeletes, Commentable, SearchScope;

    protected $table = "addworking_contract_contracts";

    protected $fillable = [
        'name',
        'number',
        'valid_from',
        'valid_until',
        'archived_at',
        'status',
        'state',
        'signinghub_package_id',
        'signinghub_document_id',
        'external_identifier',
        'yousign_procedure_id',
        'canceled_at',
        'inactive_at',
        'sent_to_signature_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'archived_at',
        'valid_from',
        'valid_until',
        'canceled_at',
        'inactive_at',
        'sent_to_signature_at',
    ];

    protected $attributes = [
        'status' => Contract::STATUS_DRAFT,
        'state' => Contract::STATE_DRAFT
    ];

    protected static $cascade_relations = ['parties', 'contractVariables', 'parts'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($resource) {
            foreach (static::$cascade_relations as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    $item->delete();
                }
            }
        });

        static::restoring(function ($resource) {
            foreach (static::$cascade_relations as $relation) {
                foreach ($resource->{$relation}()->withTrashed()->get() as $item) {
                    $item->restore();
                }
            }
        });

        static::updated(function ($resource) {
            /* @var Contract $resource */
            if (!(strcasecmp($resource->getState(), $resource->getOriginal('state')) == 0)) {
                if ($resource->getState() === ContractEntityInterface::STATE_GENERATED) {
                    App::make(ContractRepositoryInterface::class)
                        ->sendNotificationToSendContractToSignature($resource);
                }

                if ($resource->getState() === ContractEntityInterface::STATE_IN_PREPARATION
                    && $resource->getContractModel()->getShouldVendorsFillTheirVariables()
                ) {
                    App::make(ContractRepositoryInterface::class)
                        ->sendNotificationContractNeedsVariablesValues($resource);
                }
            }
        });
    }

    protected $with = ['enterprise', 'contractModel', 'parties'];
    
    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function enterprise()
    {
        return $this->belongsTo(Enterprise::class)->withDefault();
    }

    public function contractModel()
    {
        return $this->belongsTo(ContractModel::class)->withDefault();
    }

    public function contractVariables()
    {
        return $this->hasMany(ContractVariable::class, 'contract_id');
    }

    public function parties()
    {
        return $this->hasMany(ContractParty::class, "contract_id");
    }

    public function parts()
    {
        return $this->hasMany(ContractPart::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id')->withDefault();
    }

    public function amendments()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function captureInvoices()
    {
        return $this->hasMany(CaptureInvoice::class);
    }

    public function contractNotification()
    {
        return $this->hasMany(ContractNotification::class, 'contract_id');
    }

    public function mission()
    {
        return $this->belongsTo(Mission::class, 'mission_id')->withDefault();
    }

    public function workfield()
    {
        return $this->belongsTo(WorkField::class, 'workfield_id')->withDefault();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function archivedBy()
    {
        return $this->belongsTo(User::class, 'archived_by')->withDefault();
    }

    public function actions()
    {
        return $this->morphMany(Action::class, 'trackable');
    }

    public function sentToSignatureBy()
    {
        return $this->belongsTo(User::class, 'sent_to_signature_by')->withDefault();
    }

    public function nextPartyToSign()
    {
        return $this->belongsTo(ContractParty::class, 'next_party_to_sign_id')->withDefault();
    }

    public function nextPartyToValidate()
    {
        return $this->belongsTo(ContractParty::class, 'next_party_to_validate_id')->withDefault();
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by')->withDefault();
    }

    public function subcontractingDeclaration()
    {
        return $this->hasOne(SubcontractingDeclaration::class)->withDefault();
    }

    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------
    public function setEnterprise($enterprise)
    {
        $this->enterprise()->associate($enterprise);
    }

    public function setContractModel(ContractModelEntityInterface $contract_model)
    {
        $this->contractModel()->associate($contract_model);
    }

    public function setParent(ContractEntityInterface $contract)
    {
        $this->parent()->associate($contract);
    }

    public function setWorkfield(WorkField $workfield)
    {
        $this->workfield()->associate($workfield);
    }

    public function setMission(Mission $mission)
    {
        $this->mission()->associate($mission);
    }

    public function setNextPartyToSign(?ContractPartyEntityInterface $contract_party)
    {
        $this->nextPartyToSign()->associate($contract_party);
    }

    public function setNextPartyToValidate(?ContractPartyEntityInterface $contract_party)
    {
        $this->nextPartyToValidate()->associate($contract_party);
    }

    public function setDeletedBy(User $user): void
    {
        $this->deletedBy()->associate($user);
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setNumber()
    {
        $this->number = 1 + (int) self::withTrashed()->get()->max('number');
    }

    public function setValidFrom(?string $valid_from)
    {
        $this->valid_from = $valid_from;
    }

    public function setValidUntil(?string $valid_until)
    {
        $this->valid_until = $valid_until;
    }

    public function setExternalIdentifier(?string $external_identifier)
    {
        $this->external_identifier = $external_identifier;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function setState(string $state)
    {
        $this->state = $state;
    }

    public function setInactiveAt($inactive_at)
    {
        $this->inactive_at = $inactive_at;
    }

    public function setCanceledAt($canceled_at)
    {
        $this->canceled_at = $canceled_at;
    }

    public function setSentToSignatureAt($sent_to_signature_at)
    {
        $this->sent_to_signature_at = $sent_to_signature_at;
    }

    public function setCreatedBy(?User $created_by): void
    {
        $this->createdBy()->associate($created_by);
    }

    public function setSentToSignatureBy(?User $sent_to_signature_by): void
    {
        $this->sentToSignatureBy()->associate($sent_to_signature_by);
    }

    public function setArchivedBy(?User $archived_by): void
    {
        $this->archivedBy()->associate($archived_by);
    }

    public function setArchivedAt(): void
    {
        $this->archived_at = Carbon::today();
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------

    public function getEnterprise(): ?Enterprise
    {
        return $this->enterprise()->first();
    }

    public function getSubcontractingDeclaration()
    {
        return $this->subcontractingDeclaration()->first();
    }

    public function getContractModel(): ?ContractModelEntityInterface
    {
        return $this->contractModel()->first();
    }

    public function getContractVariables()
    {
        return $this->contractVariables()->get();
    }

    public function getParent(): ?ContractEntityInterface
    {
        return $this->parent()->first();
    }

    public function getAmendments()
    {
        return $this->amendments()->get();
    }

    public function getCaptureInvoices()
    {
        return $this->captureInvoices()->get();
    }

    public function getNextPartyToSign(): ?ContractPartyEntityInterface
    {
        return $this->nextPartyToSign()->first();
    }

    public function getNextPartyToValidate(): ?ContractPartyEntityInterface
    {
        return $this->nextPartyToValidate()->first();
    }

    public function getId(): string
    {
        if (! $this->exists) {
            throw new ContractIsNotFoundException($this);
        }

        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getValidFrom()
    {
        return $this->valid_from;
    }

    public function getValidUntil()
    {
        return $this->valid_until;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function getParties()
    {
        return $this->parties()->get();
    }

    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    public function getParts()
    {
        return $this->parts()->get();
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getExternalIdentifier(): ?string
    {
        return $this->external_identifier;
    }

    public function getInactiveAt()
    {
        return $this->inactive_at;
    }

    public function getCanceledAt()
    {
        return $this->canceled_at;
    }

    public function getMission(): ?Mission
    {
        return $this->mission()->first();
    }

    public function getWorkfield(): ?WorkField
    {
        return $this->workfield()->first();
    }

    public function getSentToSignatureAt()
    {
        return $this->sent_to_signature_at;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy()->first();
    }

    public function getSentToSignatureBy(): ?User
    {
        return $this->sentToSignatureBy()->first();
    }

    public function getArchivedBy(): ?User
    {
        return $this->archivedBy()->first();
    }

    public function getArchivedAt()
    {
        return $this->archived_at;
    }

    public function getDeletedBy(): ?User
    {
        return $this->deletedBy()->first();
    }

    // -------------------------------------------------------------------------
    // Filters & Search
    // -------------------------------------------------------------------------

    public function scopeFilterEnterprise($query, $enterprises)
    {
        return $query->whereHas('enterprise', function ($query) use ($enterprises) {
            return $query->whereIn('id', Arr::wrap($enterprises));
        });
    }

    public function scopeFilterStatus($query, $statuses)
    {
        return $query->whereIn('status', Arr::wrap($statuses));
    }

    public function scopeFilterState($query, $states, ?User $user = null)
    {
        return $query->where(function ($q) use ($states, $user) {
            if (!is_null($user)) {
                $states = Arr::wrap($states);
                $array_states = [
                    ContractEntityInterface::STATE_MISSING_DOCUMENTS,
                    ContractEntityInterface::STATE_CANCELED,
                    ContractEntityInterface::STATE_INACTIVE,
                    ContractEntityInterface::STATE_UNKNOWN
                ];

                if (($key = array_search(ContractEntityInterface::STATE_TO_SIGN, $states)) !== false) {
                    unset($states[$key]);
                    $q->orWhere(function ($q) use ($user, $array_states) {
                        $q->whereHas('nextPartyToSign', function ($q) use ($user) {
                            $q->whereHas('signatory', function ($q) use ($user) {
                                $q->where('id', $user->id);
                            });
                        })->whereNotIn('state', $array_states);
                    });
                }

                if (($key = array_search(ContractEntityInterface::STATE_WAITING_FOR_SIGNATURE, $states)) !== false) {
                    unset($states[$key]);
                    $q->orWhere(function ($q) use ($user, $array_states) {
                        $q->whereHas('nextPartyToSign', function ($q) use ($user) {
                            $q->whereHas('signatory', function ($q) use ($user) {
                                $q->where('id', '!=', $user->id);
                            });
                        })->whereNotIn('state', $array_states)
                        ->where('state', ContractEntityInterface::STATE_TO_SIGN);
                    });
                }

                if (($key = array_search(ContractEntityInterface::STATE_TO_VALIDATE, $states)) !== false) {
                    unset($states[$key]);
                    $q->orWhere(function ($q) use ($user, $array_states) {
                        $q->whereHas('nextPartyToValidate', function ($q) use ($user) {
                            $q->whereHas('signatory', function ($q) use ($user) {
                                $q->where('id', $user->id);
                            });
                        })->whereNotIn('state', $array_states)
                        ->where('state', ContractEntityInterface::STATE_TO_VALIDATE);
                    });
                }

                if (($key = array_search(ContractEntityInterface::STATE_UNDER_VALIDATION, $states)) !== false) {
                    unset($states[$key]);
                    $q->orWhere(function ($q) use ($user, $array_states) {
                        $q->whereHas('nextPartyToValidate', function ($q) use ($user) {
                            $q->whereHas('enterprise', function ($q) use ($user) {
                                $q->whereNotIn('id', $user->enterprises->pluck('id'));
                            });
                        })->whereNotIn('state', $array_states)
                        ->where('state', ContractEntityInterface::STATE_TO_VALIDATE);
                    });
                }

                if (($key = array_search(ContractEntityInterface::STATE_INTERNAL_VALIDATION, $states)) !== false) {
                    unset($states[$key]);
                    $q->orWhere(function ($q) use ($user, $array_states, $states) {
                        $q->where(function ($q) use ($states, $user) {
                            $q->whereHas('nextPartyToValidate', function ($q) use ($user) {
                                $q->whereHas('enterprise', function ($q) use ($user) {
                                    $q->whereIn('id', $user->enterprises->pluck('id'));
                                });
                            });

                            $q->whereDoesntHave('nextPartyToValidate', function ($q) use ($user) {
                                $q->whereHas('signatory', function ($q) use ($user) {
                                    $q->where('id', $user->id);
                                });
                            });
                        })->whereNotIn('state', $array_states)
                        ->where('state', ContractEntityInterface::STATE_TO_VALIDATE);
                    });
                }
            }

            $q->orWhereIn('state', Arr::wrap($states));
        });
    }

    public function scopeFilterParties($query, $parties)
    {
        return $query->whereHas('parties', function ($query) use ($parties) {
            return $query->whereHas('enterprise', function ($query) use ($parties) {
                return $query->whereIn('id', Arr::wrap($parties));
            });
        });
    }

    public function scopeFilterModels($query, $models)
    {
        return $query->whereIn('contract_model_id', Arr::wrap($models));
    }

    public function scopeFilterName($query, $name)
    {
        return $query->where('name', 'LIKE', "%".$name."%")
                     ->orWhere('name', 'LIKE', "%".strtolower($name)."%")
                     ->orWhere('name', 'LIKE', "%".strtoupper($name)."%");
    }

    public function scopefilterExternalIdentifier($query, $external_identifier)
    {
        return $query->where('external_identifier', 'LIKE', "%".$external_identifier."%")
                     ->orWhere('external_identifier', 'LIKE', "%".strtolower($external_identifier)."%")
                     ->orWhere('external_identifier', 'LIKE', "%".strtoupper($external_identifier)."%");
    }

    public function scopeFilterCreators($query, $creators)
    {
        return $query->whereHas('createdBy', function ($query) use ($creators) {
            return $query->whereIn('id', Arr::wrap($creators));
        });
    }

    public function scopeFilterWorkFields($query, $work_fields)
    {
        return $query->whereHas('workfield', function ($query) use ($work_fields) {
            return $query->whereIn('id', Arr::wrap($work_fields));
        });
    }

    public function scopeFilterExpiringContracts($query, $day)
    {
        return $query->where('state', ContractEntityInterface::STATE_ACTIVE)
            ->where([
                ['valid_until','<=', Carbon::now()->addDay($day)],
                ['valid_until', '>', Carbon::now()]
            ]);
    }

    public function scopeOfEnterprises($query, $enterprises)
    {
        return $query->where(function ($query) use ($enterprises) {
            foreach ($enterprises as $enterprise) {
                $query->whereHas('parties', function ($query) use ($enterprise) {
                    $query->where('enterprise_id', $enterprise->id);
                });
            }
        });
    }

    public function isPublished()
    {
        return $this->getStatus() === self::STATUS_PUBLISHED;
    }

    public function isSigned()
    {
        return $this->getStatus() === self::STATUS_SIGNED;
    }

    public function setYousignProcedureId(?string $id): void
    {
        $this->yousign_procedure_id = $id;
    }

    public function getYousignProcedureId(): ?string
    {
        return $this->yousign_procedure_id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }
}
