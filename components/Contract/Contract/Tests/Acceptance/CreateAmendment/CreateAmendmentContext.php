<?php

namespace Components\Contract\Contract\Tests\Acceptance\CreateAmendment;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Repositories\ContractModelDocumentTypeRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelVariableRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Application\Repositories\DocumentTypeRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\MissionRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\AmendmentCantBeCreatedFromAmendment;
use Components\Contract\Contract\Domain\Exceptions\ContractModelIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\ContractModelIsNotPublishedException;
use Components\Contract\Contract\Domain\UseCases\CreateAmendment;
use Components\Infrastructure\PdfManager\Application\PdfManager;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateAmendmentContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $enterpriseRepository;
    private $userRepository;
    private $documentTypeRepository;
    private $contractModelRepository;
    private $contractModelPartyRepository;
    private $contractModelPartRepository;
    private $contractRepository;
    private $contractPartyRepository;
    private $contractModelVariableRepository;
    private $contractVariableRepository;
    private $contractModelDocumentTypeRepository;
    private $contractPartRepository;
    private $pdfManager;
    private $contractStateRepository;
    private $missionRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository;
        $this->userRepository = new UserRepository;
        $this->documentTypeRepository = new DocumentTypeRepository;
        $this->contractModelRepository = new ContractModelRepository;
        $this->contractModelPartyRepository = new ContractModelPartyRepository;
        $this->contractModelPartRepository = new ContractModelPartRepository;
        $this->contractModelVariableRepository = new ContractModelVariableRepository;
        $this->contractVariableRepository = new ContractVariableRepository;
        $this->contractRepository = new ContractRepository;
        $this->contractPartyRepository = new ContractPartyRepository;
        $this->contractModelDocumentTypeRepository = new ContractModelDocumentTypeRepository;
        $this->contractPartRepository = new ContractPartRepository();
        $this->pdfManager = new PdfManager;
        $this->contractStateRepository = new ContractStateRepository();
        $this->missionRepository = new MissionRepository();
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
                'archived_at' => null,
            ]);

            if($item['published_at'] !== 'null'){
                $model->setPublishedAt($item['published_at']);
            }

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
                'should_compile' => $item['should_compile'],
            ]);
            
            $file = factory(File::class)->create([
                "mime_type" => "text/html",
                "path" => sprintf('%s.%s', uniqid('/tmp/'), 'html'),
                "content" => "<html><body><p>{{1.variable1}}</p><p>{{1.variable2}}</p></body></html>",
            ]);

            $contract_part->file()->associate($file);
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_part->contractModel()->associate($contract_model)->save();
        }
    }

    /**
     * @Given /^les contrat suivant existe$/
     */
    public function lesContratSuivantExiste(TableNode $contracts)
    {
        foreach ($contracts as $item) {
            $contract = $this->contractRepository->make();
            $contract->fill([
                'number' => $item['number'],
                'name' => $item['name'],
            ]);

            if ($item['parent_number'] !== 'null') {
                $contract_parent = $this->contractRepository->findByNumber($item['parent_number']);
                $contract->setParent($contract_parent);
            }

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
     * @When /^j\'essaie de créer un avenant à partir du contract "([^"]*)" et du model de contract "([^"]*)"$/
     */
    public function jessaieDeCreerUnAvenantAPartirDuContractEtDuModelDeContract(
        $contract_number,
        $contract_model_number
    ) {
        $auth_user = $this->userRepository->connectedUser();
        $contract_parent = $this->contractRepository->findByNumber($contract_number);
        $contract_model = $this->contractModelRepository->findByNumber($contract_model_number);
        $inputs = [
            'contract' => [
                'contract_model' => $contract_model->getId(),
                'enterprise' => $contract_parent->getEnterprise()->getId(),
                'name' => $contract_parent->getName() . ' amendment',
                'external_identifier' => 'external_identifier_of_amendment',
                'valid_from' => Carbon::now()->format('Y-m-d'),
                'valid_until' => Carbon::now()->addWeek()->format('Y-m-d'),
            ],
        ];

        try {
            $this->response = (new CreateAmendment(
                $this->contractModelRepository,
                $this->contractRepository,
                $this->enterpriseRepository,
                $this->contractPartyRepository,
                $this->userRepository,
                $this->contractStateRepository,
                $this->contractVariableRepository,
                $this->contractModelPartyRepository,
                $this->missionRepository
            ))->handle($auth_user, $contract_parent, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^l\'avenant du contrat est créee$/
     */
    public function lavenantDuContratEstCreee()
    {
        $this->assertDatabaseHas('addworking_contract_contracts', [
            'id' => $this->response->getId(),
        ]);
    }

    /**
     * @When /^j\'essaie de créer un avenant à partir du contract "([^"]*)" et d\'un fichier et de deux partie prenante$/
     */
    public function jessaieDeCreerUnAvenantAPartirDuContractEtDunFichierEtDeDeuxPartiePrenante($contract_number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $contract_parent = $this->contractRepository->findByNumber($contract_number);

        $enterprise_party_1 = $this->enterpriseRepository->findBySiret('02000000000000');
        $signatory_party_1 = $this->userRepository->findByEmail('jean.paul@clideux.com');

        $enterprise_party_2 = $this->enterpriseRepository->findBySiret('03000000000000');
        $signatory_party_2 = $this->userRepository->findByEmail('victor.hugo@miserables.com');

        $inputs = [
            'contract' => [
                'contract_model' => null,
                'enterprise' => $contract_parent->getEnterprise()->getId(),
                'name' => $contract_parent->getName() . ' amendment',
                'external_identifier' => 'external_identifier_of_amendment',
                'valid_from' => Carbon::now()->format('Y-m-d'),
                'valid_until' => Carbon::now()->addWeek()->format('Y-m-d'),
            ],
            'contract_party' => [
                1 => [
                    'denomination' => 'denomination 2',
                    'enterprise_id' => $enterprise_party_1->getId(),
                    'signatory_id' => $signatory_party_1->getId(),
                    'order' => '1',
                ],
                2 => [
                    'denomination' => 'denomination 2',
                    'enterprise_id' => $enterprise_party_2->getId(),
                    'signatory_id' => $signatory_party_2->getId(),
                    'order' => '2',
                ],
            ],
            'contract_part' => [
                'display_name' => 'Display Name',
            ]
        ];

        $file = factory(File::class)->create([
            "mime_type" => "text/html",
            "path" => sprintf('%s.%s', uniqid('/tmp/'), 'html'),
            "content" => "<html><body><p>lorem</p><p>ipsum</p></body></html>",
        ]);

        try {
            $this->response = (new CreateAmendment(
                $this->contractModelRepository,
                $this->contractRepository,
                $this->enterpriseRepository,
                $this->contractPartyRepository,
                $this->userRepository,
                $this->contractStateRepository,
                $this->contractVariableRepository,
                $this->contractModelPartyRepository,
                $this->missionRepository
            ))->handle($auth_user, $contract_parent, $inputs, $file);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @When /^j\'essaie de créer un avenant à partir du contract "([^"]*)" sans model$/
     */
    public function jessaieDeCreerUnAvenantAPartirDuContractSansModelEtSansFichier($contract_number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $contract_parent = $this->contractRepository->findByNumber($contract_number);

        $enterprise_party_1 = $this->enterpriseRepository->findBySiret('02000000000000');
        $signatory_party_1 = $this->userRepository->findByEmail('jean.paul@clideux.com');

        $enterprise_party_2 = $this->enterpriseRepository->findBySiret('03000000000000');
        $signatory_party_2 = $this->userRepository->findByEmail('victor.hugo@miserables.com');

        $inputs = [
            'contract' => [
                'contract_model' => null,
                'enterprise' => $contract_parent->getEnterprise()->getId(),
                'name' => $contract_parent->getName() . ' amendment',
                'external_identifier' => 'external_identifier_of_amendment',
                'valid_from' => Carbon::now()->format('Y-m-d'),
                'valid_until' => Carbon::now()->addWeek()->format('Y-m-d'),
            ],
            'contract_party' => [
                1 => [
                    'denomination' => 'denomination 2',
                    'enterprise_id' => $enterprise_party_1->getId(),
                    'signatory_id' => $signatory_party_1->getId(),
                    'order' => '1',
                ],
                2 => [
                    'denomination' => 'denomination 2',
                    'enterprise_id' => $enterprise_party_2->getId(),
                    'signatory_id' => $signatory_party_2->getId(),
                    'order' => '2',
                ],
            ],
            'contract_part' => [
                'display_name' => 'Display Name',
            ]
        ];

        try {
            $this->response = (new CreateAmendment(
                $this->contractModelRepository,
                $this->contractRepository,
                $this->enterpriseRepository,
                $this->contractPartyRepository,
                $this->userRepository,
                $this->contractStateRepository,
                $this->contractVariableRepository,
                $this->contractModelPartyRepository,
                $this->missionRepository
            ))->handle($auth_user, $contract_parent, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^une erreur est levée car le model n\'est pas renseigné$/
     */
    public function uneErreurEstLeveeCarLeModelNestPasRenseigne()
    {
        $this->assertContainsEquals(
            ContractModelIsNotFoundException::class,
            $this->errors
        );
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
     * @Then /^une erreur est levée car le contract parent est un avenant$/
     */
    public function uneErreurEstLeveeCarLeContractParentEstUnAvenant()
    {
        $this->assertContainsEquals(
            AmendmentCantBeCreatedFromAmendment::class,
            $this->errors
        );
    }
}
