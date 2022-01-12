<?php

namespace Components\Contract\Model\Tests\Acceptance\UnpublishContractModel;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Contract\Model\Application\Repositories\EnterpriseRepository;
use Components\Contract\Model\Application\Repositories\UserRepository;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Components\Contract\Model\Domain\UseCases\UnpublishContractModel;
use Components\Contract\Model\Domain\Exceptions\ContractModelHasContractsException;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsNotPublishedException;
use Illuminate\Support\Facades\Hash;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Exception;

class UnpublishContractModelContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $contractModelRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $contractRepository;

    public function __construct()
    {
        parent::setUp();

        $this->contractModelRepository = new ContractModelRepository();
        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
        $this->contractRepository = new ContractRepository();
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
            $user = $this->userRepository->make();
            $user->fill([
                'firstname' => $item['firstname'],
                'lastname' => $item['lastname'],
                'email' => $item['email'],
                'is_system_admin' => $item['is_system_admin'],
                'gender' => array_random(['male', 'female']),
                'password' => Hash::make('password'),
                'remember_token' => str_random(10),
            ]);
            $user->save();

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
        }
    }

    /**
     * @Given /^les modèles de contrat suivants existent$/
     */
    public function lesModelesDeContratSuivantsExistent(TableNode $contract_models)
    {
        foreach($contract_models as $item) {
            $contract_model = $this->contractModelRepository->make();
            $contract_model->fill([
                'number' => $item['number'],
                'name'   => $item['name'],
                'display_name' => $item['display_name'],
                'published_at' => $item['published_at'] === 'null' ? null : $item['published_at'],
                'archived_at' => $item['archived_at'] === 'null' ? null : $item['archived_at'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $contract_model->enterprise()->associate($enterprise)->save();
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
                'status' => $item['status'],
                'name' => $item['name'],
                'external_identifier' => $item['external_identifier'],
                'valid_from' => $item['valid_from'] === 'null' ? null : $item['valid_from'],
                'valid_until' => $item['valid_until'] === 'null' ? null : $item['valid_until'],
            ]);
            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $contract->enterprise()->associate($enterprise)->save();

            $contract_model= $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract->contractModel()->associate($contract_model)->save();            
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
     * @When /^j\'essaie de dépublier le modèle de contrat numéro "([^"]*)"$/
     */
    public function jessaieDeDepublierLeModeleDeContratNumero($number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $contract_model = $this->contractModelRepository->findByNumber($number);

        try {
            $this->response = (new UnpublishContractModel(
                $this->contractModelRepository,
                $this->userRepository,
            ))->handle($auth_user, $contract_model);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le modèle de contrat numéro "([^"]*)" est dépublié$/
     */
    public function leModeleDeContratNumeroEstDepublie($number)
    {
        $contract_model = $this->contractModelRepository->findByNumber($number);

        $this->assertNull($contract_model->getPublishedAt());
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
    /**
     * @Then /^une erreur est levée car le modèle de contrat a au moins un contrat$/
     */
    public function uneErreurEstLeveeCarLeModeleDeContratAAuMoinsUnContrat()
    {
        $this->assertContainsEquals(
            ContractModelHasContractsException::class,
            $this->errors
        );
    }
}
