<?php

namespace Components\Contract\Contract\Application\Providers;

use Components\Contract\Contract\Application\Commands\CheckExpiry;
use Components\Contract\Contract\Application\Commands\Notifications\SendRequestContractDocumentFollowupNotification;
use Components\Contract\Contract\Application\Commands\Notifications\SendSignContractFollowupNotification;
use Components\Contract\Contract\Application\Commands\SetContractState;
use Components\Contract\Contract\Application\Commands\UpdateContractNextPartyToSignToValidate;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractPart;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Application\Repositories\AnnexRepository;
use Components\Contract\Contract\Application\Repositories\CaptureInvoiceRepository;
use Components\Contract\Contract\Application\Repositories\CommentRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelDocumentTypeRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractNotificationRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\MilestoneRepository;
use Components\Contract\Contract\Application\Repositories\MissionRepository;
use Components\Contract\Contract\Application\Repositories\SubcontractingDeclarationRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Entities\ContractPartyEntityInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\AnnexRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\CaptureInvoiceRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\CommentRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractModelDocumentTypeRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractModelPartRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractModelPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractModelVariableRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractNotificationRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractPartyRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractStateRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractVariableRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\MilestoneRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\MissionRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\SubcontractingDeclarationRepositoryInterface;
use Components\Contract\Contract\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Contract\Contract\Domain\UseCases\AddContractPartToSignedContract;
use Components\Contract\Contract\Domain\UseCases\AssociateAnnexToContract;
use Components\Contract\Contract\Domain\UseCases\AssociateMissionToContract;
use Components\Contract\Contract\Domain\UseCases\CreateAmendment;
use Components\Contract\Contract\Domain\UseCases\CreateAmendmentWithoutModelToSign;
use Components\Contract\Contract\Domain\UseCases\CreateAnnex;
use Components\Contract\Contract\Domain\UseCases\CreateContract;
use Components\Contract\Contract\Domain\UseCases\CreateContractPart;
use Components\Contract\Contract\Domain\UseCases\CreateContractPartFromModel;
use Components\Contract\Contract\Domain\UseCases\CreateContractWithoutModel;
use Components\Contract\Contract\Domain\UseCases\CreateContractWithoutModelToSign;
use Components\Contract\Contract\Domain\UseCases\CreateSignedAmendmentWithoutModel;
use Components\Contract\Contract\Domain\UseCases\DefineContractVariableValue;
use Components\Contract\Contract\Domain\UseCases\DeleteAnnex;
use Components\Contract\Contract\Domain\UseCases\DeleteContract;
use Components\Contract\Contract\Domain\UseCases\DeleteContractPart;
use Components\Contract\Contract\Domain\UseCases\DownloadContract;
use Components\Contract\Contract\Domain\UseCases\DownloadContractDocuments;
use Components\Contract\Contract\Domain\UseCases\EditCaptureInvoice;
use Components\Contract\Contract\Domain\UseCases\EditContract;
use Components\Contract\Contract\Domain\UseCases\EditContractPart;
use Components\Contract\Contract\Domain\UseCases\EditContractParty;
use Components\Contract\Contract\Domain\UseCases\IdentifyParty;
use Components\Contract\Contract\Domain\UseCases\IdentifyValidator;
use Components\Contract\Contract\Domain\UseCases\ListAnnexAsSupport;
use Components\Contract\Contract\Domain\UseCases\ListContract;
use Components\Contract\Contract\Domain\UseCases\ListContractAsSupport;
use Components\Contract\Contract\Domain\UseCases\ListContractPartyDocument;
use Components\Contract\Contract\Domain\UseCases\ListContractVariable;
use Components\Contract\Contract\Domain\UseCases\ReorderContractParts;
use Components\Contract\Contract\Domain\UseCases\SendNotificationRequestDocuments;
use Components\Contract\Contract\Domain\UseCases\SendNotificationToRequestContractVariableValue;
use Components\Contract\Contract\Domain\UseCases\ShowAnnex;
use Components\Contract\Contract\Domain\UseCases\ShowContract;
use Components\Contract\Contract\Domain\UseCases\UpdateContractFromYousignData;
use Components\Contract\Model\Application\Repositories\ContractModelVariableRepository;
use Components\Infrastructure\PdfManager\Domain\Classes\PdfManagerInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ContractServiceProvider extends ServiceProvider
{
    protected $commands = [
        SetContractState::class,
        SendRequestContractDocumentFollowupNotification::class,
        SendSignContractFollowupNotification::class,
        CheckExpiry::class,
        UpdateContractNextPartyToSignToValidate::class,
    ];

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'contract');

        $this->bootValidator();
    }

    protected function bootValidator(): self
    {
        Validator::extend('contract_variable_is_required', function ($attribute, $value, $parameters, $validator) {
            $contract_variable_id = str_replace('contract_variable.', '', $attribute);

            $contract_variable = App::make(ContractVariableRepositoryInterface::class)->find($contract_variable_id);

            if ($contract_variable->getContractModelVariable()->getRequired() && is_null($value)) {
                return false;
            }

            return true;
        });

        return $this;
    }

    public function register()
    {
        $this->bindEntityInterfaces();

        $this->bindRepositoryInterfaces();

        $this->bindUseCases();
    }

    protected function bootForConsole()
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

    private function bindEntityInterfaces()
    {
        $this->app->bind(
            ContractEntityInterface::class,
            Contract::class
        );

        $this->app->bind(
            ContractPartyEntityInterface::class,
            ContractParty::class
        );

        $this->app->bind(
            ContractPartEntityInterface::class,
            ContractPart::class
        );
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            ContractModelDocumentTypeRepositoryInterface::class,
            ContractModelDocumentTypeRepository::class
        );

        $this->app->bind(
            ContractModelPartRepositoryInterface::class,
            ContractModelPartRepository::class
        );

        $this->app->bind(
            ContractModelPartyRepositoryInterface::class,
            ContractModelPartyRepository::class
        );

        $this->app->bind(
            ContractModelRepositoryInterface::class,
            ContractModelRepository::class
        );

        $this->app->bind(
            ContractModelVariableRepositoryInterface::class,
            ContractModelVariableRepository::class
        );

        $this->app->bind(
            ContractRepositoryInterface::class,
            ContractRepository::class
        );
        $this->app->bind(
            ContractPartyRepositoryInterface::class,
            ContractPartyRepository::class
        );

        $this->app->bind(
            EnterpriseRepositoryInterface::class,
            EnterpriseRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            ContractVariableRepositoryInterface::class,
            ContractVariableRepository::class
        );

        $this->app->bind(
            ContractPartRepositoryInterface::class,
            ContractPartRepository::class
        );

        $this->app->bind(
            ContractStateRepositoryInterface::class,
            ContractStateRepository::class
        );

        $this->app->bind(
            ContractNotificationRepositoryInterface::class,
            ContractNotificationRepository::class
        );

        $this->app->bind(
            CommentRepositoryInterface::class,
            CommentRepository::class
        );

        $this->app->bind(
            MissionRepositoryInterface::class,
            MissionRepository::class
        );

        $this->app->bind(
            MilestoneRepositoryInterface::class,
            MilestoneRepository::class
        );

        $this->app->bind(
            CaptureInvoiceRepositoryInterface::class,
            CaptureInvoiceRepository::class
        );

        $this->app->bind(
            SubcontractingDeclarationRepositoryInterface::class,
            SubcontractingDeclarationRepository::class
        );

        $this->app->bind(
            AnnexRepositoryInterface::class,
            AnnexRepository::class
        );
    }

    private function bindUseCases()
    {
        $this->bindCreateContractUseCase();
        $this->bindCreateAmendmentUseCase();
        $this->bindCreateAmendmentWithoutModelToSign();
        $this->bindCreateSignedAmendmentWithoutModel();
        $this->bindListContractUseCase();
        $this->bindListContractAsSupportUseCase();
        $this->bindEditContractUseCase();
        $this->bindIdentifyPartyUseCase();
        $this->bindIdentifyValidatorUseCase();
        $this->bindShowContractUseCase();
        $this->bindDeleteContractUseCase();
        $this->bindDefineContractVariableValueUseCase();
        $this->bindListContractVariableUseCase();
        $this->bindSendNotificationRequestDocumentsUseCase();
        $this->bindSendNotificationToRequestContractVariableValue();
        $this->bindDeleteContractUseCase();
        $this->bindListContractPartyDocumentUseCase();
        $this->bindCreateContractPartFromModelUseCase();
        $this->bindCreateContractPartUseCase();
        $this->bindAddContractPartToSignedContractUseCase();
        $this->bindEditContractPartUseCase();
        $this->bindDeleteContractPartUseCase();
        $this->bindEditContractPartyUseCase();
        $this->bindCreateContractWithoutModelUseCase();
        $this->bindAssociateMissionToContractUseCase();
        $this->bindCreateContractWithoutModelToSignUseCase();
        $this->bindReorderContractPartsUseCase();
        $this->bindDownloadContractUseCase();
        $this->bindDownloadContractDocumentsUseCase();
        $this->bindEditCaptureInvoiceUseCase();
        $this->bindCreateAnnexUseCase();
        $this->bindShowAnnexUseCase();
        $this->bindListAnnexAsSupportUseCase();
        $this->bindDeleteAnnexUseCase();
        $this->bindAssociateAnnexToContract();
        $this->bindUpdateContractFromYousignData();
    }

    private function bindCreateContractUseCase()
    {
        $this->app->bind(
            CreateContract::class,
            function ($app) {
                return new CreateContract(
                    $app->make(ContractModelRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractStateRepositoryInterface::class)
                );
            }
        );
    }

    private function bindCreateAmendmentUseCase()
    {
        $this->app->bind(
            CreateAmendment::class,
            function ($app) {
                return new CreateAmendment(
                    $app->make(ContractModelRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ContractPartyRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractStateRepositoryInterface::class),
                    $app->make(ContractVariableRepositoryInterface::class),
                    $app->make(ContractModelPartyRepository::class),
                    $app->make(MissionRepositoryInterface::class)
                );
            }
        );
    }

    private function bindCreateAmendmentWithoutModelToSign()
    {
        $this->app->bind(
            CreateAmendmentWithoutModelToSign::class,
            function ($app) {
                return new CreateAmendmentWithoutModelToSign(
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(ContractPartRepositoryInterface::class),
                    $app->make(ContractPartyRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ContractStateRepositoryInterface::class),
                    $app->make(MissionRepositoryInterface::class),
                    $app->make(ContractVariableRepositoryInterface::class)
                );
            }
        );
    }

    private function bindCreateSignedAmendmentWithoutModel()
    {
        $this->app->bind(
            CreateSignedAmendmentWithoutModel::class,
            function ($app) {
                return new CreateSignedAmendmentWithoutModel(
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(ContractPartRepositoryInterface::class),
                    $app->make(ContractPartyRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ContractStateRepositoryInterface::class),
                    $app->make(MissionRepositoryInterface::class)
                );
            }
        );
    }

    private function bindListContractUseCase()
    {
        $this->app->bind(
            ListContract::class,
            function ($app) {
                return new ListContract(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class),
                );
            }
        );
    }

    private function bindListContractAsSupportUseCase()
    {
        $this->app->bind(
            ListContractAsSupport::class,
            function ($app) {
                return new ListContractAsSupport(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class),
                );
            }
        );
    }

    private function bindIdentifyPartyUseCase()
    {
        $this->app->bind(
            IdentifyParty::class,
            function ($app) {
                return new IdentifyParty(
                    $app->make(ContractPartyRepositoryInterface::class),
                    $app->make(ContractModelPartyRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractVariableRepositoryInterface::class),
                    $app->make(ContractStateRepositoryInterface::class),
                );
            }
        );
    }

    private function bindIdentifyValidatorUseCase()
    {
        $this->app->bind(
            IdentifyValidator::class,
            function ($app) {
                return new IdentifyValidator(
                    $app->make(ContractPartyRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindEditContractUseCase()
    {
        $this->app->bind(
            EditContract::class,
            function ($app) {
                return new EditContract(
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractStateRepositoryInterface::class),
                );
            }
        );
    }

    private function bindDeleteContractUseCase()
    {
        $this->app->bind(
            DeleteContract::class,
            function ($app) {
                return new DeleteContract(
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindShowContractUseCase()
    {
        $this->app->bind(
            ShowContract::class,
            function ($app) {
                return new ShowContract();
            }
        );
    }

    private function bindDefineContractVariableValueUseCase()
    {
        $this->app->bind(
            DefineContractVariableValue::class,
            function ($app) {
                return new DefineContractVariableValue(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(ContractVariableRepositoryInterface::class),
                    $app->make(ContractStateRepositoryInterface::class),
                );
            }
        );
    }

    private function bindListContractVariableUseCase()
    {
        $this->app->bind(
            ListContractVariable::class,
            function ($app) {
                return new ListContractVariable(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractVariableRepositoryInterface::class),
                );
            }
        );
    }

    private function bindSendNotificationRequestDocumentsUseCase()
    {
        $this->app->bind(
            SendNotificationRequestDocuments::class,
            function ($app) {
                return new SendNotificationRequestDocuments(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(ContractNotificationRepositoryInterface::class),
                    $app->make(CommentRepositoryInterface::class),
                    $app->make(ContractPartyRepositoryInterface::class),
                );
            }
        );
    }

    private function bindSendNotificationToRequestContractVariableValue()
    {
        $this->app->bind(
            SendNotificationToRequestContractVariableValue::class,
            function ($app) {
                return new SendNotificationToRequestContractVariableValue(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(ContractNotificationRepositoryInterface::class)
                );
            }
        );
    }

    private function bindListContractPartyDocumentUseCase()
    {
        $this->app->bind(
            ListContractPartyDocument::class,
            function ($app) {
                return new ListContractPartyDocument(
                    $app->make(ContractModelDocumentTypeRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindCreateContractPartFromModelUseCase()
    {
        $this->app->bind(
            CreateContractPartFromModel::class,
            function ($app) {
                return new CreateContractPartFromModel(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractPartRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(ContractVariableRepositoryInterface::class),
                    $app->make(PdfManagerInterface::class),
                );
            }
        );
    }

    private function bindCreateContractPartUseCase()
    {
        $this->app->bind(
            CreateContractPart::class,
            function ($app) {
                return new CreateContractPart(
                    $app->make(ContractPartRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(ContractStateRepository::class),
                );
            }
        );
    }

    private function bindAddContractPartToSignedContractUseCase()
    {
        $this->app->bind(
            AddContractPartToSignedContract::class,
            function ($app) {
                return new AddContractPartToSignedContract(
                    $app->make(ContractPartRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(ContractStateRepository::class),
                );
            }
        );
    }

    private function bindEditContractPartUseCase()
    {
        $this->app->bind(
            EditContractPart::class,
            function ($app) {
                return new EditContractPart(
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindDeleteContractPartUseCase()
    {
        $this->app->bind(
            DeleteContractPart::class,
            function ($app) {
                return new DeleteContractPart(
                    $app->make(ContractPartRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindEditContractPartyUseCase()
    {
        $this->app->bind(
            EditContractParty::class,
            function ($app) {
                return new EditContractParty(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(ContractPartyRepositoryInterface::class),
                    $app->make(ContractVariableRepositoryInterface::class),
                    $app->make(ContractStateRepository::class),
                    $app->make(ContractPartRepositoryInterface::class),
                );
            }
        );
    }

    private function bindCreateContractWithoutModelUseCase()
    {
        $this->app->bind(
            CreateContractWithoutModel::class,
            function ($app) {
                return new CreateContractWithoutModel(
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(ContractPartRepositoryInterface::class),
                    $app->make(ContractPartyRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ContractStateRepositoryInterface::class),
                    $app->make(MissionRepositoryInterface::class)
                );
            }
        );
    }

    private function bindAssociateMissionToContractUseCase()
    {
        $this->app->bind(
            AssociateMissionToContract::class,
            function ($app) {
                return new AssociateMissionToContract(
                    $app->make(MissionRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class)
                );
            }
        );
    }

    private function bindCreateContractWithoutModelToSignUseCase()
    {
        $this->app->bind(
            CreateContractWithoutModelToSign::class,
            function ($app) {
                return new CreateContractWithoutModelToSign(
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(ContractPartRepositoryInterface::class),
                    $app->make(ContractPartyRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(ContractStateRepositoryInterface::class),
                    $app->make(MissionRepositoryInterface::class)
                );
            }
        );
    }

    private function bindReorderContractPartsUseCase()
    {
        $this->app->bind(
            ReorderContractParts::class,
            function ($app) {
                return new ReorderContractParts(
                    $app->make(ContractPartRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class),
                );
            }
        );
    }

    private function bindDownloadContractUseCase()
    {
        $this->app->bind(
            DownloadContract::class,
            function ($app) {
                return new DownloadContract(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class),
                );
            }
        );
    }

    private function bindDownloadContractDocumentsUseCase()
    {
        $this->app->bind(
            DownloadContractDocuments::class,
            function ($app) {
                return new DownloadContractDocuments(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class),
                );
            }
        );
    }

    private function bindEditCaptureInvoiceUseCase()
    {
        $this->app->bind(
            EditCaptureInvoice::class,
            function ($app) {
                return new EditCaptureInvoice(
                    $app->make(CaptureInvoiceRepositoryInterface::class),
                    $app->make(SubcontractingDeclarationRepositoryInterface::class),
                );
            }
        );
    }

    private function bindUpdateContractFromYousignData()
    {
        $this->app->bind(
            UpdateContractFromYousignData::class,
            function ($app) {
                return new UpdateContractFromYousignData(
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractPartRepositoryInterface::class),
                    $app->make(ContractPartyRepositoryInterface::class)
                );
            }
        );
    }

    private function bindCreateAnnexUseCase()
    {
        $this->app->bind(
            CreateAnnex::class,
            function ($app) {
                return new CreateAnnex(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(AnnexRepositoryInterface::class),
                );
            }
        );
    }

    private function bindShowAnnexUseCase()
    {
        $this->app->bind(
            ShowAnnex::class,
            function ($app) {
                return new ShowAnnex(
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindListAnnexAsSupportUseCase()
    {
        $this->app->bind(
            ListAnnexAsSupport::class,
            function ($app) {
                return new ListAnnexAsSupport(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(AnnexRepositoryInterface::class),
                );
            }
        );
    }

    private function bindDeleteAnnexUseCase()
    {
        $this->app->bind(
            DeleteAnnex::class,
            function ($app) {
                return new DeleteAnnex(
                    $app->make(AnnexRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindAssociateAnnexToContract()
    {
        $this->app->bind(
            AssociateAnnexToContract::class,
            function ($app) {
                return new AssociateAnnexToContract(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractRepositoryInterface::class),
                    $app->make(ContractPartRepository::class),
                    $app->make(ContractStateRepository::class),
                );
            }
        );
    }
}
