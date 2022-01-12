<?php

namespace Components\Mission\Offer\Application\Providers;

use Components\Mission\Offer\Application\Presenters\OfferListPresenter;
use Components\Mission\Offer\Application\Presenters\OfferShowPresenter;
use Components\Mission\Offer\Application\Presenters\ResponseListPresenter;
use Components\Mission\Offer\Application\Presenters\ResponseShowPresenter;
use Components\Mission\Offer\Application\Repositories\CostEstimationRepository;
use Components\Mission\Offer\Application\Repositories\EnterpriseRepository;
use Components\Mission\Offer\Application\Repositories\JobRepository;
use Components\Mission\Offer\Application\Repositories\MissionRepository;
use Components\Mission\Offer\Application\Repositories\OfferRepository;
use Components\Mission\Offer\Application\Repositories\ProposalRepository;
use Components\Mission\Offer\Application\Repositories\ResponseRepository;
use Components\Mission\Offer\Application\Repositories\SectorRepository;
use Components\Mission\Offer\Application\Repositories\SkillRepository;
use Components\Mission\Offer\Application\Repositories\UserRepository;
use Components\Mission\Offer\Application\Repositories\WorkFieldRepository;
use Components\Mission\Offer\Domain\Interfaces\Presenters\OfferListPresenterInterface;
use Components\Mission\Offer\Domain\Interfaces\Presenters\OfferShowPresenterInterface;
use Components\Mission\Offer\Domain\Interfaces\Presenters\ResponseListPresenterInterface;
use Components\Mission\Offer\Domain\Interfaces\Presenters\ResponseShowPresenterInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\CostEstimationRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\EnterpriseRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\JobRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\MissionRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\OfferRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\ProposalRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\ResponseRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\SectorRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\SkillRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Components\Mission\Offer\Domain\Interfaces\Repositories\WorkFieldRepositoryInterface;
use Components\Mission\Offer\Domain\UseCases\CloseOffer;
use Components\Mission\Offer\Domain\UseCases\CreateConstructionOffer;
use Components\Mission\Offer\Domain\UseCases\CreateConstructionResponse;
use Components\Mission\Offer\Domain\UseCases\DeleteOffer;
use Components\Mission\Offer\Domain\UseCases\EditConstructionOffer;
use Components\Mission\Offer\Domain\UseCases\ListOffer;
use Components\Mission\Offer\Domain\UseCases\ListResponse;
use Components\Mission\Offer\Domain\UseCases\SendOfferToEnterprise;
use Components\Mission\Offer\Domain\UseCases\ShowConstructionOffer;
use Illuminate\Support\ServiceProvider;
use Components\Mission\Offer\Domain\UseCases\ShowConstructionResponse;

class OfferServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->loadViewsFrom([__DIR__ . '/../Views'], 'offer');
        $this->loadTranslationsFrom(__DIR__.'/../Langs', 'offer');
        $this->bootDirectives();
    }

    public function register()
    {
        $this->bindPresenterInterfaces();

        $this->bindRepositoryInterfaces();

        $this->bindUseCases();
    }

    public function provides()
    {
        //
    }

    protected function bootDirectives()
    {
        //
    }

    protected function bootForConsole()
    {
        //
    }

    protected function bindPresenterInterfaces()
    {
        $this->app->bind(
            OfferShowPresenterInterface::class,
            OfferShowPresenter::class
        );

        $this->app->bind(
            ResponseShowPresenterInterface::class,
            ResponseShowPresenter::class
        );

        $this->app->bind(
            ResponseListPresenterInterface::class,
            ResponseListPresenter::class
        );

        $this->app->bind(
            OfferListPresenterInterface::class,
            OfferListPresenter::class
        );
    }

    protected function bindRepositoryInterfaces()
    {
        $this->app->bind(
            OfferRepositoryInterface::class,
            OfferRepository::class
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
            WorkFieldRepositoryInterface::class,
            WorkFieldRepository::class
        );

        $this->app->bind(
            SectorRepositoryInterface::class,
            SectorRepository::class
        );

        $this->app->bind(
            JobRepositoryInterface::class,
            JobRepository::class
        );

        $this->app->bind(
            ProposalRepositoryInterface::class,
            ProposalRepository::class
        );

        $this->app->bind(
            SkillRepositoryInterface::class,
            SkillRepository::class
        );

        $this->app->bind(
            ResponseRepositoryInterface::class,
            ResponseRepository::class
        );

        $this->app->bind(
            MissionRepositoryInterface::class,
            MissionRepository::class
        );

        $this->app->bind(
            CostEstimationRepositoryInterface::class,
            CostEstimationRepository::class
        );
    }

    protected function bindUseCases()
    {
        $this->bindCreateConstructionOfferUseCase();
        $this->bindEditConstructionOfferUseCase();
        $this->bindSendOfferToEnterpriseUseCase();
        $this->bindCreateConstructionResponseUseCase();
        $this->bindCloseOfferUseCase();
        $this->bindListResponseUseCase();
        $this->bindListOfferUseCase();
        $this->bindShowConstructionResponseUseCase();
        $this->bindShowConstructionOfferUseCase();
        $this->bindDeleteOfffer();
    }

    protected function bindCreateConstructionOfferUseCase()
    {
        $this->app->bind(
            CreateConstructionOffer::class,
            function ($app) {
                return new CreateConstructionOffer(
                    $app->make(OfferRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(WorkFieldRepositoryInterface::class),
                    $app->make(SectorRepositoryInterface::class),
                );
            }
        );
    }

    protected function bindEditConstructionOfferUseCase()
    {
        $this->app->bind(
            EditConstructionOffer::class,
            function ($app) {
                return new EditConstructionOffer(
                    $app->make(OfferRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    protected function bindSendOfferToEnterpriseUseCase()
    {
        $this->app->bind(
            SendOfferToEnterprise::class,
            function ($app) {
                return new SendOfferToEnterprise(
                    $app->make(ProposalRepositoryInterface::class),
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(OfferRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    protected function bindCreateConstructionResponseUseCase()
    {
        $this->app->bind(
            CreateConstructionResponse::class,
            function ($app) {
                return new CreateConstructionResponse(
                    $app->make(ResponseRepositoryInterface::class),
                    $app->make(ProposalRepositoryInterface::class),
                );
            }
        );
    }

    protected function bindListResponseUseCase()
    {
        $this->app->bind(
            ListResponse::class,
            function ($app) {
                return new ListResponse(
                    $app->make(ResponseRepositoryInterface::class),
                );
            }
        );
    }

    protected function bindCloseOfferUseCase()
    {
        $this->app->bind(
            CloseOffer::class,
            function ($app) {
                return new CloseOffer(
                    $app->make(ResponseRepositoryInterface::class),
                    $app->make(MissionRepositoryInterface::class),
                    $app->make(OfferRepositoryInterface::class),
                    $app->make(CostEstimationRepositoryInterface::class),
                );
            }
        );
    }

    protected function bindListOfferUseCase()
    {
        $this->app->bind(
            ListOffer::class,
            function ($app) {
                return new ListOffer(
                    $app->make(OfferRepositoryInterface::class),
                );
            }
        );
    }

    protected function bindShowConstructionResponseUseCase()
    {
        $this->app->bind(
            ShowConstructionResponse::class,
            function ($app) {
                return new ShowConstructionResponse(
                    $app->make(OfferRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                    $app->make(ResponseRepositoryInterface::class)
                );
            }
        );
    }
  
    protected function bindShowConstructionOfferUseCase()
    {
        $this->app->bind(
            ShowConstructionOffer::class,
            function ($app) {
                return new ShowConstructionOffer(
                    $app->make(ProposalRepositoryInterface::class),
                    $app->make(OfferRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    public function bindDeleteOfffer()
    {
        $this->app->bind(
            DeleteOffer::class,
            function ($app) {
                return new DeleteOffer(
                    $app->make(OfferRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }
}
