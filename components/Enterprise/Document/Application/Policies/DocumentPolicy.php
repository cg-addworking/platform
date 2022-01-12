<?php

namespace Components\Enterprise\Document\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Enterprise\Document\Application\Models\Document;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function sign(User $user, Document $model)
    {
        return $model->exists
            && $user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_ENTERPRISE])
            && $user->enterprise->is($model->enterprise)
            && $user->isSignatoryFor($model->enterprise)
            && is_null($model->signed_at)
            && ! is_null($model->getDocumentTypeModel());
    }

    public function generateModel(User $user)
    {
        return $user->hasRoleFor($user->enterprise, [User::IS_ADMIN, User::IS_OPERATOR, User::IS_READONLY])
            && $user->hasAccessFor($user->enterprise, [User::ACCESS_TO_ENTERPRISE])
            && $user->isSignatoryFor($user->enterprise);
    }

    public function addRequiredDocument(User $user, Document $document)
    {
        return $this->sign($user, $document)
            && $document->getDocumentTypeModel()->getRequiresDocuments()
            && is_null($document->getRequiredDocument());
    }
}
