<?php

namespace Components\Enterprise\WorkField\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Enterprise\WorkField\Application\Repositories\UserRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class WorkFieldContributorPolicy
{
    use HandlesAuthorization;

    protected $userRepository;
    protected $workFieldRepository;
    protected $workFieldContributorRepository;

    public function __construct(
        UserRepository $userRepository,
        WorkFieldRepository $workFieldRepository,
        WorkFieldContributorRepository $workFieldContributorRepository
    ) {
        $this->userRepository = $userRepository;
        $this->workFieldRepository = $workFieldRepository;
        $this->workFieldContributorRepository = $workFieldContributorRepository;
    }
}
