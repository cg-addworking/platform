<?php

namespace Components\Contract\Contract\Tests\Acceptance\CreateContractPart;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\ContractStateRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractInvalidStateException;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\EnterpriseDoesntHavePartnershipWithContractException;
use Components\Contract\Contract\Domain\UseCases\CreateContractPart;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Barryvdh\DomPDF\Facade as PDF;

class CreateContractPartContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    protected $enterpriseRepository;
    protected $userRepository;
    protected $contractRepository;
    protected $contractStateRepository;
    protected $contractPartRepository;
    protected $contractPartyRepository;
    protected $contractModelRepository;
    protected $contractModelPartyRepository;
    protected $contractModelPartRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository;
        $this->userRepository = new UserRepository;
        $this->contractRepository = new ContractRepository;
        $this->contractStateRepository = new ContractStateRepository;
        $this->contractPartRepository = new ContractPartRepository;
        $this->contractPartyRepository = new ContractPartyRepository;
        $this->contractModelRepository = new ContractModelRepository;
        $this->contractModelPartyRepository = new ContractModelPartyRepository;
        $this->contractModelPartRepository = new ContractModelPartRepository;
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
                'published_at' => $item['published_at'],
                'archived_at' => null,
            ]);

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
                "content" => "<html><body><p>{{p1.1.variable1}}</p><p>{{p1.1.variable2}}</p></body></html>",
            ]);

            $contract_part->file()->associate($file);
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_part->contractModel()->associate($contract_model)->save();
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
                'status' => $item['status'],
                'yousign_procedure_id' => isset($item['yousign_procedure_id'])
                    && $item['yousign_procedure_id']
                    !== 'null'
                    ? $item['yousign_procedure_id']
                    : null,
            ]);

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
     * @Given /^les pièces de contrat suivantes existent$/
     */
    public function lesPiecesDeContratSuivantesExistent(TableNode $contract_parts)
    {
        foreach ($contract_parts as $item) {
            $contract_part = $this->contractPartRepository->make();
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
     * @Given /^je suis authentifié en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie d\'ajouter une pièce de contrat au contrat numéro "([^"]*)"$/
     */
    public function jessaieDajouterUnePieceDeContratAuContratNumero(string $contract_number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $contract = $this->contractRepository->findByNumber($contract_number);
        $inputs = ['display_name' => "Annexe", "is_signed" => (bool) mt_rand(0, 1)];

        $pdf = PDF::loadHTML('
            <img src="img/logo_addworking_vertical.png">
            <h1><div style="text-align: center;">Test pdf</div></h1>
        ');
        $file = factory(File::class)->create([
            'path'      => sprintf('%s.%s', uniqid('/tmp/'), 'pdf'),
            'mime_type' => 'application/pdf',
            'content'   => @$pdf->output()
        ]);

        try {
            $this->response = (new CreateContractPart(
                $this->contractPartRepository,
                $this->userRepository,
                $this->contractRepository,
                $this->contractStateRepository,
            ))->handle($auth_user, $contract, $inputs, $file);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^la pièce de contrat est ajoutée$/
     */
    public function laPieceDeContratEstAjoutee()
    {
        $this->assertDatabaseHas('addworking_contract_contract_parts', [
            'id' => $this->response->getId()
        ]);
    }

    /**
     * @Then /^une erreur est levée car le contrat n\'existe pas$/
     */
    public function uneErreurEstLeveeCarLeContratNexistePas()
    {
        $this->assertContainsEquals(
            ContractIsNotFoundException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car le contrat est déjà signée$/
     */
    public function uneErreurEstLeveeCarLeContratEstDejaSignee()
    {
        $this->assertContainsEquals(
            ContractInvalidStateException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car l\'entreprise choisie n\'a aucune relation avec le contrat$/
     */
    public function uneErreurEstLeveeCarLentrepriseChoisieNaAucuneRelationAvecLeContrat()
    {
        $this->assertContainsEquals(
            EnterpriseDoesntHavePartnershipWithContractException::class,
            $this->errors
        );
    }
}
