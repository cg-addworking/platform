<?php

namespace Components\Enterprise\Document\Application\Providers;

use Components\Enterprise\Document\Application\Models\DocumentType;
use Components\Enterprise\Document\Application\Models\DocumentTypeRejectReason;
use Components\Enterprise\Document\Application\Repositories\DocumentRepository;
use Components\Enterprise\Document\Application\Repositories\DocumentTypeRejectReasonRepository;
use Components\Enterprise\Document\Application\Repositories\DocumentTypeRepository;
use Components\Enterprise\Document\Application\Repositories\UserRepository;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentTypeEntityInterface;
use Components\Enterprise\Document\Domain\Interfaces\Entities\DocumentTypeRejectReasonEntityInterface;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\DocumentRepositoryInterface;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\DocumentTypeRejectReasonRepositoryInterface;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\DocumentTypeRepositoryInterface;
use Components\Enterprise\Document\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Enterprise\Document\Domain\UseCases\CreateDocumentTypeRejectReason;
use Components\Enterprise\Document\Domain\UseCases\DeleteDocumentTypeRejectReason;
use Components\Enterprise\Document\Domain\UseCases\ListDocumentTypeRejectReason;
use Components\Enterprise\Document\Domain\UseCases\UpdateDocumentTypeRejectReason;
use Illuminate\Support\ServiceProvider;

class DocumentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'document');

        $this->loadTranslationsFrom(__DIR__.'/../Langs', 'document');
    }

    public function register()
    {
        $this->bindEntityInterfaces();

        $this->bindRepositoryInterfaces();

        $this->bindUseCases();
    }

    private function bindEntityInterfaces()
    {
        $this->app->bind(
            DocumentTypeEntityInterface::class,
            DocumentType::class
        );

        $this->app->bind(
            DocumentTypeRejectReasonEntityInterface::class,
            DocumentTypeRejectReason::class
        );
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            DocumentRepositoryInterface::class,
            DocumentRepository::class
        );

        $this->app->bind(
            DocumentTypeRejectReasonRepositoryInterface::class,
            DocumentTypeRejectReasonRepository::class
        );

        $this->app->bind(
            DocumentTypeRepositoryInterface::class,
            DocumentTypeRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }

    private function bindUseCases()
    {
        $this->bindCreateDocumentTypeRejectReasonUseCase();
        $this->bindListDocumentTypeRejectReasonUseCase();
        $this->bindDeleteDocumentTypeRejectReasonUseCase();
        $this->bindUpdateDocumentTypeRejectReasonUseCase();
    }

    private function bindCreateDocumentTypeRejectReasonUseCase()
    {
        $this->app->bind(
            CreateDocumentTypeRejectReason::class,
            function ($app) {
                return new CreateDocumentTypeRejectReason(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(DocumentTypeRejectReasonRepository::class)
                );
            }
        );
    }

    private function bindListDocumentTypeRejectReasonUseCase()
    {
        $this->app->bind(
            ListDocumentTypeRejectReason::class,
            function ($app) {
                return new ListDocumentTypeRejectReason(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(DocumentTypeRejectReasonRepository::class)
                );
            }
        );
    }

    public function bindDeleteDocumentTypeRejectReasonUseCase()
    {
        $this->app->bind(
            DeleteDocumentTypeRejectReason::class,
            function ($app) {
                return new DeleteDocumentTypeRejectReason(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(DocumentTypeRejectReasonRepository::class)
                );
            }
        );
    }
                  
    private function bindUpdateDocumentTypeRejectReasonUseCase()
    {
        $this->app->bind(
            UpdateDocumentTypeRejectReason::class,
            function ($app) {
                return new UpdateDocumentTypeRejectReason(
                    $app->make(UserRepositoryInterface::class),
                    $app->make(DocumentTypeRejectReasonRepository::class)
                );
            }
        );
    }
}
