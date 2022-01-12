<?php
namespace Components\Enterprise\InvoiceParameter\Domain\UseCases;

use Components\Enterprise\InvoiceParameter\Domain\Exceptions\EnterpriseNotExistsException;
use Components\Enterprise\InvoiceParameter\Domain\Exceptions\UserNotAuthentificatedException;
use Components\Enterprise\InvoiceParameter\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\EnterpriseRepositoryInterface;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\InvoiceParameterRepositoryInterface;
use Components\Enterprise\InvoiceParameter\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ListInvoiceParameter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $userRepository;
    private $enterpriseRepository;
    private $invoiceParameterRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        EnterpriseRepositoryInterface $enterpriseRepository,
        InvoiceParameterRepositoryInterface $invoiceParameterRepository
    ) {
        $this->userRepository             = $userRepository;
        $this->enterpriseRepository       = $enterpriseRepository;
        $this->invoiceParameterRepository = $invoiceParameterRepository;
    }

    public function handle(string $siret)
    {
        $authUser = $this->userRepository->connectedUser();

        $this->checkUser($authUser);

        $enterprise = $this->enterpriseRepository->findBySiret($siret);

        $this->checkEnterprise($enterprise);

        return $this->invoiceParameterRepository->list($enterprise);
    }

    public function checkUser($authUser)
    {
        if (is_null($authUser)) {
            throw new UserNotAuthentificatedException();
        }

        if (! $this->userRepository->isSupport($authUser)) {
            throw new UserIsNotSupportException();
        }
    }

    public function checkEnterprise($enterprise)
    {
        if (is_null($enterprise)) {
            throw new EnterpriseNotExistsException();
        }
    }
}
