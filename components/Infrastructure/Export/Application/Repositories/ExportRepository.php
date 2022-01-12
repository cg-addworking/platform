<?php

namespace Components\Infrastructure\Export\Application\Repositories;

use App\Models\Addworking\User\User;
use Carbon\Carbon;
use Components\Infrastructure\Export\Application\Models\Export;
use Components\Common\Common\Domain\Exceptions\UnableToSaveException;
use Components\Infrastructure\Export\Domain\Interfaces\ExportEntityInterface;
use Components\Infrastructure\Export\Domain\Interfaces\ExportRepositoryInterface;

class ExportRepository implements ExportRepositoryInterface
{
    public function list(User $user, ?array $filter = null, ?string $search = null)
    {
        return Export::query()->whereHas('user', function ($query) use ($user) {
            return $query->where('id', $user->getId());
        })->where('created_at', '>', Carbon::now()->subHour())
        ->latest()->paginate(25);
    }

    public function make($data = []): ExportEntityInterface
    {
        return new Export($data);
    }

    public function create(User $user, string $export_name, array $filters = []): ExportEntityInterface
    {
        $export = $this->make();
        $export->setStatus(ExportEntityInterface::STATUS_GENERATION_PROCESSING);
        $export->setName($export_name);
        if (!empty($filters)) {
            $export->setFilters($filters);
        }

        $export->setUser($user);
        $this->save($export);

        return $export;
    }

    public function save(ExportEntityInterface $export)
    {
        try {
            $export->save();
        } catch (UnableToSaveException $exception) {
            throw $exception;
        }

        $export->refresh();

        return $export;
    }

    public function isExportOwner(User $user, ExportEntityInterface $export)
    {
        return $user->getId() === $export->getUser()->getId();
    }

    public function isGenerated(ExportEntityInterface $export)
    {
        return $export->getStatus() === ExportEntityInterface::STATUS_GENERATED;
    }

    public function displayFilters(?array $filters = []): ?string
    {
        $glue = ', ';
        $filters_string = '';

        if ($filters) {
            foreach ($filters as $filter) {
                if (is_array($filter)) {
                    $filters_string .= $this->displayFilters($filter, $glue) . $glue;
                } else {
                    $filters_string .= $filter . $glue;
                }
            }
        }

        $filters_string = substr($filters_string, 0, 0-strlen($glue));

        return $filters_string;
    }
}
