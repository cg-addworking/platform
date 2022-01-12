<?php

namespace App\Repositories\Addworking\Common;

use App\Contracts\Models\Repository;
use App\Models\Addworking\Common\File;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class FileRepository extends BaseRepository
{
    protected $model = File::class;

    public function list(?string $search = null, ?array $filter = null): Builder
    {
        return File::query()
            ->when($filter['owner'] ?? null, function ($query, $phone) {
                return $query->owner($phone);
            })
            ->when($filter['path'] ?? null, function ($query, $address) {
                return $query->path($address);
            })
            ->when($filter['created_at'] ?? null, function ($query, $date) {
                return $query->createdAt($date);
            })
            ->when($filter['mime_type'] ?? null, function ($query, $date) {
                return $query->mimeType($date);
            });
    }

    public function createFromRequest(Request $request, string $input = "file.content"): File
    {
        $file = File::from($request->file($input))
            ->name("%date%_%uniq%.%ext%")
            ->owner()->associate($request->user());

        if ($attachable = $this->getAttachable($request)) {
            $file->attachTo($attachable);
        }

        $file->save();

        return $file;
    }

    public function updateFromRequest(Request $request, File $file): File
    {
        $file->update($request->input('file'));

        return $file;
    }

    protected function getAttachable(Request $request): ?Model
    {
        if (! $request->has(['file.attachable_type', 'file.attachable_id'])) {
            return null;
        }

        $type = $request->input('file.attachable_type');
        $id   = $request->input('file.attachable_id');

        if (! $class = config("attachable.{$type}")) {
            throw new RuntimeException("no such attachable type: {$type}");
        }

        if (! class_exists($class)) {
            throw new RuntimeException("class doesn't exists: {$class}");
        }

        if (! in_array(Model::class, class_parents($class))) {
            throw new RuntimeException("class is not a model: {$class}");
        }

        try {
            return $class::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }
}
