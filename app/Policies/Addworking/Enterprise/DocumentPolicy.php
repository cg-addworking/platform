<?php

namespace App\Policies\Addworking\Enterprise;

use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\OnboardingProcess\UploadLegalDocument;
use App\Models\Addworking\User\User;
use App\Models\Sogetrel\User\Passwork;
use App\Repositories\Addworking\Enterprise\CustomerRepository;
use App\Repositories\Addworking\Enterprise\DocumentRepository;
use App\Repositories\Addworking\Enterprise\EnterpriseMemberRepository;
use App\Repositories\Sogetrel\Enterprise\SogetrelEnterpriseRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DocumentPolicy
{
    use HandlesAuthorization;

    private $documentRepository;
    private $memberRepository;
    private $customerRepository;
    private $sogetrelEnterpriseRepository;

    public function __construct(
        DocumentRepository $documentRepository,
        EnterpriseMemberRepository $memberRepository,
        CustomerRepository $customerRepository,
        SogetrelEnterpriseRepository $sogetrelEnterpriseRepository
    ) {
        $this->documentRepository = $documentRepository;
        $this->memberRepository = $memberRepository;
        $this->customerRepository = $customerRepository;
        $this->sogetrelEnterpriseRepository = $sogetrelEnterpriseRepository;
    }

    public function index(User $user, Enterprise $enterprise)
    {
        $customersWithAncestors = $this->customerRepository->getCustomersAndAncestorsOf($enterprise);

        $filtered = $customersWithAncestors->filter(function ($customer) use ($user) {
            return $this->memberRepository->isMember($customer, $user);
        });

        if ($user->isSupport() || $filtered->count()) {
            return true;
        }

        if ($this->memberRepository->isMember($enterprise, $user)) {
            // PASSWORK SOGETREL OK + STATUS ACCEPTED == ACCEES OK
            if ($user->sogetrelPasswork->exists && $user->sogetrelPasswork->status == Passwork::STATUS_ACCEPTED) {
                return true;
            }

            // SI PASSWORK AUTRE QUE SOGETREL == ACCESS OK
            if (count($user->enterprise->passworks) > 0) {
                return true;
            }

            // PAS DE CLIENTS == ACCESS NOK
            if (count($user->enterprise->customers) == 0) {
                return false;
            }

            // SI PASSWORK AUTRE NOK + PASSWORK SOGETREL NOK == ACCESS OK
            if (count($user->enterprise->passworks) == 0 && ! $user->sogetrelPasswork->exists) {
                return true;
            }

            return false;
        }

        return false;
    }

    public function indexSupport(User $user)
    {
        return $user->isSupport();
    }

    public function create(User $user, Enterprise $enterprise, DocumentType $document_type)
    {
        $document = $document_type->getDocumentForEnterprise($enterprise);

        if ($document->exists) {
            return false;
        }

        return $user->isSupport()
            || ($user->hasRoleFor($enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($enterprise, [User::ACCESS_TO_ENTERPRISE])
            && $enterprise->isVendor());
    }

    public function show(User $user, Document $model)
    {
        return $model->exists
            && ($user->isSupport()
            || ($user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
                && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_ENTERPRISE])
                && $user->enterprise->is($model->enterprise))
            || $user->enterprise->isCustomerOf($model->enterprise));
    }

    public function update(User $user, Document $document)
    {
        if (! $user->isSupport()) {
            return Response::deny("You are not member of AddWorking support");
        }

        return Response::allow();
    }

    public function destroy(User $user, Document $document)
    {
        return $user->isSupport();
    }

    public function delete(User $user, Document $document)
    {
        return $this->destroy($user, $document);
    }

    public function forceDelete(User $user, Document $document)
    {
        return $user->isSystemSuperadmin();
    }

    public function store(User $user, Enterprise $model)
    {
        return $user->isSupport()
            || ($user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
                && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_ENTERPRISE])
                && $user->enterprise->is($model)
            );
    }

    public function replace(User $user, Document $document)
    {
        if (! $document->exists) {
            return false;
        }

        return $user->isSupport()
            || $user->hasRoleFor($document->enterprise, [User::IS_ADMIN, User::IS_OPERATOR])
            && $user->hasAccessFor($document->enterprise, [User::ACCESS_TO_ENTERPRISE]);
    }

    public function accept(User $user, Document $model)
    {
        return ! $model->isValidated() && $user->isSupport();
    }

    public function reject(User $user, Document $model)
    {
        return ! $model->isRejected() && $user->isSupport();
    }

    public function download(User $user, Document $document)
    {
        return $document->files()->exists()
            && ($user->isSupport()
            || ($user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
                && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_ENTERPRISE])
                && $user->enterprise->is($document->enterprise))
            || $user->enterprise->isCustomerOf($document->enterprise));
    }

    public function showIndexMenu(User $user, Enterprise $model)
    {
        return $this->index($user, $model) && $model->isVendor();
    }

    public function tag(User $user, Document $document)
    {
        return $user->isSupport();
    }

    public function untag(User $user, Document $document)
    {
        return $user->isSupport() && $document->tagged()->exists();
    }

    public function preCheck(User $user, Document $model)
    {
        if (! $user->isSupport()) {
            return Response::deny("You are not member of AddWorking support");
        }

        if ($this->documentRepository->isPreCheck($model)) {
            return Response::deny("The document is already pre-checked");
        }

        return Response::allow();
    }

    public function noPreCheck(User $user, Document $model)
    {
        if (! $user->isSupport()) {
            return Response::deny("You are not member of AddWorking support");
        }

        if (! $this->documentRepository->isPreCheck($model)) {
            return Response::deny("The document is already not pre-checked");
        }

        return Response::allow();
    }

    public function showDocumentInIndex(User $user, DocumentType $type)
    {
        return $user->isSupport()
            || $user->enterprise->is_vendor
            || ($user->enterprise->is_customer
                && ($type->enterprise->is($user->enterprise)
                    || $user->enterprise->ancestors()->contains($type->enterprise)
                    || $type->enterprise->is(Enterprise::addworking())));
    }

    public function showHistory(User $user, Document $document)
    {
        return ($user->isSupport() || $user->enterprise->is_customer)
            && $document->documentType->exists;
    }

    public function createProofAuthenticity(User $user, Document $document)
    {
        return $user->isSupport()
            && ! is_null($document->getDocumentType())  && $document->getDocumentType()->getNeedAnAuthenticityCheck()
            && is_null($document->getProofAuthenticity());
    }

    public function editProofAuthenticity(User $user, Document $document)
    {
        return $user->isSupport()
            && ! is_null($document->getProofAuthenticity());
    }

    public function sign(User $user, Document $model)
    {
        return $model->exists
            && $user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_ENTERPRISE])
            && $user->enterprise->is($model->enterprise)
            && $user->isSignatoryFor($model->enterprise)
            && is_null($model->signed_at)
            && ! is_null($model->document_type_model_id);
    }

    public function addRequiredDocument(User $user, Document $document)
    {
        return $this->sign($user, $document)
            && $document->getDocumentTypeModel()->getRequiresDocuments()
            && is_null($document->getRequiredDocument());
    }
}
