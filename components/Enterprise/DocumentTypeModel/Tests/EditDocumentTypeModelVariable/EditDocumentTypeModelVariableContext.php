<?php

namespace Components\Enterprise\DocumentTypeModel\Tests\EditDocumentTypeModelVariable;

use Exception;
use Tests\TestCase;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Illuminate\Support\Facades\App;
use App\Models\Addworking\User\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Components\Enterprise\Document\Application\Models\DocumentType;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\UserRepository;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModelVariable;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\EditDocumentTypeModelVariable;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeRepository;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeModelRepository;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeModelVariableRepository;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeModelVariableIsNotFoundException;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeModelIsPublishedException;
use Carbon\Carbon;

class EditDocumentTypeModelVariableContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $enterpriseRepository;
    private $documentTypeRepository;
    private $documentTypeModelRepository;
    private $userRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
        $this->documentTypeRepository = new DocumentTypeRepository();
        $this->documentTypeModelRepository = new DocumentTypeModelRepository();
    }

     /**
     * @Given les entreprises suivantes existent
     */
    public function lesEntreprisesSuivantesExistent(TableNode $enterprises)
    {
        foreach ($enterprises as $item) {
            $enterprise = new Enterprise();

            $enterprise->fill([
                'name'                      => $item['name'],
                'identification_number'     => $item['siret'],
                'is_customer'               => $item['is_customer'],
                'is_vendor'                 => $item['is_vendor']
            ])->save();
        }
    }

    /**
     * @Given les utilisateurs suivants existent
     */
    public function lesUtilisateursSuivantsExistent(TableNode $users)
    {
        foreach ($users as $item) {
            $user = new User();

            $user->fill([
                'gender'          => array_random(['male', 'female']),
                'firstname'       => $item['firstname'],
                'lastname'        => $item['lastname'],
                'email'           => $item['email'],
                'password'        => Hash::make('password'),
                'is_system_admin' => $item['is_system_admin'],
            ])->save();

            $user->enterprises()->attach($this->enterpriseRepository->findBySiret($item['siret']));
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
                'name'         => $item['display_name'],
                'description'  => $item['description'],
                'display_name' => $item['display_name'],
            ]);

            $document_type->enterprise()->associate($this->enterpriseRepository->findBySiret($item['siret']))->save();
        }
    }

    /**
     * @Given les attestations sur l'honneur suivantes existent
     */
    public function lesAttestationsSurLhonneurSuivantesExistent(TableNode $models)
    {
        foreach ($models as $item) {
            $model = new DocumentTypeModel();

            $model->fill([
                'short_id'       => $item['short_id'],
                'display_name'   => $item['display_name'],
                'name'           => str_slug($item['display_name'], '_'),
                'signature_page' => $item['signature_page'],
                'description'    => $item['description'],
                'content'        => $item['content'],
                'published_at'   => $item['published_at'] !== 'null' ? $item['published_at'] : null
            ]);

            $model->file()->associate(factory(File::class)->create());
            $model->documentType()->associate($this->documentTypeRepository->findByDisplayName($item['type']))->save();
        }
    }

    /**
     * @Given les variables suivantes existent
     */
    public function lesVariablesSuivantesExistent(TableNode $document_type_model_variables)
    {
        foreach ($document_type_model_variables as $item) {
            $document_type_model_variable = new DocumentTypeModelVariable();

            $document_type_model_variable->fill([
                'short_id'       => $item['short_id'],
                'display_name'   => $item['display_name'],
                'name'           => str_slug($item['display_name'], '_'),
                'input_type'     => $item['input_type'],
                'default_value'  => $item['default_value'],
                'description'    => $item['description']
            ]);

            $document_type_model = $this->documentTypeModelRepository->findByShortId($item['document_type_model']);

            $document_type_model_variable->documentTypeModel()->associate($document_type_model)->save();
        }
    }

    /**
     * @Given je suis authentifié en tant que utilisateur avec l'email :arg1
     */
    public function jeSuisAuthentifieEnTantQueUtilisateurAvecLemail(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);
    }

    /**
     * @When j'essaie de modifier la variable numéro :arg1
     */
    public function jessaieDeModifierLaVariableNumero(int $short_id)
    {
        $auth_user = $this->userRepository->connectedUser();
        $document_type_model_variable = App::make(DocumentTypeModelVariableRepository::class)->findByShortId($short_id);

        $inputs = [
            'description'   => 'new description',
            'type'          => 'enterprise_name',
            'default_value' => 'edit default value'
        ];

        try {
            $this->response = (
            new EditDocumentTypeModelVariable(
                $this->userRepository,
                App::make(DocumentTypeModelVariableRepository::class),
            )
            )->handle($auth_user, $document_type_model_variable, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then la variable numéro :arg1 est modifié
     */
    public function laVariableNumeroEstModifie(int $short_id)
    {
        $document_type_model_variable = App::make(DocumentTypeModelVariableRepository::class)->findByShortId($short_id);

        $object = [
            $document_type_model_variable->getDescription(),
            $document_type_model_variable->getInputType(),
            $document_type_model_variable->getDefaultValue()
        ];

        $response_result = [
            $this->response->getDescription(),
            $this->response->getInputType(),
            $this->response->getDefaultValue()
        ];

        $this->assertEquals($object, $response_result);
    }

    /**
     * @Then une erreur est levée car l'attestation sur l'honneur est publiée
     */
    public function uneErreurEstLeveeCarLattestationSurLhonneurEstPubliee()
    {
        $this->assertContainsEquals(
            DocumentTypeModelIsPublishedException::class,
            $this->errors
        );
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
     * @Then une erreur est levée car la variable n'existe pas
     */
    public function uneErreurEstLeveeCarLaVariableNexistePas()
    {
        $this->assertContainsEquals(
            DocumentTypeModelVariableIsNotFoundException::class,
            $this->errors
        );
    }
}
