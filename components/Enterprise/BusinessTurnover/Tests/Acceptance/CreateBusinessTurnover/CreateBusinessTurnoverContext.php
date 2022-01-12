<?php

namespace Components\Enterprise\BusinessTurnover\Tests\Acceptance\CreateBusinessTurnover;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Carbon\Carbon;
use Components\Enterprise\BusinessTurnover\Application\Models\BusinessTurnover;
use Components\Enterprise\BusinessTurnover\Application\Repositories\BusinessTurnoverRepository;
use Components\Enterprise\BusinessTurnover\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\BusinessTurnover\Application\Repositories\UserRepository;
use Components\Enterprise\BusinessTurnover\Domain\Exceptions\BusinessTurnoverAlreadyExistsException;
use Components\Enterprise\BusinessTurnover\Domain\Exceptions\EnterpriseIsNotRequestedToDeclareBusinessTurnoverException;
use Components\Enterprise\BusinessTurnover\Domain\Exceptions\SupportCantCreateBusinessTurnoverException;
use Components\Enterprise\BusinessTurnover\Domain\UseCases\CreateBusinessTurnover;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateBusinessTurnoverContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $businessTurnoverRepository;
    private $enterpriseRepository;
    private $userRepository;

    public function __construct()
    {
        parent::setUp();

        $this->businessTurnoverRepository = new BusinessTurnoverRepository;
        $this->enterpriseRepository = new EnterpriseRepository;
        $this->userRepository = new UserRepository;
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
                'is_vendor' => $item['is_vendor'],
                'collect_business_turnover' => $item['collect_business_turnover'],
            ])->save();

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
                'email' => $item['email'],
                'firstname' => $item['firstname'],
                'lastname' => $item['lastname'],
                'is_system_admin' => $item['is_system_admin'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $user->enterprises()->attach($enterprise);
            $enterprise->users()->updateExistingPivot($user->id, ['is_allowed_to_view_business_turnover' => $item['is_allowed_to_view_business_turnover']]);
        }
    }

    /**
     * @Given /^les chiffres d\'affaire suivants  existent$/
     */
    public function lesChiffresDaffaireSuivantsExistent(TableNode $business_turnovers)
    {
        foreach ($business_turnovers as $item) {
            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $user = $this->userRepository->findByEmail($item['created_by_email']);
            $business_turnover = new BusinessTurnover([
                'number' => $item['number'],
                'year' =>Carbon::now()->subYear()->year,
                'amount' => $item['amount'],
                'enterprise_name' => $enterprise->name,
                'created_by_name' => $user->name,
            ]);

            $business_turnover
                ->enterprise()->associate($enterprise)
                ->createdBy()->associate($user)
                ->save();
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
     * @When /^j\'essaie de créer un chiffre d\'affaire pour l\'année précédente pour l\'entreprise avec le siret numéro "([^"]*)"$/
     */
    public function jessaieDeCreerUnChiffreDaffairePourLanneePrecedentePourLentrepriseAvecLeSiretNumero($siret)
    {
        $enterprise = $this->enterpriseRepository->findBySiret($siret);

        $authenticated = $this->userRepository->connectedUser();

        $inputs = [
            'amount' => '259321.21',
            //'no_activity' => true,
        ];

        try {
            $this->response = (new CreateBusinessTurnover(
                $this->businessTurnoverRepository,
                $this->enterpriseRepository,
                $this->userRepository
            ))->handle($authenticated, $enterprise, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le chiffre d\'affaire est crée$/
     */
    public function leChiffreDaffaireEstCree()
    {
        $this->assertDatabaseCount('addworking_enterprise_business_turnovers', 2);

        $this->assertDatabaseHas('addworking_enterprise_business_turnovers', [
            'year' => Carbon::now()->subYear()->year,
            'enterprise_id' => $this->response->getEnterprise()->id,
            'created_by' => $this->response->getCreatedBy()->id,
            'amount' => $this->response->getAmount(),
        ]);
    }

    /**
     * @Then /^une erreur est levée car l\'entreprise en question n\'a pas l\'obligation de créer des chiffres d\'affaire$/
     */
    public function uneErreurEstLeveeCarLentrepriseEnQuestionNaPasLobligationDeCreerDesChiffresDaffaire()
    {
        self::assertContainsEquals(
            EnterpriseIsNotRequestedToDeclareBusinessTurnoverException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car le chiffre d\'affaire pour l\'année dernière est déjà declaré$/
     */
    public function uneErreurEstLeveeCarLeChiffreDaffairePourLanneeDerniereEstDejaDeclare()
    {
        self::assertContainsEquals(
            BusinessTurnoverAlreadyExistsException::class,
            $this->errors
        );
    }

    /**
     * @Then une erreur est levée car le support ne peut pas créer de chiffre d'affaire
     */
    public function uneErreurEstLeveeCarLeSupportNePeutPasCreerDeChiffreDaffaire()
    {
        self::assertContainsEquals(
            SupportCantCreateBusinessTurnoverException::class,
            $this->errors
        );
    }

}
