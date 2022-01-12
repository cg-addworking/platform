<?php

namespace Components\Mission\Offer\Tests\Acceptance\CloseOffer;

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
use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Domain\UseCases\CloseOffer;
use Components\Mission\Offer\Application\Models\Response;
use Components\Enterprise\WorkField\Application\Models\Sector;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Mission\Offer\Application\Repositories\UserRepository;
use Components\Mission\Offer\Application\Repositories\OfferRepository;
use Components\Mission\Offer\Application\Repositories\SectorRepository;
use Components\Mission\Offer\Application\Repositories\MissionRepository;
use Components\Mission\Offer\Application\Repositories\ResponseRepository;
use Components\Mission\Offer\Application\Repositories\WorkFieldRepository;
use Components\Mission\Offer\Application\Repositories\EnterpriseRepository;
use Components\Mission\Offer\Domain\Exceptions\OfferAlreadyClosedException;
use Components\Mission\Offer\Domain\Exceptions\EnterpriseIsNotCustomerException;
use Components\Mission\Offer\Domain\Exceptions\OfferHasNotAcceptedResponseException;

class CloseOfferContext extends TestCase implements Context
{
    use RefreshDatabase;

    protected $response;
    protected $errors = [];

    private $enterpriseRepository;
    private $sectorRepository;
    private $userRepository;
    private $workFieldRepository;
    private $offerRepository;
    private $responseRepository;
    private $missionRepository;
    private $costEstimationRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository;
        $this->sectorRepository = new SectorRepository;
        $this->userRepository = new UserRepository;
        $this->workFieldRepository = new WorkFieldRepository;
        $this->offerRepository = new OfferRepository;
        $this->responseRepository = new ResponseRepository;
        $this->missionRepository = new MissionRepository;
        $this->costEstimationRepository = new CostEstimationRepository;
    }

    /**
     * @Given le secteur suivant  existe
     */
    public function leSecteurSuivantExiste(TableNode $sectors)
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
     * @Given les offres de missions suivantes existent
     */
    public function lesOffresDeMissionsSuivantesExistent(TableNode $construction_offers)
    {
        foreach ($construction_offers as $item) {
            $construction_offer = new Offer();
            $referent = $this->userRepository->findByEmail($item['referent']);
            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $work_field = $this->workFieldRepository->findByNumber($item['workfield_number']);

            $created_by = $this->userRepository->findByEmail($item['created_by']);

            $construction_offer->fill([
                'number' => $item['number'],
                'name'   => $item['name'],
                'label' => $item['label'],
                'starts_at_desired' => $item['starts_at_desired'],
                'ends_at' => $item['ends_at'],
                'description' => $item['description'],
                'external_id' => $item['external_id'],
                'analytic_code' => $item['analytic_code'],
                'status' => $item['status']
            ]);

            $construction_offer->setReferent($referent);
            $construction_offer->setWorkfield($work_field);
            $construction_offer->setCustomer($enterprise);
            $construction_offer->setCreatedBy($created_by);

            $construction_offer->save();
        }
    }

    /**
     * @Given les reponses suivantes existent
     */
    public function lesReponsesSuivantesExistent(TableNode $responses)
    {
        foreach ($responses as $item) {
            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $owner = $this->userRepository->findByEmail($item['created_by']);
            $offer = $this->offerRepository->findByNumber($item['offer_number']);
            $response = new Response();

            $response->fill([
                'number' => $item['number'],
                'starts_at' => $item['starts_at'],
                'ended_at' => $item['ended_at'],
                'amount_before_taxes' => $item['amount_before_taxes'],
                'argument' => $item['argument'],
                'status' => $item['status'],
            ]);
            
            $response->setOffer($offer);
            $response->setCreatedBy($owner);
            $response->setEnterprise($enterprise);

            $response->save();
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
     * @When j'essaie de fermer l'offre de mission numéro :arg1
     */
    public function jessaieDeFermerLoffreDeMissionNumero(string $offer_number)
    {
        $offer = $this->offerRepository->findByNumber($offer_number);
        $user = $this->userRepository->connectedUser();

        try {
            $this->response = (new CloseOffer(
                $this->responseRepository,
                $this->missionRepository,
                $this->offerRepository,
                $this->costEstimationRepository
            ))->handle($user, $offer);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then l'offre de mission numéro :arg1 est fermée
     */
    public function loffreDeMissionNumeroEstFermee(string $number)
    {
        $offer = $this->offerRepository->findByNumber($number);

        $this->assertEquals($offer->getStatus(), $this->response->getStatus());
    }

    /**
     * @Then une erreur est levée car l'offre n'a pas de réponses acceptées
     */
    public function uneErreurEstLeveeCarLoffreNaPasDeReponsesAcceptees()
    {
        self::assertContainsEquals(
            OfferHasNotAcceptedResponseException::class,
            $this->errors
        );
    }

    /**
     * @Then une erreur est levée car l'offre est déjà fermée
     */
    public function uneErreurEstLeveeCarLoffreEstDejaFermee()
    {
        self::assertContainsEquals(
            OfferAlreadyClosedException::class,
            $this->errors
        );
    }

     /**
     * @Then une erreur est levée car l'entreprise n'est pas propriétaire
     */
    public function uneErreurEstLeveeCarLentrepriseNestPasProprietaire()
    {
        self::assertContainsEquals(
            EnterpriseIsNotCustomerException::class,
            $this->errors
        );
    }
}
