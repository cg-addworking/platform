<?php

namespace Components\Enterprise\WorkField\Application\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Enterprise\WorkField\Application\Models\WorkFieldContributor;
use Components\Enterprise\WorkField\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\WorkField\Application\Repositories\UserRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository;
use Components\Enterprise\WorkField\Domain\UseCases\DetachContributorToWorkField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class WorkFieldContributorController extends Controller
{
    protected $workFieldRepository;
    protected $enterpriseRepository;
    protected $userRepository;
    protected $workFieldContributorRepository;

    public function __construct(
        WorkFieldRepository $workFieldRepository,
        EnterpriseRepository $enterpriseRepository,
        UserRepository $userRepository,
        WorkFieldContributorRepository $workFieldContributorRepository
    ) {
        $this->workFieldRepository = $workFieldRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->userRepository = $userRepository;
        $this->workFieldContributorRepository = $workFieldContributorRepository;
    }

    public function manageContributors(WorkField $work_field)
    {
        $this->authorize('manageContributors', $work_field);

        $authenticated_enterprise = $this->userRepository->connectedUser()->enterprise;
        $subsidiaries = $this->enterpriseRepository->getOwnerAndDescendants($authenticated_enterprise)->sortBy('name');
        $contributors = $this->workFieldContributorRepository->getContributorsOf($work_field);

        return view(
            'work_field::work_field_contributor.manage_contributors',
            compact('subsidiaries', 'work_field', 'contributors')
        );
    }
}
