<?php

namespace App\Repositories\Addworking\Common;

use App\Contracts\Models\Repository;
use App\Http\Requests\Addworking\Common\Folder\StoreFolderRequest;
use App\Http\Requests\Addworking\Common\Folder\UpdateFolderRequest;
use App\Repositories\BaseRepository;
use App\Models\Addworking\Common\Folder;
use Illuminate\Database\Eloquent\Builder;

class FolderRepository extends BaseRepository
{
    protected $model = Folder::class;

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return Folder::query()
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function createFromRequest(StoreFolderRequest $request): Folder
    {
        return tap($this->make($request->input('folder', [])), function (Folder $folder) use ($request) {
            $folder->createdBy()->associate(
                $request->input('folder.created_by')
            );

            $folder->enterprise()->associate(
                $request->route('enterprise')
            );

            $folder->save();
        });
    }

    public function updateFromRequest(UpdateFolderRequest $request, Folder $folder): Folder
    {
        return tap($folder->fill($request->input('folder', [])), function ($folder) use ($request) {
            $folder->createdBy()->associate(
                $request->input('folder.created_by')
            );

            $folder->save();
        });
    }
}
