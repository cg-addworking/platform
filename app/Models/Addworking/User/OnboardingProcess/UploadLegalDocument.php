<?php

namespace App\Models\Addworking\User\OnboardingProcess;

use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Repositories\Addworking\Enterprise\DocumentRepository;

class UploadLegalDocument extends Step
{
    protected $description = 'addworking.user.dashboard._onboarding.step.upload_legal_document.description';

    protected $displayName = "Téléchargement des documents légaux";

    protected $message = 'addworking.user.dashboard._onboarding.step.upload_legal_document.message';

    protected $callToAction = 'addworking.user.dashboard._onboarding.step.upload_legal_document.call_to_action';

    public function passes(): bool
    {
        return $this->user()->enterprise->isReadyToWorkFor(Enterprise::addworking());
    }

    public function action(): string
    {
        return app()->make(DocumentRepository::class)
            ->factory()->enterprise()->associate($this->user()->enterprise)->routes->index;
    }
}
