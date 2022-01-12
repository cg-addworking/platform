<?php

namespace Components\Contract\Model\Tests\Acceptance\ListContractModelVariable;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Model\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Contract\Model\Application\Repositories\ContractModelVariableRepository;
use Components\Contract\Model\Application\Repositories\EnterpriseRepository;
use Components\Contract\Model\Application\Repositories\UserRepository;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\UseCases\ListContractModelVariable;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListContractModelVariableContext extends TestCase implements Context
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

    public function __construct()
    {
        parent::setUp();

        $this->contractModelPartRepository = new ContractModelPartRepository();
        $this->contractModelPartyRepository = new ContractModelPartyRepository();
        $this->contractModelRepository = new ContractModelRepository();
        $this->contractModelVariableRepository = new ContractModelVariableRepository();
        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
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
     * @Given /^les variables suivantes existent$/
     */
    public function lesVariablesSuivantesExistent(TableNode $contract_model_variables)
    {
        foreach ($contract_model_variables as $item) {
            $contract_model_variable = $this->contractModelVariableRepository->make([
                'name' => $item['name'],
                'number' => $item['number'],
                'order'  => 0
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
     * @Given /^je suis authentifié en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail($email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de lister toutes les variables du modèle de contrat numéro "([^"]*)"$/
     */
    public function jessaieDeListerToutesLesVariablesDuModeleDeContratNumero($contract_model_number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $filter = null;
        $search = null;

        try {
            $this->response = (new ListContractModelVariable(
                $this->contractModelVariableRepository,
                $this->userRepository,
            ))->handle(
                $auth_user,
                $this->contractModelRepository->findByNumber($contract_model_number),
                $filter,
                $search
            );
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^toutes les variables du modèle de contrat numéro "([^"]*)" sont listées$/
     */
    public function toutesLesVariablesDuModeleDeContratNumeroSontListees($contract_model_number)
    {
        $contract_model = $this->contractModelRepository->findByNumber($contract_model_number);

        $this->assertEquals($contract_model->getVariables()->count(), 7);
        $this->assertCount(7, $this->response);
    }

    /**
     * @Then /^une erreur est levée car l\'utilisateur connecté n\'est pas support$/
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasSupport()
    {
        $this->assertContainsEquals(
            UserIsNotSupportException::class,
            $this->errors
        );
    }

}
