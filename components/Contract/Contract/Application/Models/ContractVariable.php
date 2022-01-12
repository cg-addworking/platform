<?php

namespace Components\Contract\Contract\Application\Models;

use App\Helpers\HasUuid;
use App\Contracts\Models\Searchable;
use App\Models\Addworking\User\User;
use Components\Contract\Contract\Domain\Exceptions\ContractVariableDoesNotExistException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractVariableEntityInterface;
use Components\Contract\Model\Application\Models\ContractModelVariable;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelVariableEntityInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ContractVariable extends Model implements ContractVariableEntityInterface, Searchable
{
    use HasUuid, SoftDeletes;

    protected $table = "addworking_contract_contract_variables";

    protected $fillable = [
        'value',
        'number',
        'order',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'value_requested_at',
    ];

    protected $with = ['contractModelVariable'];

    // -------------------------------------------------------------------------
    // Relationships
    // -------------------------------------------------------------------------
    public function contract()
    {
        return $this->belongsTo(Contract::class)->withDefault();
    }

    public function contractModelVariable()
    {
        return $this->belongsTo(ContractModelVariable::class)->withDefault();
    }

    public function filledBy()
    {
        return $this->belongsTo(User::class, 'filled_by')->withDefault();
    }

    public function contractParty()
    {
        return $this->belongsTo(ContractParty::class, 'contract_party_id')->withDefault();
    }

    public function valueRequestedTo()
    {
        return $this->belongsTo(User::class, 'value_requested_to')->withDefault();
    }

    // -------------------------------------------------------------------------
    // Getters
    // -------------------------------------------------------------------------

    public function getContract(): ContractEntityInterface
    {
        return $this->contract()->first();
    }

    public function getContractParty(): ?ContractPartyEntityInterface
    {
        return $this->contractParty()->first();
    }

    public function getContractModelVariable(): ?ContractModelVariableEntityInterface
    {
        return $this->contractModelVariable()->first();
    }

    public function getValueRequestedTo(): ?ContractPartyEntityInterface
    {
        return $this->valueRequestedTo()->first();
    }

    public function getId(): string
    {
        if (! $this->exists) {
            throw new ContractVariableDoesNotExistException($this);
        }

        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getValueHtmlAttribute(): ?string
    {
        return strip_tags(nl2br($this->value), '<br>');
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function getValueRequestedAt()
    {
        return $this->value_requested_at;
    }
    // -------------------------------------------------------------------------
    // Setters
    // -------------------------------------------------------------------------

    public function setContract($contract)
    {
        $this->contract()->associate($contract);
    }

    public function setContractModelVariable($contract_model_variable)
    {
        $this->contractModelVariable()->associate($contract_model_variable);
    }

    public function setFilledBy(User $user)
    {
        $this->filledBy()->associate($user);
    }

    public function setValueRequestedTo(User $user): void
    {
        $this->valueRequestedTo()->associate($user);
    }

    public function setContractParty(ContractPartyEntityInterface $contractParty)
    {
        $this->contractParty()->associate($contractParty);
    }

    public function setValue(?string $value)
    {
        $this->value = $value;
    }

    public function setNumber()
    {
        $query = 'SELECT max("accv"."number") as "max_number"';
        $query .= ' FROM "public"."addworking_contract_contract_variables" AS "accv"';

        $max = DB::select(DB::raw("$query"));
        $this->number = 1 + $max[0]->max_number;
    }

    public function setOrder(int $order): void
    {
        $this->order = $order;
    }

    public function setValueRequestedAt($value_requested_at): void
    {
        $this->value_requested_at = $value_requested_at;
    }

    // -------------------------------------------------------------------------
    // Filters & Search
    // -------------------------------------------------------------------------

    public function scopeFilterModelVariableDisplayName($query, string $display_name)
    {
        return $query->whereHas('contractModelVariable', function ($q) use ($display_name) {
            return $q->where('display_name', 'like', '%'.$display_name.'%');
        });
    }

    public function scopeFilterValue($query, $value)
    {
        return $query->where('value', 'LIKE', '%'.$value.'%');
    }

    public function scopeFilterModelVariableModelPartDisplayName($query, $display_name)
    {
        return $query->whereHas('contractModelVariable', function ($query) use ($display_name) {
            return $query->whereHas('contractModelPart', function ($query) use ($display_name) {
                return $query->where('display_name', 'like', '%'.$display_name.'%');
            });
        });
    }

    public function scopeFilterModelVariableRequired($query, $required)
    {
        return $query->whereHas('contractModelVariable', function ($query) use ($required) {
            return $query->where('required', $required);
        });
    }

    public function scopeSearch($query, string $search): Builder
    {
        $search = strtolower($search);

        return $query->orWhere(function ($query) use ($search) {
            return $query->filterValue($search);
        });
    }
}
