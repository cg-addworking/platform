<?php

namespace Components\Enterprise\DocumentTypeModel\Tests\EditDocumentTypeModel;

use App\Models\Addworking\User\User;
use App\Models\Addworking\Common\File;
use App\Models\Addworking\Enterprise\Enterprise;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Enterprise\Document\Application\Models\DocumentType;
use Components\Common\WYSIWYG\Application\Repositories\WysiwygRepository;
use Components\Enterprise\DocumentTypeModel\Application\Models\DocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Domain\UseCases\EditDocumentTypeModel;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\UserRepository;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeRepository;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeModelRepository;
use Components\Enterprise\DocumentTypeModel\Domain\Exceptions\DocumentTypeModelIsNotFoundException;
use Components\Enterprise\DocumentTypeModel\Application\Repositories\DocumentTypeModelVariableRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Exception;
use Tests\TestCase;

class EditDocumentTypeModelContext extends TestCase implements Context
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
     * @Given les models suivants existent
     */
    public function lesModelsSuivantsExistent(TableNode $models)
    {
        foreach ($models as $item) {
            $model = new DocumentTypeModel();

            $model->fill([
                'short_id'       => $item['short_id'],
                'display_name'   => $item['display_name'],
                'name'           => str_slug($item['display_name'], '_'),
                'signature_page' => $item['signature_page'],
                'description'    => $item['description'],
                'content'        => $item['content']
            ]);

            $model->file()->associate(factory(File::class)->create());
            $model->documentType()->associate($this->documentTypeRepository->findByDisplayName($item['type']))->save();
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
     * @When j'essaie de modifier le model numéro :arg1
     */
    public function jessaieDeModifierLeModelNumero($short_id)
    {
        $auth_user = $this->userRepository->connectedUser();
        $model = $this->documentTypeModelRepository->findByShortId($short_id);

        $inputs = [
            'display_name'   => 'Random name',
            'description'    => 'Random message',
            'content'        => 'Random content edit',
            'signature_page' => 2
        ];

        try {
            $this->response = (
            new EditDocumentTypeModel(
                $this->userRepository,
                $this->documentTypeModelRepository,
                App::make(DocumentTypeModelVariableRepository::class),
                App::make(WysiwygRepository::class)
            )
            )->handle($auth_user, $model, $inputs);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then le model numéro :arg1 est modifié
     */
    public function leModelNumeroEstModifie($short_id)
    {
        $model = $this->documentTypeModelRepository->findByShortId($short_id);

        $this->assertEquals($model->getContent(), $this->response->getContent());
    }

    /**
     * @Then une erreur est levée car le model n'existe pas
     */
    public function uneErreurEstLeveeCarLeModelNexistePas()
    {
        $this->assertContainsEquals(
            DocumentTypeModelIsNotFoundException::class,
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
}
