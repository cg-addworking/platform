<?php

namespace App\Policies\Addworking\Contract;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Contract\Contract;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Policies\Addworking\Common\FilePolicy;
use App\Repositories\Addworking\Contract\ContractRepository;
use App\Support\Facades\Repository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Collection;

class ContractPolicy
{
    use HandlesAuthorization;

    protected $policies = [];
    protected $repositories = [];

    public function __construct(FilePolicy $file, ContractRepository $contract)
    {
        $this->policies['file'] = $file;
        $this->repositories['contract'] = $contract;
    }

    public function viewAny(User $user, Enterprise $enterprise)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        if (! $user->hasRoleFor($enterprise, User::ROLE_ADMIN, User::ROLE_OPERATOR, User::ROLE_READONLY)) {
            return Response::deny("Vos privilèges sur l'entreprise {$enterprise->name} sont insuffisants");
        }

        if (! $user->hasAccessFor($enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("Vous n'avez pas accès aux contrats");
        }

        return Response::allow();
    }

    public function view(User $user, Contract $contract)
    {
        if (! $contract->exists) {
            return Response::deny("Contrat invalide");
        }

        if ($user->isSupport()) {
            return Response::allow();
        }

        if ($this->repositories['contract']->isSignatory($contract, $user)) {
            return Response::allow();
        }

        // does the user has the right privileges on any involved enterprise
        // (or one of its ancestors) to view the given contract?
        $allowed = Repository::contract()
            ->getInvolvedEnterprises($contract)
            ->ancestors(true)
            ->get()
            ->contains(function (Enterprise $enterprise) use ($user) {
                return $user->hasRoleFor($enterprise, User::ROLE_ADMIN, User::ROLE_OPERATOR, User::ROLE_READONLY)
                    && $user->hasAccessFor($enterprise, User::ACCESS_TO_CONTRACT);
            });

        if ($allowed) {
            return Response::allow();
        }

        return Response::deny("Niveau de privilèges est insuffisant");
    }

    public function viewSummary(User $user, Contract $contract)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        return Response::deny("Seul le support peut voir le résumé d'un contrat");
    }

    public function create(User $user, Enterprise $enterprise)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        // remove-me
        if (! $user->isSupport()) {
            return Response::deny("Accessible au support AddWorking seulement");
        }

        if (! $user->hasRoleFor($enterprise, User::ROLE_ADMIN, User::ROLE_OPERATOR)) {
            return Response::deny("Vos privilèges sur l'entreprise {$enterprise->name} sont insuffisants");
        }

        if (! $user->hasAccessFor($enterprise, User::ACCESS_TO_CONTRACT)) {
            return Response::deny("Vous n'avez pas accès aux contrats");
        }

        return Response::allow();
    }

    public function createBlank(User $user, Enterprise $enterprise)
    {
        // remove-me
        if (! $user->isSupport()) {
            return Response::deny("Accessible au support AddWorking seulement");
        }

        return $this->create($user, $enterprise);
    }

    public function createFromExistingFile(User $user, Enterprise $enterprise)
    {
        return $this->create($user, $enterprise);
    }

    public function createFromTemplate(User $user, Enterprise $enterprise)
    {
        if (! ($create = $this->create($user, $enterprise))->allowed()) {
            return $create;
        }

        if (! $enterprise->contractTemplates()->exists()) {
            return Response::deny("l'entreprise {$enterprise->name} ne possède aucune maquette");
        }

        return Response::allow();
    }

    public function update(User $user, Contract $contract)
    {
        // remove-me
        if (! $user->isSupport()) {
            return Response::deny("Accessible au support AddWorking seulement");
        }

        if (! $contract->exists) {
            return Response::deny("Invalid contract");
        }

        if ($this->repositories['contract']->isLocked($contract)) {
            return Response::deny("Ce contrat est vérouillé");
        }

        return $this->create($user, $contract->enterprise);
    }

    public function updateStatus(User $user, Contract $contract)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        return Response::deny("Seul le support peut manuellement changer le status d'un contrat");
    }

    public function updateFile(User $user, Contract $contract)
    {
        if ($user->isSupport()) {
            return Response::allow();
        }

        return Response::deny("Seul le support peut manuellement changer le fichier d'un contrat");
    }

    public function destroy(User $user, Contract $contract)
    {
        return $this->update($user, $contract);
    }

    public function download(User $user, Contract $contract)
    {
        if (! ($download = $this->policies['file']->download($user, $contract->file)->allowed())) {
            return $download;
        }

        return $this->view($user, $contract);
    }

    public function createAddendum(User $user, Contract $contract)
    {
        if ($contract->parent->exists) {
            return Response::deny("Un avenant ne peut pas avoir d'avenants");
        }

        return $this->create($user, $contract->enterprise);
    }
}
