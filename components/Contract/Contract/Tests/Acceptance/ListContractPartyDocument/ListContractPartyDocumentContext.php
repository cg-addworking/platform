<?php

namespace Components\Contract\Contract\Tests\Acceptance\ListContractPartyDocument;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Carbon\Carbon;
use Components\Contract\Contract\Application\Repositories\ContractModelDocumentTypeRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractModelRepository;
use Components\Contract\Contract\Application\Repositories\ContractPartyRepository;
use Components\Contract\Contract\Application\Repositories\ContractRepository;
use Components\Contract\Contract\Application\Repositories\DocumentTypeRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\UserIsNotMemberOfTheContractPartyEnterpriseException;
use Components\Contract\Contract\Domain\UseCases\ListContractPartyDocument;
use Components\Contract\Model\Application\Models\ContractModel;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListContractPartyDocumentContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $contractModelDocumentTypeRepository;
    private $contractModelPartyRepository;
    private $contractModelRepository;
    private $contractPartyRepository;
    private $contractRepository;
    private $documentTypeRepository;
    private $enterpriseRepository;
    private $userRepository;

    public function __construct()
    {
        parent::setUp();

        $this->contractModelDocumentTypeRepository = new ContractModelDocumentTypeRepository();
        $this->contractModelPartyRepository = new ContractModelPartyRepository();
        $this->contractModelRepository = new ContractModelRepository();
        $this->contractPartyRepository = new ContractPartyRepository();
        $this->contractRepository = new ContractRepository();
        $this->documentTypeRepository = new DocumentTypeRepository();
        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
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

            $enterprise
                ->legalForm()->associate(factory(LegalForm::class)->create())
                ->parent()->associate($this->enterpriseRepository->findBySiret($item['parent_siret']))
                ->save();

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
                'is_system_admin' => $item['is_system_admin'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
            $enterprise->users()->updateExistingPivot($user->id,['is_signatory' => $item['is_signatory']]);
        }
    }

    /**
     * @Given /^les documents types suivants existent$/
     */
    public function lesDocumentsTypesSuivantsExistent(TableNode $document_types)
    {
        foreach ($document_types as $item) {
            $document_type = new DocumentType([
                'display_name' => $item['display_name'],
                'name' => str_slug($item['display_name']),
                'description' => $item['description'],
                'validity_period' => $item['validity_period'],
                'code' => $item['code'],
                'type' => $item['type'],
            ]);
            $entreprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $document_type->enterprise()->associate($entreprise)->save();
        }
    }

    /**
     * @Given /^les modèles de contrat suivants existent$/
     */
    public function lesModelesDeContratSuivantsExistent(TableNode $contract_models)
    {
        foreach ($contract_models as $item) {
            $contract_model  = factory(ContractModel::class)->make([
                'number' => $item['number'],
                'display_name' => $item['display_name'],
                'published_at' => $item['published_at'] === 'null' ? null : $item['published_at'],
                'archived_at' => $item['archived_at'] === 'null' ? null : $item['archived_at'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $contract_model->enterprise()->associate($enterprise)->save();
        }
    }

    /**
     * @Given /^les parties prenantes suivantes \(modèle de contrat\) existent$/
     */
    public function lesPartiesPrenantesSuivantesModeleDeContratExistent(TableNode $contract_model_parties)
    {
        foreach ($contract_model_parties as $item) {
            $contract_model_party = $this->contractModelPartyRepository->make([
                'denomination' => $item['denomination'],
                'order' => $item['order'],
                'number' => $item['number'],
            ]);
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_model_party->contractModel()->associate($contract_model)->save();
        }
    }

    /**
     * @Given /^les types de documents suivants sont définis pour les parties prenantes du modèle de contrat$/
     */
    public function lesTypesDeDocumentsSuivantsSontDefinisPourLesPartiesPrenantesDuModeleDeContrat2(TableNode $contract_model_document_types)
    {
        foreach ($contract_model_document_types as $item) {
            $contract_model_party = $this->contractModelPartyRepository->findByNumber($item['contract_model_party_number']);
            $document_type = $this->documentTypeRepository->findByDisplayName($item['document_type_display_name']);
            $contract_model_document_type = $this->contractModelDocumentTypeRepository->make([
                'number' => $item['number'],
                'validation_required' => $item['validation_required'],
            ]);

            $contract_model_document_type
                ->contractModelParty()->associate($contract_model_party)
                ->documentType()->associate($document_type)
                ->save();
        }
    }

    /**
     * @Given /^les contracts suivants existent$/
     */
    public function lesContractsSuivantsExistent(TableNode $contracts)
    {
        foreach ($contracts as $item) {
            $contract = $this->contractRepository->make([
                'number' => $item['number'],
                'name' => $item['name'],
                'status' => $item['status'],
                'valid_from' => Carbon::createFromFormat('Y-m-d', $item['valid_from']),
                'valid_until' => Carbon::createFromFormat('Y-m-d', $item['valid_until']),
            ]);
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);

            $contract
                ->contractModel()->associate($contract_model)
                ->enterprise()->associate($enterprise)
                ->save();
        }
    }

    /**
     * @Given /^les parties prenantes suivantes \(contrat\) existent$/
     */
    public function lesPartiesPrenantesSuivantesContratExistent(TableNode $contract_parties)
    {
        foreach ($contract_parties as $item) {
            $contract = $this->contractRepository->findByNumber($item['contract_number']);
            $contract_model_party = $this->contractModelPartyRepository->findByNumber($item['contract_model_party_number']);
            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $signatory = $this->userRepository->findByNumber($item['signatory_number']);

            $contract_party = $this->contractPartyRepository->make([
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
     * @Given /^je suis authentifié en tant que utilisateur avec l\'émail "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail($email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de lister tous les documents de la partie prenante numéro "([^"]*)"$/
     */
    public function jessaieDeListerTousLesDocumentsDeLaPartiePrenanteNumero($contract_party_number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $contract_party = $this->contractPartyRepository->findByNumber($contract_party_number);

        try {
            $this->response = (new ListContractPartyDocument(
                $this->contractModelDocumentTypeRepository,
                $this->userRepository
            ))->handle($auth_user, $contract_party);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^les documents de la partie prenante sont listés$/
     */
    public function lesDocumentsDeLaPartiePrenanteSontListes()
    {
        $this->assertCount(5, $this->response);
    }

    /**
     * @Then /^une erreur est levée car l\'utilisateur connecté n\'est pas membre de l\'entreprise partie prenante$/
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasMembreDeLentreprisePartiePrenante()
    {
        $this->assertContainsEquals(
            UserIsNotMemberOfTheContractPartyEnterpriseException::class,
            $this->errors
        );
    }
}
