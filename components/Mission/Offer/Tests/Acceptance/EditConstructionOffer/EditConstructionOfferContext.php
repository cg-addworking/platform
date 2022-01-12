<?php

namespace Components\Mission\Offer\Tests\Acceptance\EditConstructionOffer;

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
use Components\Mission\Offer\Domain\UseCases\EditConstructionOffer;
use Components\Enterprise\WorkField\Application\Models\Sector;
use App\Models\Addworking\Enterprise\Enterprise;
use Components\Mission\Offer\Domain\Exceptions\UserHasNotPermissionToEditOfferException;
use Components\Mission\Offer\Domain\Exceptions\OfferStatusClosedException;
use Components\Mission\Offer\Application\Models\Offer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditConstructionOfferContext extends TestCase implements Context
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
     * @Given les offres de missions suivantes existent
     */
    public function lesOffresDeMissionsSuivantesExistent(TableNode $construction_offers)
    {
        foreach ($construction_offers as $item) {
            $construction_offer = new Offer();
            $referent = $this->userRepository->findByNumber($item['referent_number']);
            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $work_field = $this->workFieldRepository->findByNumber($item['workfield_number']);
          
            $created_by = $this->userRepository->findByNumber($item['created_by_number']);

            $construction_offer->setReferent($referent);
            $construction_offer->setWorkfield($work_field);
            $construction_offer->setCustomer($enterprise);
            $construction_offer->setCreatedBy($created_by);

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
            ])->save();
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
     * @When j'essaie de modifier l'offre de mission numéro :arg1
     */
    public function jessaieDeModifierLoffreDeMissionNumero(string $number)
    {
        $offer = $this->offerRepository->findByNumber($number);

        $user = $this->userRepository->connectedUser();
        $referent = $offer->getCustomer()->users()->first();
       
        $inputs = [
            'referent_id' => $referent->getId(),
            'label' => 'Label mission',
            'starts_at_desired' => '2021-03-20',
            'ends_at' => '2022-03-23',
            'description' => 'edit offer',
            'external_id' => 'id',
            'analytic_code' => 'D1120',
        ];

        try {
            $this->response = (new EditConstructionOffer(
                $this->offerRepository,
                $this->userRepository,
            ))->handle($user, $offer, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then l'offre de mission numéro :arg1 est modifié
     */
    public function loffreDeMissionNumeroEstModifie(string $number)
    {
        $offer = $this->offerRepository->findByNumber($number);

        $this->assertEquals($offer->getDescription(), $this->response->getDescription());
    }

    /**
     * @Then une erreur est levée car l'entreprise n'est pas propriétaire
     */
    public function uneErreurEstLeveeCarLentrepriseNestPasProprietaire()
    {
        self::assertContainsEquals(
            UserHasNotPermissionToEditOfferException::class,
            $this->errors
        );
    }

    /**
     * @Then une erreur est levée car l'offre de mission est fermée
     */
    public function uneErreurEstLeveeCarLoffreDeMissionEstFermee()
    {
        self::assertContainsEquals(
            OfferStatusClosedException::class,
            $this->errors
        );
    }
}
