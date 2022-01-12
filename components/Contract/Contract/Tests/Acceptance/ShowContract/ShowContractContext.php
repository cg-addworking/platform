<?php

namespace Components\Contract\Contract\Tests\Acceptance\ShowContract;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Components\Contract\Contract\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelVariableRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\UseCases\ShowContract;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ShowContractContext extends TestCase implements Context
{
    use RefreshDatabase;

    protected $enterpriseRepository;
    protected $contractModelRepository;
    protected $contractModelVariableRepository;
    protected $contractModelPartyRepository;
    protected $contractPartyRepository;
    protected $contractModelPartRepository;
    protected $contractRepository;
    protected $userRepository;

    protected $response;
    protected $errors = [];

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository;
        $this->contractModelRepository = new ContractModelRepository;
        $this->contractModelVariableRepository = new ContractModelVariableRepository;
        $this->contractModelPartyRepository = new ContractModelPartyRepository;
        $this->contractPartyRepository = new ContractPartyRepository;
        $this->contractModelPartRepository = new ContractModelPartRepository;
        $this->contractRepository = new ContractRepository;
        $this->userRepository = new UserRepository;
    }

    /**
     * @Given /^les entreprises suivantes existent$/
     */
    public function lesEntreprisesSuivantesExistent(TableNode $enterprises)
    {
        foreach ($enterprises as $item) {
            $enterprise = $this->enterpriseRepository->make();
            $enterprise->fill([
                'name'                      => $item['name'],
                'identification_number'     => $item['siret'],
                'registration_town'         => uniqid('PARIS_'),
                'tax_identification_number' => 'FR' . random_numeric_string(11),
                'main_activity_code'        => random_numeric_string(4) . 'X',
                'is_customer'               => $item['is_customer'],
                'is_vendor'                 => $item['is_vendor']
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
            $user = $this->userRepository->make();
            $user->fill([
                'gender'         => array_random(['male', 'female']),
                'password'       => Hash::make('password'),
                'remember_token' => str_random(10),
                'email' => $item['email'],
                'firstname'=> $item['firstname'],
                'lastname' => $item['lastname'],
                'is_system_admin' => $item['is_system_admin'],
            ]);
            $user->save();

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
        }
    }

    /**
     * @Given /^le modèle de contrat suivant existe$/
     */
    public function leModeleDeContratSuivantExiste(TableNode $models)
    {
        foreach ($models as $item) {
            $model = $this->contractModelRepository->make();
            $model->fill([
                'number' => $item['number'],
                'name' => $item['name'],
                'display_name' => $item['display_name'],
                'published_at' => $item['published_at'],
                'archived_at' => null,
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $model->enterprise()->associate($enterprise)->save();

            $user = $this->userRepository->findByEmail($item['owner_email']);
            $model->publishedBy()->associate($user)->save();
        }
    }

    /**
     * @Given /^les parties prenantes du modèle suivantes existent$/
     */
    public function lesPartiesPrenantesDuModeleSuivantesExistent(TableNode $contract_model_parties)
    {
        foreach ($contract_model_parties as $item) {
            $contract_party = $this->contractModelPartyRepository->make();
            $contract_party->fill([
                'denomination' => $item['denomination'],
                'order' => $item['order'],
                'number' => $item['number'],
            ]);

            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_party->contractModel()->associate($contract_model)->save();
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
            ]);

            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_part->contractModel()->associate($contract_model)->save();
        }
    }

    /**
     * @Given /^le contrat suivant existe$/
     */
    public function leContratSuivantExiste(TableNode $contracts)
    {
        foreach ($contracts as $item) {
            $contract = $this->contractRepository->make();
            $contract->fill([
                'number' => $item['number'],
                'name' => $item['name'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $contract->enterprise()->associate($enterprise)->save();

            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract->contractModel()->associate($contract_model)->save();
        }
    }

    /**
     * @Given /^les parties prenantes suivantes existent$/
     */
    public function lesPartiesPrenantesSuivantesExistent(TableNode $contract_parties)
    {
        foreach ($contract_parties as $item) {
            $contract_party = $this->contractPartyRepository->make();
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
            ->findByNumber($item['contract_model_party_number']);
            $contract_party->contractModelParty()->associate($contract_model_party)->save();

            $user = $this->userRepository->findByEmail($item['email']);
            $contract_party->signatory()->associate($user)->save();
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
     * @When /^j\'essaie de voir le détail du contrat numéro "([^"]*)"$/
     */
    public function jessaieDeVoirLeDetailDuContratNumero(string $number)
    {
        $contract = $this->contractRepository->findByNumber($number);
        $auth_user = $this->userRepository->connectedUser();

        try {
            $this->response = (new ShowContract())->handle($auth_user, $contract);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le détail du contrat numéro "([^"]*)" est affiché$/
     */
    public function leDetailDuContratNumeroEstAffiche(string $number)
    {
        $contract = $this->contractRepository->findByNumber($number);
        $this->assertEquals($contract->getNumber(), $this->response->getNumber());
    }

    /**
     * @Then /^une erreur est levée car le contrat n\'existe pas$/
     */
    public function uneErreurEstLeveeCarLeContratNexistePas()
    {
        $this->assertContainsEquals(
            ContractIsNotFoundException::class,
            $this->errors
        );
    }
}
