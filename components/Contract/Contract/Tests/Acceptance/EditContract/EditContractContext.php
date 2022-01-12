<?php

namespace Components\Contract\Contract\Tests\Acceptance\EditContract;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractIsPublishedException;
use Components\Contract\Contract\Domain\UseCases\EditContract;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportException;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditContractContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;
    private $inputs = [
                'name' => 'nom modifié',
                'external_identifier' => 'identifiant externe modifié',
                'valid_from' => '2021-01-01',
                'valid_until' => '2021-12-30',
            ];

    private $contractRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $contractStateRepository;

    public function __construct()
    {
        parent::setUp();

        $this->contractRepository           = new ContractRepository();
        $this->enterpriseRepository         = new EnterpriseRepository();
        $this->userRepository               = new UserRepository();
        $this->contractStateRepository      = new ContractStateRepository();
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
            $user = factory(User::class)->create([
                'firstname'       => $item['firstname'],
                'lastname'        => $item['lastname'],
                'email'           => $item['email'],
                'is_system_admin' => $item['is_system_admin']
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
        }
    }

    /**
     * @Given /^les contrats suivants existent$/
     */
    public function lesContratSuivantsExistent(TableNode $contracts)
    {
        foreach ($contracts as $item) {
            $contract  = new Contract([
                'number' => $item['number'],
                'status' => $item['status'],
                'name' => $item['name'],
                'external_identifier' => $item['external_identifier'],
                'valid_from' => $item['valid_from'] === 'null' ? null : $item['valid_from'],
                'valid_until' => $item['valid_until'] === 'null' ? null : $item['valid_until'],
            ]);
            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $contract->enterprise()->associate($enterprise)->save();
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
     * @When /^j\'essaie de modifier le contrat numéro "([^"]*)"$/
     */
    public function jessaieDeModifierLeContratNumero($number)
    {
        try {
            $authUser = $this->userRepository->connectedUser();
            $contract = $this->contractRepository->findByNumber($number);

            $this->response = (new EditContract(
                $this->contractRepository,
                $this->enterpriseRepository,
                $this->userRepository,
                $this->contractStateRepository
            ))->handle($authUser, $contract, $this->inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le contrat numéro "([^"]*)" est modifié$/
     */
    public function leContratNumeroEstModifie($number)
    {
        $this->assertDatabaseHas(
            'addworking_contract_contracts',
            [
                'id' => $this->response->getId(),
                'name' => $this->inputs['name'],
                'external_identifier' => $this->inputs['external_identifier'],
            ]
        );
    }

    /**
     * @Then /^une erreur est levée car le contrat est publié$/
     */
    public function uneErreurEstLeveeCarLeContratEstPublie()
    {
        $this->assertContainsEquals(
            ContractIsPublishedException::class,
            $this->errors
        );
    }
}
