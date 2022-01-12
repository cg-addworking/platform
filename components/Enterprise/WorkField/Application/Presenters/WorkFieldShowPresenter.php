<?php

namespace Components\Enterprise\WorkField\Application\Presenters;

use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Application\Models\WorkFieldContributor;
use Components\Enterprise\WorkField\Domain\Interfaces\Entities\WorkFieldEntityInterface;
use Components\Enterprise\WorkField\Domain\Interfaces\Presenters\WorkFieldShowPresenterInterface;
use Illuminate\Support\Facades\Auth;

class WorkFieldShowPresenter implements WorkFieldShowPresenterInterface
{
    public function present(WorkFieldEntityInterface $work_field)
    {
        return [
            'id' => $work_field->getId(),
            'created_at' => $work_field->getCreatedAt(),
            'updated_at' => $work_field->getUpdatedAt(),
            'enterprise_owner_id' => $work_field->getOwner()->id,
            'enterprise_owner' => $work_field->getOwner()->name,
            'created_by_id' => is_null($work_field->getCreatedBy()) ? null : $work_field->getCreatedBy()->id,
            'created_by' => is_null($work_field->getCreatedBy()) ? 'Système' : $work_field->getCreatedBy()->name,
            'number' => $work_field->getNumber(),
            'display_name' => $work_field->getDisplayName(),
            'description' => $work_field->getDescriptionHtml(),
            'estimated_budget' => $work_field->getEstimatedBudget(),
            'started_at' => $work_field->getStartedAt(),
            'ended_at' => $work_field->getEndedAt(),
            'archived_at' => $work_field->getArchivedAt(),
            'contributors' => $this->getContributorsInformations($work_field),
            'authorizations' => $this->getAuthorizations(Auth::user(), $work_field),
            'offers' => $this->getOffers($work_field),
            'external_id' => $work_field->getExternalId(),
            'departments' => $work_field->getDepartments()->pluck('display_name')->toArray(),
            'project_manager' => $work_field->getProjectManager(),
            'project_owner' => $work_field->getProjectOwner(),
            'address' => $work_field->getAddress(),
            'sps_coordinator' => $work_field->getSpsCoordinator(),
        ];
    }
    
    private function getContributorsInformations(WorkFieldEntityInterface $work_field)
    {
        $data = [];

        foreach ($work_field->workFieldContributors()->cursor() as $contributor) {
            $data[] = [
                'contributor_user_id' => $contributor->getContributor()->id,
                'contributor_user' => $contributor->getContributor()->name,
                'contributor_enterprise' => $contributor->getEnterprise()->name,
                'contributor_is_admin' => $contributor->getIsAdmin(),
                'contributor_role' => $contributor->getRole(),
            ];
        }

        return $data;
    }

    private function getAuthorizations(User $user, WorkFieldEntityInterface $work_field)
    {
        return [
            'edit' => $user->can('edit', $work_field),
            'manage-contributors' => $user->can('manageContributors', $work_field),
            'delete' => $user->can('delete', $work_field),
            'archive' => $user->can('archive', $work_field),
        ];
    }

    private function getOffers(WorkFieldEntityInterface $work_field)
    {
        $data = [];

        foreach ($work_field->offers()->cursor() as $offer) {
            $data[] = [
                'offer_label' => $offer->label,
                'offer_id' => $offer->id,
            ];
        }

        return $data;
    }
}
