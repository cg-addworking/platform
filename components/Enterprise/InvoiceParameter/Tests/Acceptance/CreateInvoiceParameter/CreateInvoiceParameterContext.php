<?php
namespace Components\Enterprise\InvoiceParameter\Tests\Acceptance\CreateInvoiceParameter;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Gherkin\Node\TableNode;
use Carbon\Carbon;
use Components\Enterprise\InvoiceParameter\Application\Repositories\CustomerBillingDeadlineRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\IbanRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\InvoiceParameterRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\UserRepository;
use Components\Enterprise\InvoiceParameter\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\InvoiceParameter\Domain\UseCases\CreateInvoiceParameter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Behat\Behat\Context\Context;
use Exception;

class CreateInvoiceParameterContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response = [];
    private $enterpriseRepository;
    private $customerBillingDeadlineRepository;
    private $ibanRepository;
    private $userRepository;
    private $invoiceParameterRepository;

    public function __construct()
    {
        parent::setUp();
        $this->enterpriseRepository = new EnterpriseRepository();
        $this->customerBillingDeadlineRepository = new CustomerBillingDeadlineRepository();
        $this->ibanRepository = new IbanRepository();
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
     * @Given les Ibans suivants existent
     */
    public function lesIbansSuivantsExistent(TableNode $ibans)
    {
        foreach ($ibans as $item) {
            $iban = factory(Iban::class)->make(['status' => $item['status']]);
            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $iban->enterprise()->associate($enterprise);
            $iban->save();
        }
    }

    /**
     * @Given les échéances de paiement suivantes existent
     */
    public function lesEcheancesDePaiementSuivantesExistent(TableNode $deadlines)
    {
        foreach ($deadlines as $item) {
            $deadline = factory(DeadlineType::class)->make(['name' => $item['name'], 'display_name' => $item['display_name']]);
            $deadline->save();
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
     * @When /^j\'essaie de creer un parametre de facturation de l\'entreprise avec le siret "([^"]*)"$/
     */
    public function jessaieDeCreerUnParametreDeFacturationDeLentrepriseAvecLeSiret($siret)
    {
        $enterprise = $this->enterpriseRepository->findBySiret($siret);
        $auth_user = $this->userRepository->connectedUser();
        $addworking = Enterprise::where('name', "ADDWORKING1")->first();
        $iban = $this->ibanRepository->findByEnterprise($addworking);
        $deadline = DeadlineType::where('name', "30_jours")->first();

        $inputs = [
            'iban_id' => $iban->id,
            'enterprise_id' => $enterprise->getId(),
            'analytic_code' => 'analytic_code',
            'discount_starts_at' => "2020-10-17 00:00:00",
            'discount_ends_at' => "2020-12-16 23:59:59",
            'discount_amount' => 12.5,
            'billing_floor_amount' => 12.5,
            'billing_cap_amount' => 12.5,
            'default_management_fees_by_vendor' => 12.5,
            'custom_management_fees_by_vendor' => 12.5,
            'fixed_fees_by_vendor_amount' => 12.5,
            'subscription_amount' => 12.5,
            'starts_at' => "2020-10-17 00:00:00",
            'ends_at' => "2021-10-16 23:59:59",
            'invoicing_from_inbound_invoice' => 0,
            'vendor_creating_inbound_invoice_items' => 0,
            'customer_deadlines' => [$deadline->id],
        ];
        try {
            $this->response = (new CreateInvoiceParameter(
                $this->userRepository,
                $this->enterpriseRepository,
                $this->customerBillingDeadlineRepository,
                $this->ibanRepository,
                $this->invoiceParameterRepository,
            ))->handle($auth_user, $inputs, $enterprise);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^les parametres de facturation sont créé/
     */
    public function lesParametresDeFacturationSontCree()
    {
        $this->assertDatabaseHas('addworking_enterprise_invoice_parameters', [
            'id' => $this->response->getId(),
            'analytic_code' => 'analytic_code',
        ]);

        $this->assertDatabaseCount('addworking_enterprise_invoice_parameters', 1);
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
