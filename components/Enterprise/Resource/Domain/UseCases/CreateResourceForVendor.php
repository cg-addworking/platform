<?php

namespace Components\Enterprise\Resource\Domain\UseCases;

use Components\Enterprise\Resource\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\Resource\Domain\Classes\ResourceInterface;
use Components\Enterprise\Resource\Domain\Exceptions\EnterpriseDoesntHaveAccessToResourceException;
use Components\Enterprise\Resource\Domain\Exceptions\EnterpriseIsNotVendorException;
use Components\Enterprise\Resource\Domain\Exceptions\EnterpriseNotFoundException;
use Components\Enterprise\Resource\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\Resource\Domain\Repositories\ModuleRepositoryInterface;
use Components\Enterprise\Resource\Domain\Repositories\ResourceRepositoryInterface;
use Components\Enterprise\Resource\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateResourceForVendor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $enterpriseRepository;
    private $resource;
    private $moduleRepository;
    private $resourceRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        EnterpriseRepository $enterpriseRepository,
        ResourceInterface $resource,
        ModuleRepositoryInterface $moduleRepository,
        ResourceRepositoryInterface $resourceRepository
    ) {
        $this->userRepository = $userRepository;
        $this->enterpriseRepository = $enterpriseRepository;
        $this->resource = $resource;
        $this->moduleRepository = $moduleRepository;
        $this->resourceRepository = $resourceRepository;
    }

    public function handle(array $data)
    {
        $authUser = $this->userRepository->connectedUser();
        $this->checkUser($authUser);

        $vendor = $this->enterpriseRepository->find($data['enterprise_id']);
        $this->checkVendor($vendor);

        $resource = $this->resource;
        $resource->setFirstName($data['first_name']);
        $resource->setLastName($data['last_name']);
        $resource->setVendor($vendor);
        $resource->setCreator($authUser);
        $resource->setEmail($data['email']);
        $resource->setNumber();
        $resource->setRegistrationNumber($data['registration_number']);
        $resource->setStatus($data['status']);
        $resource->setNote($data['note']);

        $resource = $this->resourceRepository->save($resource);

        if (isset($data['file'])) {
            $this->resourceRepository->attach($resource, $data['file']);
        }

        return $resource;
    }

    public function checkUser($authUser)
    {
        if (is_null($authUser)) {
            throw new UserIsNotAuthenticatedException;
        }
    }

    public function checkVendor($vendor)
    {
        if (is_null($vendor)) {
            throw new EnterpriseNotFoundException;
        }

        if (! $this->enterpriseRepository->isVendor($vendor)) {
            throw new EnterpriseIsNotVendorException;
        }

        if (! $this->moduleRepository->hasAccessToResource($vendor)) {
            throw new EnterpriseDoesntHaveAccessToResourceException;
        }
    }
}
