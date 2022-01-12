<?php

namespace Components\Enterprise\Enterprise\Application\Providers;

use Components\Enterprise\Enterprise\Application\Commands\GetFrCompaniesFromPappersApi;
use Components\Enterprise\Enterprise\Application\Commands\NotifyForNonCompliance;
use Components\Enterprise\Enterprise\Application\Models\Activity;
use Components\Enterprise\Enterprise\Application\Models\Company;
use Components\Enterprise\Enterprise\Application\Models\CompanyActivity;
use Components\Enterprise\Enterprise\Application\Models\CompanyDenomination;
use Components\Enterprise\Enterprise\Application\Models\CompanyEmploye;
use Components\Enterprise\Enterprise\Application\Models\CompanyInvoicingDetail;
use Components\Enterprise\Enterprise\Application\Models\CompanyLegalRepresentative;
use Components\Enterprise\Enterprise\Application\Models\CompanyRegistrationOrganization;
use Components\Enterprise\Enterprise\Application\Models\CompanyShareCapital;
use Components\Enterprise\Enterprise\Application\Models\RegistrationOrganization;
use Components\Enterprise\Enterprise\Application\Policies\CompanyPolicy;
use Components\Enterprise\Enterprise\Application\Repositories\CompanyRepository;
use Components\Enterprise\Enterprise\Application\Repositories\EnterpriseMembershipRepository;
use Components\Enterprise\Enterprise\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\Enterprise\Application\Repositories\UserRepository;
use Components\Enterprise\Enterprise\Domain\Interfaces\CompanyRepositoryInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\EnterpriseMembershipRepositoryInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\EnterpriseRepositoryInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\ActivityEntityInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyActivityEntityInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyDenominationEntityInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyEmployeEntityInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyEntityInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyInvoicingDetailEntityInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyLegalRepresentativeEntityInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyRegistrationOrganizationEntityInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\CompanyShareCapitalEntityInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\Entities\RegistrationOrganizationEntityInterface;
use Components\Enterprise\Enterprise\Domain\Interfaces\UserRepositoryInterface;
use Components\Enterprise\Enterprise\Domain\UseCases\ListCompanies;
use Components\Enterprise\Enterprise\Domain\UseCases\ListEnterprisesAsSupport;
use Components\Enterprise\Enterprise\Domain\UseCases\ShowCompany;
use Illuminate\Support\ServiceProvider;

class EnterpriseServiceProvider extends ServiceProvider
{
    protected $policies = [
        Company::class => CompanyPolicy::class,
    ];

    protected $commands = [
        NotifyForNonCompliance::class,
        GetFrCompaniesFromPappersApi::class
    ];

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }

        $this->loadViewsFrom([
            __DIR__ . '/../Views'
        ], 'enterprise');

        $this->loadTranslationsFrom(__DIR__.'/../Langs', 'company');
    }

    protected function bootForConsole()
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
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
            ActivityEntityInterface::class,
            Activity::class
        );

        $this->app->bind(
            CompanyActivityEntityInterface::class,
            CompanyActivity::class
        );

        $this->app->bind(
            CompanyShareCapitalEntityInterface::class,
            CompanyShareCapital::class
        );

        $this->app->bind(
            CompanyDenominationEntityInterface::class,
            CompanyDenomination::class
        );

        $this->app->bind(
            CompanyEmployeEntityInterface::class,
            CompanyEmploye::class
        );

        $this->app->bind(
            CompanyEntityInterface::class,
            Company::class
        );

        $this->app->bind(
            CompanyInvoicingDetailEntityInterface::class,
            CompanyInvoicingDetail::class
        );

        $this->app->bind(
            CompanyLegalRepresentativeEntityInterface::class,
            CompanyLegalRepresentative::class
        );

        $this->app->bind(
            CompanyRegistrationOrganizationEntityInterface::class,
            CompanyRegistrationOrganization::class
        );

        $this->app->bind(
            RegistrationOrganizationEntityInterface::class,
            RegistrationOrganization::class
        );

        $this->app->bind(
            CompanyRepositoryInterface::class,
            CompanyRepository::class
        );
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(
            EnterpriseMembershipRepositoryInterface::class,
            EnterpriseMembershipRepository::class
        );

        $this->app->bind(
            EnterpriseRepositoryInterface::class,
            EnterpriseRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }

    private function bindUseCases()
    {
        $this->bindListEnterprisesAsSupportUseCase();
        $this->bindListCompanies();
        $this->bindShowCompany();
    }

    private function bindListEnterprisesAsSupportUseCase()
    {
        $this->app->bind(
            ListEnterprisesAsSupport::class,
            function ($app) {
                return new ListEnterprisesAsSupport(
                    $app->make(EnterpriseRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindListCompanies()
    {
        $this->app->bind(
            ListCompanies::class,
            function ($app) {
                return new ListCompanies(
                    $app->make(CompanyRepositoryInterface::class),
                    $app->make(UserRepositoryInterface::class),
                );
            }
        );
    }

    private function bindShowCompany()
    {
        $this->app->bind(
            ShowCompany::class,
            function ($app) {
                return new ShowCompany(
                    $app->make(UserRepositoryInterface::class)
                );
            }
        );
    }
}
