<?php

namespace Components\Contract\Contract\Tests\Acceptance\GenerateContract;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Document;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Repositories\Addworking\Enterprise\LegalFormRepository;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
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
use Components\Contract\Contract\Application\Repositories\ContractVariableRepository;
use Components\Contract\Contract\Application\Repositories\DocumentTypeRepository;
use Components\Contract\Contract\Application\Repositories\EnterpriseRepository;
use Components\Contract\Contract\Application\Repositories\UserRepository;
use Components\Contract\Contract\Domain\Exceptions\ContractIsNotFoundException;
use Components\Contract\Contract\Domain\Exceptions\ContractPartyMissingException;
use Components\Contract\Contract\Domain\Exceptions\ContractVariableDoesNotExistException;
use Components\Contract\Contract\Domain\Exceptions\DocumentIsNotValidatedException;
use Components\Contract\Contract\Domain\Exceptions\EnterpriseDoesntHavePartnershipWithContractException;
use Components\Contract\Contract\Domain\UseCases\CreateContractPartFromModel;
use Components\Infrastructure\PdfManager\Application\PdfManager;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class GenerateContractContext extends TestCase implements Context
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
    private $legalFormRepository;

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
        $this->contractPartRepository = new ContractPartRepository;
        $this->pdfManager = new PdfManager;
        $this->legalFormRepository = new LegalFormRepository;
    }

    /**
     * @Given /^les formes légales suivantes existent$/
     */
    public function lesFormesLegalesSuivantesExistent(TableNode $legal_Forms)
    {
        foreach ($legal_Forms as $item) {
            $legal_Form = new LegalForm;
            $legal_Form->fill([
                'name'         => $item['legal_form_name'],
                'display_name' => $item['display_name'],
                'country'      => $item['country'],
            ]);
            $legal_Form->save();
        }
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

            $enterprise->legalForm()->associate($this->legalFormRepository->findByName($item['legal_form_name']));
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
     * @Given /^les documents types suivants existent$/
     */
    public function lesDocumentsTypesSuivantsExistent(TableNode $documentTypes)
    {
        foreach ($documentTypes as $item) {
            $type = factory(DocumentType::class)->make();
            $type->fill([
                'name' => $item['name'],
                'display_name' => $item['display_name'],
                'type' => $item['type'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $type->enterprise()->associate($enterprise);
            $type->save();

            $type->legalForms()->attach($this->legalFormRepository->findByName($item['legal_form_name']));
        }
    }

    /**
     * @Given /^les documents suivants existent$/
     */
    public function lesDocumentsSuivantsExistent(TableNode $documents)
    {
        foreach ($documents as $item) {
            $doc = factory(Document::class)->make();
            $doc->fill([
                'valid_from' => $item['valid_from'],
                'status' => $item['status'],
            ]);

            $type = $this->documentTypeRepository->findByDisplayName($item['type_name']);
            $doc->documentType()->associate($type);
            $doc->save();

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $doc->enterprise()->associate($enterprise);
            $doc->save();
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
                "content" => "<html><body><p>{{1.variable1}}</p><p>{{1.variable2}}</p></body></html>",
            ]);

            $contract_part->file()->associate($file);
            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_part->contractModel()->associate($contract_model)->save();
        }
    }

    /**
     * @Given /^les variables du modèle suivantes existent$/
     */
    public function lesVariablesDuModeleSuivantesExistent(TableNode $contract_model_variables)
    {
        foreach ($contract_model_variables as $item) {
            $contract_model_variable = $this->contractModelVariableRepository->make([
                'name' => $item['name'],
                'number' => $item['number'],
                'order'  => 0,
            ]);

            $contract_model = $this->contractModelRepository->findByNumber($item['contract_model_number']);
            $contract_model_variable->contractModel()->associate($contract_model);

            $contract_model_party = $this->contractModelPartyRepository
            ->findByNumber($item['contract_model_party_number']);
            $contract_model_variable->contractModelParty()->associate($contract_model_party);

            $contract_model_part = $this->contractModelPartRepository
            ->findByNumber($item['contract_model_part_number']);
            $contract_model_variable->setContractModelPart($contract_model_part);
            $contract_model_variable->save();
        }
    }

    /**
     * @Given /^les document types du modèle suivants existent$/
     */
    public function lesDocumentTypesDuModeleSuivantsExistent(TableNode $contract_model_document_type)
    {
        foreach ($contract_model_document_type as $item) {
            $document = $this->contractModelDocumentTypeRepository->make();
            $document->fill([
                'number' => $item['number'],
                'validation_required' => $item['validation_required'],
            ]);

            $document_type = $this->documentTypeRepository->findByDisplayName($item['document_type_display_name']);
            $document->documentType()->associate($document_type);
            $document->save();

            $contract_model_party = $this->contractModelPartyRepository
            ->findByNumber($item['contract_model_party_number']);
            $document->contractModelParty()->associate($contract_model_party);
            $document->save();
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
     * @Given /^les variables du contrat suivantes existent$/
     */
    public function lesVariablesDuContratSuivantesExistent(TableNode $contract_variables)
    {
        foreach ($contract_variables as $item) {
            $contract_variable = $this->contractVariableRepository->make([
                'value' => $item['value'],
                'number' => $item['number'],
            ]);

            $contract = $this->contractRepository->findByNumber($item['contract_number']);
            $contract_variable->contract()->associate($contract);
            $contract_variable->save();

            $contract_model_variable = $this->contractModelVariableRepository
            ->findByNumber($item['contract_model_variable_number']);
            $contract_variable->setContractModelVariable($contract_model_variable);

            $contract_party = $this->contractPartyRepository->findByNumber($item['party_number']);
            $contract_variable->setContractParty($contract_party);

            $contract_variable->save();
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
     * @When /^j\'essaie de générer la pièce du contrat numéro "([^"]*)" à partir de la pièce numéro "([^"]*)" du modèle de contrat$/
     */
    public function jessaieDeGenererLaPieceDuContratNumeroAPartirDeLaPieceNumeroDuModeleDeContrat(
        $contract_number,
        $contract_model_part_number
    ) {
        $auth_user = $this->userRepository->connectedUser();
        $contract = $this->contractRepository->findByNumber($contract_number);
        $contract_model_part = $this->contractModelPartRepository->findByNumber($contract_model_part_number);

        try {
            $this->response = (new CreateContractPartFromModel(
                $this->userRepository,
                $this->contractPartRepository,
                $this->contractRepository,
                $this->contractVariableRepository,
                $this->pdfManager
            ))->handle($auth_user, $contract, $contract_model_part);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^la pièce du contrat est créee$/
     */
    public function laPieceDuContratEstCreee()
    {
        $this->assertDatabaseHas('addworking_contract_contract_parts', [
            'id' => $this->response->getId()
        ]);
    }


    /**
     * @Then /^une erreur est levée car il n\'y a pas assez de parties prenantes renseignées$/
     */
    public function uneErreurEstLeveeCarIlNyAPasAssezDePartiesPrenantesRenseignees()
    {
        $this->assertContainsEquals(
            ContractPartyMissingException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car le contract n\'existe pas$/
     */
    public function uneErreurEstLeveeCarLeContractNexistePas()
    {
        $this->assertContainsEquals(
            ContractIsNotFoundException::class,
            $this->errors
        );
    }

    /**
     * @Then /^une erreur est levée car l\'utilisateur connecté n\'est pas partie prenante du contrat$/
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasPartiePrenanteDuContrat()
    {
        $this->assertContainsEquals(
            EnterpriseDoesntHavePartnershipWithContractException::class,
            $this->errors
        );
    }
}
