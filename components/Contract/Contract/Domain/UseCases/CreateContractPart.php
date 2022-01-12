<?php

namespace Components\Contract\Contract\Domain\UseCases;

use App\Models\Addworking\User\User;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractInvalidStateException;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\EnterpriseDoesntHavePartnershipWithContractException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use setasign\Fpdi\Fpdi;

/**
 * Create a @var ContractPartEntityInterface part from a contract, form inputs and a $file
 */
class CreateContractPart
{
    protected $contractPartRepository;
    protected $userRepository;
    protected $contractRepository;
    protected $contractStateRepository;

    public function __construct(
        ContractPartRepositoryInterface $contractPartRepository,
        UserRepositoryInterface $userRepository,
        ContractRepository $contractRepository,
        ContractStateRepository $contractStateRepository
    ) {
        $this->contractPartRepository = $contractPartRepository;
        $this->userRepository = $userRepository;
        $this->contractRepository = $contractRepository;
        $this->contractStateRepository = $contractStateRepository;
    }

    /**
     * Handles the process
     *
     * @param User|null $auth_user
     * @param ContractEntityInterface|null $contract
     * @param array|null $inputs
     * @param $file
     * @return mixed
     * @throws ContractInvalidStateException
     * @throws ContractIsNotFoundException
     * @throws EnterpriseDoesntHavePartnershipWithContractException
     * @throws UserIsNotAuthenticatedException
     */
    public function handle(
        ?User $auth_user,
        ?ContractEntityInterface $contract,
        ?array $inputs,
        $file
    ) {
        $this->checkUser($auth_user);
        $this->checkContract($contract, $auth_user);

        $file = $this->contractPartRepository->createFile($file);
        $contract_part = $this->createContractPart($contract, $inputs, $file);

        return $this->contractPartRepository->save($contract_part);
    }

    /**
     * Creates a @var ContractPartEntityInterface
     *
     * @param ContractEntityInterface|null $contract
     * @param array|null $inputs
     * @param $file
     * @return ContractPartEntityInterface
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     */
    public function createContractPart(?ContractEntityInterface $contract, ?array $inputs, $file)
    {
        $contract_part = $this->contractPartRepository->make();
        $contract_part->setContract($contract);
        $contract_part->setFile($file);
        $contract_part->setDisplayName($inputs['display_name']);
        $contract_part->setName($inputs['display_name']);
        $contract_part->setIsSigned(isset($inputs['is_signed']) ? $inputs['is_signed'] : false);
        $contract_part->setSignatureMention(
            isset($inputs['signature_mention']) ? $inputs['signature_mention'] : null
        );
        if (isset($inputs['is_signed']) && $inputs['is_signed']) {
            $contract_part->setSignOnLastPage($inputs['sign_on_last_page'] ?? false);
            $contract_part->setSignaturePage($this->getLastPage($file));
        } else {
            $contract_part->setSignaturePage(
                isset($inputs['signature_page']) ? $inputs['signature_page'] : null
            );
        }
        $contract_part->setNumber();
        $contract_part->setOrder($this->contractRepository->getContractParts($contract)->count() + 1);

        return $contract_part;
    }

    private function checkUser($auth_user)
    {
        if (is_null($auth_user)) {
            throw new UserIsNotAuthenticatedException;
        }
    }
    private function checkContract($contract, $auth_user)
    {
        if (is_null($contract)) {
            throw new ContractIsNotFoundException;
        }

        // TODO: Solution temporaire a remettre une fois Yousign ACTIF v0.76.7
        /*
        if (($this->contractStateRepository->toSign($contract)
                && !$this->contractRepository->isAmendment($contract))
            ||
            $this->contractStateRepository->isSigned($contract) ||
            $this->contractStateRepository->isActive($contract) ||
            $this->contractStateRepository->isDue($contract)
        ) {
            throw new ContractInvalidStateException();
        }
        */

        if ($this->contractStateRepository->toValidate($contract) ||
            $this->contractStateRepository->toSign($contract) ||
            $this->contractStateRepository->isSigned($contract) ||
            $this->contractStateRepository->isActive($contract) ||
            $this->contractStateRepository->isDue($contract)
        ) {
            throw new ContractInvalidStateException();
        }

        if ($this->userRepository->isSupport($auth_user)) {
            return true;
        }

        if (!$this->contractRepository->isOwnerOf($auth_user, $contract)) {
            throw new EnterpriseDoesntHavePartnershipWithContractException;
        }
    }

    /**
     * Get a pdf $file and return its amount of pages
     *
     * @param $file
     * @return int
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     */
    private function getLastPage($file)
    {
        $temp = tmpfile();
        fwrite($temp, $file->content);
        $pdfPath = stream_get_meta_data($temp)['uri'];

        $pdf = new Fpdi();
        $page_count = $pdf->setSourceFile($pdfPath); // How many pages?
        unlink($pdfPath);
        unset($file);
        unset($pdf);
        fclose($temp);
        return $page_count;
    }
}
