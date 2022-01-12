<?php

namespace Components\Sogetrel\Passwork\Domain\UseCases;

use App\Models\Addworking\Common\Comment;
use App\Models\Addworking\User\User;
use App\Models\Sogetrel\User\Passwork;
use App\Models\Sogetrel\User\Passwork as SogetrelPasswork;
use Components\Sogetrel\Passwork\Domain\Exceptions\CommentIsNotRelatedToThePassworkException;
use Components\Sogetrel\Passwork\Domain\Exceptions\PassworkIsBlackListedException;
use Components\Sogetrel\Passwork\Domain\Exceptions\PassworkIsNotFoundException;
use Components\Sogetrel\Passwork\Domain\Exceptions\UserEnterpriseIsNotPartOfSogetrelOrSubsidiaryException;
use Components\Sogetrel\Passwork\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Sogetrel\Passwork\Domain\Interfaces\Repositories\AcceptationRepositoryInterface;
use Components\Sogetrel\Passwork\Domain\Interfaces\Repositories\UserRepositoryInterface;

class CreateAcceptationFromPasswork
{
    protected $acceptationRepository;
    protected $userRepository;

    public function __construct(
        AcceptationRepositoryInterface $acceptationRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->acceptationRepository = $acceptationRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(
        ?User $user,
        ?SogetrelPasswork $passwork,
        ?Comment $operational_monitoring_data_comment,
        ?Comment $acceptation_comment
    ) {
        $this->checkUser($user);
        $this->checkPasswork($passwork);
        $this->checkComment($operational_monitoring_data_comment, $passwork);
        $this->checkComment($acceptation_comment, $passwork);

        $acceptation = $this->acceptationRepository->make();

        $acceptation->setNumber();

        $acceptation->setSogetrelPasswork($passwork);

        $acceptation->setEnterprise($passwork->user->enterprise);

        $acceptation->setContractStartingAt($passwork->work_starts_at);
        $acceptation->setContractEndingAt($passwork->date_due_at);

        $acceptation->setAcceptedBy($user);
        $acceptation->setAcceptedByName($user->name);

        $acceptation->setOperationalManager($passwork->operationalManager);
        $acceptation->setOperationalManagerName($passwork->operationalManager->name);

        $acceptation->setAdministrativeAssistant($passwork->administrativeAssistant);
        $acceptation->setAdministrativeAssistantName($passwork->administrativeAssistant->name);

        $acceptation->setAdministrativeManager($passwork->administrativeManager);
        $acceptation->setAdministrativeManagerName($passwork->administrativeManager->name);

        $acceptation->setContractSignatory($passwork->contractSignatory);
        $acceptation->setContractSignatoryName($passwork->contractSignatory->name);

        $acceptation->setOperationalMonitoringDataComment($operational_monitoring_data_comment);
        $acceptation->setAcceptationComment($acceptation_comment);

        $acceptation->setNeedsDecennialInsurance($passwork->needs_decennial_insurance);
        $acceptation->setApplicablePriceSlip($passwork->applicable_price_slip);
        $acceptation->setBankGuaranteeAmount($passwork->bank_guarantee_amount);

        return $this->acceptationRepository->save($acceptation);
    }

    private function checkUser(?User $user)
    {
        if (is_null($user)) {
            throw new UserIsNotAuthenticatedException;
        }

        if (! $this->userRepository->isSupport($user) && ! $user->enterprise->isSogetrelOrSubsidiary()) {
            throw new UserEnterpriseIsNotPartOfSogetrelOrSubsidiaryException;
        }
    }

    private function checkPasswork(?SogetrelPasswork $passwork)
    {
        if (is_null($passwork)) {
            throw new PassworkIsNotFoundException;
        }

        if ($passwork->isBlacklisted()) {
            throw new PassworkIsBlackListedException;
        }
    }

    private function checkComment(?Comment $comment, Passwork $passwork)
    {
        if (! is_null($comment) && $comment->commentable->id !== $passwork->id) {
            throw new CommentIsNotRelatedToThePassworkException;
        }
    }
}
