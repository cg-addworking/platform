<?php
namespace Components\Enterprise\InvoiceParameter\Tests\Acceptance\EditInvoiceParameter;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use App\Models\Addworking\User\User;
use Behat\Gherkin\Node\TableNode;
use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Components\Enterprise\InvoiceParameter\Application\Repositories\CustomerBillingDeadlineRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\EnterpriseRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\IbanRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\InvoiceParameterRepository;
use Components\Enterprise\InvoiceParameter\Application\Repositories\UserRepository;
use Components\Enterprise\InvoiceParameter\Domain\Exceptions\InvoiceParameterNotFoundException;
use Components\Enterprise\InvoiceParameter\Domain\Exceptions\UserIsNotSupportException;
use Components\Enterprise\InvoiceParameter\Domain\UseCases\EditInvoiceParameter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Behat\Behat\Context\Context;
use Exception;

class EditInvoiceParameterContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response = [];

    private $enterpriseRepository;
    private $userRepository;
    private $invoiceParameterRepository;
    private $ibanRepository;
    private $customerBillingDeadlineRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository = new EnterpriseRepository();
        $this->userRepository = new UserRepository();
        $this->invoiceParameterRepository = new InvoiceParameterRepository();
        $this->ibanRepository = new IbanRepository();
        $this->customerBillingDeadlineRepository = new CustomerBillingDeadlineRepository();
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
                'registration_town'         => uniqid('PARIS_'),
                'tax_identification_number' => 'FR' . random_numeric_string(11),
                'main_activity_code'        => random_numeric_string(4) . 'X',
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
                'gender'         => array_random(['male', 'female']),
                'password'       => Hash::make('password'),
                'remember_token' => str_random(10),
                'email' => $item['email'],
                'firstname'=> $item['firstname'],
                'lastname' => $item['lastname'],
                'is_system_admin' => $item['is_system_admin'],
            ]);
            $user->save();

            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $user->enterprises()->attach($enterprise);
        }
    }

    /**
     * @Given les ibans suivants existent
     */
    public function lesIbansSuivantsExistent(TableNode $ibans)
    {
        foreach ($ibans as $item) {
            $iban = new Iban();

            $iban->fill([
                'status' => $item['status'],
                'iban'  => $item['iban'],
                'bic'   => $item['bic'],
                'label' => $item['label']
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
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
            $deadline = new DeadlineType();

            $deadline->fill([
                'name'         => str_slug($item['display_name'], '_'),
                'display_name' => $item['display_name'],
                'value'        => $item['value'],
                'description'  => $item['description'],
            ])->save();
        }
    }

    /**
     * @Given les paraméters de facturation suivants existent
     */
    public function lesParametersDeFacturationSuivantsExistent(TableNode $parameters)
    {
        foreach ($parameters as $item) {
            $parameter = new InvoiceParameter();

            $parameter->fill([
                'number' => $item['number'],
                'invoicing_from_inbound_invoice' => $item['invoicing_from_inbound_invoice'],
                'vendor_creating_inbound_invoice_items' => $item['vendor_creating_inbound_invoice_items'],
                'fixed_fees_by_vendor_amount' => $item['fixed_fees_by_vendor_amount'],
                'subscription_amount' => $item['subscription_amount']
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['enterprise_siret']);
            $parameter->enterprise()->associate($enterprise);
            $parameter->save();
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
     * @When j'essaie de modifier le paramétre de facturation numéro :arg1 de l'entreprise avec le siret :arg2
     */
    public function jessaieDeModifierLeParametreDeFacturationNumeroDeLentrepriseAvecLeSiret(
        int $invoice_parameter_number, string $enterprise_siret
    ) {
        $enterprise = $this->enterpriseRepository->findBySiret($enterprise_siret);
        $auth_user = $this->userRepository->connectedUser();

        $invoice_parameter = $this->invoiceParameterRepository->findByNumber($invoice_parameter_number);

        $addworking = $this->enterpriseRepository->findEnterpriseByName('ADDWORKING');
        $iban = $this->ibanRepository->findByEnterprise($addworking);
        $deadline = DeadlineType::where('name', "30_jours")->first();

        $inputs = [
            'iban_id' => $iban->id,
            'enterprise_id' => $enterprise->getId(),
            'discount_amount' => 12.5,
            'default_management_fees_by_vendor' => 12.5,
            'custom_management_fees_by_vendor' => 12.5,
            'fixed_fees_by_vendor_amount' => 12.5,
            'ends_at' => "2021-10-16 23:59:59",
            'invoicing_from_inbound_invoice' => 0,
            'vendor_creating_inbound_invoice_items' => 0,
            'customer_deadlines' => [$deadline->id],
            'starts_at' => "2020-10-17 00:00:00",
        ];
        try {
            $this->response = (new EditInvoiceParameter(
                $this->userRepository,
                $this->customerBillingDeadlineRepository,
                $this->ibanRepository,
                $this->invoiceParameterRepository,
            ))->handle($auth_user, $inputs, $enterprise, $invoice_parameter);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then le paramétre de facturation numéro :arg1 est modifié
     */
    public function leParametreDeFacturationNumeroEstModifie(int $invoice_parameter_number)
    {
        $invoice_parameter = $this->invoiceParameterRepository->findByNumber($invoice_parameter_number);

        $this->assertEquals($invoice_parameter->getUpdatedAt(), $this->response->updated_at);
    }

    /**
     * @Then une erreur est levée car l'utilisateur connecté n'est pas support
     */
    public function uneErreurEstLeveeCarLutilisateurConnecteNestPasSupport()
    {
        $this->assertContainsEquals(UserIsNotSupportException::class, $this->errors);
    }

    /**
     * @Then une erreur est levée car le paramétre de facturation il n'existe pas
     */
    public function uneErreurEstLeveeCarLeParametreDeFacturationIlNexistePas()
    {
        $this->assertContainsEquals(InvoiceParameterNotFoundException::class, $this->errors);
    }
}
