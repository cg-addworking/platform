<?php

namespace Components\Mission\Offer\Tests\Acceptance\CreateConstructionResponse;

use Exception;
use Tests\TestCase;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use App\Models\Addworking\User\User;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Components\Mission\Offer\Application\Models\Offer;
use Components\Mission\Offer\Application\Models\Proposal;
use Components\Enterprise\WorkField\Application\Models\Sector;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Mission\Offer\Application\Repositories\UserRepository;
use Components\Mission\Offer\Application\Repositories\OfferRepository;
use Components\Mission\Offer\Application\Repositories\SectorRepository;
use Components\Mission\Offer\Domain\UseCases\CreateConstructionResponse;
use Components\Mission\Offer\Application\Repositories\ProposalRepository;
use Components\Mission\Offer\Application\Repositories\ResponseRepository;
use Components\Mission\Offer\Application\Repositories\WorkFieldRepository;
use Components\Mission\Offer\Application\Repositories\EnterpriseRepository;
use Components\Mission\Offer\Domain\Exceptions\EnterpriseNotVendorException;
use Components\Mission\Offer\Domain\Exceptions\OfferNotCommunicatedException;
use Components\Mission\Offer\Domain\Exceptions\ResponseDeadlineExceededException;

class CreateConstructionResponseContext extends TestCase implements Context
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
    private $proposalRepository;
    
    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository;
        $this->sectorRepository = new SectorRepository;
        $this->userRepository = new UserRepository;
        $this->workFieldRepository = new WorkFieldRepository;
        $this->offerRepository = new OfferRepository;
        $this->responseRepository = new ResponseRepository;
        $this->proposalRepository = new ProposalRepository;
    }

    /**
     * @Given le secteur suivant existe
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
                'status' => $item['status'],
                'response_deadline' => $item['response_deadline'],
            ]);

            $construction_offer->setReferent($referent);
            $construction_offer->setWorkfield($work_field);
            $construction_offer->setCustomer($enterprise);
            $construction_offer->setCreatedBy($created_by);

            $construction_offer->save();
        }
    }

    /**
     * @Given les propositions suivantes existent
     */
    public function lesPropositionsSuivantesExistent(TableNode $proposals)
    {
        foreach ($proposals as $item) {
            $vendor = $this->enterpriseRepository->findBySiret($item['vendor_enterprise_siret']);
            $owner = $this->userRepository->findByEmail($item['created_by']);
            $offer = $this->offerRepository->findByNumber($item['mission_offer_number']);
            $proposal = new Proposal();

            $proposal->fill([
                'number' => $item['number'],
            ]);

            $proposal->setOffer($offer);
            $proposal->setCreatedBy($owner);
            $proposal->setVendor($vendor);

            $proposal->save();
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
     * @When j'essaie de créer une réponse pour l'offre numéro :arg1
     */
    public function jessaieDeCreerUneReponsePourLoffreNumero(string $number)
    {
        $offer = $this->offerRepository->findByNumber($number);
        $user = $this->userRepository->connectedUser();

        $inputs = [
            'starts_at' => '2021-03-20',
            'ends_at' => '2022-03-20',
            'amount_before_taxes' => '123425',
            'argument' => 'argument',
        ];

        $file = factory(File::class)->create();
        
        try {
            $this->response = (new CreateConstructionResponse(
                $this->responseRepository,
                $this->proposalRepository
            ))->handle($user, $offer, $inputs, $file);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then la réponse est crée
     */
    public function laReponseEstCree()
    {
        $this->assertDatabaseCount('addworking_mission_proposal_responses', 1);
    }

    /**
     * @Then une erreur est levée car l'entreprise n'est pas destinataire de l'offre
     */
    public function uneErreurEstLeveeCarLentrepriseNestPasDestinataireDeLoffre()
    {
        self::assertContainsEquals(
            EnterpriseNotVendorException::class,
            $this->errors
        );
    }

    /**
     * @Then une erreur est levée car l'offre n'est pas diffusée
     */
    public function uneErreurEstLeveeCarLoffreNestPasDiffusee()
    {
        self::assertContainsEquals(
            OfferNotCommunicatedException::class,
            $this->errors
        );
    }

    /**
     * @Then une erreur est levée car la date limite de réponse est atteinte
     */
    public function uneErreurEstLeveeCarLaDateLimiteDeReponseEstAtteinte()
    {
        self::assertContainsEquals(
            ResponseDeadlineExceededException::class,
            $this->errors
        );
    }

}
