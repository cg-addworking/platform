<?php

namespace Components\Enterprise\Document\Tests\Acceptance\DeleteDocumentTypeRejectReason;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use App\Repositories\Addworking\Enterprise\LegalFormRepository;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Enterprise\Document\Application\Models\Document;
use Components\Enterprise\Document\Application\Models\DocumentType;
use Components\Enterprise\Document\Application\Models\DocumentTypeRejectReason;
use Components\Enterprise\Document\Application\Repositories\DocumentTypeRejectReasonRepository;
use Components\Enterprise\Document\Application\Repositories\DocumentTypeRepository;
use Components\Enterprise\Document\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\Document\Application\Repositories\UserRepository;
use Components\Enterprise\Document\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\Document\Domain\UseCases\DeleteDocumentTypeRejectReason;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteDocumentTypeRejectReasonContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $enterpriseRepository;
    private $userRepository;
    private $legalFormRepository;
    private $documentTypeRepository;
    private $documentTypeRejectReasonRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
        $this->documentTypeRepository = new DocumentTypeRepository();
        $this->legalFormRepository = new LegalFormRepository();
        $this->documentTypeRejectReasonRepository = new DocumentTypeRejectReasonRepository();
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
            ]);

            $enterprise->legalForm()->associate(factory(LegalForm::class)->create());
            $enterprise->parent()->associate($this->enterpriseRepository->findBySiret($item['parent_siret']));

            $enterprise->save();

            $enterprise->addresses()->attach(factory(Address::class)->create());
            $enterprise->phoneNumbers()->attach(factory(PhoneNumber::class)->create());

        }
    }

    /**
     * @Given les utilisateurs suivants existent
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
     * @Given les documents types suivants existent
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
     * @Given les motifs de refus suivants existent
     */
    public function lesMotifsDeRefusSuivantsExistent(TableNode $document_type_reject_reasons)
    {
        foreach ($document_type_reject_reasons as $item) {
            $document_type_reject_reason = new DocumentTypeRejectReason();
            $document_type_reject_reason->fill([
                'display_name' => $item['name'],
                'name' => str_slug($item['name']),
                'number' => $item['number'],
                'message' => $item['message'],
            ]);

            $document_type = $this->documentTypeRepository->findByDisplayName($item['document_type_display_name']);
            $document_type_reject_reason->setDocumentType($document_type);
            $this->documentTypeRejectReasonRepository->save($document_type_reject_reason);
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
     * @When /^j\'essaie de supprimer le motif de refus numéro "([^"]*)"$/
     */
    public function jessaieDeSupprimerLeMotifDeRefusNumero($number)
    {
        $auth_user = $this->userRepository->connectedUser();
        $document_type_reject_reason = $this->documentTypeRejectReasonRepository->findByNumber($number);

        try {
            $this->response = (new DeleteDocumentTypeRejectReason(
                $this->userRepository,
                $this->documentTypeRejectReasonRepository
            ))->handle($auth_user, $document_type_reject_reason);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le motif de refus numéro "([^"]*)" est supprimé$/
     */
    public function leMotifDeRefusNumeroEstSupprime($number)
    {
        $this->assertTrue($this->response);
        $document_type_reject_reason = $this->documentTypeRejectReasonRepository->findByNumber($number);
        $this->assertNull($document_type_reject_reason);
    }

    /**
     * @Then une erreur est levée car l'utilisateur connecté n'est pas support
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasSupport()
    {
        $this->assertContainsEquals(
            UserIsNotSupportException::class,
            $this->errors
        );
    }

}
