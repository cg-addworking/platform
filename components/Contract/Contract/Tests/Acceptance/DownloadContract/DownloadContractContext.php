<?php

namespace Components\Contract\Contract\Tests\Acceptance\DownloadContract;

use Exception;
use Tests\TestCase;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use App\Models\Addworking\User\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Contract\Application\Models\ContractPart;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Domain\UseCases\DownloadContract;
use Components\Contract\Model\Application\Models\ContractModelPart;
use Components\Contract\Model\Application\Models\ContractModelParty;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\ContractStateIsDraftException;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Domain\Exceptions\UserNotAllowedToDownloadContractException;

class DownloadContractContext extends TestCase implements Context
{
    use RefreshDatabase;

    protected $enterpriseRepository;
    protected $contractModelRepository;
    protected $contractModelPartyRepository;
    protected $contractPartyRepository;
    protected $contractRepository;
    protected $userRepository;
    protected $contractModelPartRepository;

    protected $response;
    protected $errors = [];

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository;
        $this->contractModelRepository = new ContractModelRepository;
        $this->contractModelPartyRepository = new ContractModelPartyRepository;
        $this->contractPartyRepository = new ContractPartyRepository;
        $this->contractRepository = new ContractRepository;
        $this->userRepository = new UserRepository;
        $this->contractModelPartRepository = new ContractModelPartRepository;
    }

    /**
     * @Given les entreprises suivantes existent
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

            $enterprise->customers()->attach($this->enterpriseRepository->findBySiret($item['client_siret']));
        }
    }

    /**
     * @Given les utilisateurs suivants existent
     */
    public function lesUtilisateursSuivantsExistent(TableNode $users)
    {
        foreach ($users as $item) {
            $user = new User();
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
     * @Given le modèle de contrat suivant existe
     */
    public function leModeleDeContratSuivantExiste(TableNode $models)
    {
        foreach ($models as $item) {
            $model = new ContractModel();
            $model->fill([
                'number' => $item['number'],
                'name' => $item['name'],
                'display_name' => $item['display_name'],
                'published_at' => $item['published_at'],
            ]);

            $model->enterprise()->associate(
                $this->enterpriseRepository->findBySiret($item['siret'])
            );

            $model->publishedBy()->associate(
                $this->userRepository->findByEmail($item['owner_email'])
            );
            $model->save();
        }
    }

    /**
     * @Given les parties prenantes du modèle suivantes existent
     */
    public function lesPartiesPrenantesDuModeleSuivantesExistent(TableNode $contract_model_parties)
    {
        foreach ($contract_model_parties as $item) {
            $contract_party = new ContractModelParty();
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
     * @Given les pièces du modèle suivantes existent
     */
    public function lesPiecesDuModeleSuivantesExistent(TableNode $contract_model_parts)
    {
        foreach ($contract_model_parts as $item) {
            $contract_part = new ContractModelPart();
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
     * @Given les contrats suivants existent
     */
    public function lesContratsSuivantsExistent(TableNode $contracts)
    {
        foreach ($contracts as $item) {
            $contract = new Contract();
            $contract->fill([
                'number' => $item['number'],
                'name' => $item['name'],
                'state' => $item['state'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $contract->enterprise()->associate($enterprise)->save();

            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract->contractModel()->associate($contract_model)->save();
        }
    }

     /**
     * @Given les pièces de contrat suivantes existent
     */
    public function lesPiecesDeContratSuivantesExistent(TableNode $contract_parts)
    {
        foreach ($contract_parts as $item) {
            $contract_part = new ContractPart();
            $contract_part->fill([
                'number' => $item['number'],
            ]);
            
            $contract_part->contract()->associate(
                $this->contractRepository->findByNumber($item['contract_number'])
            );

            if ($item['model_part_number'] !== 'null') {
                $contract_part->contractModelPart()->associate(
                    $this->contractModelPartRepository->findByNumber($item['model_part_number'])
                );
            }

            $contract_part->file()->associate(factory(File::class)->create());
            $contract_part->save();
        }
    }

    /**
     * @Given les parties prenantes suivantes existent
     */
    public function lesPartiesPrenantesSuivantesExistent(TableNode $contract_parties)
    {
        foreach ($contract_parties as $item) {
            $contract_party = new ContractParty();
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
     * @Given je suis authentifié en tant que utilisateur avec l'email :arg1
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When j'essaie de télécharger le contrat numéro :arg1
     */
    public function jessaieDeTelechargerLeContratNumero(string $number)
    {
        try {
            $authUser = $this->userRepository->connectedUser();
            $contract = $this->contractRepository->findByNumber($number);

            $this->response = (new DownloadContract(
                $this->userRepository,
                $this->contractRepository
            ))->handle($authUser, $contract);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then le contrat est téléchargé
     */
    public function leContratEstTelecharge()
    {
        $this->assertNotNull($this->response->getFile());
        $this->assertEquals("zip", $this->response->getFile()->getExtension());
        $this->assertEquals('200', $this->response->getStatusCode());
    }

    /**
     * @Then une erreur est levée car le contrat est en brouillon
     */
    public function uneErreurEstLeveeCarLeContratEstEnBrouillon()
    {
        $this->assertContainsEquals(
            ContractStateIsDraftException::class,
            $this->errors
        );
    }

    /**
     * @Then une erreur est levée car le contrat n'existe pas
     */
    public function uneErreurEstLeveeCarLeContratNexistePas()
    {
        $this->assertContainsEquals(
            ContractIsNotFoundException::class,
            $this->errors
        );
    }

     /**
     * @Then une erreur est levée car l'entreprise n'est pas propriétaire\/ non partie prenante
     */
    public function uneErreurEstLeveeCarLentrepriseNestPasProprietaireNonPartiePrenante()
    {
        $this->assertContainsEquals(
            UserNotAllowedToDownloadContractException::class,
            $this->errors
        );
    }
}
