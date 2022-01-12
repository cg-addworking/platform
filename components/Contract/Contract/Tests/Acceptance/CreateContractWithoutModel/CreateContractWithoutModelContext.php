<?php

namespace Components\Contract\Contract\Tests\Acceptance\CreateContractWithoutModel;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\Mission\Milestone;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Contract\Contract\Application\Models\Contract;
use Components\Contract\Contract\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelVariableRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\MissionRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\FileNotExistsException;
use Components\Contract\Contract\Domain\UseCases\CreateContractWithoutModel;
use Components\Mission\Mission\Application\Models\Mission;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateContractWithoutModelContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $contractModelPartRepository;
    private $contractModelPartyRepository;
    private $contractModelRepository;
    private $contractModelVariableRepository;
    private $contractRepository;
    private $contractPartyRepository;
    private $contractPartRepository;
    private $enterpriseRepository;
    private $userRepository;
    private $contractStateRepository;
    private $missionRepository;

    public function __construct()
    {
        parent::setUp();

        $this->contractModelPartRepository = new ContractModelPartRepository();
        $this->contractModelPartyRepository = new ContractModelPartyRepository();
        $this->contractModelRepository = new ContractModelRepository();
        $this->contractModelVariableRepository = new ContractModelVariableRepository();
        $this->contractRepository = new ContractRepository();
        $this->contractPartyRepository = new ContractPartyRepository();
        $this->contractPartRepository = new ContractPartRepository();
        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
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
                'name' => $item['name'],
                'identification_number' => $item['siret'],
                'registration_town' => uniqid('PARIS_'),
                'tax_identification_number' => 'FR' . random_numeric_string(11),
                'main_activity_code' => random_numeric_string(4) . 'X',
                'is_customer' => $item['is_customer'],
                'is_vendor' => $item['is_vendor']
            ]);

            $enterprise->legalForm()->associate(factory(LegalForm::class)->create());
            $enterprise->parent()->associate($this->enterpriseRepository->findBySiret($item['parent_siret']));

            $enterprise->save();

            $enterprise->addresses()->attach(factory(Address::class)->create());
            $enterprise->phoneNumbers()->attach(factory(PhoneNumber::class)->create());

            $enterprise->customers()->attach($this->enterpriseRepository->findBySiret($item['client_siret']));
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
                'email' => $item['email'],
                'is_system_admin' => $item['is_system_admin']
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
        }
    }

    /**
     * @Given les missions suivantes existent
     */
    public function lesMissionsSuivantesExistent(TableNode $missions)
    {
        foreach ($missions as $item) {
            $mission = $this->missionRepository->make();
            $mission->fill([
                "label" => $item['label'],
                "starts_at" => $item['starts_at'],
                "number" => $item['number'],
                "unit" => Mission::UNIT_DAYS,
                "quantity" => "1",
                "unit_price" => 0,
                'status' => Mission::STATUS_DRAFT,
                'milestone_type' => Milestone::MILESTONE_MONTHLY,
            ]);

            $mission
                ->customer()->associate($this->enterpriseRepository->findBySiret($item['client_siret']))
                ->vendor()->associate($this->enterpriseRepository->findBySiret($item['vendor_siret']))
                ->contract()->associate($this->contractRepository->findByNumber($item['contract_number']))
                ->save();
        }
    }

    /**
     * @Given /^je suis authentifié en tant que utilisateur avec l\'émail "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail($email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de créer un contrat sans modèle pour l\'entreprise avec le siret "([^"]*)" avec un fichier$/
     */
    public function jessaieDeCreerUnContratSansModelePourLentrepriseAvecLeSiretAvecUnFichier($siret)
    {
        $this->jessaieDeCreerUnContratSansModelePourLentrepriseAvecLeSiret($siret, true);
    }

    /**
     * @When /^j\'essaie de créer un contrat sans modèle pour l\'entreprise avec le siret "([^"]*)" sans fichier$/
     */
    public function jessaieDeCreerUnContratSansModelePourLentrepriseAvecLeSiretSansFichier($siret)
    {
        $this->jessaieDeCreerUnContratSansModelePourLentrepriseAvecLeSiret($siret, false);
    }


    /**
     * @When /^j\'essaie de créer un contrat sans modèle pour l\'entreprise avec le siret "([^"]*)"$/
     */
    public function jessaieDeCreerUnContratSansModelePourLentrepriseAvecLeSiret($siret, $with_file = false)
    {
        $auth_user = $this->userRepository->connectedUser();

        $enterprise = $this->enterpriseRepository->findBySiret($siret);

        $vendor = $enterprise->vendors->first();

        $party_one_enterprise = $this->enterpriseRepository->findBySiret("02000000000000");
        $party_one_signatory = $this->userRepository->findByEmail("jean.paul@head-quarter.com");

        $party_two_enterprise = $this->enterpriseRepository->findBySiret("04000000000000");
        $party_two_signatory = $this->userRepository->findByEmail("jean.michel@not-related.com");

        $inputs = [
            "contract" => [
                "enterprise" => $enterprise->getId(),
                "name" => "Contract without model",
                "valid_from" => "2020-12-29",
                "valid_until" => "2021-01-18",
                "external_identifier" => "random_external_identifier",
                "yousign_procedure_id" => "random_external_yousign_procedure_id",
                'with_mission' => true,
                'mission' => [
                    'id' => $this->missionRepository->findByNumber(1)->id,
                    'label' => "mission label",
                    'starts_at' => "2020-11-26",
                    'ends_at' => null,
                    'vendor_id' => $vendor->id,
                ],
            ],
            "contract_party" => [
                1 => [
                    "denomination" => "Le client",
                    "enterprise_id" => $party_one_enterprise->getId(),
                    "signatory_id" => $party_one_signatory->getId(),
                    "signed_at" => "2021-01-27",
                    "order" => "1",
                ],
                2 => [
                    "denomination" => "Le prestataire",
                    "enterprise_id" => $party_two_enterprise->getId(),
                    "signatory_id" => $party_two_signatory->getId(),
                    "signed_at" => "2021-01-28",
                    "order" => "2",
                ],
            ],
            "contract_part" => [
                "display_name" => "Contract Part Name",
            ],
        ];

        $file = null;
        if ($with_file) {
            $file = factory(File::class)->create();
        }

        try {
            $this->response = (new CreateContractWithoutModel(
                $this->contractRepository,
                $this->contractPartRepository,
                $this->contractPartyRepository,
                $this->userRepository,
                $this->enterpriseRepository,
                $this->contractStateRepository,
                $this->missionRepository
            ))->handle($auth_user, $inputs, $file);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le contrat est crée$/
     */
    public function leContratEstCree()
    {
        $this->assertDatabaseCount('addworking_contract_contracts', 1);

        $this->assertDatabaseHas('addworking_contract_contracts', [
            'id' => $this->response->getId(),
            'name' => $this->response->getName(),
            'enterprise_id' => $this->response->getEnterprise()->id,
            'state' => Contract::STATE_DUE,
        ]);
    }

    /**
     * @Then /^une erreur est levée car le fichier n\'est pas renseigné$/
     */
    public function uneErreurEstLeveeCarLeFichierNestPasRenseigne()
    {
        $this->assertContainsEquals(
            FileNotExistsException::class,
            $this->errors
        );
    }
}
