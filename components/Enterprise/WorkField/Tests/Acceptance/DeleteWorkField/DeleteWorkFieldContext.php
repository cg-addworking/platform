<?php

namespace Components\Enterprise\WorkField\Tests\Acceptance\DeleteWorkField;

use Exception;
use Tests\TestCase;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use App\Models\Addworking\User\User;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Components\Enterprise\WorkField\Domain\UseCases\DeleteWorkField;
use Components\Enterprise\WorkField\Application\Repositories\UserRepository;
use Components\Enterprise\WorkField\Application\Repositories\SectorRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository;
use Components\Enterprise\WorkField\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Components\Enterprise\WorkField\Domain\Exceptions\UserHasNotPermissionToDeleteAWorkFieldException;

class DeleteWorkFieldContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    public $sectorRepository;
    public $enterpriseRepository;
    public $userRepository;
    public $workFieldRepository;
    public $workFieldContributorRepository;

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
            $enterprise->phoneNumbers()->attach(factory(PhoneNumber::class)->create());
            $enterprise->addresses()->attach(factory(Address::class)->create());
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
     * @Given /^les chantiers suivants existent$/
     */
    public function lesChantiersSuivantsExistent(TableNode $work_fields)
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
     * @Given /^les intervenants suivants existent$/
     */
    public function lesIntervenantsSuivantsExistent(TableNode $work_field_contributors)
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
     * @When /^j\'essaie de supprimer le chantier num??ro "([^"]*)"$/
     */
    public function jessaieDeSupprimerLeChantierNumero(string $number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $work_field = $this->workFieldRepository->findByNumber($number);

        try {
            $this->response = (new DeleteWorkField(
                $this->workFieldRepository,$this->workFieldContributorRepository
            ))->handle($auth_user, $work_field);
        } catch (Exception $e) {
           $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le chantier num??ro "([^"]*)" est supprim??$/
     */
    public function leChantierNumeroEstSupprime(string $number)
    {
        $this->assertTrue($this->response);

        $this->assertTrue($this->workFieldRepository->isDeleted($number));
    }

    /**
     * @Then /^une erreur est lev??e car l\'utilisateur n\'a pas le r??le de cr??ateur\/administrateur$/
     */
    public function uneErreurEstLeveeCarLutilisateurNaPasLeRoleDeCreateurAdministrateur()
    {
        $this->assertContainsEquals(
            UserHasNotPermissionToDeleteAWorkFieldException::class,
            $this->errors
        );
    }
}
