<?php

namespace Components\Mission\Mission\Tests\Acceptance\CreateConstructionMission;

use Components\Mission\Offer\Application\Repositories\CostEstimationRepository;
use Exception;
use Tests\TestCase;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use App\Models\Addworking\User\User;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Components\Enterprise\WorkField\Application\Models\Sector;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Mission\Mission\Application\Repositories\UserRepository;
use Components\Mission\Mission\Application\Repositories\SectorRepository;
use Components\Mission\Mission\Domain\UseCases\CreateConstructionMission;
use Components\Mission\Mission\Application\Repositories\WorkFieldRepository;
use Components\Mission\Mission\Application\Repositories\EnterpriseRepository;
use Components\Mission\Mission\Application\Repositories\NewMissionRepository as MissionRepository;
use Components\Mission\Mission\Domain\Exceptions\EnterpriseIsNotAssociatedToConstructionSectorException;

class CreateConstructionMissionContext extends TestCase implements Context
{
    use RefreshDatabase;

    protected $response;
    protected $errors = [];

    private $enterpriseRepository;
    private $sectorRepository;
    private $userRepository;
    private $workFieldRepository;
    private $missionRepository;
    private $costEstimationRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository;
        $this->sectorRepository = new SectorRepository;
        $this->userRepository = new UserRepository;
        $this->workFieldRepository = new WorkFieldRepository;
        $this->missionRepository = new MissionRepository;
        $this->costEstimationRepository = new CostEstimationRepository;
    }

     /**
     * @Given les secteurs suivants  existent
     */
    public function lesSecteursSuivantsExistent(TableNode $sectors)
    {
        foreach ($sectors as $item) {
            $sector = new Sector();
            $sector->fill([
                'number' => $item['number'],
                'name' => $item['name'],
                'display_name' => $item['display_name'],
            ])->save();
        }
    }

    /**
     * @Given les entreprises suivantes existent
     */
    public function lesEntreprisesSuivantesExistent(TableNode $enterprises)
    {
        foreach ($enterprises as $item) {
            $enterprise = new Enterprise();
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
            $enterprise->vendors()->attach($this->enterpriseRepository->findBySiret($item['vendor_siret']));
        }
    }

    /**
     * @Given les utilisateurs suivants existent
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
        }
    }

    /**
     * @Given les chantiers suivants existent
     */
    public function lesChantiersSuivantsExistent(TableNode $work_fields)
    {
        foreach ($work_fields as $item) {
            $enterprise = $this->enterpriseRepository->findBySiret($item['owner_siret']);
            $owner = $this->userRepository->findByEmail($item['created_by']);
            $work_field = new WorkField();

            $work_field->fill([
                'number' => $item['number'],
                'name' => str_slug($item['name'], '_'),
                'display_name' => $item['name'],
                'description' => $item['description'],
                'estimated_budget' => $item['estimated_budget'],
                'started_at' => $item['started_at'],
                'ended_at' => $item['ended_at'],
            ]);
            
            $work_field->setOwner($enterprise);
            $work_field->setCreatedBy($owner);

            $work_field->save();
        }
    }

    /**
     * @Given je suis authentifié en tant que utilisateur avec l'email :arg1
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When j'essaie de créer une mission pour l'entreprise avec le siret numéro :arg1
     */
    public function jessaieDeCreerUneMissionPourLentrepriseAvecLeSiretNumero(string $enterprise_siret)
    {
        $customer   = $this->enterpriseRepository->findBySiret($enterprise_siret);
        $vendor     = $customer->vendors()->first();
        $referent   = $customer->users()->first();
        $auth_user  = $this->userRepository->connectedUser();
        $work_field = $customer->workFields()->first();
       
        $inputs = [
            'enterprise_id' => $customer->getId(),
            'vendor_id' => $vendor->getId(),
            'referent_id' => $referent->getId(),
            'label' => 'Label mision',
            'starts_at' => '2021-05-15',
            'ends_at' => '2022-06-15',
            'description' => 'description mission',
            'external_id' => 'external id',
            'analytic_code' => 'D12010',
            'status' =>  'ready_to_start',
            'amount' => 15.15,
        ];

        try {
            $this->response = (new CreateConstructionMission(
                $this->missionRepository,
                $this->enterpriseRepository,
                $this->userRepository,
                $this->workFieldRepository,
                $this->sectorRepository,
                $this->costEstimationRepository
            ))->handle($auth_user, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then la mission est crée
     */
    public function laMissionEstCree()
    {
        $this->assertDatabaseCount('addworking_mission_missions', 1);
    }

    /**
     * @Then une erreur est levée car l'entreprise n'est pas associée au secteur BTP
     */
    public function uneErreurEstLeveeCarLentrepriseNestPasAssocieeAuSecteurBtp()
    {
        self::assertContainsEquals(
            EnterpriseIsNotAssociatedToConstructionSectorException::class,
            $this->errors
        );
    }
}
