<?php

namespace Components\Enterprise\WorkField\Tests\Acceptance\DetachContributorToWorkField;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Components\Enterprise\WorkField\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\WorkField\Application\Repositories\SectorRepository;
use Components\Enterprise\WorkField\Application\Repositories\UserRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository;
use Components\Enterprise\WorkField\Domain\Exceptions\UserCantDetachContributorException;
use Components\Enterprise\WorkField\Domain\Exceptions\WorkFieldContributorIsNotFoundException;
use Components\Enterprise\WorkField\Domain\UseCases\DetachContributorToWorkField;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DetachContributorToWorkFieldContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $sectorRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $workFieldRepository;
    private $workFieldContributorRepository;

    public function __construct()
    {
        parent::setUp();

        $this->sectorRepository = new SectorRepository;
        $this->enterpriseRepository = new EnterpriseRepository;
        $this->userRepository = new UserRepository;
        $this->workFieldRepository = new WorkFieldRepository;
        $this->workFieldContributorRepository = new WorkFieldContributorRepository;
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

            $sector = $this->sectorRepository->findByNumber((int)$item['sector_number']);

            $enterprise->sectors()->attach($sector);
            $enterprise->parent()->associate($this->enterpriseRepository->findBySiret($item['parent_siret']))
                ->save();

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
            $user = $this->userRepository->make();
            $user->fill([
                'gender' => $gender = array_random(['male', 'female']),
                'firstname' => $item['firstname'],
                'lastname' => $item['lastname'],
                'email' => $item['email'],
                'is_system_admin' => $item['is_system_admin'],
                'password' => Hash::make('password'),
                'remember_token' => str_random(10),
            ]);

            $user->save();

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
            $enterprise->users()->updateExistingPivot(
                $user->id,
                ['is_work_field_creator' => $item['is_work_field_creator']]
            );
        }
    }

    /**
     * @Given /^les chantiers suivants existent$/
     */
    public function lesChantiersSuivantsExistent(TableNode $work_fields)
    {
        foreach ($work_fields as $item) {
            $work_field = $this->workFieldRepository->make();
            $work_field->fill([
                'number' => $item['number'],
                'name' => $item['name'],
                'display_name' => $item['display_name'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['owner_siret']);
            $user = $this->userRepository->findByEmail($item['created_by_email']);

            $work_field
                ->owner()->associate($enterprise)
                ->createdBy()->associate($user)
                ->save();
        }
    }

    /**
     * @Given /^les intervenants suivants existent$/
     */
    public function lesIntervenantsSuivantsExistent(TableNode $work_field_contributors)
    {
        foreach ($work_field_contributors as $item) {
            $work_field_contributor = $this->workFieldContributorRepository->make();
            $work_field_contributor->fill([
                'number' => $item['number'],
                'is_admin' => $item['is_admin'],
            ]);

            $work_field = $this->workFieldRepository->findByNumber($item['work_field_number']);
            $user = $this->userRepository->findByEmail($item['contributor_email']);
            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);

            $work_field_contributor
                ->enterprise()->associate($enterprise)
                ->contributor()->associate($user)
                ->workField()->associate($work_field)
                ->save();
        }
    }

    /**
     * @Given /^je suis authentifié en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de détacher l\'intervenant numéro "([^"]*)"$/
     */
    public function jessaieDeDetacherLintervenantNumero(
        string $work_field_contributor_number
    ) {
        $authenticated = $this->userRepository->connectedUser();
        $work_field_contributor = $this->workFieldContributorRepository->findByNumber($work_field_contributor_number);

        try {
            $this->response = (new DetachContributorToWorkField(
                $this->workFieldRepository,
                $this->workFieldContributorRepository
            ))->handle($authenticated, $work_field_contributor);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^l\'intervenant avec l\'email "([^"]*)" est détaché du chantier$/
     */
    public function lintervenantAvecLemailEstDetacheDuChantier(string $email)
    {
        $this->assertDatabaseMissing('addworking_enterprise_work_field_has_contributors', ['email' => $email]);
    }

    /**
     * @Then /^une erreur est levée car l\'utilisateur connecté n\'a pas la permission de détacher un intervenant$/
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNaPasLaPermissionDeDetacherUnIntervenant()
    {
        $this->assertContainsEquals(
            UserCantDetachContributorException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car l\'intervenant n\'est pas attaché au chantier$/
     */
    public function uneErreurEstLeveeCarLintervenantNestPasAttacheAuChantier()
    {
        $this->assertContainsEquals(
            WorkFieldContributorIsNotFoundException::class,
            $this->errors
        );
    }
}
