<?php

namespace Components\Contract\Contract\Tests\Acceptance\ArchiveContract;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Exception;
use Tests\TestCase;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Models\ContractModelParty;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractIsAlreadyArchivedException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotAllowedToArchiveContractException;
use Components\Contract\Contract\Domain\UseCases\ArchiveContract;

class ArchiveContractContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $enterpriseRepository;
    private $contractModelRepository;
    private $userRepository;
    private $contractRepository;
    private $contractModelPartyRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository();
        $this->contractModelRepository = new ContractModelRepository();
        $this->userRepository = new UserRepository();
        $this->contractRepository = new ContractRepository();
        $this->contractModelPartyRepository = new ContractModelPartyRepository();
    }

    /**
     * @Given les entreprises suivantes existent
     */
    public function lesEntreprisesSuivantesExistent(TableNode $enterprises)
    {
        foreach ($enterprises as $item) {
            $enterprise = new Enterprise();
            $enterprise->fill([
                'name' => $item['name'],
                'identification_number' => $item['siret'],
                'registration_town' => uniqid('PARIS_'),
                'tax_identification_number' => 'FR' . random_numeric_string(11),
                'main_activity_code' => random_numeric_string(4) . 'X',
                'is_customer' => $item['is_customer'],
                'is_vendor' => $item['is_vendor']
            ])->save();
        }
    }

    /**
     * @Given les utilisateurs suivants existent
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
            $enterprise->users()->updateExistingPivot($user->id,['is_contract_creator' => $item['is_contract_creator']]);
        }
    }

    /**
     * @Given les modèles de contrat suivants existent
     */
    public function lesModelesDeContratSuivantsExistent(TableNode $contract_models)
    {
        foreach ($contract_models as $item) {
            $contract_model  = new ContractModel();
            $contract_model->fill([
                'number' => $item['number'],
                'display_name' => $item['display_name'],
                'name' => $item['display_name'],
                'published_at' => $item['published_at'] === 'null' ? null : $item['published_at'],
                'archived_at' => $item['archived_at'] === 'null' ? null : $item['archived_at'],
            ]);

            $contract_model->enterprise()->associate($this->enterpriseRepository->findBySiret($item['siret']))->save();
        } 
    }

    /**
     * @Given les parties prenantes du modèle suivantes existent
     */
    public function lesPartiesPrenantesDuModeleSuivantesExistent(TableNode $contract_model_parties)
    {
        foreach ($contract_model_parties as $item) {
            $contract_model_party = new ContractModelParty();
            $contract_model_party->fill([
                'denomination' => $item['denomination'],
                'order' => $item['order'],
                'number' => $item['number'],
            ]);
            $contract_model_party->contractModel()->associate(
                $this->contractModelRepository->findByNumber($item['contract_model_number'])
            )->save();
        } 
    }

    /**
     * @Given les contracts suivants existent
     */
    public function lesContractsSuivantsExistent(TableNode $contracts)
    {
        foreach ($contracts as $item) {
            $contract = new Contract();
            $contract->fill([
                'number' => $item['number'],
                'name' => $item['name'],
                'state' => $item['state'],
                'valid_from' => Carbon::createFromFormat('Y-m-d', $item['valid_from']),
                'valid_until' => Carbon::createFromFormat('Y-m-d', $item['valid_until']),
                'archived_at'  => $item['archived_at'] === 'null' ? null : $item['archived_at'],
            ]);
            $contract->contractModel()->associate(
                $this->contractModelRepository->findByNumber($item['contract_model_number'])
            );
            $contract->enterprise()->associate($this->enterpriseRepository->findBySiret($item['siret']));
            $contract->createdBy()->associate($this->userRepository->findByEmail($item['created_by']))->save();
        }
    }

    /**
     * @Given les parties prenantes suivantes existent
     */
    public function lesPartiesPrenantesSuivantesExistent(TableNode $contract_parties)
    {
        foreach ($contract_parties as $item) {
            $contract = $this->contractRepository->findByNumber($item['contract_number']);
            $contract_model_party = $this->contractModelPartyRepository->findByNumber($item['contract_model_party_number']);
            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $signatory = $this->userRepository->findByNumber($item['signatory_number']);

            $contract_party = new ContractParty();
            $contract_party->fill([
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
     * @Given je suis authentifié en tant que utilisateur avec l'email :arg1
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When j'essaie d'archiver le contrat numéro :arg1
     */
    public function jessaieDarchiverLeContratNumero(string $number)
    {
        $contract = $this->contractRepository->findByNumber($number);
        $auth_user = $this->userRepository->connectedUser();

        try {
            $this->response = (new ArchiveContract(
                $this->contractRepository,
                $this->userRepository
            ))->handle($auth_user, $contract);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then le contrat numéro :arg1 est archivé
    */
    public function leContratNumeroEstArchive(string $number)
    {
        $contract = $this->contractRepository->findByNumber($number);
        $this->assertNotNull($contract->getArchivedAt());
        $this->assertNotNull($contract->getArchivedBy());
        $this->assertEquals($contract->getState(), "archived");
    }

    /**
     * @Then une erreur est levée car l'utilisateur connecté n'est pas membre de l'entreprise propriétaire du contrat
    */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasMembreDeLentrepriseProprietaireDuContrat()
    {
        $this->assertContainsEquals(
            UserIsNotAllowedToArchiveContractException::class,
            $this->errors
        );
    }

    /**
     * @Then une erreur est levée car le contract est déjà archivé
     */
    public function uneErreurEstLeveeCarLeContractEstDejaArchive()
    {
        $this->assertContainsEquals(
            ContractIsAlreadyArchivedException::class,
            $this->errors
        );
    }
}
