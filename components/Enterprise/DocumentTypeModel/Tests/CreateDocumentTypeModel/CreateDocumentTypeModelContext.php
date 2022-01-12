<?php

namespace Components\Enterprise\DocumentTypeModel\Tests\CreateDocumentTypeModel;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\LegalFormRepository;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Common\WYSIWYG\Application\Repositories\WysiwygRepository;
use Components\Enterprise\Document\Application\Models\DocumentType;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeModelRepository;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeModelVariableRepository;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeRepository;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\UserRepository;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\CreateDocumentTypeModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateDocumentTypeModelContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $enterpriseRepository;
    private $legalFormRepository;
    private $documentTypeRepository;
    private $documentTypeModelRepository;
    private $documentTypeModelVariableRepository;
    private $userRepository;
    private $wysiwygRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository();
        $this->legalFormRepository = new LegalFormRepository;
        $this->documentTypeRepository = new DocumentTypeRepository();
        $this->userRepository = new UserRepository();
        $this->wysiwygRepository = new WysiwygRepository();
        $this->documentTypeModelRepository = new DocumentTypeModelRepository();
        $this->documentTypeModelVariableRepository = new DocumentTypeModelVariableRepository();
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
     * @Given /^je suis authentifié en tant que utilisateur avec l\'email "([^"]*)"$/
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When /^j\'essaie de créer un document type model pour le document type "([^"]*)"$/
     */
    public function jessaieDeCreerUnDocumentTypeModelPourLeDocumentType(string $display_name)
    {
        $auth_user = $this->userRepository->connectedUser();

        $document_type = $this->documentTypeRepository->findByDisplayName($display_name);

        $inputs = [
            'display_name' => 'Random name',
            'description' => 'Random message',
            'content'     => 'Random content',
        ];

        try {
            $this->response = (
            new CreateDocumentTypeModel(
                $this->documentTypeModelRepository,
                $this->documentTypeModelVariableRepository,
                $this->wysiwygRepository,
                $this->userRepository
            )
            )->handle($auth_user, $document_type, $inputs);
        } catch (\Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le document type "([^"]*)" possède un document type model$/
     */
    public function leDocumentTypePossedeUnDocumentTypeModel(string $number)
    {
        $this->assertDatabaseCount('addworking_enterprise_document_type_models', 1);

        $this->assertDatabaseHas('addworking_enterprise_document_type_models', [
            'name'         => $this->response->getName(),
            'display_name' => $this->response->getDisplayName(),
        ]);
    }

    /**
     * @Then /^une erreur est levée car je ne suis pas membre du support$/
     */
    public function uneErreurEstLeveeCarJeNeSuisPasMembreDuSupport()
    {
        $this->assertContainsEquals(
            UserIsNotSupportException::class,
            $this->errors
        );
    }
}
