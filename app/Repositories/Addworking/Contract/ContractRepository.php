<?php

namespace App\Repositories\Addworking\Contract;

use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\EnterpriseCollection;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Common\FileRepository;
use App\Repositories\BaseRepository;
use App\Support\Facades\Repository as RepositoryFacade;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContractRepository extends BaseRepository
{
    use DispatchesJobs;

    protected $model = Contract::class;

    protected $factory;

    protected $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return Contract::query()
            ->when($filter['name'] ?? null, function ($query, $name) {
                return $query->name($name);
            })
            ->when($filter['contract_party_enterprise'] ?? null, function ($query, $enterprise_id) {
                return $query->contractPartyEnterprise($enterprise_id);
            })
            ->when($filter['valid_until'] ?? null, function ($query, $valid_until) {
                return $query->validUntil($valid_until);
            })
            ->when($filter['status'] ?? null, function ($query, $status) {
                return $query->status($status);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function createFromRequest(Request $request, Enterprise $enterprise): Contract
    {
        return tap($this->create($request->input('contract')), function ($contract) use ($enterprise) {
            $contract->enterprise()->associate($enterprise)->save();
        });
    }

    public function log(Contract $contract, string $message, array $data = []): Contract
    {
        Log::debug("contract.DEBUG: {$message}");

        $contract->logs()->create(compact('message', 'data'));

        return $contract;
    }

    public function isSignatory(Contract $contract, User $user): bool
    {
        return $contract->contractParties()
            ->whereHas('user', fn($q) => $q->whereId($user->id))
            ->exists();
    }

    public function nextSignatoryIs(Contract $contract, User $user): bool
    {
        if (! $next = $contract->getNextSignatoryAttribute()) {
            return false;
        }

        return $next->is($user);
    }

    public function isSignedBy(Contract $contract, User $user): bool
    {
        return $this->signatories($contract)->where('user_id', $user->id)->exists();
    }

    public function signatories(Contract $contract): BelongsToMany
    {
        throw new \BadMethodCallException(__METHOD__ . ' is deprecated');
    }

    public function getInvolvedEnterprises(Contract $contract): EnterpriseCollection
    {
        $enterprises = new EnterpriseCollection;
        $enterprises->push($contract->enterprise);

        foreach ($contract->contractParties()->with('enterprise')->cursor() as $party) {
            if ($party->enterprise->exists) {
                $enterprises->push($party->enterprise);
            }
        }

        // deduplicate
        return $enterprises->unique('id');
    }

    public function isDraft(Contract $contract): bool
    {
        return $contract->status == Contract::STATUS_DRAFT;
    }

    public function isReadyToGenerate(Contract $contract): bool
    {
        return $contract->status == Contract::STATUS_READY_TO_GENERATE;
    }

    public function isGenerating(Contract $contract): bool
    {
        return $contract->status == Contract::STATUS_GENERATING;
    }

    public function isGenerated(Contract $contract): bool
    {
        return $contract->status == Contract::STATUS_GENERATED;
    }

    public function isUploading(Contract $contract): bool
    {
        return $contract->status == Contract::STATUS_UPLOADING;
    }

    public function isUploaded(Contract $contract): bool
    {
        return $contract->status == Contract::STATUS_UPLOADED;
    }

    public function isReadyToSign(Contract $contract): bool
    {
        return $contract->status == Contract::STATUS_READY_TO_SIGN;
    }

    public function isBeingSigned(Contract $contract): bool
    {
        return $contract->status == Contract::STATUS_BEING_SIGNED;
    }

    public function isSignable(Contract $contract): bool
    {
        return $this->isReadyToSign($contract)
            || $this->isBeingSigned($contract);
    }

    public function isCancelled(Contract $contract): bool
    {
        return $contract->status == Contract::STATUS_CANCELLED;
    }

    public function isActive(Contract $contract): bool
    {
        if (! $contract->exists) {
            return false;
        }

        if ($contract->status == Contract::STATUS_ACTIVE) {
            return true;
        }

        if (! is_null($contract->valid_from) && $contract->valid_from->isFuture()) {
            return false;
        }

        if (! is_null($contract->valid_until) && $contract->valid_until->isPast()) {
            return false;
        }

        if ($contract->contractParties->contains(fn($p) => ! $p->hasSigned())) {
            return false;
        }

        if ($contract->contractDocuments->contains(
            fn($d) => RepositoryFacade::enterpriseDocument()->isValid($d->document)
        )) {
            return false;
        }

        return true;
    }

    public function isDeclined(Contract $contract): bool
    {
        if (! $contract->exists) {
            return false;
        }

        if ($contract->status == Contract::STATUS_DECLINED) {
            return true;
        }

        if ($contract->contractParties->contains(fn($p) => $p->hasDeclined())) {
            return true;
        }

        return false;
    }

    public function isInactive(Contract $contract): bool
    {
        return $contract->status == Contract::STATUS_INACTIVE;
    }

    public function isExpired(Contract $contract): bool
    {
        if (! $contract->exists) {
            return false;
        }

        if ($contract->status == Contract::STATUS_EXPIRED) {
            return true;
        }

        if ($contract->contractDocuments->contains(
            fn($d) => RepositoryFacade::enterpriseDocument()->isExpired($d->document)
        )) {
            return true;
        }

        return false;
    }

    public function isError(Contract $contract): bool
    {
        return $contract->status == Contract::STATUS_ERROR;
    }

    public function isLocked(Contract $contract): bool
    {
        return false;
    }

    public function isPositiveStatus(Contract $contract)
    {
        return in_array($this->getStatus($contract), [
            Contract::STATUS_GENERATED,
            Contract::STATUS_UPLOADED,
            Contract::STATUS_READY_TO_SIGN,
            Contract::STATUS_BEING_SIGNED,
            Contract::STATUS_ACTIVE,
        ]);
    }

    public function isNegativeStatus(Contract $contract)
    {
        return in_array($this->getStatus($contract), [
            Contract::STATUS_CANCELLED,
            Contract::STATUS_DECLINED,
            Contract::STATUS_EXPIRED,
            Contract::STATUS_ERROR,
        ]);
    }

    public function isNeutralStatus(Contract $contract)
    {
        return in_array($this->getStatus($contract), [
            Contract::STATUS_DRAFT,
            Contract::STATUS_READY_TO_GENERATE,
            Contract::STATUS_GENERATING,
            Contract::STATUS_UPLOADING,
            Contract::STATUS_INACTIVE,
            Contract::STATUS_LOCKED,
        ]);
    }

    public function getStatus(Contract $contract, bool $translate = false): string
    {
        switch (true) {
            case $this->isDraft($contract):
                $status = Contract::STATUS_DRAFT;
                break;

            case $this->isReadyToGenerate($contract):
                $status = Contract::STATUS_READY_TO_GENERATE;
                break;

            case $this->isGenerating($contract):
                $status = Contract::STATUS_GENERATING;
                break;

            case $this->isGenerated($contract):
                $status = Contract::STATUS_GENERATED;
                break;

            case $this->isUploading($contract):
                $status = Contract::STATUS_UPLOADING;
                break;

            case $this->isUploaded($contract):
                $status = Contract::STATUS_UPLOADED;
                break;

            case $this->isReadyToSign($contract):
                $status = Contract::STATUS_READY_TO_SIGN;
                break;

            case $this->isBeingSigned($contract):
                $status = Contract::STATUS_BEING_SIGNED;
                break;

            case $this->isCancelled($contract):
                $status = Contract::STATUS_CANCELLED;
                break;

            case $this->isActive($contract):
                $status = Contract::STATUS_ACTIVE;
                break;

            case $this->isDeclined($contract):
                $status = Contract::STATUS_DECLINED;
                break;

            case $this->isInactive($contract):
                $status = Contract::STATUS_INACTIVE;
                break;

            case $this->isExpired($contract):
                $status = Contract::STATUS_EXPIRED;
                break;

            case $this->isError($contract):
                $status = Contract::STATUS_ERROR;
                break;

            case $this->isLocked($contract):
                $status = Contract::STATUS_LOCKED;
                break;

            default:
                $status = Contract::STATUS_UNKNOWN;
                break;
        }

        if ($translate) {
            return $this->getAvailableStatuses($contract, true)[$status] ?? "inconnu";
        }

        return $status;
    }

    public function getAvailableStatuses(Contract $contract, bool $translate = false): array
    {
        $statuses = [
            Contract::STATUS_DRAFT             => "brouillon",
            Contract::STATUS_READY_TO_GENERATE => "prêt pour génération",
            Contract::STATUS_GENERATING        => "en cours de génération",
            Contract::STATUS_GENERATED         => "généré",
            Contract::STATUS_UPLOADING         => "en cours d'envoi",
            Contract::STATUS_UPLOADED          => "envoyé",
            Contract::STATUS_READY_TO_SIGN     => "prêt pour signature",
            Contract::STATUS_BEING_SIGNED      => "en cours de signature",
            Contract::STATUS_CANCELLED         => "annulé",
            Contract::STATUS_ACTIVE            => "actif",
            Contract::STATUS_DECLINED          => "décliné",
            Contract::STATUS_INACTIVE          => "inactif",
            Contract::STATUS_EXPIRED           => "expiré",
            Contract::STATUS_ERROR             => "en erreur",
            Contract::STATUS_LOCKED            => "verouillé",
            Contract::STATUS_UNKNOWN           => "dans un etat inconnu",
        ];

        return $translate ? $statuses : array_keys($statuses);
    }

    public function newName(Contract $contract): string
    {
        if ($contract->parent->exists) {
            return sprintf(
                "Avenant #%d au contrat %s",
                $contract->parent->children()->count() + 1,
                $contract->parent->name
            );
        }

        return sprintf(
            "Contrat %s #%d",
            $contract->enterprise->name,
            $contract->enterprise->contracts()->count() + 1
        );
    }

    public function getContractsBetween(Enterprise ...$enterprises): Builder
    {
        $query = Contract::query()->exceptAddendums();

        foreach ($enterprises as $enterprise) {
            $query->ofEnterprise($enterprise);
        }

        return $query;
    }
}
