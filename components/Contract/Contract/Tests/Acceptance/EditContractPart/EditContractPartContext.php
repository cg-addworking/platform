<?php

namespace Components\Contract\Contract\Tests\Acceptance\EditContractPart;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Components\Contract\Contract\Application\Repositories\ContractModelPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractPartNotExistsException;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Contract\Domain\UseCases\EditContractPart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Exception;

class EditContractPartContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $enterpriseRepository;
    private $userRepository;
    private $contractModelRepository;
    private $contractModelPartyRepository;
    private $contractModelPartRepository;
    private $contractRepository;
    private $contractPartyRepository;
    private $contractPartRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository;
        $this->userRepository = new UserRepository;
        $this->contractModelRepository = new ContractModelRepository;
        $this->contractModelPartyRepository = new ContractModelPartyRepository;
        $this->contractModelPartRepository = new ContractModelPartRepository;
        $this->contractRepository = new ContractRepository;
        $this->contractPartyRepository = new ContractPartyRepository;
        $this->contractPartRepository = new ContractPartRepository;
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
            $model_party = $this->contractModelPartyRepository->make();
            $model_party->fill([
                'denomination' => $item['denomination'],
                'order' => $item['order'],
                'number' => $item['number'],
            ]);

            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $model_party->contractModel()->associate($contract_model)->save();
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
     * @Given /^le contrat suivant existe$/
     */
    public function leContratSuivantExiste(TableNode $contracts)
    {
        foreach ($contracts as $item) {
            $contract = $this->contractRepository->make();
            $contract->fill([
                'number' => $item['number'],
                'name' => $item['name'],
                'status' => $item['status'],
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
                'is_hidden' => $item['is_hidden'],
            ]);
            
            $contract = $this->contractRepository->findByNumber($item['contract_number']);
            $contract_part->contract()->associate($contract);

            $model_part = $this->contractModelPartRepository->findByNumber($item['model_part_number']);
            $contract_part->contractModelPart()->associate($model_part);

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
     * @When /^j\'essaie de modifier la pièce de contrat numéro "([^"]*)"$/
     */
    public function jessaieDeModifierLaPieceDeContratNumero(string $number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $contract_part = $this->contractPartRepository->findByNumber($number);
        $inputs = ['is_hidden' => true];

        try {
            $this->response = (new EditContractPart(
                $this->userRepository
            ))->handle($auth_user, $contract_part, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^la pièce du contrat est modifiée$/
     */
    public function laPieceDuContratEstModifiee()
    {
        $this->assertDatabaseHas(
            'addworking_contract_contract_parts',
            [
                'id' => $this->response->getId(),
                'is_hidden' => true,
            ]
        );
    }

    /**
     * @Then /^une erreur est soulevée car la pièce de contrat n\'existe pas$/
     */
    public function uneErreurEstSouleveeCarLaPieceDeContratNexistePas()
    {
        $this->assertContainsEquals(
            ContractPartNotExistsException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est soulevée car l\'utilisateur connecté n\'est pas support$/
     */
    public function uneErreurEstSouleveeCarLutilisateurConnecteNestPasSupport()
    {
        $this->assertContainsEquals(
            UserIsNotSupportException::class,
            $this->errors
        );
    }
}
