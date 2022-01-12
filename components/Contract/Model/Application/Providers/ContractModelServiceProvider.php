<?php

namespace Components\Contract\Model\Application\Providers;

use Components\Contract\Contract\Domain\Interfaces\Repositories\ContractVariableRepositoryInterface;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Models\ContractModelDocumentType;
use Components\Contract\Model\Application\Models\ContractModelPart;
use Components\Contract\Model\Application\Models\ContractModelParty;
use Components\Contract\Model\Application\Models\ContractModelVariable;
use Components\Contract\Model\Application\Repositories\ContractModelDocumentTypeRepository;
use Components\Contract\Model\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Model\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Contract\Model\Application\Repositories\ContractModelVariableRepository;
use Components\Contract\Model\Application\Repositories\DocumentTypeRepository;
use Components\Contract\Model\Application\Repositories\EnterpriseRepository;
use Components\Contract\Model\Application\Repositories\UserRepository;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelDocumentTypeEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelPartyEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Entities\ContractModelVariableEntityInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelDocumentTypeRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelPartRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelPartyRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\ContractModelVariableRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\DocumentTypeRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Contract\Model\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Contract\Model\Domain\UseCases\CreateContractModelPart;
use Components\Contract\Model\Domain\UseCases\CreateContractModelPartPreview;
use Components\Contract\Model\Domain\UseCases\CreateEmptyContractModel;
use Components\Contract\Model\Domain\UseCases\CreateSpecificDocumentForContractModel;
use Components\Contract\Model\Domain\UseCases\DefineDocumentTypeForContractModel;
use Components\Contract\Model\Domain\UseCases\DeleteContractModel;
use Components\Contract\Model\Domain\UseCases\DeleteContractModelPart;
use Components\Contract\Model\Domain\UseCases\DeleteContractModelParty;
use Components\Contract\Model\Domain\UseCases\DeleteDocumentTypeForContractModel;
use Components\Contract\Model\Domain\UseCases\DuplicateContractModel;
use Components\Contract\Model\Domain\UseCases\EditContractModel;
use Components\Contract\Model\Domain\UseCases\EditContractModelPart;
use Components\Contract\Model\Domain\UseCases\ListContractModelAsSupport;
use Components\Contract\Model\Domain\UseCases\ListContractModelPart;
use Components\Contract\Model\Domain\UseCases\ListContractModelVariable;
use Components\Contract\Model\Domain\UseCases\ListDocumentTypeOfContractModelParty;
use Components\Contract\Model\Domain\UseCases\ShowContractModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Components\Contract\Model\Domain\UseCases\ArchiveContractModel;

class ContractModelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'contract_model');

        $this->loadFactoriesFrom(__DIR__.'/../Factories');

        $this->bootValidator();
    }

    public function register()
    {
        $this->bindEntityInterfaces();

        $this->bindRepositoryInterfaces();

        $this->bindUseCases();
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            ContractModelRepositoryInterface::class,
            ContractModelRepository::class
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
            ContractModelPartyRepositoryInterface::class,
            ContractModelPartyRepository::class
        );

        $this->app->bind(
            ContractModelDocumentTypeRepositoryInterface::class,
            ContractModelDocumentTypeRepository::class
        );

        $this->app->bind(
            DocumentTypeRepositoryInterface::class,
            DocumentTypeRepository::class
        );

        $this->app->bind(
            ContractModelPartRepositoryInterface::class,
            ContractModelPartRepository::class
        );

        $this->app->bind(
            ContractModelVariableRepositoryInterface::class,
            ContractModelVariableRepository::class
        );
    }

    private function bindEntityInterfaces()
    {
        $this->app->bind(
            ContractModelEntityInterface::class,
            ContractModel::class
        );

        $this->app->bind(
            ContractModelPartyEntityInterface::class,
            ContractModelParty::class
        );

        $this->app->bind(
            ContractModelDocumentTypeEntityInterface::class,
            ContractModelDocumentType::class
        );

        $this->app->bind(
            ContractModelPartEntityInterface::class,
            ContractModelPart::class
        );

        $this->app->bind(
            ContractModelVariableEntityInterface::class,
            ContractModelVariable::class
        );
    }

    private function bindUseCases()
    {
        $this->bindCreateContractModelUseCase();
        $this->bindShowContractModelUseCase();
        $this->bindListContractModelAsSupportUseCase();
        $this->bindEditContractModelUseCase();
        $this->bindDeleteContractModelUseCase();
        $this->bindDeleteContractModelPartyUseCase();
        $this->bindDefineDocumentTypeForContractModelUseCase();
        $this->bindListDocumentTypeOfContractModelPartyUseCase();
        $this->bindDeleteDocumentTypeForContractModelUseCase();
        $this->bindCreateContractModelPartUseCase();
        $this->bindListContractModelPartUseCase();
        $this->bindEditContractModelPartUseCase();
        $this->bindDeleteContractModelPartUseCase();
        $this->bindCreateContractModelPartPreview();
        $this->bindListContractModelVariable();
        $this->bindDuplicateContractModelUseCase();
        $this->bindCreateSpecificDocumentForContractModelUseCase();
        $this->bindArchiveContractModelUseCase();
    }

    private function bindCreateContractModelUseCase()
    {
        $this->app->bind(
            CreateEmptyContractModel::class,
            function ($app) {
                return new CreateEmptyContractModel(
                    $app->make(ContractModelPartyRepositoryInterface::class),
                    $app->make(ContractModelRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindShowContractModelUseCase()
    {
        $this->app->bind(
            ShowContractModel::class,
            function ($app) {
                return new ShowContractModel(
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindListContractModelAsSupportUseCase()
    {
        $this->app->bind(
            ListContractModelAsSupport::class,
            function ($app) {
                return new ListContractModelAsSupport(
                    $app->make(ContractModelRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindEditContractModelUseCase()
    {
        $this->app->bind(
            EditContractModel::class,
            function ($app) {
                return new EditContractModel(
                    $app->make(ContractModelPartyRepositoryInterface::class),
                    $app->make(ContractModelRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindDeleteContractModelUseCase()
    {
        $this->app->bind(
            DeleteContractModel::class,
            function ($app) {
                return new DeleteContractModel(
                    $app->make(ContractModelRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindDeleteContractModelPartyUseCase()
    {
        $this->app->bind(
            DeleteContractModelParty::class,
            function ($app) {
                return new DeleteContractModelParty(
                    $app->make(ContractModelPartyRepositoryInterface::class),
                    $app->make(ContractModelRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindDefineDocumentTypeForContractModelUseCase()
    {
        $this->app->bind(
            DefineDocumentTypeForContractModel::class,
            function ($app) {
                return new DefineDocumentTypeForContractModel(
                    $app->make(ContractModelRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractModelDocumentTypeRepositoryInterface::class),
                    $app->make(DocumentTypeRepositoryInterface::class)
                );
            }
        );
    }

    private function bindDeleteDocumentTypeForContractModelUseCase()
    {
        $this->app->bind(
            DeleteDocumentTypeForContractModel::class,
            function ($app) {
                return new DeleteDocumentTypeForContractModel(
                    $app->make(ContractModelRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractModelDocumentTypeRepositoryInterface::class),
                    $app->make(DocumentTypeRepositoryInterface::class)
                );
            }
        );
    }

    private function bindListDocumentTypeOfContractModelPartyUseCase()
    {
        $this->app->bind(
            ListDocumentTypeOfContractModelParty::class,
            function ($app) {
                return new ListDocumentTypeOfContractModelParty(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractModelDocumentTypeRepository::class)
                );
            }
        );
    }

    private function bindCreateContractModelPartUseCase()
    {
        $this->app->bind(
            CreateContractModelPart::class,
            function ($app) {
                return new CreateContractModelPart(
                    $app->make(ContractModelPartRepositoryInterface::class),
                    $app->make(ContractModelPartyRepositoryInterface::class),
                    $app->make(ContractModelRepositoryInterface::class),
                    $app->make(ContractModelVariableRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindListContractModelPartUseCase()
    {
        $this->app->bind(
            ListContractModelPart::class,
            function ($app) {
                return new ListContractModelPart(
                    $app->make(ContractModelPartRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindEditContractModelPartUseCase()
    {
        $this->app->bind(
            EditContractModelPart::class,
            function ($app) {
                return new EditContractModelPart(
                    $app->make(ContractModelPartRepositoryInterface::class),
                    $app->make(ContractModelRepositoryInterface::class),
                    $app->make(ContractModelVariableRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindDeleteContractModelPartUseCase()
    {
        $this->app->bind(
            DeleteContractModelPart::class,
            function ($app) {
                return new DeleteContractModelPart(
                    $app->make(ContractModelRepositoryInterface::class),
                    $app->make(ContractModelVariableRepositoryInterface::class),
                    $app->make(ContractModelPartRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindCreateContractModelPartPreview()
    {
        $this->app->bind(
            CreateContractModelPartPreview::class,
            function ($app) {
                return new CreateContractModelPartPreview(
                    $app->make(ContractModelPartRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindListContractModelVariable()
    {
        $this->app->bind(
            ListContractModelVariable::class,
            function ($app) {
                return new ListContractModelVariable(
                    $app->make(ContractModelVariableRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindDuplicateContractModelUseCase()
    {
        $this->app->bind(
            DuplicateContractModel::class,
            function ($app) {
                return new DuplicateContractModel(
                    $app->make(ContractModelRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindCreateSpecificDocumentForContractModelUseCase()
    {
        $this->app->bind(
            CreateSpecificDocumentForContractModel::class,
            function ($app) {
                return new CreateSpecificDocumentForContractModel(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ContractModelRepositoryInterface::class),
                    $app->make(ContractModelDocumentTypeRepositoryInterface::class)
                );
            }
        );
    }

    protected function bootValidator(): self
    {
        Validator::extend('contract_model_variable_size', function ($attribute, $value, $parameters, $validator) {
            $input_type_field_name = str_replace('default_value', 'input_type', $attribute);
            $input_type = request($input_type_field_name);

            if ($input_type === ContractModelVariableEntityInterface::INPUT_TYPE_LONG_TEXT) {
                $max = 1500;
            } else {
                $max = 255;
            }

            return strlen($value) <= $max;
        });

        return $this;
    }

    private function bindArchiveContractModelUseCase()
    {
        $this->app->bind(
            ArchiveContractModel::class,
            function ($app) {
                return new ArchiveContractModel(
                    $app->make(ContractModelRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class)
                );
            }
        );
    }
}
