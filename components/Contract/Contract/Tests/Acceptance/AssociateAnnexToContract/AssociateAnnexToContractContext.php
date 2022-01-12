<?php

namespace Components\Contract\Contract\Tests\Acceptance\AssociateAnnexToContract;

use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Barryvdh\DomPDF\Facade as PDF;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Models\Annex;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Models\ContractPart;
use Components\Contract\Contract\Application\Models\ContractParty;
use Components\Contract\Contract\Application\Repositories\AnnexRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\UserNotAllowedToAssociateAnnexToContractException;
use Components\Contract\Contract\Domain\UseCases\AssociateAnnexToContract;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Models\ContractModelPart;
use Components\Contract\Model\Application\Models\ContractModelParty;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AssociateAnnexToContractContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;
    private EnterpriseRepository $enterpriseRepository;
    private ContractModelRepository $contractModelRepository;
    private ContractRepository $contractRepository;
    private ContractModelPartyRepository $contractModelPartyRepository;
    private UserRepository $userRepository;
    private ContractModelPartRepository $contractModelPartRepository;
    private AnnexRepository $annexRepository;
    private ContractPartRepository $contractPartRepository;
    private ContractStateRepository $contractStateRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository();
        $this->contractModelRepository = new ContractModelRepository();
        $this->contractRepository = new ContractRepository();
        $this->contractModelPartyRepository = new ContractModelPartyRepository();
        $this->userRepository = new UserRepository();
        $this->contractModelPartRepository = new ContractModelPartRepository();
        $this->annexRepository = new AnnexRepository();
        $this->contractPartRepository = new ContractPartRepository();
        $this->contractStateRepository = new ContractStateRepository();
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

            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $user->enterprises()->attach($enterprise);
        }
    }

    /**
     * @Given les annexes suivantes existent
     */
    public function lesAnnexesSuivantesExistent(TableNode $annexes)
    {
        foreach ($annexes  as $item) {
            $annex = new Annex();

            $annex->fill([
                'number' => $item['number'],
                'name' => $item['name'],
                'display_name' => $item['name'],
                'description' => $item['description'],

            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $annex->setEnterprise($enterprise);

            $pdf = PDF::loadHTML('
                <img src="img/logo_addworking_vertical.png">
                <h1><div style="text-align: center;">Test annexe pdf</div></h1>
            ');

            $file = factory(File::class)->create([
                'path'      => sprintf('%s.%s', uniqid('/tmp/'), 'pdf'),
                'mime_type' => 'application/pdf',
                'content'   => @$pdf->output()
            ]);

            $annex->setFile($file);

            $annex->save();
        }
    }

    /**
     * @Given le modèle de contrat suivant existe
     */
    public function leModeleDeContratSuivantExiste(TableNode $contract_models)
    {
        foreach ($contract_models as $item) {
            $model = new ContractModel();

            $model->fill([
                'number' => $item['number'],
                'name' => $item['name'],
                'display_name' => $item['display_name'],
                'published_at' => $item['published_at'],
                'archived_at' => null,
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $model->enterprise()->associate($enterprise)->save();
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

            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_model_party->contractModel()->associate($contract_model)->save();
        }
    }

    /**
     * @Given les pièces du modèle suivantes existent
     */
    public function lesPiecesDuModeleSuivantesExistent(TableNode $contract_model_parts)
    {
        foreach ($contract_model_parts as $item) {
            $contract_model_part = new ContractModelPart();

            $contract_model_part->fill([
                'name' => $item['name'],
                'display_name' => $item['display_name'],
                'order' => $item['order'],
                'number' => $item['number'],
                'should_compile' => $item['should_compile'],
            ]);

            $file = factory(File::class)->create();

            $contract_model_part->file()->associate($file);
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_model_part->contractModel()->associate($contract_model)->save();
        }
    }

    /**
     * @Given les contrats suivants existent
     */
    public function lesContratsSuivantsExistent(TableNode $contracts)
    {
        foreach ($contracts as $item) {
            $contract = new Contract();

            $contract->fill(['number' => $item['number'], 'name' => $item['name'], 'state' => $item['state']]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $contract->enterprise()->associate($enterprise)->save();

            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract->contractModel()->associate($contract_model)->save();
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
                'signed_at' => $item['signed_at'] !== 'null' ? Carbon::createFromFormat('Y-m-d', $item['signed_at']) : null,
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
     * @Given les pièces de contrat suivantes existent
     */
    public function lesPiecesDeContratSuivantesExistent(TableNode $contract_parts)
    {
        foreach ($contract_parts as $item) {
            $contract_part = new ContractPart();

            $contract_part->fill([
                'number' => $item['number'],
            ]);

            $contract = $this->contractRepository->findByNumber($item['contract_number']);
            $contract_part->contract()->associate($contract);

            if ($item['model_part_number'] !== 'null') {
                $model_part = $this->contractModelPartRepository->findByNumber($item['model_part_number']);
                $contract_part->contractModelPart()->associate($model_part);
            }

            $contract_part->file()->associate(factory(File::class)->create());
            $contract_part->save();
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
     * @When j'essaie d'ajouter l'annexe numéro :arg1 au contrat numéro :arg2
     */
    public function jessaieDajouterLannexeNumeroAuContratNumero(int $annex_number, int $contract_number)
    {
        $annex     = $this->annexRepository->findByNumber($annex_number);
        $contract  = $this->contractRepository->findByNumber($contract_number);
        $auth_user = $this->userRepository->connectedUser();
        $inputs = ['display_name' => "Annexe", "is_signed" => (bool) mt_rand(0, 1)];

        try {
            $this->response = (new AssociateAnnexToContract(
                $this->userRepository,
                $this->contractRepository,
                $this->contractPartRepository,
                $this->contractStateRepository
            ))->handle($auth_user, $annex, $contract, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then l'annexe numéro :arg1 est ajoutée au contrat numéro :arg2
     */
    public function lannexeNumeroEstAjouteeAuContratNumero(int $annex_number, int $contract_number)
    {
        $annex     = $this->annexRepository->findByNumber($annex_number);
        $contract  = $this->contractRepository->findByNumber($contract_number);

        $contract_part =$this->contractPartRepository->findByNumber($this->response->getNumber());
        $this->assertEquals($annex->getFile()->getId(), $contract_part->getFile()->getId());

        $this->assertEquals(3, $contract->getParts()->count());
    }


    /**
     * @Then une erreur est levée car le contrat n'existe pas
     */
    public function uneErreurEstLeveeCarLeContratNexistePas()
    {
        $this->assertContainsEquals(ContractIsNotFoundException::class, $this->errors);
    }

    /**
     * @Then une erreur est levée car l'utilisateur n'est pas support ou propriètaire du contrat
     */
    public function uneErreurEstLeveeCarLutilisateurNestPasSupportOuProprietaireDuContrat()
    {
        $this->assertContainsEquals(UserNotAllowedToAssociateAnnexToContractException::class, $this->errors);
    }
}
