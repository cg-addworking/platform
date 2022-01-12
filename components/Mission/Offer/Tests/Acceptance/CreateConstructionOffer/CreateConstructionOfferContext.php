<?php

namespace Components\Mission\Offer\Tests\Acceptance\CreateConstructionOffer;

use Exception;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Mission\Offer\Application\Repositories\EnterpriseRepository;
use Components\Mission\Offer\Application\Repositories\OfferRepository;
use Components\Mission\Offer\Application\Repositories\SectorRepository;
use Components\Mission\Offer\Application\Repositories\UserRepository;
use Components\Mission\Offer\Application\Repositories\WorkFieldRepository;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Mission\Offer\Domain\UseCases\CreateConstructionOffer;
use Components\Mission\Offer\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Enterprise\WorkField\Application\Models\Sector;
use Components\Mission\Offer\Domain\Exceptions\EnterpriseIsNotAssociatedToConstructionSectorException;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateConstructionOfferContext extends TestCase implements Context
{
    use RefreshDatabase;

    protected $response;
    protected $errors = [];

    private $enterpriseRepository;
    private $sectorRepository;
    private $userRepository;
    private $workFieldRepository;
    private $offerRepository;
    
    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository;
        $this->sectorRepository = new SectorRepository;
        $this->userRepository = new UserRepository;
        $this->workFieldRepository = new WorkFieldRepository;
        $this->offerRepository = new OfferRepository;
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
     * @Given je suis authentifié en tant que utilisateur avec l'email :arg1
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When j'essaie de créer une offre de mission pour l'entreprise avec le siret numéro :arg1
     */
    public function jessaieDeCreerUneOffreDeMissionPourLentrepriseAvecLeSiretNumero(string $siret)
    {
        $enterprise = $this->enterpriseRepository->findBySiret($siret);
        $user = $this->userRepository->connectedUser();
        $work_field = $enterprise->workFields()->first();
        $referent = $enterprise->users()->first();
       
        $inputs = [
            'enterprise_id' => $enterprise->getId(),
            'referent_id' => $referent->getId(),
            'label' => 'Label mission',
            'starts_at_desired' => '2021-03-20',
            'ends_at' => '2022-03-23',
            'description' => 'Nouvelle offre de mission',
            'external_id' => 'id',
            'analytic_code' => 'D1120',
            'status' => 'draft',
            'workfield_id' =>  $work_field ? $work_field->getId(): null,
        ];

        try {
            $this->response = (new CreateConstructionOffer(
                $this->offerRepository,
                $this->enterpriseRepository,
                $this->userRepository,
                $this->workFieldRepository,
                $this->sectorRepository
            ))->handle($user, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then l'offre de mission est crée
     */
    public function loffreDeMissionEstCree()
    {
        $this->assertDatabaseCount('addworking_mission_offers', 1);
    }

    /**
     * @Then une erreur est levée car l'entreprise n'est pas cliente
     */
    public function uneErreurEstLeveeCarLentrepriseNestPasCliente()
    {
        self::assertContainsEquals(
            EnterpriseIsNotCustomerException::class,
            $this->errors
        );
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
