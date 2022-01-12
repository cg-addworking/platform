<?php

namespace Components\Enterprise\Enterprise\Tests\Acceptance\ListEnterprisesAsSupport;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Enterprise\Enterprise\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\Enterprise\Application\Repositories\UserRepository;
use Components\Enterprise\Enterprise\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\Enterprise\Domain\UseCases\ListEnterprisesAsSupport;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListEnterprisesAsSupportContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $enterpriseRepository;
    private $userRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository;
        $this->userRepository       = new UserRepository;
    }

    /**
     * @Given /^les entreprises suivantes existent$/
     */
    public function lesEntreprisesSuivantesExistent(TableNode $enterprises)
    {
        foreach ($enterprises as $item) {
            $enterprise = new Enterprise;
            $enterprise->fill([
                'name'                      => $item['name'],
                'identification_number'     => $item['siret'],
                'registration_town'         => uniqid('PARIS_'),
                'tax_identification_number' => 'FR' . random_numeric_string(11),
                'main_activity_code'        => random_numeric_string(4) . 'X',
                'is_customer'               => $item['is_customer'],
                'is_vendor'                 => $item['is_vendor']
            ]);

            $enterprise->legalForm()->associate(factory(LegalForm::class)->create());
            $enterprise->save();

            $enterprise->addresses()->attach(
                factory(Address::class)->create()
            );

            $enterprise->phoneNumbers()->attach(
                factory(PhoneNumber::class)->create()
            );
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

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
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
     * @When /^j\'essaie de lister toutes les entreprises$/
     */
    public function jessaieDeListerToutesLesEntreprises()
    {
        $auth_user = $this->userRepository->connectedUser();
        $filter = null;
        $search = null;
        $page = null;

        try {
            $this->response = (new ListEnterprisesAsSupport(
                $this->enterpriseRepository,
                $this->userRepository
            ))->handle($auth_user, $filter, $search, $page);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^toutes les entreprises sont listées$/
     */
    public function toutesLesEntreprisesSontListees()
    {
        $this->assertDatabaseCount('addworking_enterprise_enterprises', 8);
        $this->assertCount(8, $this->response);
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
