<?php

namespace Components\Contract\Contract\Application\Repositories;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\FamilyEnterpriseRepository;
use Components\Contract\Contract\Application\Models\Annex;
use Components\Contract\Contract\Domain\Exceptions\AnnexCreationFailedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\AnnexEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\AnnexRepositoryInterface;
use Illuminate\Support\Facades\App;

class AnnexRepository implements AnnexRepositoryInterface
{
    /**
     * @param array $data
     * @return AnnexEntityInterface
     */
    public function make($data = []): AnnexEntityInterface
    {
        return new Annex($data);
    }

    /**
     * @param AnnexEntityInterface $annex
     * @return AnnexEntityInterface
     * @throws AnnexCreationFailedException
     */
    public function save(AnnexEntityInterface $annex)
    {
        try {
            $annex->save();
        } catch (AnnexCreationFailedException $exception) {
            throw $exception;
        }

        $annex->refresh();

        return $annex;
    }

    /**
     * @param $content
     * @return File
     */
    public function createFile($content)
    {
        $file = File::from($content)
            ->fill(['mime_type' => "application/pdf"])
            ->name("/part_%uniq%.pdf")
            ->saveAndGet();

        unset($content);
        return $file;
    }

    public function findByNumber(string $number): ?AnnexEntityInterface
    {
        return Annex::where('number', $number)->first();
    }

    public function delete(AnnexEntityInterface $annex)
    {
        return $annex->delete();
    }

    public function isDeleted(int $number): bool
    {
        $annex = Annex::withTrashed()->where('number', $number)->first();
        if (!is_null($annex)) {
            return !is_null($annex->getDeletedAt());
        }
        return false;
    }

    /**
     * @param User|null $user
     * @param array|null $filter
     * @param string|null $search
     * @param int|null $page
     * @param string|null $operator
     * @param string|null $field_name
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listAsSupport(
        ?User $user,
        ?array $filter = null,
        ?string $search = null,
        ?int $page = null,
        ?string $operator = null,
        ?string $field_name = null
    ) {
        return Annex::query()
            ->when($filter['enterprises'] ?? null, function ($query, $enterprises) {
                return $query->filterEnterprise($enterprises);
            })
            ->latest()
            ->paginate($page ?? 25);
    }

    /**
     * @param Enterprise $enterprise
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function list(Enterprise $enterprise)
    {
        return Annex::query()
            ->whereHas('enterprise', function ($q) use ($enterprise) {
                $q->whereIn(
                    'id',
                    App::make(FamilyEnterpriseRepository::class)->getAncestors($enterprise, true)->pluck('id')
                );
            })
            ->get();
    }

    public function findById(string $annex_number): ?Annex
    {
        return Annex::whereId($annex_number)->first();
    }
}
