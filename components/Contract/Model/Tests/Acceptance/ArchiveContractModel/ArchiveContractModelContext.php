<?php

namespace Components\Contract\Model\Tests\Acceptance\ArchiveContractModel;

use Exception;
use Tests\TestCase;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use App\Models\Addworking\User\User;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Domain\UseCases\ArchiveContractModel;
use Components\Contract\Model\Application\Repositories\UserRepository;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Application\Repositories\EnterpriseRepository;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsDraftException;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsNotFoundException;

class ArchiveContractModelContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $enterpriseRepository;
    private $userRepository;
    private $contractModelRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository    = new EnterpriseRepository();
        $this->userRepository          = new UserRepository();
        $this->contractModelRepository = new ContractModelRepository();
    }

    /**
     * @Given /^les entreprises suivantes existent$/
     */
    public function lesEntreprisesSuivantesExistent(TableNode $enterprises)
    {
        foreach ($enterprises as $item) {
            $enterprise = new Enterprise();
            $enterprise->fill([
                'name'                      => $item['name'],
                'identification_number'     => $item['siret'],
                'registration_town'         => uniqid('PARIS_'),
                'tax_identification_number' => 'FR' . random_numeric_string(11),
                'main_activity_code'        => random_numeric_string(4) . 'X',
                'is_customer'               => $item['is_customer'],
                'is_vendor'                 => $item['is_vendor']
            ])->save();
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

            $user->enterprises()->attach($this->enterpriseRepository->findBySiret($item['siret']));
        }
    }

    /**
     * @Given /^les modèles de contrat suivants existent$/
     */
    public function lesModelesDeContratSuivantsExistent(TableNode $contract_models)
    {
        foreach($contract_models as $item) {
            $contract_model  = new ContractModel();
            $contract_model->fill([
                'number'       => $item['number'],
                'name' => str_slug($item['display_name']),
                'display_name' => $item['display_name'],
                'published_at' => $item['published_at'] === 'null' ? null : $item['published_at'],
            ]);

            $contract_model->enterprise()->associate($this->enterpriseRepository->findBySiret($item['siret']))->save();
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
     * @When j'essaie d'archiver le modèle de contrat numéro :arg1
     */
    public function jessaieDarchiverLeModeleDeContratNumero(string $number)
    {
        $contract_model = $this->contractModelRepository->findByNumber($number);
        $user = $this->userRepository->connectedUser();

        try {
            $this->response = (new ArchiveContractModel(
                $this->contractModelRepository,
                $this->userRepository
            ))->handle($user, $contract_model);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then le modèle de contrat numéro :arg1 est archivé
     */
    public function leModeleDeContratNumeroEstArchive(string $number)
    {
        $contract_model = $this->contractModelRepository->findByNumber($number);

        $this->assertNotNull($contract_model->getArchivedAt());
    }

    /**
     * @Then une erreur est levée car l'utilisateur connecté n'est pas support
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasSupport()
    {
        $this->assertContainsEquals(
            UserIsNotSupportException::class,
            $this->errors
        );
    }

     /**
     * @Then une erreur est levée car le modèle de contrat est en brouillon
     */
    public function uneErreurEstLeveeCarLeModeleDeContratEstEnBrouillon()
    {
        $this->assertContainsEquals(
            ContractModelIsDraftException::class,
            $this->errors
        );
    }

    /**
     * @Then une erreur est levée car le modèle de contrat n'existe pas
     */
    public function uneErreurEstLeveeCarLeModeleDeContratNexistePas()
    {
        $this->assertContainsEquals(
            ContractModelIsNotFoundException::class,
            $this->errors
        );
    }
}
