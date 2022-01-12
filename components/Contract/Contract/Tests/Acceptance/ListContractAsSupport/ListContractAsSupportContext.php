<?php

namespace Components\Contract\Contract\Tests\Acceptance\ListContractAsSupport;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\EnterpriseDoesntHaveAccessToContractException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Contract\Domain\UseCases\ListContractAsSupport;
use Components\Contract\Model\Application\Models\ContractModel;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ListContractAsSupportContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $enterpriseRepository;
    private $userRepository;
    private $contractRepository;
    private $contractModelRepository;
    private $contractModelPartyRepository;

    private $response;
    private $error;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository         = new EnterpriseRepository;
        $this->userRepository               = new UserRepository;
        $this->contractRepository           = new ContractRepository;
        $this->contractModelRepository      = new ContractModelRepository;
        $this->contractModelPartyRepository = new ContractModelPartyRepository;
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
     * @Given /^les partenariats suivants existent$/
     */
    public function lesPartenariatsSuivantsExistent(TableNode $partnerships)
    {
        foreach ($partnerships as $item) {
            $customer = $this->enterpriseRepository->findBySiret($item['siret_customer']);
            $vendor   = $this->enterpriseRepository->findBySiret($item['siret_vendor']);

            $customer->vendors()->attach($vendor, ['activity_starts_at' => $item['activity_starts_at']]);
        }
    }

    /**
     * @Given /^les utilisateurs suivants existent$/
     */
    public function lesUtilisateursSuivantsExistent(TableNode $users)
    {
        foreach ($users as $item) {
            if ($this->userRepository->findByEmail($item['email'])) {
                $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
                $user = $this->userRepository->findByEmail($item['email']);
                $user->enterprises()->attach($enterprise);
            } else {
                $user = $this->userRepository->make();
                $user->fill([
                    'gender'         => $gender = array_random(['male', 'female']),
                    'password'       => Hash::make('password'),
                    'remember_token' => str_random(10),
                    'firstname' => $item['firstname'],
                    'lastname' => $item['lastname'],
                    'email'    => $item['email'],
                    'is_system_admin' => $item['is_system_admin']
                ]);
                $user->save();
                $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
                $user->enterprises()->attach($enterprise);
            }
        }
    }

    /**
     * @Given /^les modèles de contrat suivants existent$/
     */
    public function lesModelesDeContratSuivantsExistent(TableNode $contract_models)
    {
        foreach ($contract_models as $item) {
            $contract_model  = $this->contractModelRepository->make();
            $contract_model->fill([
                'number' => $item['number'],
                'name' => $item['display_name'],
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
     * @When /^j\'essaie de lister tous les contrats de la plateforme$/
     */
    public function jessaieDeListerTousLesContratsDeLaPlateforme()
    {
        $auth_user = $this->userRepository->connectedUser();

        try {
            $this->response = (new ListContractAsSupport(
                $this->userRepository,
                $this->contractRepository
            ))->handle($auth_user);
        } catch (Exception $e) {
            $this->error[] = get_class($e);
        }
    }

    /**
     * @Then /^tous les contrats de la plateforme sont listés$/
     */
    public function tousLesContratsDeLaPlateformeSontListes()
    {
        $this->assertDatabaseCount('addworking_contract_contracts', 6);
        $this->assertCount(6, $this->response);
    }

    /**
     * @Then /^une erreur est levée car l\'utilisateur n\'est pas support$/
     */
    public function uneErreurEstLeveeCarLutilisateurNestPasSupport()
    {
        $this->assertContainsEquals(
            UserIsNotSupportException::class,
            $this->error
        );
    }
}
