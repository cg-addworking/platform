<?php

namespace Components\Contract\Contract\Tests\Acceptance\DeleteContract;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelVariableRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportOrCreatorException;
use Components\Contract\Contract\Domain\UseCases\DeleteContract;
use Components\Contract\Model\Application\Models\ContractModel;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteContractContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $contractModelPartyRepository;
    private $contractModelRepository;
    private $contractPartyRepository;
    private $contractModelPartRepository;
    private $contractRepository;
    private $enterpriseRepository;
    private $contractModelVariableRepository;
    private $contractVariableRepository;
    private $userRepository;

    public function __construct()
    {
        parent::setUp();

        $this->contractModelPartyRepository = new ContractModelPartyRepository();
        $this->contractModelRepository = new ContractModelRepository();
        $this->contractPartyRepository = new ContractPartyRepository();
        $this->contractModelPartRepository = new ContractModelPartRepository;
        $this->contractRepository = new ContractRepository();
        $this->enterpriseRepository = new EnterpriseRepository();
        $this->contractModelVariableRepository = new ContractModelVariableRepository;
        $this->contractVariableRepository = new ContractVariableRepository;
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
                'is_system_admin' => $item['is_system_admin'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
            $enterprise->users()->updateExistingPivot($user->id,['is_signatory' => $item['is_signatory']]);
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
     * @Given /^les parties prenantes suivantes \(modèle de contrat\) existent$/
     */
    public function lesPartiesPrenantesSuivantesModeleDeContratExistent(TableNode $contract_model_parties)
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

            $created_by = $this->userRepository->findByEmail($item['created_by']);
            $contract->createdBy()->associate($created_by);
            $contract->save();
        }
    }

    /**
     * @Given /^les parties prenantes suivantes \(contrat\) existent$/
     */
    public function lesPartiesPrenantesSuivantesContratExistent(TableNode $contract_parties)
    {
        foreach ($contract_parties as $item) {
            $contract = $this->contractRepository->findByNumber($item['contract_number']);
            $contract_model_party = $this->contractModelPartyRepository->findByNumber($item['contract_model_party_number']);
            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $signatory = $this->userRepository->findByNumber($item['signatory_number']);

            $contract_party = $this->contractPartyRepository->make([
                'number' => $item['number'],
                'denomination' => $contract_model_party->getDenomination(),
                'order' => $item['order'],
                'enterprise_name' => $enterprise->name,
                'signatory_name' => $signatory->name,
            ]);
            $contract_party
                ->contract()->associate($contract)
                ->contractModelParty()->associate($contract_model_party)
                ->enterprise()->associate($enterprise)
                ->signatory()->associate($signatory)
                ->save();
        }
    }

    /**
     * @Given /^les pièces du modèle suivantes existent$/
     */
    public function lesPiecesDuModeleSuivantesExistent(TableNode $contract_model_parts)
    {
        foreach ($contract_model_parts as $item) {
            $contract_part = $this->contractModelPartRepository->make();
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
                "content" => "<html><body><p>Test</p></body></html>",
            ]);

            $contract_part->file()->associate($file);
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_part->contractModel()->associate($contract_model)->save();
        }
    }

    /**
     * @Given /^les variables du modèle suivantes existent$/
     */
    public function lesVariablesDuModeleSuivantesExistent(TableNode $contract_model_variables)
    {
        foreach ($contract_model_variables as $item) {
            $contract_model_variable = $this->contractModelVariableRepository->make([
                'name' => $item['name'],
                'number' => $item['number'],
                'order'  => 0,
            ]);

            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_model_variable->contractModel()->associate($contract_model);

            $contract_model_party = $this->contractModelPartyRepository
                ->findByNumber($item['contract_model_party_number']);
            $contract_model_variable->contractModelParty()->associate($contract_model_party);

            $contract_model_part = $this->contractModelPartRepository
                ->findByNumber($item['contract_model_part_number']);
            $contract_model_variable->setContractModelPart($contract_model_part);
            $contract_model_variable->save();
        }
    }

    /**
     * @Given /^les variables du contrat suivantes existent$/
     */
    public function lesVariablesDuContratSuivantesExistent(TableNode $contract_variables)
    {
        foreach ($contract_variables as $item) {
            $contract_variable = $this->contractVariableRepository->make([
                'value' => $item['value'],
                'number' => $item['number'],
            ]);

            $contract = $this->contractRepository->findByNumber($item['contract_number']);
            $contract_variable->contract()->associate($contract);
            $contract_variable->save();

            $contract_model_variable = $this->contractModelVariableRepository
                ->findByNumber($item['contract_model_variable_number']);
            $contract_variable->setContractModelVariable($contract_model_variable);

            $contract_party = $this->contractPartyRepository->findByNumber($item['party_number']);
            $contract_variable->setContractParty($contract_party);

            $contract_variable->save();
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
     * @When /^j\'essaie de supprimer le contrat numéro "([^"]*)"$/
     */
    public function jessaieDeSupprimerLeContratNumero($number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $contract = $this->contractRepository->findByNumber($number);

        try {
            $this->response = (new DeleteContract(
                $this->contractRepository,
                $this->userRepository
            ))->handle($auth_user, $contract);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le contrat numéro "([^"]*)" est supprimé$/
     */
    public function leContratNumeroEstSupprime($number)
    {
        $this->assertTrue($this->response);

        $this->assertTrue($this->contractRepository->isDeleted($number));
    }

    /**
     * @Then /^les parties prenantes du contrat numéro "([^"]*)" sont supprimées$/
     */
    public function lesPartiesPrenantesDuContratNumeroSontSupprimees($number)
    {
        $contract = $this->contractRepository->findByNumber($number, true);
        foreach ($contract->parties()->withTrashed()->get() as $party) {
            $this->assertTrue($this->contractPartyRepository->isDeleted($party));
        }
    }

    /**
     * @Then /^les variables du contrat numéro "([^"]*)" sont supprimées$/
     */
    public function lesVariablesDuContratNumeroSontSupprimees($number)
    {
        $contract = $this->contractRepository->findByNumber($number, true);
        foreach ($contract->contractVariables()->withTrashed()->get() as $variable) {
            $this->assertTrue($this->contractVariableRepository->isDeleted($variable));
        }
    }
    
    /**
     * @Then une erreur est levée car l'utilisateur connecté n'est pas le créateur
    */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasLeCreateur()
    {
        $this->assertContainsEquals(
            UserIsNotSupportOrCreatorException::class,
            $this->errors
        );
    }
}
