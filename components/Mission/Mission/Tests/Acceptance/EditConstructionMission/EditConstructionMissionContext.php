<?php

namespace Components\Mission\Mission\Tests\Acceptance\EditConstructionMission;

use Components\Mission\Offer\Application\Repositories\CostEstimationRepository;
use Exception;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Enterprise\WorkField\Application\Models\Sector;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Mission\Mission\Application\Models\Mission;
use Components\Mission\Mission\Application\Repositories\EnterpriseRepository;
use Components\Mission\Mission\Application\Repositories\NewMissionRepository as MissionRepository;
use Components\Mission\Mission\Application\Repositories\SectorRepository;
use Components\Mission\Mission\Application\Repositories\UserRepository;
use Components\Mission\Mission\Application\Repositories\WorkFieldRepository;
use Components\Mission\Mission\Domain\Exceptions\CannotEditMissionInThisStatusException;
use Components\Mission\Mission\Domain\UseCases\EditConstructionMission;
use Components\Mission\Mission\Domain\Exceptions\UserHasNotPermissionToEditMissionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditConstructionMissionContext extends TestCase implements Context
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

            $enterprise->customers()->attach($this->enterpriseRepository->findBySiret($item['client_siret']));
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
     * @Given les missions suivantes existent
     */
    public function lesMissionsSuivantesExistent(TableNode $construction_missions)
    {
        foreach ($construction_missions as $item) {
            $construction_mission = new Mission();
            $referent = $this->userRepository->findByNumber($item['referent_number']);
            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $work_field = $this->workFieldRepository->findByNumber($item['workfield_number']);

            $construction_mission->setReferent($referent);
            $construction_mission->setWorkfield($work_field);
            $construction_mission->setCustomer($enterprise);

            $construction_mission->fill([
                'number' => $item['number'],
                'name'   => $item['name'],
                'label' => $item['label'],
                'starts_at' => $item['starts_at'],
                'ends_at' => $item['ends_at'],
                'description' => $item['description'],
                'external_id' => $item['external_id'],
                'analytic_code' => $item['analytic_code'],
                'status' => $item['status']
            ])->save();
        }
    }

    /**
     * @Given je suis authentifi?? en tant que utilisateur avec l'email :arg1
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail($email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When j'essaie de modifier la mission num??ro :arg1
     */
    public function jessaieDeModifierLaMissionNumero($number)
    {
        $mission = $this->missionRepository->findByNumber($number);

        $user = $this->userRepository->connectedUser();
        $referent = $mission->getCustomer()->users()->first();
        $inputs = [
            'referent_id' => $referent->getId(),
            'label' => 'Label mission edit',
            'starts_at' => '2021-05-20',
            'ends_at' => '2022-03-23',
            'description' => 'edit mission',
            'external_id' => 'id',
            'analytic_code' => 'D1120',
            'amount' => 1524.15,
        ];

        try {
            $this->response = (new EditConstructionMission(
                $this->missionRepository,
                $this->userRepository,
                $this->costEstimationRepository
            ))->handle($user, $mission, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then la mission num??ro :arg1 est modifi??e
     */
    public function laMissionNumeroEstModifiee($number)
    {
        $mission = $this->missionRepository->findByNumber($number);

        $this->assertEquals($mission->getDescription(), $this->response->getDescription());
    }

    /**
     * @Then une erreur est lev??e car l'entreprise n'est pas cliente
     */
    public function uneErreurEstLeveeCarLentrepriseNestPasCliente()
    {
        self::assertContainsEquals(
            UserHasNotPermissionToEditMissionException::class,
            $this->errors
        );
    }

    /**
     * @Then une erreur est lev??e car la mission n'est pas en brouillon ou bon pour d??marrage
    */
    public function uneErreurEstLeveeCarLaMissionNestPasEnBrouillonOuBonPourDemarrage()
    {
        self::assertContainsEquals(
            CannotEditMissionInThisStatusException::class,
            $this->errors
        );
    }
}
