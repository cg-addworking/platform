<?php

namespace Components\Enterprise\DocumentTypeModel\Application\Providers;

use Components\Common\WYSIWYG\Domain\Interfaces\Repositories\WysiwygRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModelVariable;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeModelRepository;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeModelVariableRepository;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeRepository;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\UserRepository;
use Components\Enterprise\DocumentTypeModel\Domain\Entities\DocumentTypeModelEntityInterface;
use Components\Enterprise\DocumentTypeModel\Domain\Entities\DocumentTypeModelVariableEntityInterface;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\DocumentTypeModelRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\DocumentTypeModelVariableRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\DocumentTypeRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\EnterpriseRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Domain\RepositoriesInterface\UserRepositoryInterface;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\CreateDocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\EditDocumentTypeModelVariable;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\ListDocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\ListDocumentTypeModelVariable;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\ShowDocumentTypeModel;
use Illuminate\Support\ServiceProvider;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\EditDocumentTypeModel;

class DocumentTypeModelServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom([__DIR__ . '/../Views'], 'document_type_model');
        $this->loadTranslationsFrom(__DIR__.'/../Langs', 'document_type_model');
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
            DocumentTypeModelRepositoryInterface::class,
            DocumentTypeModelRepository::class
        );

        $this->app->bind(
            DocumentTypeModelVariableRepositoryInterface::class,
            DocumentTypeModelVariableRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            EnterpriseRepositoryInterface::class,
            EnterpriseRepository::class
        );

        $this->app->bind(
            DocumentTypeRepositoryInterface::class,
            DocumentTypeRepository::class
        );
    }

    private function bindEntityInterfaces()
    {
        $this->app->bind(
            DocumentTypeModelEntityInterface::class,
            DocumentTypeModel::class
        );

        $this->app->bind(
            DocumentTypeModelVariableEntityInterface::class,
            DocumentTypeModelVariable::class
        );
    }

    private function bindUseCases()
    {
        $this->bindCreateDocumentTypeModelUseCase();
        $this->bindListDocumentTypeModelUseCase();
        $this->bindEditDocumentTypeModelUseCase();
        $this->bindShowDocumentTypeModelUseCase();
        $this->bindListDocumentTypeModelVariableUseCase();
        $this->bindEditDocumentTypeModelVariableUseCase();
    }

    private function bindCreateDocumentTypeModelUseCase()
    {
        $this->app->bind(
            CreateDocumentTypeModel::class,
            function ($app) {
                return new CreateDocumentTypeModel(
                    $app->make(DocumentTypeModelRepositoryInterface::class),
                    $app->make(DocumentTypeModelVariableRepositoryInterface::class),
                    $app->make(WysiwygRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindListDocumentTypeModelUseCase()
    {
        $this->app->bind(
            ListDocumentTypeModel::class,
            function ($app) {
                return new ListDocumentTypeModel(
                    $app->make(DocumentTypeModelRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindEditDocumentTypeModelUseCase()
    {
        $this->app->bind(
            EditDocumentTypeModel::class,
            function ($app) {
                return new EditDocumentTypeModel(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(DocumentTypeModelRepositoryInterface::class),
                    $app->make(DocumentTypeModelVariableRepositoryInterface::class),
                    $app->make(WysiwygRepositoryInterface::class)
                );
            }
        );
    }

    private function bindShowDocumentTypeModelUseCase()
    {
        $this->app->bind(
            ShowDocumentTypeModel::class,
            function ($app) {
                return new ShowDocumentTypeModel(
                    $app->make(UserRepositoryInterface::class)
                );
            }
        );
    }

    private function bindListDocumentTypeModelVariableUseCase()
    {
        $this->app->bind(
            ListDocumentTypeModelVariable::class,
            function ($app) {
                return new ListDocumentTypeModelVariable(
                    $app->make(DocumentTypeModelVariableRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class)
                );
            }
        );
    }

    private function bindEditDocumentTypeModelVariableUseCase()
    {
        $this->app->bind(
            EditDocumentTypeModelVariable::class,
            function ($app) {
                return new EditDocumentTypeModelVariable(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(DocumentTypeModelVariableRepositoryInterface::class)
                );
            }
        );
    }
}
