<?php

namespace Components\Enterprise\WorkField\Tests\Acceptance\ListWorkField;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Components\Enterprise\WorkField\Application\Presenters\WorkFieldListPresenter;
use Components\Enterprise\WorkField\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\WorkField\Application\Repositories\SectorRepository;
use Components\Enterprise\WorkField\Application\Repositories\UserRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository;
use Components\Enterprise\WorkField\Domain\UseCases\ListWorkField;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListWorkFieldContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    public $sectorRepository;
    public $enterpriseRepository;
    public $userRepository;
    public $workFieldRepository;
    public $workFieldContributorRepository;
    public $workFieldListPresenter;

    public function __construct()
    {
        parent::setUp();

        $this->sectorRepository = new SectorRepository;
        $this->enterpriseRepository = new EnterpriseRepository;
        $this->userRepository = new UserRepository;
        $this->workFieldRepository = new WorkFieldRepository;
        $this->workFieldContributorRepository = new WorkFieldContributorRepository;
        $this->workFieldListPresenter = new WorkFieldListPresenter;
    }

    /**
     * @Given /^le secteur suivant existe$/
    */
    public function leSecteurSuivantExiste(TableNode $sectors)
    {
        foreach ($sectors as $item) {
            $sector = $this->sectorRepository->make([
                'number' => $item['number'],
                'name' => $item['name'],
                'display_name' => $item['display_name'],
            ]);

            $this->sectorRepository->save($sector);
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

            $sector = $this->sectorRepository->findByNumber((int) $item['sector_number']);

            $enterprise->parent()->associate($this->enterpriseRepository->findBySiret($item['parent_siret']));
            $enterprise->sectors()->attach($sector);

            $enterprise->addresses()->attach(factory(Address::class)->create());
            $enterprise->phoneNumbers()->attach(factory(PhoneNumber::class)->create());
        }
    }

    /**
     * @Given /^les utilisateurs suivants existent$/
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
            $enterprise->users()->updateExistingPivot($user->id, [
                'is_work_field_creator' => $item['is_wf_creator']
            ]);
        }
    }

    /**
     * @Given /^le chantier suivant existe$/
     */
    public function leChantierSuivantExiste(TableNode $work_fields)
    {
        foreach ($work_fields as $item) {
            $enterprise = $this->enterpriseRepository->findBySiret($item['owner_siret']);
            $owner = $this->userRepository->findByEmail($item['created_by']);

            $work_field = $this->workFieldRepository->make([
                'number' => $item['number'],
                'name' => str_slug($item['name'], '_'),
                'display_name' => $item['name'],
                'description' => $item['description'],
                'estimated_budget' => $item['estimated_budget'],
                'started_at' => $item['started_at'],
                'ended_at' => $item['ended_at'],
            ]);

            $work_field->owner()->associate($enterprise);
            $work_field->createdBy()->associate($owner);

            $this->workFieldRepository->save($work_field);
        }
    }

    /**
     * @Given /^l\'intervenant suivant existe$/
     */
    public function lintervenantSuivantExiste(TableNode $work_field_contributors)
    {
        foreach ($work_field_contributors as $item) {
            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $user = $this->userRepository->findByEmail($item['contributor_email']);
            $work_field = $this->workFieldRepository->findByNumber($item['work_field_number']);

            $contributor = $this->workFieldContributorRepository->make();
            $contributor->fill([
                'number' => $item['number'],
                'is_admin' => $item['is_admin'],
            ]);

            $contributor->workField()->associate($work_field);
            $contributor->enterprise()->associate($enterprise);
            $contributor->contributor()->associate($user);

            $this->workFieldContributorRepository->save($contributor);
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
     * @When /^j\'essaie de lister tous les chantiers dont je suis créateur$/
     */
    public function jessaieDeListerTousLesChantiersDontJeSuisCreateur()
    {
        $auth_user = $this->userRepository->connectedUser();

        try {
            $this->response = (new ListWorkField(
                $this->userRepository,
                $this->workFieldRepository,
                $this->workFieldContributorRepository
            ))->handle($this->workFieldListPresenter, $auth_user);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @When /^j\'essaie de lister tous les chantiers dont je suis administrateur$/
     */
    public function jessaieDeListerTousLesChantiersDontJeSuisAdministrateur()
    {
        $auth_user = $this->userRepository->connectedUser();

        try {
            $this->response = (new ListWorkField(
                $this->userRepository,
                $this->workFieldRepository,
                $this->workFieldContributorRepository
            ))->handle($this->workFieldListPresenter, $auth_user);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @When /^j\'essaie de lister tous les chantiers dont je suis intervenant$/
     */
    public function jessaieDeListerTousLesChantiersDontJeSuisIntervenant()
    {
        $auth_user = $this->userRepository->connectedUser();

        try {
            $this->response = (new ListWorkField(
                $this->userRepository,
                $this->workFieldRepository,
                $this->workFieldContributorRepository
            ))->handle($this->workFieldListPresenter, $auth_user);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^tous les chantiers sont listés$/
     */
    public function tousLesChantiersSontListes()
    {
        $this->assertDatabaseCount('addworking_enterprise_work_fields', 3);
        $this->assertCount(3, $this->response);
    }
}
