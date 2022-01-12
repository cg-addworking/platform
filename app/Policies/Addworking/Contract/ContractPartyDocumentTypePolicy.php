<?php

namespace App\Policies\Addworking\Contract;

use App\Models\Addworking\Contract\ContractParty;
use App\Models\Addworking\Contract\ContractPartyDocumentType;
use App\Models\Addworking\User\User;
use App\Support\Facades\Repository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContractPartyDocumentTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, ContractParty $contract_party)
    {
        return $user->can('view', $contract_party);
    }

    public function view(User $user, ContractPartyDocumentType $contract_party_document_type)
    {
        return $user->can('view', $contract_party_document_type->contractParty);
    }

    public function create(User $user, ContractParty $contract_party)
    {
        $type = $contract_party->contractPartyDocumentTypes()->make();

        if (Repository::contractPartyDocumentType()->getAvailableDocumentTypes($type)->isEmpty()) {
            return Response::deny("aucun type de document n'est éligible");
        }

        return $user->can('create', [ContractParty::class, $contract_party->contract]);
    }

    public function update(User $user, ContractPartyDocumentType $contract_party_document_type)
    {
        return $user->can('update', $contract_party_document_type->contractParty);
    }

    public function delete(User $user, ContractPartyDocumentType $contract_party_document_type)
    {
        return $user->can('delete', $contract_party_document_type->contractParty);
    }

    public function attachNewDocument(User $user, ContractPartyDocumentType $contract_party_document_type)
    {
        if (Repository::contractPartyDocumentType()->getContractDocument($contract_party_document_type)->exists) {
            return Response::deny("un document est déjà attaché");
        }

        if ($user->isSupport()) {
            return Response::allow();
        }

        $enterprise = $contract_party_document_type->contractParty->enterprise;

        if (! $user->hasRoleFor($enterprise, User::ROLE_ADMIN, User::ROLE_OPERATOR, User::ROLE_SIGNATORY)) {
            return Response::deny("vous devez être administrateur ou opérateur de {$enterprise->name}");
        }

        if (! $user->hasAccessToContractFor($enterprise)) {
            return Response::deny("vous devez avoir accès aux contrat de {$enterprise->name}");
        }

        if (! $user->hasAccessToEnterpriseFor($enterprise)) {
            return Response::deny("vous devez avoir accès aux documents de {$enterprise->name}");
        }

        return Response::allow();
    }

    public function attachExistingDocument(User $user, ContractPartyDocumentType $contract_party_document_type)
    {
        $enterprise = $contract_party_document_type->contractParty->enterprise;

        if (! $enterprise->documents()->exists()) {
            return Response::deny("l'entreprise {$enterprise->name} n'a aucun document");
        }

        return $this->attachNewDocument($user, $contract_party_document_type);
    }

    public function detachDocument(User $user, ContractPartyDocumentType $contract_party_document_type)
    {
        if (! Repository::contractPartyDocumentType()->getContractDocument($contract_party_document_type)->exists) {
            return Response::deny("aucun document n'est attaché à cette partie prennante pour ce type");
        }

        if ($user->isSupport()) {
            return Response::allow();
        }

        $enterprise = $contract_party_document_type->contractParty->enterprise;

        if (! $user->hasRoleFor($enterprise, User::ROLE_ADMIN, User::ROLE_OPERATOR, User::ROLE_SIGNATORY)) {
            return Response::deny("vous devez être administrateur ou opérateur de {$enterprise->name}");
        }

        if (! $user->hasAccessToContractFor($enterprise)) {
            return Response::deny("vous devez avoir accès aux contrat de {$enterprise->name}");
        }

        if (! $user->hasAccessToEnterpriseFor($enterprise)) {
            return Response::deny("vous devez avoir accès aux documents de {$enterprise->name}");
        }

        return Response::allow();
    }
}
