<?php
namespace Components\Enterprise\InvoiceParameter\Tests\Acceptance\ListInvoiceParameter;

use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Gherkin\Node\TableNode;
use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Components\Enterprise\InvoiceParameter\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\InvoiceParameterRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\UserRepository;
use Components\Enterprise\InvoiceParameter\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\InvoiceParameter\Domain\UseCases\ListInvoiceParameter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Behat\Behat\Context\Context;
use Exception;

class ListInvoiceParameterContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $enterpriseRepository;
    private $userRepository;
    private $invoiceParameterRepository;
    private $items = null;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
        $this->invoiceParameterRepository = new InvoiceParameterRepository();
    }

    /**
     * @Given /^les entreprises suivantes existent$/
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
     * @Given /^les parameters de facturation suivants existent$/
     */
    public function lesParametersDeFacturationSuivantsExistent(TableNode $parameters)
    {
        foreach ($parameters as $item) {
            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $parameter = new InvoiceParameter();
            $parameter->fill([
                'number' => $item['number'],
            ]);

            $parameter->enterprise()->associate($enterprise);
            $parameter->save();
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
                'email'    => $item['email'],
                'is_system_admin' => $item['is_system_admin']
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $user->enterprises()->attach($enterprise);
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
     * @When /^j\'essaie de lister les parametres de facturation de l\'entreprise avec le siret "([^"]*)"$/
     */
    public function jessaieDeListerLesParametresDeFacturationDeLentrepriseAvecLeSiret($siret)
    {
        try {
            $this->items = (new ListInvoiceParameter(
                $this->userRepository,
                $this->enterpriseRepository,
                $this->invoiceParameterRepository,
            ))->handle($siret);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^les parametres de facturation sont listées$/
     */
    public function lesParametresDeFacturationSontListees()
    {
        $this->assertCount(1, $this->items);
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
