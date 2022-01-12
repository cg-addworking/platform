<?php

namespace Components\Mission\Offer\Tests\Acceptance\ListResponse;

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
use Components\Mission\Offer\Application\Models\Response;
use Components\Mission\Offer\Domain\UseCases\ListResponse;
use Components\Enterprise\WorkField\Application\Models\Sector;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Mission\Offer\Application\Repositories\UserRepository;
use Components\Mission\Offer\Application\Repositories\OfferRepository;
use Components\Mission\Offer\Domain\Exceptions\OfferNotFoundException;
use Components\Mission\Offer\Application\Repositories\SectorRepository;
use Components\Mission\Offer\Application\Repositories\ResponseRepository;
use Components\Mission\Offer\Application\Presenters\ResponseListPresenter;
use Components\Mission\Offer\Application\Repositories\WorkFieldRepository;
use Components\Mission\Offer\Application\Repositories\EnterpriseRepository;

class ListResponseContext extends TestCase implements Context
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
    private $responseListPresenter;
    
    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository;
        $this->sectorRepository = new SectorRepository;
        $this->userRepository = new UserRepository;
        $this->workFieldRepository = new WorkFieldRepository;
        $this->offerRepository = new OfferRepository;
        $this->responseRepository = new ResponseRepository;
        $this->responseListPresenter = new ResponseListPresenter;
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
    public function lesOffresDeMissionsSuivantesExistent(TableNode $offers)
    {
        foreach ($offers as $item) {
            $offer = new Offer();
            $referent = $this->userRepository->findByEmail($item['referent']);
            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $work_field = $this->workFieldRepository->findByNumber($item['workfield_number']);

            $created_by = $this->userRepository->findByEmail($item['created_by']);

            $offer->fill([
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

            $offer->setReferent($referent);
            $offer->setWorkfield($work_field);
            $offer->setCustomer($enterprise);
            $offer->setCreatedBy($created_by);

            $offer->save();
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
     * @When j'essaie de lister toutes les réponses de l'offre numéro :arg1
     */
    public function jessaieDeListerToutesLesReponsesDeLoffreNumero(string $number)
    {
        $offer = $this->offerRepository->findByNumber($number);
        $user = $this->userRepository->connectedUser();

        try {
            $this->response = (new ListResponse(
                $this->responseRepository
            ))->handle($this->responseListPresenter,$user, $offer);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

     /**
     * @Then toutes les réponses pour l'offre numéro :arg1 sont listées
     */
    public function toutesLesReponsesPourLoffreNumeroSontListees(string $number)
    {
        $offer = $this->offerRepository->findByNumber($number);
        $count = $offer->getResponses()->count();

        $this->assertCount($count, $this->response);
    }

    /**
     * @Then une erreur est levée car l'offre n'existe pas
     */
    public function uneErreurEstLeveeCarLoffreNexistePas()
    {
        self::assertContainsEquals(
            OfferNotFoundException::class,
            $this->errors
        );
    }
}
