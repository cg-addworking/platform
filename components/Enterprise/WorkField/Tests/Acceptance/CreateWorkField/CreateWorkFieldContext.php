<?php

namespace Components\Enterprise\WorkField\Tests\Acceptance\CreateWorkField;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Carbon\Carbon;
use Components\Enterprise\WorkField\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\WorkField\Application\Repositories\SectorRepository;
use Components\Enterprise\WorkField\Application\Repositories\UserRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository;
use Components\Enterprise\WorkField\Domain\Exceptions\EnterpriseIsNotAssociatedToConstructionSectorException;
use Components\Enterprise\WorkField\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Enterprise\WorkField\Domain\Exceptions\UserIsMissingTheWorkFieldCreationRoleException;
use Components\Enterprise\WorkField\Domain\UseCases\CreateWorkField;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateWorkFieldContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $enterpriseRepository;
    private $sectorRepository;
    private $userRepository;
    private $workFieldRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository;
        $this->sectorRepository = new SectorRepository;
        $this->userRepository = new UserRepository;
        $this->workFieldRepository = new WorkFieldRepository;
    }

    /**
     * @Given /^les secteurs suivants  existent$/
     */
    public function lesSecteursSuivantsExistent(TableNode $sectors)
    {
        foreach ($sectors as $item) {
            $this->sectorRepository->make([
                'number' => $item['number'],
                'name' => $item['name'],
                'display_name' => $item['display_name'],
            ])->save();
        }
    }

    /**
     * @Given /^les entreprises suivantes existent$/
     */
    public function lesEntreprisesSuivantesExistent(TableNode $enterprises)
    {
        foreach ($enterprises as $item) {
            $enterprise = $this->enterpriseRepository->make();
            $enterprise->fill([
                'name' => $item['name'],
                'identification_number' => $item['siret'],
                'registration_town' => uniqid('PARIS_'),
                'tax_identification_number' => 'FR' . random_numeric_string(11),
                'main_activity_code' => random_numeric_string(4) . 'X',
                'is_customer' => $item['is_customer'],
                'is_vendor' => $item['is_vendor']
            ])->save();

            $sector = $this->sectorRepository->findByNumber((int) $item['sector_number']);

            $enterprise->sectors()->attach($sector);

            $enterprise->addresses()->attach(factory(Address::class)->create());
            $enterprise->phoneNumbers()->attach(factory(PhoneNumber::class)->create());

            $enterprise->customers()->attach($this->enterpriseRepository->findBySiret($item['client_siret']));
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
                'email' => $item['email'],
                'is_system_admin' => $item['is_system_admin'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
            $enterprise->users()->updateExistingPivot($user->id, ['is_work_field_creator' => $item['is_work_field_creator']]);
        }
    }

    /**
     * @Given /^je suis authentifié en tant que utilisateur avec l\'émail "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail($email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de créer un chantier pour l\'entreprise avec le siret numéro "([^"]*)"$/
     */
    public function jessaieDeCreerUnChantierPourLentrepriseAvecLeSiretNumero($siret)
    {
        $enterprise = $this->enterpriseRepository->findBySiret($siret);

        $authenticated = $this->userRepository->connectedUser();

        $inputs = [
            'display_name' => 'Nouveau chantier',
            'description' => 'this is a description',
            'estimated_budget' => 1000.23,
            'started_at' => '2021-03-20',
            'ended_at' => '2022-03-20',
            'address' => 'address_data',
            'project_manager' => 'project_manager_data',
            'project_owner' => 'project_owner_data',
            'external_id' => 'external_id_data',
            'sps_coordinator' => 'sps_coordinator',
        ];

        try {
            $this->response = (new CreateWorkField(
                $this->enterpriseRepository,
                $this->sectorRepository,
                $this->userRepository,
                $this->workFieldRepository
            ))->handle($authenticated, $enterprise, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le chantier est crée$/
     */
    public function leChantierEstCree()
    {
        $this->assertDatabaseCount('addworking_enterprise_work_fields', 1);
    }

    /**
     * @Then /^une erreur est levée car l\'entreprise n\'est pas associée au secteur BTP$/
     */
    public function uneErreurEstLeveeCarLentrepriseNestPasAssocieeAuSecteurBtp()
    {
        self::assertContainsEquals(
            EnterpriseIsNotAssociatedToConstructionSectorException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car l\'utilisateur n\'a pas le rôle adéquat$/
     */
    public function uneErreurEstLeveeCarLutilisateurNaPasLeRoleAdequat()
    {
        self::assertContainsEquals(
            UserIsMissingTheWorkFieldCreationRoleException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car l\'entreprise n\'est pas cliente$/
     */
    public function uneErreurEstLeveeCarLentrepriseNestPasCliente()
    {
        self::assertContainsEquals(
            EnterpriseIsNotCustomerException::class,
            $this->errors
        );
    }
}
