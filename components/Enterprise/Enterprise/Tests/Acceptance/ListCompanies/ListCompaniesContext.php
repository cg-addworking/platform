<?php

namespace Components\Enterprise\Enterprise\Tests\Acceptance\ListCompanies;

use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Common\Common\Application\Models\Country;
use Components\Enterprise\Enterprise\Application\Models\Company;
use Components\Enterprise\Enterprise\Application\Repositories\CompanyRepository;
use Components\Enterprise\Enterprise\Application\Repositories\UserRepository;
use Components\Enterprise\Enterprise\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\Enterprise\Domain\UseCases\ListCompanies;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListCompaniesContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $companyRepository;
    private $userRepository;

    public function __construct()
    {
        parent::setUp();

        $this->companyRepository = new CompanyRepository;
        $this->userRepository    = new UserRepository;
    }

    /**
     * @Given /^les pays suivant existent$/
     */
    public function lesPaysSuivantExistent(TableNode $countries)
    {
        foreach ($countries as $item)
        {
            $country = new Country();
            $country->fill([
                'short_id' => $item['short_id'],
                'code' => $item['code'],
            ]);
            $country->save();
        }
    }

    /**
     * @Given /^les companies suivantes existent$/
     */
    public function lesCompanieSuivantesExistent(TableNode $companies)
    {
        $default_country = Country::where('code', 'fr')->first();

        foreach ($companies as $item) {
            $companie = new Company();

            $companie->fill([
                'name'                      => $item['name'],
                'identification_number'     => $item['identification_number'],
                'short_id'                  => $item['short_id'],
            ]);

            $companie->legalForm()->associate(factory(LegalForm::class)->create());

            $companie->country()->associate($default_country);

            $companie->save();
        }
    }

    /**
     * @Given /^les utilisateurs suivants existent$/
     */
    public function lesUtilisateursSuivantsExistent(TableNode $users)
    {
        foreach ($users as $item) {
            $user = factory(User::class)->create([
                'firstname' => $item['firstname'],
                'lastname' => $item['lastname'],
                'email'    => $item['email'],
                'is_system_admin' => $item['is_system_admin']
            ]);

            // todo : activate when company is linked to user
//            $company = $this->companyRepository->findByIdentificationNumber($item['identification_number']);
//            $user->company()->attach($company);
        }
    }

    /**
     * @Given /^je suis authentifié en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail($email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de lister toutes les companies$/
     */
    public function jessaieDeListerToutesLesCompanies()
    {
        $auth_user = $this->userRepository->connectedUser();
        $filter = null;
        $search = null;
        $page = null;

        try {
            $this->response = (
                new ListCompanies($this->companyRepository, $this->userRepository)
            )->handle($auth_user, $filter, $search, $page);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^toutes les companies sont listées$/
     */
    public function toutesLesCompanieSontListees()
    {
        $this->assertDatabaseCount('companies', 7);
        $this->assertCount(7, $this->response);
    }

    /**
     * @Then /^une erreur est levée car l\'utilisateur connecté n\'est pas support$/
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasSupport()
    {
        $this->assertContainsEquals(
            UserIsNotSupportException::class,
            $this->errors
        );
    }
}
