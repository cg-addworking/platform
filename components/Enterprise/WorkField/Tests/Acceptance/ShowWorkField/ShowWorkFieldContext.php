<?php

namespace Components\Enterprise\WorkField\Tests\Acceptance\ShowWorkField;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Components\Enterprise\WorkField\Application\Presenters\WorkFieldShowPresenter;
use Components\Enterprise\WorkField\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\WorkField\Application\Repositories\SectorRepository;
use Components\Enterprise\WorkField\Application\Repositories\UserRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository;
use Components\Enterprise\WorkField\Domain\Exceptions\UserHasNoAccessToWorkFieldException;
use Components\Enterprise\WorkField\Domain\Exceptions\UserHasNotPermissionToShowAWorkFieldException;
use Components\Enterprise\WorkField\Domain\Exceptions\WorkFieldIsNotFoundException;
use Components\Enterprise\WorkField\Domain\UseCases\ShowWorkField;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ShowWorkFieldContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    public $sectorRepository;
    public $enterpriseRepository;
    public $userRepository;
    public $workFieldRepository;
    public $workFieldContributorRepository;
    public $workFieldShowPresenter;

    public function __construct()
    {
        parent::setUp();

        $this->sectorRepository = new SectorRepository;
        $this->enterpriseRepository = new EnterpriseRepository;
        $this->userRepository = new UserRepository;
        $this->workFieldRepository = new WorkFieldRepository;
        $this->workFieldContributorRepository = new WorkFieldContributorRepository;
        $this->workFieldShowPresenter = new WorkFieldShowPresenter;
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

            $enterprise->sectors()->attach($sector);

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
     * @Given /^je suis authentifi?? en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de voir le d??tail du chantier num??ro "([^"]*)"$/
     */
    public function jessaieDeVoirLeDetailDuChantierNumero(string $number)
    {
        $work_field = $this->workFieldRepository->findByNumber($number);
        $auth_user = $this->userRepository->connectedUser();

        try {
            $this->response = (new ShowWorkField(
                $this->workFieldRepository,
                $this->userRepository,
                $this->workFieldContributorRepository
            ))->handle($this->workFieldShowPresenter, $auth_user, $work_field);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le d??tail du chantier num??ro "([^"]*)" est affich??$/
     */
    public function leDetailDuChantierNumeroEstAffiche(string $number)
    {
        $work_field = $this->workFieldRepository->findByNumber($number);

        $this->assertEquals($work_field->getNumber(), $this->response['number']);
    }

    /**
     * @Then /^une erreur est lev??e car l\'utilisateur n\'a pas de relation avec le chantier$/
     */
    public function uneErreurEstLeveeCarLutilisateurNaPasDeRelationAvecLeChantier()
    {
        $this->assertContainsEquals(
            UserHasNotPermissionToShowAWorkFieldException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est lev??e car le chantier n\'existe pas$/
     */
    public function uneErreurEstLeveeCarLeChantierNexistePas()
    {
        $this->assertContainsEquals(
            WorkFieldIsNotFoundException::class,
            $this->errors
        );
    }
}
