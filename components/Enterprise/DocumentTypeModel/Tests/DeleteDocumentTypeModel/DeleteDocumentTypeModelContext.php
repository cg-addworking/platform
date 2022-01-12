<?php

namespace Components\Enterprise\DocumentTypeModel\Tests\DeleteDocumentTypeModel;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\LegalFormRepository;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Enterprise\Document\Application\Models\DocumentType;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeModelRepository;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeRepository;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\UserRepository;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\DeleteDocumentTypeModel;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteDocumentTypeModelContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $enterpriseRepository;
    private $legalFormRepository;
    private $documentTypeRepository;
    private $documentTypeModelRepository;
    private $userRepository;

    public function __construct()
    {
        parent::setUp();
        
        $this->enterpriseRepository = new EnterpriseRepository();
        $this->legalFormRepository = new LegalFormRepository();
        $this->documentTypeRepository = new DocumentTypeRepository();
        $this->documentTypeModelRepository = new DocumentTypeModelRepository();
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
            $user = factory(User::class)->create([
                'firstname'       => $item['firstname'],
                'lastname'        => $item['lastname'],
                'email'           => $item['email'],
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
                'is_mandatory' => $item['is_mandatory'],
                'validity_period' => $item['validity_period'],
                'code' => $item['code'],
                'type' => $item['type'],
            ]);

            $entreprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $document_type->enterprise()->associate($entreprise)->save();

            $document_type->legalForms()->attach($this->legalFormRepository->findByName($item['legal_form_name']));
        }
    }

    /**
     * @Given /^les documents types model suivants existent$/
     */
    public function lesDocumentsTypesModelSuivantsExistent(TableNode $document_type_models)
    {
        foreach ($document_type_models as $item) {
            $document_type_model = new DocumentTypeModel([
                'short_id' => $item['number'],
                'display_name' => $item['display_name'],
                'name' => $item['name'],
                'description' => $item['description'],
                'content' => $item['content'],
            ]);

            $document_type_model->file()->associate(factory(File::class)->create());
            $document_type = $this->documentTypeRepository->findByDisplayName($item['type']);
            $document_type_model->documentType()->associate($document_type)->save();
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
     * @When /^j\'essaie de supprimer le document type model numéro "([^"]*)"$/
     */
    public function jessaieDeSupprimerLeDocumentTypeModelNumero($document_type_model_number)
    {
        $user = $this->userRepository->connectedUser();
        $document_type_model = $this->documentTypeModelRepository->findByShortId($document_type_model_number);

        try {
            $this->response = (new DeleteDocumentTypeModel(
                $this->documentTypeModelRepository,
                $this->userRepository
            ))->handle($user, $document_type_model);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le document type model "([^"]*)" est supprimé$/
     */
    public function leDocumentTypeModelEstSupprime($number)
    {
        $this->assertTrue($this->response);

        $document_type_model = $this->documentTypeModelRepository->findByShortId($number);

        $this->assertSoftDeleted($document_type_model);
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
}
