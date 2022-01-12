<?php

namespace Components\Enterprise\ActivityReport\Tests\Acceptance\CreateActivityReport;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\Mission\Mission;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Carbon\Carbon;
use Components\Enterprise\Enterprise\Application\Repositories\EnterpriseRepository;
use Components\Mission\Mission\Application\Repositories\MissionRepository;
use Components\Module\Module\Application\Repositories\ModuleRepository;
use Components\Enterprise\ActivityReport\Application\Repositories\ActivityReportCustomerRepository;
use Components\Enterprise\ActivityReport\Application\Repositories\ActivityReportMissionRepository;
use Components\Enterprise\ActivityReport\Application\Repositories\ActivityReportRepository;
use Components\Enterprise\ActivityReport\Domain\Exceptions\UserIsNotAuthenticatedException;
use Components\Enterprise\ActivityReport\Domain\Exceptions\VendorNotActiveForAllCustomersException;
use Components\Enterprise\ActivityReport\Domain\UseCases\CreateActivityReport;
use Components\User\User\Application\Repositories\UserRepository;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateActivityReportContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $activityReportCustomerRepository;
    private $activityReportMissionRepository;
    private $activityReportRepository;
    private $enterpriseRepository;
    private $missionRepository;
    private $moduleRepository;
    private $userRepository;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        parent::setUp();

        $this->activityReportCustomerRepository = new ActivityReportCustomerRepository();
        $this->activityReportMissionRepository  = new ActivityReportMissionRepository();
        $this->activityReportRepository         = new ActivityReportRepository();
        $this->enterpriseRepository             = new EnterpriseRepository();
        $this->missionRepository                = new MissionRepository();
        $this->moduleRepository                 = new ModuleRepository();
        $this->userRepository                   = new UserRepository();
    }

    /**
     * @Given les entreprises suivantes existent
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
     * @Given les utilisateurs suivants existent
     */
    public function lesUtilisateursSuivantsExistent(TableNode $users)
    {
        foreach ($users as $item) {
            $user = factory(User::class)->create([
                'firstname' => $item['firstname'],
                'lastname' => $item['lastname'],
                'email'    => $item['email'],
                'is_active' => $item['is_active'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
        }
    }

    /**
     * @Given /^les partenariats suivants existent$/
     */
    public function lesPartenariatsSuivantsExistent(TableNode $partnerships)
    {
        foreach ($partnerships as $item) {
            $customer = $this->enterpriseRepository->findBySiret($item['siret_customer']);
            $vendor   = $this->enterpriseRepository->findBySiret($item['siret_vendor']);

            $customer->vendors()->attach($vendor, ['activity_starts_at' => $item['activity_starts_at']]);
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
     * @When /^j\'essaie de créer un rapport de travail pour l\'enterprise prestataire avec le siret "([^"]*)"$/
     */
    public function jessaieDeCreerUnRapportDeTravailPourLenterprisePrestataireAvecLeSiret2($siret)
    {
        $authUser = $this->userRepository->connectedUser();
        $vendor   = $this->enterpriseRepository->findBySiret($siret);

        $customer1 = $this->enterpriseRepository->findBySiret('02000000000000');

        $date_last_month = Carbon::now()->subMonth();

        $data = [
            'other_activity' => "this is another activity",
            'note' => "this is a note",
            'customers' => [
                $customer1->id,
            ],
            'missions' => [
                factory(Mission::class)->create()->id,
                factory(Mission::class)->create()->id,
                factory(Mission::class)->create()->id,
            ],
            'year' => $date_last_month->year,
            'month' => $date_last_month->month,
        ];

        try {
            $this->response = (new CreateActivityReport(
                $this->activityReportCustomerRepository,
                $this->activityReportMissionRepository,
                $this->activityReportRepository,
                $this->enterpriseRepository,
                $this->missionRepository,
                $this->moduleRepository,
            ))->handle($authUser, $vendor, $data);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le rapport d'activité est crée$/
     */
    public function leRapportDActiviteEstCree()
    {
        $this->assertDatabaseHas('addworking_enterprise_activity_reports', [
            'vendor_id' => $this->response->getVendor()->id,
            'year'      => $this->response->getYear(),
            'month'     => $this->response->getMonth(),
        ]);

        $this->assertDatabaseCount('addworking_enterprise_activity_reports', 1);
    }

    /**
     * @Then l'erreur VendorNotActiveForAllCustomersException est levée
     */
    public function lerreurVendornotactiveforallcustomersexceptionEstLevee()
    {
        $this->assertContainsEquals(
            VendorNotActiveForAllCustomersException::class,
            $this->errors
        );
    }

    /**
     * @Then l'erreur UserIsNotAuthenticatedException est levée
     */
    public function lerreurUserisnotauthenticatedexceptionEstLevee()
    {
        $this->assertContainsEquals(
            UserIsNotAuthenticatedException::class,
            $this->errors
        );
    }
}
