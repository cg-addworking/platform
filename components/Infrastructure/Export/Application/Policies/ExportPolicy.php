<?php

namespace Components\Infrastructure\Export\Application\Policies;

use App\Models\Addworking\User\User;
use Components\Infrastructure\Export\Application\Models\Export;
use Components\Infrastructure\Export\Application\Repositories\ExportRepository;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ExportPolicy
{
    use HandlesAuthorization;

    private $exportRepository;

    public function __construct(
        ExportRepository $exportRepository
    ) {
        $this->exportRepository = $exportRepository;
    }

    public function download(User $user, Export $export)
    {
        if (!$this->exportRepository->isExportOwner($user, $export)) {
            return Response::deny("This export doesn't belong to you.");
        }

        return Response::allow();
    }
}
