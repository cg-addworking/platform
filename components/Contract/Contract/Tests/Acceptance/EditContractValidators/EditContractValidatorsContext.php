<?php

namespace Components\Contract\Contract\Tests\Acceptance\EditContractValidators;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\MissionRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractValidatorEditFailedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportOrCreatorException;
use Components\Contract\Contract\Domain\UseCases\EditContractValidators;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Models\ContractModelPart;
use Components\Contract\Model\Application\Models\ContractModelParty;
use Components\Enterprise\WorkField\Application\Models\WorkField;
use Components\Enterprise\WorkField\Application\Models\WorkFieldContributor;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldContributorRepository;
use Components\Enterprise\WorkField\Application\Repositories\WorkFieldRepository;
use Components\Mission\Mission\Application\Models\Mission;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EditContractValidatorsContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $contractRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $workFieldContributorRepository;
    private $workFieldRepository;
    private $contractModelRepository;
    private $contractModelPartRepository;
    private $contractModelPartyRepository;
    private $missionRepository;
    private $contractPartyRepository;

    public function __construct()
    {
        parent::setUp();

        $this->contractRepository = new ContractRepository();
        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
        $this->workFieldContributorRepository = new WorkFieldContributorRepository();
        $this->workFieldRepository = new WorkFieldRepository();
        $this->contractModelRepository = new ContractModelRepository();
        $this->contractModelPartRepository = new ContractModelPartRepository();
        $this->contractModelPartyRepository = new ContractModelPartyRepository();
        $this->missionRepository = new MissionRepository();
        $this->contractPartyRepository = new ContractPartyRepository();
    }

    /**
     * @Given les entreprises suivantes existent
     */
    public function lesEntreprisesSuivantesExistent(TableNode $enterprises)
    {
        foreach ($enterprises as $item) {
            $enterprise = new Enterprise();

            $enterprise->fill([
                'name'                      => $item['name'],
                'identification_number'     => $item['siret'],
                'registration_town'         => uniqid('PARIS_'),
                'tax_identification_number' => 'FR' . random_numeric_string(11),
                'main_activity_code'        => random_numeric_string(4) . 'X',
                'is_customer'               => $item['is_customer'],
                'is_vendor'                 => $item['is_vendor']
            ])->save();
        }
    }

    /**
     * @Given les utilisateurs suivants existent
     */
    public function lesUtilisateursSuivantsExistent(TableNode $users)
    {
        foreach ($users as $item) {
            $user = new User();

            $user->fill([
                'gender'          => array_random(['male', 'female']),
                'firstname'       => $item['firstname'],
                'lastname'        => $item['lastname'],
                'email'           => $item['email'],
                'password'        => Hash::make('password'),
                'is_system_admin' => $item['is_system_admin'],
                'number'          => $item['number']
            ])->save();

            $user->enterprises()->attach($this->enterpriseRepository->findBySiret($item['siret']));
        }
    }

    /**
     * @Given les modèles de contrat suivant existe
     */
    public function lesModelesDeContratSuivantExiste(TableNode $contract_models)
    {
        foreach ($contract_models as $item) {
            $contract_model = new ContractModel();

            $contract_model->fill([
                'number' => $item['number'],
                'display_name' => $item['display_name'],
                'name' => $item['name'],
                'published_at' => $item['published_at'] === 'null' ? null : $item['published_at'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $contract_model->enterprise()->associate($enterprise)->save();
        }
    }

    /**
     * @Given les parties prenantes du modèle suivantes existent
     */
    public function lesPartiesPrenantesDuModeleSuivantesExistent(TableNode $contract_model_parties)
    {
        foreach ($contract_model_parties as $item) {
            $contract_model_party = new ContractModelParty();
            $contract_model_party->fill([
                'denomination' => $item['denomination'],
                'order' => $item['order'],
                'number' => $item['number'],
            ]);
            $contract_model_party->contractModel()->associate(
                $this->contractModelRepository->findByNumber($item['contract_model_number'])
            )->save();
        }
    }

    /**
     * @Given les pièces du modèle suivantes existent
     */
    public function lesPiecesDuModeleSuivantesExistent(TableNode $contract_model_parts)
    {
        foreach ($contract_model_parts as $item) {
            $contract_part = new ContractModelPart();

            $contract_part->fill([
                'name' => $item['name'],
                'display_name' => $item['display_name'],
                'order' => $item['order'],
                'number' => $item['number'],
                'should_compile' => $item['should_compile'],
            ]);

            $file = factory(File::class)->create([
                "mime_type" => "text/html",
                "path" => sprintf('%s.%s', uniqid('/tmp/'), 'html'),
                "content" => "<html><body><p>{{p1.1.variable1}}</p><p>{{p1.1.variable2}}</p></body></html>",
            ]);

            $contract_part->file()->associate($file);
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_part->contractModel()->associate($contract_model)->save();
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
     * @Given les intervenants suivants existent
     */
    public function lesIntervenantsSuivantsExistent(TableNode $work_field_contributors)
    {
        foreach ($work_field_contributors as $item) {
            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $user = $this->userRepository->findByEmail($item['contributor_email']);
            $work_field = $this->workFieldRepository->findByNumber($item['work_field_number']);

            $contributor = new WorkFieldContributor();
            $contributor->fill([
                'number' => $item['number'],
                'is_admin' => $item['is_admin'],
                'is_contract_validator' => (bool) $item['is_contract_validator'],
                'contract_validation_order' => $item['contract_validation_order']
            ]);

            $contributor->workField()->associate($work_field);
            $contributor->enterprise()->associate($enterprise);
            $contributor->contributor()->associate($user);

            $this->workFieldContributorRepository->save($contributor);
        }
    }

    /**
     * @Given les missions suivantes existent
     */
    public function lesMissionsSuivantesExistent(TableNode $construction_missions)
    {
        foreach ($construction_missions as $item) {
            $construction_mission = new Mission();
            $referent = $this->userRepository->findByNumber($item['referent_number']);
            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $work_field = $this->workFieldRepository->findByNumber($item['workfield_number']);

            $construction_mission->setReferent($referent);
            $construction_mission->setWorkfield($work_field);
            $construction_mission->setCustomer($enterprise);

            $construction_mission->fill([
                'number' => $item['number'],
                'name'   => $item['name'],
                'label' => $item['label'],
                'starts_at' => $item['starts_at'],
                'ends_at' => $item['ends_at'],
                'description' => $item['description'],
                'external_id' => $item['external_id'],
                'analytic_code' => $item['analytic_code'],
                'status' => $item['status']
            ])->save();
        }
    }

    /**
     * @Given les contrats suivants existent
     */
    public function lesContratsSuivantsExistent(TableNode $contracts)
    {
        foreach ($contracts as $item) {
            $contract = new Contract();
            $contract->fill([
                'number' => $item['number'],
                'name' => $item['name'],
                'state' => $item['state'],
                'valid_from' => $item['valid_from'],
                'valid_until' => $item['valid_until'],
                'external_identifier' => $item['external_identifier']
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $contract->enterprise()->associate($enterprise);

            $mission = $this->missionRepository->findByNumber($item['mission_number']);
            $contract->mission()->associate($mission);

            if (! is_null($mission->getWorkField())) {
                $contract->workfield()->associate($mission->getWorkField());
            }

            $owner = $this->userRepository->findByEmail($item['created_by']);
            $contract->setCreatedBy($owner);

            $contract->save();

            if (! is_null($contract->getWorkField())) {
                foreach ($contract->getWorkField()->getWorkFieldContributors() as $item) {
                    if ($item->is_contract_validator) {
                        $signatory = $this->userRepository->find($item->contributor_id);
                        $contract_party = $this->contractPartyRepository->make();
                        $contract_party->setContract($contract);
                        $contract_party->setEnterprise($contract->getEnterprise());
                        $contract_party->setEnterpriseName($contract->getEnterprise()->name);
                        $contract_party->setSignatory($signatory);
                        $contract_party->setSignatoryName($signatory->name);
                        $contract_party->setOrder($item->contract_validation_order);
                        $contract_party->setIsValidator(true);
                        $contract_party->setDenomination('Validator ' . $item->contract_validation_order);
                        $contract_party->setNumber();
                        $this->contractPartyRepository->save($contract_party);
                    }
                }
            }
        }
    }

    /**
     * @Given les parties prenantes suivantes existent
     */
    public function lesPartiesPrenantesSuivantesExistent(TableNode $contract_parties)
    {
        foreach ($contract_parties as $item) {
            $contract_party = new ContractParty();

            $contract_party->fill([
                'denomination' => $item['denomination'],
                'order' => $item['order'],
                'number' => $item['number'],
            ]);

            $contract = $this->contractRepository->findByNumber($item['contract_number']);
            $contract_party->contract()->associate($contract)->save();

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $contract_party->enterprise()->associate($enterprise)->save();

            $contract_model_party = $this->contractModelPartyRepository
                ->findByNumber((int) $item['contract_model_party_number']);
            $contract_party->contractModelParty()->associate($contract_model_party)->save();

            $user = $this->userRepository->findByEmail($item['email']);
            $contract_party->signatory()->associate($user)->save();
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
     * @When j'essaie de modifier les validateurs du contrat numéro :arg1
     */
    public function jessaieDeModifierLesValidateursDuContratNumero(int $contract_number)
    {
        try {
            $authUser = $this->userRepository->connectedUser();
            $contract = $this->contractRepository->findByNumber($contract_number);

            $inputs = $contract->getEnterprise()->users()->get()->pluck('id')->toArray();

            $this->response = (new EditContractValidators(
                $this->contractRepository,
                $this->userRepository,
            ))->handle($authUser, $contract, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then les validateurs du contrat numéro :arg1 sont modifiés
     */
    public function lesValidateursDuContratNumeroSontModifies(int $contract_number)
    {
        $contract = $this->contractRepository->findByNumber($contract_number);

        $contract_validators = $this->contractRepository->getValidatorParties($contract);

        $this->assertEquals(2, $contract_validators->count());
    }

    /**
     * @Then une erreur est levée car l'utilisateur n'est pas support ou créateur du contrat
     */
    public function uneErreurEstLeveeCarLutilisateurNestPasSupportOuCreateurDuContrat()
    {
        $this->assertContainsEquals(
            UserIsNotSupportOrCreatorException::class,
            $this->errors
        );
    }

    /**
     * @Then une erreur est levée car l'état du contrat est différent de Brouillon\/En préparation\/Doc à fournir\/Bon pour signature
     */
    public function uneErreurEstLeveeCarLetatDuContratEstDifferentDeBrouillonEnPreparationDocAFournirBonPourSignature()
    {
        $this->assertContainsEquals(
            ContractValidatorEditFailedException::class,
            $this->errors
        );
    }

}
