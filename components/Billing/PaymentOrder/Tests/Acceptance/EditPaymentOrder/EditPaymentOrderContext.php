<?php
namespace Components\Billing\PaymentOrder\Tests\Acceptance\EditPaymentOrder;

use App\Models\Addworking\Billing\DeadlineType;
use App\Models\Addworking\Common\Address;
use App\Models\Addworking\Common\PhoneNumber;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\Enterprise\Iban;
use App\Models\Addworking\Enterprise\LegalForm;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Components\Billing\Outbound\Application\Models\OutboundInvoice;
use Components\Billing\PaymentOrder\Application\Models\PaymentOrder;
use Components\Billing\PaymentOrder\Application\Repositories\DeadlineRepository;
use Components\Billing\PaymentOrder\Application\Repositories\EnterpriseRepository;
use Components\Billing\PaymentOrder\Application\Repositories\IbanRepository;
use Components\Billing\PaymentOrder\Application\Repositories\ModuleRepository;
use Components\Billing\PaymentOrder\Application\Repositories\OutboundInvoiceRepository;
use Components\Billing\PaymentOrder\Application\Repositories\PaymentOrderRepository;
use Components\Billing\PaymentOrder\Application\Repositories\UserRepository;
use Components\Billing\PaymentOrder\Domain\Exceptions\PaymentOrderNotFoundException;
use Components\Billing\PaymentOrder\Domain\Exceptions\UserIsNotSupportException;
use Components\Billing\PaymentOrder\Domain\UseCases\EditPaymentOrder;
use Components\Enterprise\InvoiceParameter\Application\Models\InvoiceParameter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Exception;

class EditPaymentOrderContext extends TestCase implements Context
{
    use RefreshDatabase;

    private $errors = [];
    private $response;

    private $enterpriseRepository;
    private $deadlineRepository;
    private $userRepository;
    private $outboundInvoiceRepository;
    private $moduleRepository;
    private $ibanRepository;
    private $paymentOrderRepository;

    public function __construct()
    {
        parent::setUp();

        $this->enterpriseRepository      = new EnterpriseRepository();
        $this->deadlineRepository        = new DeadlineRepository();
        $this->userRepository            = new UserRepository();
        $this->outboundInvoiceRepository = new OutboundInvoiceRepository();
        $this->moduleRepository          = new ModuleRepository();
        $this->ibanRepository            = new IbanRepository();
        $this->paymentOrderRepository    = new PaymentOrderRepository();
    }


    /**
     * @Given /^les entreprises suivantes existent$/
     */
    public function lesEntreprisesSuivantesExistent(TableNode $enterprises)
    {
        foreach ($enterprises as $item) {
            $enterprise = new Enterprise;
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
     * @Given /^les ibans suivants existent$/
     */
    public function lesIbansSuivantsExistent(TableNode $ibans)
    {
        foreach ($ibans as $item) {
            $iban = factory(Iban::class)->make(['status' => "approved"]);
            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $iban->enterprise()->associate($enterprise);
            $iban->save();
        }
    }

    /**
     * @Given /^les paramètres de facturation suivants existent$/
     */
    public function lesParametresDeFacturationSuivantsExistent(TableNode $parameters)
    {
        foreach ($parameters as $item) {
            $invoiceParameter = factory(InvoiceParameter::class)->make([
                'analytic_code' => $item['parameter_analytic_code'],
                'default_management_fees_by_vendor' => $item['default_management_fees_by_vendor'],
                'custom_management_fees_by_vendor' => $item['custom_management_fees_by_vendor'],
                'fixed_fees_by_vendor_amount' => $item['fixed_fees_by_vendor_amount'],
                'subscription_amount' => $item['subscription_amount'],
                'number' => $item['number'],
            ]);

            $enterprise = $this->enterpriseRepository->findBySiret($item['siret']);
            $invoiceParameter->enterprise()->associate($enterprise);
            $invoiceParameter->save();
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
     * @Given /^les ordres de paiement suivants existent$/
     */
    public function lesOrdresDePaiementSuivantsExistent(TableNode $paymentOrders)
    {
        foreach ($paymentOrders as $item) {
            $customer = $this->enterpriseRepository->findBySiret($item['siret_customer']);

            $paymentOrder = factory(PaymentOrder::class)->make([
                'number'        => $item['number'],
                'customer_name' => $customer->name
            ]);

            $paymentOrder->enterprise()->associate($customer);
            $paymentOrder->save();
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
     * @When /^j\'essaie de modifier l\'ordre de paiement numero "([^"]*)"$/
     */
    public function jessaieDeModifierLordreDePaiementNumero(string $number)
    {
        $authUser     = $this->userRepository->connectedUser();
        $paymentOrder = $this->paymentOrderRepository->findByNumber($number);

        $addworking   = $this->enterpriseRepository->findByName("ADDWORKING1");
        $iban         = $this->ibanRepository->findByEnterprise($addworking);

        $data = [
            'executed_at'            => "2020-08-31",
            'customer_name'          => "machinandcoedited",
            'iban_id'                => $iban->id,
            'status'                 => "created",
            'bank_reference_payment' => "XXXXXXXX",
        ];

        try {
            $this->response = (new EditPaymentOrder(
                $this->userRepository,
                $this->ibanRepository,
                $this->paymentOrderRepository
            ))->handle($authUser, $paymentOrder, $data);
        } catch (Exception $e) {
            $this->errors[] = get_class($e);
        }
    }

    /**
     * @Then /^l\'ordre de paiement numero "([^"]*)" est modifié$/
     */
    public function lordreDePaiementNumeroEstModifie(string $number)
    {
        $paymentOrder = $this->paymentOrderRepository->findByNumber($number);

        $this->assertEquals($paymentOrder->getCustomerName(), $this->response->getCustomerName());
        $this->assertEquals($paymentOrder->getExecutedAt(), $this->response->getExecutedAt());
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
     * @Then /^une erreur est levée car la facture outbound n\'existe pas$/
     */
    public function uneErreurEstLeveeCarLaFactureOutboundNexistePas()
    {
        $this->assertContainsEquals(
            PaymentOrderNotFoundException::class,
            $this->errors
        );
    }
}
