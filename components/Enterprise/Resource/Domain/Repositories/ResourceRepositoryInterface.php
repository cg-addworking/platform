<?php
namespace Components\Enterprise\Resource\Domain\Repositories;

use App\Contracts\RepositoryInterface;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\Resource\Application\Models\Resource;
use Components\Enterprise\Resource\Domain\Classes\ResourceInterface;
use Illuminate\Http\UploadedFile;

interface ResourceRepositoryInterface extends RepositoryInterface
{
    public function find(string $id);

    public function save(ResourceInterface $resource);

    public function getAvailableStatuses(): array;

    public function findByNumber(string $number);

    public function delete(ResourceInterface $resource): bool;

    public function attach(ResourceInterface $resource, UploadedFile $file): Resource;

    public function detach(ResourceInterface $resource, File $file): bool;

    public function assignedTo(ResourceInterface $resource, Enterprise $customer): bool;
}
