<?php

namespace Components\Contract\Model\Tests\Acceptance\DeleteContractModel;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Carbon\Carbon;
use Components\Contract\Model\Application\Models\ContractModel;
use Components\Contract\Model\Application\Repositories\ContractModelRepository;
use Components\Contract\Model\Application\Repositories\EnterpriseRepository;
use Components\Contract\Model\Application\Repositories\UserRepository;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsArchivedException;
use Components\Contract\Model\Domain\Exceptions\ContractModelIsPublishedException;
use Components\Contract\Model\Domain\Exceptions\UserIsNotSupportException;
use Components\Contract\Model\Domain\UseCases\DeleteContractModel;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteContractModelContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $contractModelRepository;
    private $enterpriseRepository;
    private $userRepository;

    public function __construct()
    {
        parent::setUp();

        $this->contractModelRepository = new ContractModelRepository();
        $this->enterpriseRepository    = new EnterpriseRepository();
        $this->userRepository          = new UserRepository();
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
     * @Given /^les modèles de contrat suivants existent$/
     */
    public function lesModelesDeContratSuivantsExistent(TableNode $contract_models)
    {
        foreach($contract_models as $item) {
            $contract_model  = factory(ContractModel::class)->make([
                'number'       => $item['number'],
                'display_name' => $item['display_name'],
                'published_at' => $item['published_at'] === 'null' ? null : new Carbon($item['published_at']),
                'archived_at'  => $item['archived_at'] === 'null' ? null : new Carbon($item['archived_at']),
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $contract_model->enterprise()->associate($enterprise)->save();
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
     * @When /^j\'essaie de supprimer le modèle de contrat numéro "([^"]*)"$/
     */
    public function jessaieDeSupprimerLeModeleDeContratNumero($number)
    {
        $authUser = $this->userRepository->connectedUser();
        $contract_model = $this->contractModelRepository->findByNumber($number);

        try {
            $this->response = (new DeleteContractModel(
                $this->contractModelRepository,
                $this->userRepository
            ))->handle($authUser, $contract_model);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^le modèle de contrat numéro "([^"]*)" est supprimé$/
     */
    public function leModeleDeContratNumeroEstSupprime($number)
    {
        $this->assertTrue($this->response);

        $this->assertTrue($this->contractModelRepository->isDeleted($number));
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
