<?php

namespace Components\Contract\Contract\Tests\Acceptance\CreateContract;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelVariableRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractModelIsNotPublishedException;
use Components\Contract\Contract\Domain\Exceptions\EnterpriseDoesntHaveAccessToContractModelException;
use Components\Contract\Contract\Domain\UseCases\CreateContract;
use Components\Contract\Model\Application\Models\ContractModel;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateContractContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $contractModelPartRepository;
    private $contractModelPartyRepository;
    private $contractModelRepository;
    private $contractModelVariableRepository;
    private $contractRepository;
    private $contractPartyRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $contractStateRepository;

    public function __construct()
    {
        parent::setUp();

        $this->contractModelPartRepository = new ContractModelPartRepository();
        $this->contractModelPartyRepository = new ContractModelPartyRepository();
        $this->contractModelRepository = new ContractModelRepository();
        $this->contractModelVariableRepository = new ContractModelVariableRepository();
        $this->contractRepository = new ContractRepository();
        $this->contractPartyRepository = new ContractPartyRepository();
        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
        $this->contractStateRepository = new ContractStateRepository();
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

            $enterprise->legalForm()->associate(factory(LegalForm::class)->create());
            $enterprise->parent()->associate($this->enterpriseRepository->findBySiret($item['parent_siret']));

            $enterprise->save();

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
                'is_system_admin' => $item['is_system_admin']
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
        }
    }

    /**
     * @Given /^les modèles de contrat suivants existent$/
     */
    public function lesModelesDeContratSuivantsExistent(TableNode $contract_models)
    {
        foreach ($contract_models as $item) {
            $contract_model  = factory(ContractModel::class)->make([
                'number' => $item['number'],
                'display_name' => $item['display_name'],
                'published_at' => $item['published_at'] === 'null' ? null : $item['published_at'],
                'archived_at' => $item['archived_at'] === 'null' ? null : $item['archived_at'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $contract_model->enterprise()->associate($enterprise)->save();
        }
    }

    /**
     * @Given /^les parties prenantes suivantes existent$/
     */
    public function lesPartiesPrenantesSuivantesExistent(TableNode $contract_model_parties)
    {
        foreach ($contract_model_parties as $item) {
            $contract_model_party = $this->contractModelPartyRepository->make([
                'denomination' => $item['denomination'],
                'order' => $item['order'],
                'number' => $item['number'],
            ]);
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_model_party->contractModel()->associate($contract_model)->save();
        }
    }

    /**
     * @Given /^les pièces suivantes existent$/
     */
    public function lesPiecesSuivantesExistent(TableNode $contract_model_parts)
    {
        foreach ($contract_model_parts as $item) {
            $contract_model_part = $this->contractModelPartRepository->make([
                'display_name' => $item['display_name'],
                'name' => $item['display_name'],
                'is_initialled' => $item['is_initialled'],
                'is_signed' => $item['is_signed'],
                'should_compile' => $item['should_compile'],
                'order' => $item['order'],
                'number' => $item['number'],
            ]);
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_model_part->contractModel()->associate($contract_model)->save();
        }
    }

    /**
     * @Given /^les variables suivantes existent$/
     */
    public function lesVariablesSuivantesExistent(TableNode $contract_model_variables)
    {
        foreach ($contract_model_variables as $item) {
            $contract_model_variable = $this->contractModelVariableRepository->make([
                'name' => $item['name'],
                'number' => $item['number'],
                'order' => 0,
            ]);

            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_model_variable->contractModel()->associate($contract_model);

            $contract_model_party = $this->contractModelPartyRepository->findByNumber($item['contract_model_party_number']);
            $contract_model_variable->contractModelParty()->associate($contract_model_party);

            $contract_model_part = $this->contractModelPartRepository->findByNumber($item['contract_model_part_number']);
            $contract_model_variable->setContractModelPart($contract_model_part);
            $contract_model_variable->save();
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
     * @Given /^les contracts suivants existent$/
     */
    public function lesContractsSuivantsExistent(TableNode $contracts)
    {
        foreach ($contracts as $item) {
            $contract = $this->contractRepository->make([
                'number' => $item['number'],
                'name' => $item['name'],
                'status' => $item['status'],
                'valid_from' => Carbon::createFromFormat('Y-m-d', $item['valid_from']),
                'valid_until' => Carbon::createFromFormat('Y-m-d', $item['valid_until']),
            ]);
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract->contractModel()->associate($contract_model);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $contract->enterprise()->associate($enterprise);

            $contract->save();
        }
    }

    /**
     * @Given /^les parties prenantes de contract suivantes existent$/
     */
    public function lesPartiesPrenantesDeContractSuivantesExistent(TableNode $contract_parties)
    {
        foreach ($contract_parties as $item) {
            $contract_party = $this->contractPartyRepository->make([
                'number' => $item['number'],
                'denomination' => $item['denomination'],
                'order' => $item['order'],
                'signed' => $item['signed'],
                'declined' => $item['declined'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $contract_party->enterprise()->associate($enterprise);

            $contract = $this->contractRepository->findByNumber($item['contract_number']);
            $contract_party->contract()->associate($contract);

            $contract_model_party = $this->contractModelPartyRepository->findByNumber($item['contract_model_party_number']);
            $contract_party->contractModelParty()->associate($contract_model_party)->save();
        }
    }

    /**
     * @When /^j\'essaie de créer un contrat à partir du modèle de contrat numéro "([^"]*)" pour l\'entreprise avec le siret "([^"]*)"$/
     */
    public function jessaieDeCreerUnContratAPartirDuModeleDeContratNumeroPourLentrepriseAvecLeSiret($contract_model_number, $siret)
    {
        $auth_user = $this->userRepository->connectedUser();

        $enterprise = $this->enterpriseRepository->findBySiret($siret);

        $vendor = $enterprise->vendors->first();

        $contract_model = $this->contractModelRepository->findByNumber($contract_model_number);

        $inputs = [
            'name' => 'First Contract !!',
            'enterprise' => $enterprise->id,
            'contract_model' => $contract_model->getId(),
            'external_identifier' => 'random_external_identifier',
            'valid_from' => "2020-11-25",
            'valid_until' => "2020-11-28",
        ];

        try {
            $this->response = (new CreateContract(
                $this->contractModelRepository,
                $this->contractRepository,
                $this->enterpriseRepository,
                $this->userRepository,
                $this->contractStateRepository
            ))->handle($auth_user, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le contrat est crée$/
     */
    public function leContratEstCree()
    {
        $this->assertDatabaseCount('addworking_contract_contracts', 2);

        $this->assertDatabaseHas('addworking_contract_contracts', [
            'name' => $this->response->getName(),
            'enterprise_id' => $this->response->getEnterprise()->id,
            'contract_model_id' => $this->response->getContractModel()->getId(),
            'parent_id' => null,
            'state' => Contract::STATE_DRAFT,
        ]);
    }

    /**
     * @Then /^une erreur est levée car le modèle de contrat n\'a pas de rapport avec l\'entreprise en question$/
     */
    public function uneErreurEstLeveeCarLeModeleDeContratNaPasDeRapportAvecLentrepriseEnQuestion()
    {
        $this->assertContainsEquals(
            EnterpriseDoesntHaveAccessToContractModelException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car le modèle de contrat n\'est pas publié$/
     */
    public function uneErreurEstLeveeCarLeModeleDeContratNestPasPublie()
    {
        $this->assertContainsEquals(
            ContractModelIsNotPublishedException::class,
            $this->errors
        );
    }
}
