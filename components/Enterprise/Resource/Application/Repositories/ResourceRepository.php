<?php

namespace Components\Enterprise\Resource\Application\Repositories;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Enterprise\Resource\Application\Models\Resource;
use Components\Enterprise\Resource\Domain\Classes\ResourceInterface;
use Components\Enterprise\Resource\Domain\Exceptions\ResourceCreationFailedException;
use Components\Enterprise\Resource\Domain\Repositories\ResourceRepositoryInterface;
use Illuminate\Http\UploadedFile;

class ResourceRepository implements ResourceRepositoryInterface
{
    public function list(?array $filter = null, ?string $search = null)
    {
        return Resource::query()
            ->when($filter['number'] ?? null, function ($query, $number) {
                return $query->filterNumber($number);
            })
            ->when($filter['last_name'] ?? null, function ($query, $last_name) {
                return $query->filterLastName($last_name);
            })
            ->when($filter['first_name'] ?? null, function ($query, $first_name) {
                return $query->filterFirstName($first_name);
            })
            ->when($filter['email'] ?? null, function ($query, $email) {
                return $query->filterEmail($email);
            })
            ->when($filter['registration_number'] ?? null, function ($query, $registration_number) {
                return $query->filterRegistrationNumber($registration_number);
            })
            ->when($filter['status'] ?? null, function ($query, $status) {
                return $query->filterStatus($status);
            })
            ->when($search ?? null, function ($query, $search) {
                return $query->search($search);
            });
    }

    public function make($data = []): Resource
    {
        $class = Resource::class;

        return new $class($data);
    }

    public function find(string $id)
    {
        return Resource::where('id', $id)->first();
    }

    public function getAvailableStatuses(): array
    {
        $statuses = [
            ResourceInterface::STATUS_ACTIVE,
            ResourceInterface::STATUS_INACTIVE,
        ];

        return array_mirror($statuses);
    }

    public function save(ResourceInterface $resource)
    {
        try {
            $resource->save();
        } catch (ResourceCreationFailedException $exception) {
            throw $exception;
        }

        $resource->refresh();

        return $resource;
    }

    public function findByNumber(string $number)
    {
        return Resource::where('number', $number)->first();
    }

    public function delete(ResourceInterface $resource): bool
    {
        return $resource->delete();
    }

    public function attach(ResourceInterface $resource, UploadedFile $file): Resource
    {
        return $resource->attach($file);
    }

    public function detach(ResourceInterface $resource, File $file): bool
    {
        return $resource->detach($file);
    }

    public function assignedTo(ResourceInterface $resource, Enterprise $customer): bool
    {
        $assigned = $resource->whereHas('ActivityPeriods', function ($query) use ($customer) {
            $query->where('customer_id', $customer->id);
        })->count();

        return $assigned > 0;
    }
}
