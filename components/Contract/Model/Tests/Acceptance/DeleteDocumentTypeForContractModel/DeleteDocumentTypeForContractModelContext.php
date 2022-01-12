<?php

namespace Components\Contract\Model\Tests\Acceptance\DeleteDocumentTypeForContractModel;


use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Repositories\ContractModelDocumentTypeRepository;
use Components\Contract\Model\Application\Repositories\ContractModelPartyRepository;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Contract\Model\Application\Repositories\DocumentTypeRepository;
use Components\Contract\Model\Application\Repositories\EnterpriseRepository;
use Components\Contract\Model\Application\Repositories\UserRepository;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsArchivedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsPublishedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\UseCases\DeleteDocumentTypeForContractModel;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Behat\Gherkin\Node\TableNode;

class DeleteDocumentTypeForContractModelContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;
    private $enterpriseRepository;
    private $contractModelPartyRepository;
    private $contractModelRepository;
    private $userRepository;
    private $contractModelDocumentTypeRepository;
    private $documentTypeRepository;

    public function __construct()
    {
        parent::setUp();
        $this->enterpriseRepository = new EnterpriseRepository();
        $this->contractModelPartyRepository = new ContractModelPartyRepository();
        $this->contractModelRepository = new ContractModelRepository();
        $this->userRepository = new UserRepository();
        $this->contractModelDocumentTypeRepository = new ContractModelDocumentTypeRepository();
        $this->documentTypeRepository = new DocumentTypeRepository();
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
                'email' => $item['email'],
                'is_system_admin' => $item['is_system_admin']
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
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
                'name' => $item['display_name'],
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
            $contract_model = factory(ContractModel::class)->make([
                'number' => $item['number'],
                'display_name' => $item['display_name'],
                'published_at' => $item['published_at'] === 'null' ? null : $item['published_at'],
                'archived_at' => $item['archived_at'] === 'null' ? null : $item['archived_at'],
            ]);
            $entreprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $contract_model->enterprise()->associate($entreprise)->save();
        }
    }

    /**
     * @Given /^les parties prenantes suivantes existent$/
     */
    public function lesPartiesPrenantesSuivantesExistent(TableNode $contract_model_parties)
    {
        foreach ($contract_model_parties as $item) {
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_model_party = $this->contractModelPartyRepository->make([
                'denomination' => $item['denomination'],
                'order' => $item['order'],
                'number' => $item['number'],
            ]);
            $contract_model_party->contractModel()->associate($contract_model)->save();
        }
    }

    /**
     * @Given /^les documents types de model de contract suivants existent$/
     */
    public function lesDocumentsTypesDeModelDeContractSuivantesExistent(TableNode $contract_model_document_types)
    {
        foreach ($contract_model_document_types as $item) {
            $contract_model = $this->contractModelRepository->findByNumber($item['party_contract_model_number']);
            $contract_model_party = $this
                ->contractModelPartyRepository
                ->findByOrder($contract_model, $item['contract_model_party_order']);

            $document_type = $this->documentTypeRepository->findByDisplayName($item['document_type_display_name']);

            $contract_model_document_type = $this->contractModelDocumentTypeRepository->make([
                'validation_required' => $item['validation_required'],
            ]);
            $contract_model_document_type->setNumber();
            $contract_model_document_type->contractModelParty()->associate($contract_model_party);
            $contract_model_document_type->documentType()->associate($document_type)->save();
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
     * @When /^j\'essaie de supprimer le document type "([^"]*)" associe a la partie prenante numero "([^"]*)" du modele de contrat numero "([^"]*)"$/
     */
    public function jessaieDeSupprimerLeDocumentTypeAssocieALaPartiePrenanteNumeroDuModeleDeContratNumero(
        $contract_model_document_type_number,
        $contract_model_party_order,
        $contract_model_number
    ) {
        $authUser = $this->userRepository->connectedUser();
        $contract_model = $this->contractModelRepository->findByNumber($contract_model_number);
        $contract_model_party = $this->contractModelPartyRepository->findByOrder($contract_model, $contract_model_party_order);
        try {
            $contract_model_document_type = $this->contractModelDocumentTypeRepository->findByNumber($contract_model_document_type_number);
            $this->response = (new DeleteDocumentTypeForContractModel(
                $this->contractModelRepository,
                $this->userRepository,
                $this->contractModelDocumentTypeRepository,
                $this->documentTypeRepository
            ))
                ->handle($authUser, $contract_model_document_type, $contract_model_party);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^Le contract model document type numero "([^"]*)" n'existe plus$/
     */
    public function leContractModelDocumentTypeNumeroNexistePlus(
        $contract_model_document_type_number
    ) {
        $contract_model_document_type = $this
            ->contractModelDocumentTypeRepository
            ->findByNumber($contract_model_document_type_number);
        $this->assertNull($contract_model_document_type);
    }

    /**
     * @Then /^La partie prenante numero "([^"]*)" du modele de contrat numero "([^"]*)" possede toujours deux document type$/
     */
    public function laPartiePrenanteNumeroDuModeleDeContratNumeroPossedeToujoursDeuxDocumentType(
        $order,
        $contract_model_number
    ) {
        $contract_model = $this->contractModelRepository->findByNumber($contract_model_number);
        $contract_model_party = $this->contractModelPartyRepository->findByOrder($contract_model, $order);
        $this->assertNotNull($contract_model_party);
        $this->assertDatabaseCount('addworking_contract_contract_model_party_document_types', 2);
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

    /**
     * @Then /^une erreur est levée car le modèle de contrat est publié$/
     */
    public function uneErreurEstLeveeCarLeModeleDeContratEstPublie()
    {
        $this->assertContainsEquals(
            ContractModelIsPublishedException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car le modèle de contrat est archivé$/
     */
    public function uneErreurEstLeveeCarLeModeleDeContratEstArchive()
    {
        $this->assertContainsEquals(
            ContractModelIsArchivedException::class,
            $this->errors
        );
    }
}
