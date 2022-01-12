<?php

namespace Components\Contract\Model\Tests\Acceptance\CreateEmptyContractModel;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Contract\Model\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Contract\Model\Application\Repositories\EnterpriseRepository;
use Components\Contract\Model\Application\Repositories\UserRepository;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\UseCases\CreateEmptyContractModel;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateEmptyContractModelContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $contractModelPartyRepository;
    private $contractModelRepository;
    private $enterpriseRepository;
    private $userRepository;

    public function __construct()
    {
        parent::setUp();

        $this->contractModelPartyRepository = new ContractModelPartyRepository();
        $this->contractModelRepository      = new ContractModelRepository();
        $this->enterpriseRepository         = new EnterpriseRepository();
        $this->userRepository               = new UserRepository();
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
                'firstname' => $item['firstname'],
                'lastname' => $item['lastname'],
                'email'    => $item['email'],
                'is_system_admin' => $item['is_system_admin']
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
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
     * @When /^j\'essaie de créer un modèle de contrat vide pour l\'entreprise avec le siret "([^"]*)"$/
     */
    public function jessaieDeCreerUnModeleDeContratVidePourLentrepriseAvecLeSiret($siret)
    {
        $authUser = $this->userRepository->connectedUser();

        $enterprise = $this->enterpriseRepository->findBySiret($siret);

        $inputs = [
            'display_name' => 'modèle de contrat 1',
            'enterprise'   => $enterprise->id,
            'parties'      => [
                0 => "la partie prenante 1",
                1 => "la partie prenante 2",
            ]
        ];

        try {
            $this->response = (new CreateEmptyContractModel(
                $this->contractModelPartyRepository,
                $this->contractModelRepository,
                $this->enterpriseRepository,
                $this->userRepository,
            ))->handle($authUser, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le modèle de contrat vide est crée$/
     */
    public function leModeleDeContratVideEstCree()
    {
        $this->assertDatabaseHas('addworking_contract_contract_models', [
            'display_name'  => $this->response->getDisplayName(),
            'enterprise_id' => $this->response->getEnterprise()->id,
        ]);

        $this->assertDatabaseCount('addworking_contract_contract_model_parties', 2);
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
