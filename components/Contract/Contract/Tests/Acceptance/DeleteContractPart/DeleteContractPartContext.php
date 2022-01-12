<?php

namespace Components\Contract\Contract\Tests\Acceptance\DeleteContractPart;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Contract\Contract\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractPartNotExistsException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotMemberOfTheContractEnterpriseException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Application\Models\ContractModel;
use Exception;
use Components\Contract\Contract\Domain\UseCases\DeleteContractPart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteContractPartContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $contractRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $contractStateRepository;
    private $contractPartRepository;
    private $contractModelPartRepository;
    private $contractModelRepository;


    public function __construct()
    {
        parent::setUp();
        $this->contractRepository = new ContractRepository();
        $this->contractPartRepository = new ContractPartRepository();
        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
        $this->contractStateRepository = new ContractStateRepository();
        $this->contractModelPartRepository = new ContractModelPartRepository();
        $this->contractModelRepository = new ContractModelRepository();
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
     * @Given /^les pièces du modèle suivantes existent$/
     */
    public function lesPiecesDuModeleSuivantesExistent(TableNode $contract_model_parts)
    {
        foreach($contract_model_parts as $item) {
            $contract_model_part = $this->contractModelPartRepository->make();
            $contract_model_part->fill([
                'order' => $item['order'],
                'name' => $item['name'],
                'display_name' => $item['display_name'],
                'is_initialled' => $item['is_initialled'],
                'is_signed' => $item['is_signed'],
                'should_compile' => $item['should_compile'],
            ]);
            $contract_model_part->setNumber();
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_model_part->contractModel()->associate($contract_model)->save();
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
                'status' => $item['status'],
                'yousign_procedure_id' => isset($item['yousign_procedure_id'])
                    && $item['yousign_procedure_id']
                    !== 'null'
                    ? $item['yousign_procedure_id']
                    : null,
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $contract->enterprise()->associate($enterprise)->save();

            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract->contractModel()->associate($contract_model)->save();
        }    
    }

    /**
     * @Given /^les pièces de contrat suivantes existent$/
     */
    public function lesPiecesDeContratSuivantesExistent(TableNode $contract_parts)
    {
        foreach ($contract_parts as $item) {
            $contract_part = $this->contractPartRepository->make([
                'display_name' => $item['display_name'],
                'name' => $item['display_name'],
                'is_initialled' => $item['is_initialled'],
                'is_signed' => $item['is_signed'],
                'should_compile' => $item['should_compile'],
                'number' => $item['number'],
            ]);
            $contract = $this->contractRepository->findByNumber($item['contract_number']);
            $contract_part->contract()->associate($contract)->save();

            $contract_model_part = $this->contractModelPartRepository->findByNumber($item['model_part_number']);
            $contract_part->contractModelPart()->associate($contract_model_part)->save();
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
     * @When /^j\'essaie de supprimer la piece de contract "([^"]*)"$/
     */
    public function jessaieDeSupprimerLaPieceDeContract(
        $contract_part_number
    )
    {
        $authUser = $this->userRepository->connectedUser();
        $contract_part = $this->contractPartRepository->findByNumber($contract_part_number);
        try {
            $this->response = (new DeleteContractPart(
                $this->contractPartRepository,
                $this->userRepository
            ))->handle($authUser, $contract_part);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^la piece de contrat "([^"]*)" est supprimé$/
     */
    public function laPieceDeContratEstSupprime($number)
    {
        $this->assertTrue($this->response);

        $this->assertDatabaseMissing('addworking_contract_contract_parts', ['number' => $number]);
    }

    /**
     * @Then /^une erreur est levée car la piece de contrat n\'existe pas$/
     */
    public function uneErreurEstLeveeCarLaPieceDeContratNexistePas()
    {
        $this->assertContainsEquals(
            ContractPartNotExistsException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car l\'utilisateur connecté n\'est pas membre de l\'entreprise propriétaire du contrat$/
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasMembreDeLentrepriseProprietaireDuContrat()
    {
        $this->assertContainsEquals(
            UserIsNotMemberOfTheContractEnterpriseException::class,
            $this->errors
        );
    }
}
