<?php

namespace Components\Enterprise\Enterprise\Tests\Acceptance\ShowCompany;

use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Common\Common\Application\Models\Country;
use Components\Enterprise\Enterprise\Application\Models\Company;
use Components\Enterprise\Enterprise\Application\Repositories\CompanyRepository;
use Components\Enterprise\Enterprise\Application\Repositories\UserRepository;
use Components\Enterprise\Enterprise\Domain\Exceptions\CompanyNotFoundException;
use Components\Enterprise\Enterprise\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\Enterprise\Domain\UseCases\ShowCompany;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowCompanyContext extends TestCase implements Context
{
    use RefreshDatabase;

    protected $companyRepository;
    protected $userRepository;

    protected $response;
    protected $errors = [];

    public function __construct()
    {
        parent::setUp();

        $this->companyRepository = new CompanyRepository;
        $this->userRepository = new UserRepository;
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
     * @Given /^les companies suivant existent$/
     */
    public function lesCompaniesSuivantExistent(TableNode $companies)
    {
        $default_country = Country::where('code', 'fr')->first();

        foreach ($companies as $item) {
            $companie = new Company();

            $companie->fill([
                'name'                  => $item['name'],
                'identification_number' => $item['identification_number'],
                'short_id'              => $item['short_id'],
            ]);

            $companie->legalForm()->associate(factory(LegalForm::class)->create());

            $companie->country()->associate($default_country);

            $companie->save();
        }
    }

    /**
     * @Given /^je suis authentifié en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de voir le détail de la companie "([^"]*)"$/
     */
    public function jessaieDeVoirLeDetailDeLaCompanie($short_id)
    {
        $company = $this->companyRepository->findByShortId($short_id);
        $auth_user = $this->userRepository->connectedUser();

        try {
            $this->response = (new ShowCompany($this->userRepository))->handle($auth_user, $company);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le détail de la companie "([^"]*)" est affiché$/
     */
    public function leDetailDeLaCompanieEstAffiche($short_id)
    {
        $company = $this->companyRepository->findByShortId($short_id);
        $this->assertEquals($company->getShortId(), $this->response->getShortId());
    }

    /**
     * @Then /^une erreur est levée car le companie n\'existe pas$/
     */
    public function uneErreurEstLeveeCarLeCompanieNexistePas()
    {
        $this->assertContainsEquals(
            CompanyNotFoundException::class,
            $this->errors
        );
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
