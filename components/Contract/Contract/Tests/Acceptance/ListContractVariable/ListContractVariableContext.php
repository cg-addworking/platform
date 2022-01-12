<?php

namespace Components\Contract\Contract\Tests\Acceptance\ListContractVariable;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\UseCases\ListContractVariable;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Model\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Contract\Model\Application\Repositories\ContractModelVariableRepository;
use Components\Contract\Model\Application\Repositories\EnterpriseRepository;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListContractVariableContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $contractModelPartRepository;
    private $contractModelPartyRepository;
    private $contractModelRepository;
    private $contractModelVariableRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $contractPartyRepository;
    private $contractPartRepository;
    private $contractRepository;
    private $contractVariableRepository;

    public function __construct()
    {
        parent::setUp();

        $this->contractModelPartRepository = new ContractModelPartRepository();
        $this->contractModelPartyRepository = new ContractModelPartyRepository();
        $this->contractModelRepository = new ContractModelRepository();
        $this->contractModelVariableRepository = new ContractModelVariableRepository();
        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
        $this->contractPartyRepository = new ContractPartyRepository();
        $this->contractPartRepository = new ContractPartRepository();
        $this->contractRepository = new ContractRepository();
        $this->contractVariableRepository = new ContractVariableRepository();
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
                'order'        => $item['order'],
                'number'       => $item['number'],
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
     * @Given /^les variables de model de contract suivantes existent$/
     */
    public function lesVariablesDeModelDeContractSuivantesExistent(TableNode $contract_model_variables)
    {
        foreach ($contract_model_variables as $item) {
            $contract_model_variable = $this->contractModelVariableRepository->make([
                'name'   => $item['name'],
                'number' => $item['number'],
                'order'  => $item['order'],
            ]);

            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_model_variable->contractModel()->associate($contract_model);

            $contract_model_party = $this->contractModelPartyRepository->findByNumber($item['contract_model_party_number']);
            $contract_model_variable->contractModelParty()->associate($contract_model_party);

            $contract_model_part = $this->contractModelPartRepository->findByNumber($item['contract_model_part_number']);
            $contract_model_variable->contractModelPart()->associate($contract_model_part);
            $contract_model_variable->save();
        }
    }

    /**
     * @Given /^les variables suivantes existent$/
     */
    public function lesVariablesSuivantesExistent(TableNode $contract_variables)
    {
        foreach ($contract_variables as $item) {
            $contract_variable = $this->contractVariableRepository->make([
                'value' => $item['value'],
                'number' => $item['number'],
                'order' => $item['order'],
            ]);

            $contract = $this->contractRepository->findByNumber($item['contract_number']);
            $contract_variable->contract()->associate($contract);

            $contract_model_variable = $this->contractModelVariableRepository->findByNumber($item['variable_model_number']);
            $contract_variable->contractModelVariable()->associate($contract_model_variable);

            $contract_variable->save();
        }
    }

    /**
     * @Given /^les parties prenantes de modéle de contract suivantes existent$/
     */
    public function lesPartiesPrenantesDeModelDeContractSuivantesExistent(TableNode $contract_model_parties)
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
     * @Given /^les contrats suivants existent$/
     */
    public function lesContratsSuivantsExistent(TableNode $contracts)
    {
        foreach ($contracts as $item) {
            $contract = $this->contractRepository->make();
            $contract->fill([
                'number' => $item['number'],
                'name' => $item['name'],
                'valid_from' => $item['valid_from'],
                'valid_until' => $item['valid_until']
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $contract->enterprise()->associate($enterprise)->save();

            $contract_model = $this->contractModelRepository->findByNumber($item['model_number']);
            $contract->contractModel()->associate($contract_model)->save();
            $this->contractRepository->save($contract);
        }
    }

    /**
     * @Given /^les pièces de contrat suivantes existent$/
     */
    public function lesPiecesDeContratSuivantesExistent(TableNode $parts)
    {
        foreach ($parts as $item) {
            $part = $this->contractPartRepository->make();
            $part->fill([
                'number' => $item['number'],
                'display_name' => $item['display_name'],
                'order' => $item['order'],
                'is_signed' => $item['is_signed'],
                'signature_page' => $item['signature_page'],
            ]);

            $contract = $this->contractRepository->findByNumber($item['contract_number']);
            $part->contract()->associate($contract);

            $contract_model_part = $this->contractModelPartRepository->findByNumber($item['contract_model_part_number']);
            $part->contractModelPart()->associate($contract_model_part);
            $this->contractPartRepository->save($part);
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
     * @When /^j\'essaie de lister toutes les variables du contrat numéro "([^"]*)"$/
     */
    public function jessaieDeListerToutesLesVariablesDuContratNumero($contract_number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $filter = null;
        $search = null;

        try {
            $this->response = (new ListContractVariable(
                $this->userRepository,
                $this->contractVariableRepository,
            ))->handle(
                $auth_user,
                $this->contractRepository->findByNumber($contract_number),
                $filter,
                $search
            );
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^toutes les variables du contrat numéro "([^"]*)" sont listées$/
     */
    public function toutesLesVariablesDuContratNumeroSontListees($contract_number)
    {
        $contract = $this->contractRepository->findByNumber($contract_number);
        $this->assertEquals(count($contract->getContractVariables()), 9);
        $this->assertCount(9, $this->response);
    }
}
