<?php

namespace Components\Enterprise\Resource\Domain\UseCases;

use Components\Enterprise\Resource\Domain\Exceptions\ResourceNotFoundException;
use Components\Enterprise\Resource\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\Resource\Domain\Repositories\ResourceRepositoryInterface;
use Components\Enterprise\Resource\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateResource implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $resourceRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ResourceRepositoryInterface $resourceRepository
    ) {
        $this->userRepository = $userRepository;
        $this->resourceRepository = $resourceRepository;
    }

    public function handle(array $data)
    {
        $authUser = $this->userRepository->connectedUser();
        $this->checkUser($authUser);

        $resource = $this->resourceRepository->find($data['id']);
        $this->checkResource($resource);

        $resource->setFirstName($data['first_name']);
        $resource->setLastName($data['last_name']);
        $resource->setEmail($data['email']);
        $resource->setRegistrationNumber($data['registration_number']);
        $resource->setStatus($data['status']);
        $resource->setNote($data['note']);

        return $this->resourceRepository->save($resource);
    }

    public function checkUser($authUser)
    {
        if (is_null($authUser)) {
            throw new UserIsNotAuthenticatedException;
        }
    }

    public function checkResource($resource)
    {
        if (is_null($resource)) {
            throw new ResourceNotFoundException;
        }
    }
}
