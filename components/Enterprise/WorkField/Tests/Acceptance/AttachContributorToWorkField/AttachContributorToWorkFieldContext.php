<?php

namespace Components\Enterprise\WorkField\Tests\Acceptance\AttachContributorToWorkField;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Enterprise\WorkField\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\WorkField\Application\Repositories\SectorRepository;
use Components\Enterprise\WorkField\Application\Repositories\UserRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository;
use Components\Enterprise\WorkField\Domain\Exceptions\ContributorAlreadyAttachedException;
use Components\Enterprise\WorkField\Domain\Exceptions\ContributorIsNotMemberOfOwnerEnterpriseOrDescendantException;
use Components\Enterprise\WorkField\Domain\UseCases\AttachContributorToWorkField;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Webpatser\Uuid\Uuid;

class AttachContributorToWorkFieldContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $enterpriseRepository;
    private $sectorRepository;
    private $userRepository;
    private $workFieldRepository;
    private $workFieldContributorRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository;
        $this->sectorRepository = new SectorRepository;
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
            ]);

            $enterprise->save();
            $sector = $this->sectorRepository->findByNumber((int) $item['sector_number']);

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
            $user = factory(User::class)->create([
                'firstname' => $item['firstname'],
                'lastname' => $item['lastname'],
                'email' => $item['email'],
                'is_system_admin' => $item['is_system_admin'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
            $enterprise->users()->updateExistingPivot($user->id, ['is_work_field_creator' => $item['is_work_field_creator']]);
        }
    }

    /**
     * @Given /^les chantiers suivants existent$/
     */
    public function lesChantiersSuivantsExistent(TableNode $work_fields)
    {
        foreach ($work_fields as $item) {
            $work_field = $this->workFieldRepository->make([
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
    public function lesIntervenantsSuivantsExistent(TableNode $contributors)
    {
        foreach ($contributors as $item) {
            $work_field = $this->workFieldRepository->findByNumber($item['work_field_number']);
            $contributor = $this->userRepository->findByEmail($item['contributor_email']);
            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);

            DB::table('addworking_enterprise_work_field_has_contributors')->insert([
                'id' => (string) Uuid::generate(4),
                'number' => $item['number'],
                'work_field_id' => $work_field->getId(),
                'contributor_id' => $contributor->id,
                'enterprise_id' => $enterprise->id,
                'is_admin' => $item['is_admin'],
                'role' => $item['role'],
            ]);
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
     * @Given /^je suis administrateur du chantier numéro "([^"]*)"$/
     */
    public function jeSuisAdministrateurDuChantierNumero(string $number)
    {
        $work_field = $this->workFieldRepository->findByNumber($number);
        $authenticated = $this->userRepository->connectedUser();

        $this->workFieldContributorRepository->isAdminOf($authenticated, $work_field);
    }

    /**
     * @When /^j\'essaie d\'attacher l\'intervenant avec l\'email "([^"]*)" de l\'entreprise avec le siret numéro "([^"]*)" au chantier numéro "([^"]*)"$/
     */
    public function jessaieDattacherLintervenantAvecLemailDeLentrepriseAvecLeSiretNumeroAuChantierNumero(
        $email,
        $siret,
        $work_field_number
    ) {
        $user  = $this->userRepository->findByEmail($email);

        $work_field = $this->workFieldRepository->findByNumber($work_field_number);

        $authenticated = $this->userRepository->connectedUser();

        $inputs = [
            'work_field_id' => $work_field->getId(),
            'contributor_id' => $user->id,
            'is_admin' => true,
            'enterprise_id' => $user->enterprise->id,
            'role' => Arr::random($this->workFieldContributorRepository->getAvailableRoles()),
        ];

        try {
            $this->response = (new AttachContributorToWorkField(
                $this->enterpriseRepository,
                $this->sectorRepository,
                $this->userRepository,
                $this->workFieldRepository,
                $this->workFieldContributorRepository
            ))->handle($authenticated, $work_field, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^l\'intervenant avec l\'email "([^"]*)" est attaché au chantier numéro "([^"]*)"$/
     */
    public function lintervenantAvecLemailEstAttacheAuChantierNumero(string $email, string $work_field_number)
    {
        $work_field = $this->workFieldRepository->findByNumber($work_field_number);
        $contributor = $this->userRepository->findByEmail($email);

        $this->assertDatabaseHas(
            'addworking_enterprise_work_field_has_contributors',
            [
                'contributor_id' => $contributor->id,
                'work_field_id' => $work_field->getId(),
                'id' => $this->response->id
            ]
        );
    }

    /**
     * @Then /^une erreur est levée car le futur intervenant n\'est pas membre de l\'entreprise propriétaire ou d\'une de ses filiales$/
     */
    public function uneErreurEstLeveeCarLeFuturIntervenantNestPasMembreDeLentrepriseProprietaireOuDuneDeSesFiliales()
    {
        self::assertContainsEquals(
            ContributorIsNotMemberOfOwnerEnterpriseOrDescendantException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car le futur intervenant est déjà intervenant du chantier$/
     */
    public function uneErreurEstLeveeCarLeFuturIntervenantEstDejaIntervenantDuChantier()
    {
        self::assertContainsEquals(
            ContributorAlreadyAttachedException::class,
            $this->errors
        );
    }
}
