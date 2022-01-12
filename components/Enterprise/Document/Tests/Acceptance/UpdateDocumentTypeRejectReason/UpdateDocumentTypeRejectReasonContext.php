<?php

namespace Components\Enterprise\Document\Tests\Acceptance\UpdateDocumentTypeRejectReason;

use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Enterprise\Document\Application\Models\Document;
use Components\Enterprise\Document\Application\Models\DocumentType;
use Components\Enterprise\Document\Application\Repositories\DocumentTypeRejectReasonRepository;
use Components\Enterprise\Document\Application\Repositories\DocumentTypeRepository;
use Components\Enterprise\Document\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\Document\Application\Repositories\UserRepository;
use Components\Enterprise\Document\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\Document\Domain\UseCases\UpdateDocumentTypeRejectReason;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Components\Enterprise\Document\Application\Models\DocumentTypeRejectReason;
use Components\Enterprise\Document\Domain\Exceptions\DocumentTypeRejectReasonIsNotFoundException;

class UpdateDocumentTypeRejectReasonContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $enterpriseRepository;
    private $userRepository;
    private $documentTypeRepository;
    private $documentTypeRejectReasonRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
        $this->documentTypeRepository = new DocumentTypeRepository();
        $this->documentTypeRejectReasonRepository = new DocumentTypeRejectReasonRepository();
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

            $enterprise->parent()->associate($this->enterpriseRepository->findBySiret($item['parent_siret']));
            $enterprise->save();
        }
    }

    /**
     * @Given les documents types suivants existent
     */
    public function lesDocumentsTypesSuivantsExistent(TableNode $document_types)
    {
        foreach ($document_types as $item) {
            $document_type = new DocumentType();
            $document_type->fill([
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
        }
    }

    /**
     * @Given les motifs de refus suivant existent
     */
    public function lesMotifsDeRefusSuivantExistent(TableNode $reject_reasons)
    {
        foreach ($reject_reasons as $item) {
            $reject_reason = new DocumentTypeRejectReason();
            $reject_reason->fill([
                'display_name' => $item['name'],
                'name' => str_slug($item['name']),
                'number' => $item['number'],
                'message' => $item['message'],
            ]);

            $document_type = $this->documentTypeRepository->findByDisplayName($item['document_type_display_name']);
            $reject_reason->setDocumentType($document_type);
            $this->documentTypeRejectReasonRepository->save($reject_reason);
        }
    }

    /**
     * @Given je suis authentifié en tant que utilisateur avec l'émail :arg1
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When j'essaie de modifier le motif de refus numéro :arg1
     */
    public function jessaieDeModifierLeMotifDeRefusNumero(string $number)
    {
        $auth_user = $this->userRepository->connectedUser();

        $reject_reason = $this->documentTypeRejectReasonRepository->findByNumber($number);

        $inputs = [
            'name' => str_slug('edit display name'),
            'display_name' => 'edit display name',
            'message' => 'edit reject reason message',
        ];

        try {
            $this->response = (
                new UpdateDocumentTypeRejectReason(
                    $this->userRepository,
                    $this->documentTypeRejectReasonRepository
                )
            )->handle(
                    $auth_user,
                    $inputs,
                    $reject_reason,
                    !is_null($reject_reason) ? $reject_reason->getDocumentType() : null
                );
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then le motif de refus numéro :arg1 est modifié
     */
    public function leMotifDeRefusNumeroEstModifie(string $number)
    {
        $reject_reason = $this->documentTypeRejectReasonRepository->findByNumber($number);
        
        $this->assertEquals($reject_reason->getMessage(), $this->response->getMessage());
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

    /**
     * @Then une erreur est levée car le motif de refus n'existe pas
     */
    public function uneErreurEstLeveeCarLeMotifDeRefusNexistePas()
    {
        $this->assertContainsEquals(
            DocumentTypeRejectReasonIsNotFoundException::class,
            $this->errors
        );
    }
}
